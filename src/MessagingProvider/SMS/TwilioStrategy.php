<?php

declare(strict_types=1);

namespace App\MessagingProvider\SMS;

use App\MessagingProvider\MessagingProvider;
use App\MessagingProvider\StrategyInterface;
use App\Model\Notification;
use App\Service\SmsSender;
use Twilio\Exceptions\TwilioException;

class TwilioStrategy implements StrategyInterface
{
    private const string TWILIO_SMS_MESSAGING_TYPE = 'twiliosms';
    private const string SMS = 'Money has been transferred successfully by %s provider!';

    public function __construct(private readonly SmsSender $smsSender, private readonly Notification $notification)
    {
    }

    public function canProcess(MessagingProvider $data): bool
    {
        return $data->messagingProviderKey === self::TWILIO_SMS_MESSAGING_TYPE;
    }

    public function process(MessagingProvider $data): string
    {
        $text = sprintf(self::SMS, self::TWILIO_SMS_MESSAGING_TYPE);

        $isSent = $this->smsSender->sendSms($text);
        $this->notification->register(self::TWILIO_SMS_MESSAGING_TYPE, $isSent);

        return $text;
    }
}
