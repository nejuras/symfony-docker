<?php

declare(strict_types=1);

namespace App\MessagingProvider;

class MessagingProvider
{
    public function __construct(public readonly string $messagingProviderKey)
    {
    }
}
