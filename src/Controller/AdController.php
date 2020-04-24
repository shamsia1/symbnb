<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)//injection de dependence
    {

        //$repo = $this->getDoctrine()->getRepository(Ad::class);

        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * creation de formulaire d'annonce
     * @Route("/ads/new", name="ads_create")
     * @IsGranted("ROLE_USER")
     * 
     */
    public function create(Request $request)
    {

        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);
           
        if($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($image);

            }
            // ajouter l'author de l'announce
            $ad->setAuthor($this->getUser());

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success',
             "L'annouce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }
        return $this->render('ad/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
    * permet d'afficher le formulaire d'edition
    *
    * @Route("/ads/{slug}/edit", name="ads_edit")
    * @Security("is_granted('ROLE_USER') and user === ad.getAuthor()", message= "Cette announce ne vous appartient pas, vous ne pouvez pad la modifier")
    */
    public function edit(Ad $ad, Request $request)
    {

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($image);
            }

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success',

             "Les modification de l'annouce <strong>{$ad->getTitle()}</strong> ont 

              bien été enregistrée !"
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }
           
        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }

    /**
     * permet d'afficher une seule announce
     *
     * @Route("/ads/{slug}", name="ads_show")
     *
     */
    public function show(Ad $ad)
    {
        //je récupere l'announce qui correspond au slug !
        //$ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    } 
    
}
