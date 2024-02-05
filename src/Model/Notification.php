<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity as Entity;
use Doctrine\ORM\EntityManagerInterface;

class Notification
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function register($messagingType, $isSent): void
    {
        $notification = (new Entity\Notification())
            ->setType($messagingType)
            ->setIsSent($isSent);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }
}
