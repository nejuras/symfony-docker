<?php

namespace App\Command;

use App\MessagingProvider\MessagingProvider;
use App\MessagingProvider\MessagingProviderContext;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:send-notification',
    description: 'send notification to customer',
    hidden: false
)]
class SendNotificationCommand extends Command
{
    public function __construct(private readonly MessagingProviderContext $messagingProviderContext)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('messagingProviderKey', null, InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $messagingProviderKey = $input->getOption('messagingProviderKey') ?: '';

        $data = new MessagingProvider($messagingProviderKey);

        $messagingProvider = $this->messagingProviderContext->handle($data);

        $this->getShippingRegisterMessageOutput($messagingProviderKey, $messagingProvider, $output);

        return 0;
    }

    private function getShippingRegisterMessageOutput(
        $messagingProviderKey,
        $messagingProvider,
        OutputInterface $output
    ): void
    {
        $output->write("", true);
        $output->write("<fg=green>   $messagingProviderKey</>", true);
        $output->write("<fg=green>   $messagingProvider</>", true);
        $output->write("", true);
    }
}
