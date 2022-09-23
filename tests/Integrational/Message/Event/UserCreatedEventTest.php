<?php

declare(strict_types=1);

namespace App\Tests\Integrational\Message\Event;

use App\Entity\User;
use App\Message\Event\UserCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

final class UserCreatedEventTest extends KernelTestCase
{
    private readonly MessageBusInterface $eventBus;
    private readonly EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->eventBus = $container->get('event.bus');
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
    }

    public function testIfEmailIsSent(): void
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => 'user@example.com']);

        $this->assertNotNull($user);

        $this->eventBus->dispatch(
            new UserCreatedEvent($user->getId(), $user->getEmail())
        );

        $this->assertEmailCount(1);
        $email = $this->getMailerMessage();
        $this->assertEmailHtmlBodyContains($email, 'Your confirmation link: ');
    }
}