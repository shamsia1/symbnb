<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings", name="admin_booking_index")
     */
    public function index(BookingRepository $repo)
    {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/admin/bookings/{id}/edit", name="admin_booking_edit")
     * 
     * @param Booking $booking
     * @return Response
     */
    public function edit(Booking $booking){
        $form = $this->createForm(AdminBookingType::class, $booking);
        return $this->render('admin/booking/edit.html.twig', [
            'form' => $form->createView(),
            'booking'=> $booking
        ]); 
    }
}
