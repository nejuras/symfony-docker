<?php

declare(strict_types=1);

namespace App\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SmsSender
{
    private Client $twilioClient;

    public function __construct(
        private readonly string $accountSid,
        private readonly string $authToken,
        private readonly string $twilioPhoneNumber,
        private readonly string $phoneNumberSendTo,
    )
    {
        $this->twilioClient = new Client(
            $this->accountSid,
            $this->authToken
        );
    }

    public function sendSms(string $message): bool
    {
        try {
            $this->twilioClient->messages->create(
                $this->phoneNumberSendTo,
                [
                    'from' => $this->twilioPhoneNumber,
                    'body' => $message,
                ]
            );

            return true;
        } catch (TwilioException $exception) {
            return false;
        }
    }
}
