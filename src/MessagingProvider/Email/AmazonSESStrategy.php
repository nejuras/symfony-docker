<?php

declare(strict_types=1);

namespace App\MessagingProvider\Email;

use App\MessagingProvider\MessagingProvider;
use App\MessagingProvider\StrategyInterface;
use App\Service\Notification;

class AmazonSESStrategy implements StrategyInterface
{
    private const string AMAZON_SES_MESSAGING_TYPE = 'amazonses';

    public function __construct(private readonly Notification $notification)
    {
    }

    public function canProcess(MessagingProvider $data): bool
    {
        return $data->messagingProviderKey === self::AMAZON_SES_MESSAGING_TYPE;
    }

    public function process(MessagingProvider $data): string
    {
        return $this->notification->send(self::AMAZON_SES_MESSAGING_TYPE);
    }
}
