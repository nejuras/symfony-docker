<?php

declare(strict_types=1);

namespace App\MessagingProvider;

class MessagingProviderContext
{
    public function __construct(private readonly iterable $messagingProviderStrategies)
    {
    }

    public function handle($data): string
    {
        foreach ($this->messagingProviderStrategies as $strategy) {
            if ($strategy->canProcess($data)) {
                return $strategy->process($data);
            }
        }

        $this->throwUnprocessableStrategyException($data);
    }

    private function throwUnprocessableStrategyException(MessagingProvider $data): void
    {
        throw new \RuntimeException(
            "Can not process strategy with provider key: " . $data->messagingProviderKey,
        );
    }
}
