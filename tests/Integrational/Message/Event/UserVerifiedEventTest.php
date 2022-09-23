<?php

declare(strict_types=1);

namespace App\Tests\Integrational\Message\Event;

use App\Entity\User;
use App\Message\Event\UserVerifiedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

final class UserVerifiedEventTest extends KernelTestCase
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

    public function testIfUserIsVerified()
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'newuser@example.com']);

        $this->assertNotNull($user);
        $this->assertFalse($user->getVerified());

        $this->eventBus->dispatch(new UserVerifiedEvent($user->getId()));

        $user = $userRepository->findOneBy(['email' => 'newuser@example.com']);

        $this->assertNotNull($user);
        $this->assertTrue($user->getVerified());
    }
}