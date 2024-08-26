<?php

namespace App\Smoobu\Normalizer;

use App\Entity\Smoobu\Booking;
use App\Entity\Smoobu\Channel;
use App\Entity\Smoobu\Guest;
use App\Entity\Smoobu\Property;

/**
 * Normalizes booking entries from decoded JSON array to a hydrated Booking entity
 * Based on Smooby API doc: https://docs.smoobu.com/#get-bookings-api
 */
class BookingNormalizer
{
    public function normalize(array $data): Booking
    {
        $booking = (new Booking())
            ->setId($data['id'])
            ->setReferenceId($data['reference-id'])
            ->setType($data['type'])
            ->setArrival(new \DateTimeImmutable($data['arrival']))
            ->setDeparture(new \DateTimeImmutable($data['departure']))
            ->setCreatedAt(new \DateTimeImmutable($data['created-at']))
            ->setModifiedAt(new \DateTimeImmutable($data['modifiedAt']))
            ->setProperty(
                (new Property())
                    ->setName($data['apartment']['name'])
                    ->setId($data['apartment']['id'])
            )
            ->setChannel(
                (new Channel())
                    ->setId($data['channel']['id'])
                    ->setName($data['channel']['name'])
            )
            ->setGuest(
                (new Guest())
                    ->setId($data['guestId'])
                    ->setFirstName($data['guest-name'])
                    ->setEmails([$data['email']])
                    ->setTelephoneNumbers([$data['phone']])
            )
            ->setBlocked((bool)$data['is-blocked-booking'])
            ->setCheckInTime($data['check-in'])
            ->setCheckoutTime($data['check-out'])
            ->setDeposit($data['deposit'] ?? 0)
            ->setDepositPaid($data['deposit-paid'] == 'Yes')
            ->setPrice($data['price'])
            ->setPaid($data['price-paid'] == 'Yes')
            ->setPrepayment($data['prepayment'] ?? 0)
            ->setPrepaymentPaid($data['prepayment-paid'] == 'Yes')
            ->setGuestApp($data['guest-app-url'])
            ->setLanguage($data['language'])
        ;

        return $booking;
    }
}