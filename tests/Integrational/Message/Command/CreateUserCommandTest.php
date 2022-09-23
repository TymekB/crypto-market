<?php

declare(strict_types=1);

namespace App\Tests\Integrational\Message\Command;

use App\Entity\User;
use App\Message\Command\CreateUserCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateUserCommandTest extends KernelTestCase
{
    private readonly MessageBusInterface $messageBus;
    private readonly EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->messageBus = $container->get('command.bus');
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
    }

    public function testIfUserIsCreated(): void
    {
        $this->messageBus->dispatch(
            new CreateUserCommand('test@example.com', 'test')
        );

        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => 'test@example.com']);

        $this->assertNotNull($user);
        $this->assertEquals('test@example.com', $user->getEmail());
    }
}