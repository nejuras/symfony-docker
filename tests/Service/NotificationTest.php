<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Notification;
use App\Service as Service;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    private MockObject & EntityManagerInterface $entityManagerMock;
    private Service\Notification $notificationService;

    protected function setUp(): void
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
        $this->notificationService = new Service\Notification($this->entityManagerMock);
    }

    public function testSendNotification(): void
    {
        $notification = (new Notification())
            ->setType('amazonses')
            ->setIsSent(true);

        $this->entityManagerMock->expects(self::once())->method('persist');
        $this->entityManagerMock->expects(self::once())->method('flush');

        $result = $this->notificationService->send($notification->getType());

        self::assertEquals('Notification has been sent by amazonses provider!', $result);
    }
}
