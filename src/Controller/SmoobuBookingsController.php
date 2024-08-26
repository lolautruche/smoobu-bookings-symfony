<?php

namespace App\Controller;

use App\Smoobu\Fetcher\BookingsFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SmoobuBookingsController extends AbstractController
{
    #[Route('/smoobu', name: 'app_smoobu_bookings')]
    public function index(): Response
    {
        return $this->render('smoobu_bookings/index.html.twig', [
            'controller_name' => 'SmoobuBookingsController',
        ]);
    }

    #[Route('/smoobu/overdue', name: 'app_smoobu_bookings_overdue')]
    public function overdueBookings(BookingsFetcherInterface $bookingsFetcher): Response
    {
        $bookings = $bookingsFetcher->fetch();
        return $this->render('smoobu_bookings/overdue.html.twig', ['bookings' => $bookings]);
    }
}
