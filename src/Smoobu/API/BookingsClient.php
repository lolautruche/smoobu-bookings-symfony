<?php

namespace App\Smoobu\API;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BookingsClient
{
    public function __construct(
        private HttpClientInterface $smoobuClient
    )
    {
    }

    public function getList(array $qsParams = [], array $headers = []): string
    {
        $response = $this->smoobuClient->request('GET', '/api/reservations', [
            'query' => [
                'pageSize' => 100,
                'showCancellation' => false,
                'excludeBlocked' => true,
            ] + $qsParams,
            'headers' => $headers,
        ]);

        return $response->getContent();
    }
}