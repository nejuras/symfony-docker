<?php

declare(strict_types=1);

namespace App\MessagingProvider\Email;

use App\MessagingProvider\MessagingProvider;
use App\MessagingProvider\StrategyInterface;
use App\Model\Notification;
use App\Service\EmailSender;

class GmailSesStrategy implements StrategyInterface
{
    private const string GMAIL_SES_MESSAGING_TYPE = 'gmailses';

    private const string TEXT = 'Money has been transferred successfully by %s provider!';

    public function __construct(private readonly EmailSender $emailSender, private Notification $notification)
    {
    }

    public function canProcess(MessagingProvider $data): bool
    {
        return $data->messagingProviderKey === self::GMAIL_SES_MESSAGING_TYPE;
    }

    public function process(MessagingProvider $data): string
    {
        $text = sprintf(self::TEXT, self::GMAIL_SES_MESSAGING_TYPE);

        $isSent = $this->emailSender->sendEmail($text);
        $this->notification->register(self::GMAIL_SES_MESSAGING_TYPE, $isSent);

        return $text;
    }
}
