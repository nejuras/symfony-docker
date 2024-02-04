<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity as Entity;
use Doctrine\ORM\EntityManagerInterface;

class Notification
{
    private const string NOTIFICATION_SENT_MESSAGE = "Notification has been sent";

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function send($messagingType): string
    {
        $notification = (new Entity\Notification())
            ->setType($messagingType)
            ->setIsSent(true);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        return sprintf('%s by %s provider!',self::NOTIFICATION_SENT_MESSAGE, $messagingType);
    }
}
