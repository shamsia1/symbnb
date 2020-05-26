<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\CommentType;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BookingController extends AbstractController
{
    /**
     * @Route("/ads/{slug}/book", name="booking_create")
     * @IsGranted("ROLE_USER")
     *
     */
    public function book(Ad $ad, Request $request)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            $user = $this->getUser();

            $booking ->setBooker($user)
                    ->setAd($ad);

            // si les dates ne sont pas disponible, message d'erreur
            if(!$booking->isBookableDates()){
                $this->addFlash(
                    'warning',
                    "les dates que vous avez choisi ne peuvent etre reservées: elles sont déja prises"
                ); 

            }else{

                $manager = $this->getDoctrine()->getManager();
            $manager->persist($booking);
            $manager->flush();

            return $this->redirectToRoute('booking_show',
            ['id' =>$booking->getId(), 'withAlert' => true]);

            }

            
        }
         
        return $this->render('booking/book.html.twig', [
            'ad' => $ad,
            'form'=> $form->createView()
        ]);
    }


    /**
     * 
     * permet d'afficher la page d'une réservation
     * @Route("/booking/{id}", name="booking_show")
     * @param Booking $booking
     * @return Response
     * @param Request $request
     * @param objectManager $manager
     */
    public function show(Booking $booking, Request $request){
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $comment->setAd($booking->getAd())
            ->setAuthor($this->getUser());

            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "Votre commentaire a bien été pris en compte"
            );

        }

        return $this->render('booking/show.html.twig',[
            'booking' => $booking,
            'form' => $form->createView()
        ]);

    }
}
