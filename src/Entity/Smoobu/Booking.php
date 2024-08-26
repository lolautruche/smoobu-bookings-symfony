<?php

namespace App\Entity\Smoobu;

use App\Repository\Smoobu\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    /**
     * Channel IDs that can be considered as "direct booking"
     * 940882: Direct reservation (manually booked)
     * 940885: From the website (aka "Homepage")
     *
     * @var int[]
     */
    const DIRECT_BOOKING_IDS = [940882, 940885];

    /** @var int Max number of days before booking full payment is considered overdue. */
    const OVERDUE_DELTA = 30;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referenceId = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $arrival = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $departure = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Property $property = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Channel $channel = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Guest $guest = null;

    #[ORM\Column(length: 255)]
    private ?string $checkInTime = null;

    #[ORM\Column(length: 255)]
    private ?string $checkoutTime = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?bool $paid = null;

    #[ORM\Column]
    private ?int $prepayment = null;

    #[ORM\Column]
    private ?bool $prepaymentPaid = null;

    #[ORM\Column]
    private ?int $deposit = null;

    #[ORM\Column]
    private ?bool $depositPaid = null;

    #[ORM\Column(length: 10)]
    private ?string $language = null;

    #[ORM\Column(length: 255)]
    private ?string $guestApp = null;

    #[ORM\Column]
    private ?bool $blocked = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    public function setReferenceId(?string $referenceId): static
    {
        $this->referenceId = $referenceId;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getArrival(): ?\DateTimeInterface
    {
        return $this->arrival;
    }

    public function setArrival(\DateTimeInterface $arrival): static
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function getDeparture(): ?\DateTimeInterface
    {
        return $this->departure;
    }

    public function setDeparture(\DateTimeInterface $departure): static
    {
        $this->departure = $departure;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeImmutable $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): static
    {
        $this->property = $property;

        return $this;
    }

    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    public function setChannel(?Channel $channel): static
    {
        $this->channel = $channel;

        return $this;
    }

    public function getGuest(): ?Guest
    {
        return $this->guest;
    }

    public function setGuest(?Guest $guest): static
    {
        $this->guest = $guest;

        return $this;
    }

    public function getCheckInTime(): ?string
    {
        return $this->checkInTime;
    }

    public function setCheckInTime(string $checkInTime): static
    {
        $this->checkInTime = $checkInTime;

        return $this;
    }

    public function getCheckoutTime(): ?string
    {
        return $this->checkoutTime;
    }

    public function setCheckoutTime(string $checkoutTime): static
    {
        $this->checkoutTime = $checkoutTime;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): static
    {
        $this->paid = $paid;

        return $this;
    }

    public function getPrepayment(): ?int
    {
        return $this->prepayment;
    }

    public function setPrepayment(int $prepayment): static
    {
        $this->prepayment = $prepayment;

        return $this;
    }

    public function isPrepaymentPaid(): ?bool
    {
        return $this->prepaymentPaid;
    }

    public function setPrepaymentPaid(bool $prepaymentPaid): static
    {
        $this->prepaymentPaid = $prepaymentPaid;

        return $this;
    }

    public function getDeposit(): ?int
    {
        return $this->deposit;
    }

    public function setDeposit(int $deposit): static
    {
        $this->deposit = $deposit;

        return $this;
    }

    public function isDepositPaid(): ?bool
    {
        return $this->depositPaid;
    }

    public function setDepositPaid(bool $depositPaid): static
    {
        $this->depositPaid = $depositPaid;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getGuestApp(): ?string
    {
        return $this->guestApp;
    }

    public function setGuestApp(string $guestApp): static
    {
        $this->guestApp = $guestApp;

        return $this;
    }

    public function isBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): static
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function isOverdue(\DateTimeInterface $referenceDate = new \DateTimeImmutable()): bool
    {
        if (!isset($this->arrival)) {
            return false;
        }

        return !$this->isPaid() && $referenceDate->diff($this->arrival)->days <= static::OVERDUE_DELTA;
    }

    public function isDirect(): bool
    {
        return in_array($this->channel->getId(), static::DIRECT_BOOKING_IDS);
    }
}
