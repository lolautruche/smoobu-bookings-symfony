<?php

namespace App\Smoobu\Fetcher;

use App\Entity\Smoobu\BookingList;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface BookingsFetcherInterface
{
    public function fetch(array $params = []): BookingList;

    public function configureOptions(OptionsResolver $resolver): void;
}