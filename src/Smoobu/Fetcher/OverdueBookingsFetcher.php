<?php

namespace App\Smoobu\Fetcher;

use App\Entity\Smoobu\Booking;
use App\Entity\Smoobu\BookingList;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\OptionsResolver\OptionsResolver;

#[AsDecorator(decorates: BookingsFetcher::class)]
#[AsAlias(BookingsFetcherInterface::class)]
class OverdueBookingsFetcher implements BookingsFetcherInterface
{
    public function __construct(
        private BookingsFetcherInterface $bookingsFetcher
    )
    {
    }

    public function fetch(array $params = []): BookingList
    {
        $unfilteredList = $this->bookingsFetcher->fetch($params);
        return $this->filterList($unfilteredList);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $this->bookingsFetcher->configureOptions($resolver);
    }

    private function filterList(BookingList $unfilteredList): BookingList
    {
        $filteredList = (new BookingList())
            ->setPage($unfilteredList->getPage())
            ->setPageSize($unfilteredList->getPageSize())
            ->setPageCount($unfilteredList->getPageCount())
        ;

        /** @var Booking $booking */
        foreach ($unfilteredList as $booking) {
            if ($booking->isOverdue() && $booking->isDirect()) {
                $filteredList->addBooking($booking);
            }
        }

        $filteredList->setTotalItems(count($filteredList));
        return $filteredList;
    }
}