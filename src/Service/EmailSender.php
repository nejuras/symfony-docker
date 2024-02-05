<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailSender
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $email,
    )
    {
    }

    public function sendEmail(string $message): bool
    {
        try {
            $email = (new Email())
                ->from('info@transfergo.com')
                ->to($this->email)
                ->subject('TransferGo')
                ->html("<p>$message</p>");

            $this->mailer->send($email);

            return true;
        } catch (TransportExceptionInterface $exception) {
            return false;
        }
    }
}
