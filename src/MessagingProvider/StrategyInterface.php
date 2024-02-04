<?php

namespace App\MessagingProvider;

interface StrategyInterface
{
    public function canProcess(MessagingProvider $data): bool;

    public function process(MessagingProvider $data): string;
}
