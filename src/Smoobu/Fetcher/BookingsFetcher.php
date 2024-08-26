<?php

namespace App\Smoobu\Fetcher;

use App\Entity\Smoobu\BookingList;
use App\Smoobu\API\BookingsClient;
use App\Smoobu\Normalizer\BookingNormalizer;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingsFetcher implements BookingsFetcherInterface
{
    private OptionsResolver $optionsResolver;

    public function __construct(
        private BookingsClient $client,
        private BookingNormalizer $bookingNormalizer,
    )
    {
        $this->optionsResolver = new OptionsResolver();
        $this->configureOptions($this->optionsResolver);
    }

    public function fetch(array $params = []): BookingList
    {
        $params = $this->optionsResolver->resolve();
        $json = $this->client->getList([
            'from' => $params['from']->format('Y-m-d'),
            'to' => $params['to']?->format('Y-m-d'),
            'showCancellation' => $params['showCancellation'],
            'excludeBlocked' => $params['excludeBlocked'],
        ]);

        $decoded = json_decode($json, true);
        $bookingList = (new BookingList())
            ->setPageCount($decoded['page_count'])
            ->setPageSize($decoded['page_size'])
            ->setPage($decoded['page'])
            ->setTotalItems($decoded['total_items'])
        ;
        foreach ($decoded['bookings'] as $booking) {
            $bookingList->addBooking($this->bookingNormalizer->normalize($booking));
        }

        return $bookingList;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'from' => new \DateTimeImmutable(),
            'to' => null,
            'showCancellation' => false,
            'excludeBlocked' => true,
        ]);
    }
}