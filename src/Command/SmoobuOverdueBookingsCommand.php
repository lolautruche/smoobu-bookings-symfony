<?php

namespace App\Command;

use App\Entity\Smoobu\Booking;
use App\Entity\Smoobu\BookingList;
use App\Smoobu\Fetcher\BookingsFetcherInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'smoobu:overdue-bookings',
    description: 'Get bookings whose full payment is overdue',
)]
class SmoobuOverdueBookingsCommand extends Command
{
    public function __construct(
        private BookingsFetcherInterface $bookingsFetcher,
        private MailerInterface $mailer,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('notify-email', null, InputOption::VALUE_OPTIONAL, 'Email address to notify if overdue bookings are found')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $bookings = $this->bookingsFetcher->fetch();
        if (empty($bookings)) {
            $io->success('No overdue bookings were found. All good ✅!');
        }

        $io->warning('Found ' . $bookings->getTotalItems() . ' bookings that are overdue 💶:');
        $rows = [];
        /** @var Booking $booking */
        foreach ($bookings as $booking) {
            $rows[] = [
                "<href={$booking->getUrl()}>{$booking->getId()}</>",
                $booking->getProperty()->getName(),
                $booking->getGuest()->getFullName(),
                $booking->getArrival()->format('Y-m-d'),
                $booking->getDeparture()->format('Y-m-d'),
                '€ ' . $booking->getDueAmount(),
            ];
        }

        $io->table(
            ['Booking #', '🏡 Property', '🦹 Guest', '🛬 Arrival', '🛫 Departure', '💶 Total due'],
            $rows,
        );

        $notifyEmail = $input->getOption('notify-email');
        if (null !== $notifyEmail) {
            $this->notify($bookings);
        }

        return Command::SUCCESS;
    }

    private function notify(BookingList $bookingList): void
    {
        $email = (new Email())
            ->from('smoobu@sendmail.vieilledent.fr')
            ->to('jerome@vieilledent.fr')
            ->subject('Smoobu overdue bookings')
            ->text(
                "Following bookings are overdue:\n\n* " .
                implode("\n* ", $bookingList->getBookings())
            );

        $this->mailer->send($email);
    }
}
