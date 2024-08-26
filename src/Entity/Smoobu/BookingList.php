<?php

namespace App\Entity\Smoobu;

use Traversable;

class BookingList implements \IteratorAggregate, \Countable
{
    /**
     * @var Booking[]
     */
    private array $bookings = [];

    private int $pageCount = 0;

    private int $pageSize = 0;

    private int $totalItems = 0;

    private int $page = 0;

    public function getBookings(): array
    {
        return $this->bookings;
    }

    public function setBookings(array $bookings): BookingList
    {
        $this->bookings = $bookings;
        return $this;
    }

    public function addBooking(Booking $booking): BookingList
    {
        $this->bookings[] = $booking;
        return $this;
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function setPageCount(int $pageCount): BookingList
    {
        $this->pageCount = $pageCount;
        return $this;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function setPageSize(int $pageSize): BookingList
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function setTotalItems(int $totalItems): BookingList
    {
        $this->totalItems = $totalItems;
        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): BookingList
    {
        $this->page = $page;
        return $this;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->bookings);
    }

    public function count(): int
    {
        return count($this->bookings);
    }
}