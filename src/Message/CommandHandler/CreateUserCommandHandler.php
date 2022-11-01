<?php

declare(strict_types=1);

namespace App\Message\CommandHandler;

use App\Factory\UserFactoryInterface;
use App\Message\Command\CreateUserCommand;
use App\Message\Event\UserCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class CreateUserCommandHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserFactoryInterface $userFactory,
        private readonly MessageBusInterface $eventBus
    ) {}

    public function __invoke(CreateUserCommand $createUserCommand): void
    {
        $user = $this->userFactory->createUser(
            $createUserCommand->getEmail(),
            $createUserCommand->getPassword()
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $userDto = $user->toDto();
        $this->eventBus->dispatch(UserCreatedEvent::fromDto($userDto));
    }
}