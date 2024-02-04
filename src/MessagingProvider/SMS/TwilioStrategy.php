<?php

declare(strict_types=1);

namespace App\MessagingProvider\SMS;

use App\MessagingProvider\MessagingProvider;
use App\MessagingProvider\StrategyInterface;
use App\Service\Notification;
use App\Model\ShippingProvider;

class TwilioStrategy implements StrategyInterface
{
    private const string TWILIO_SMS_MESSAGING_TYPE = 'twiliosms';

    public function __construct(private readonly Notification $notification)
    {
    }

    public function canProcess(MessagingProvider $data): bool
    {
        return $data->messagingProviderKey === self::TWILIO_SMS_MESSAGING_TYPE;
    }

    public function process(MessagingProvider $data): string
    {
        return $this->notification->send(self::TWILIO_SMS_MESSAGING_TYPE);
    }
}
