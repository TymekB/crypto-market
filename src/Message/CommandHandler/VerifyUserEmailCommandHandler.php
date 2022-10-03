<?php

declare(strict_types=1);

namespace App\Message\CommandHandler;

use App\Entity\User;
use App\Message\Command\VerifyUserEmailCommand;
use App\Message\Event\UserVerifiedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

#[AsMessageHandler]
final class VerifyUserEmailCommandHandler
{
    public function __construct(
        private readonly VerifyEmailHelperInterface $verifyEmailHelper,
        private readonly EntityManagerInterface $entityManager,
        private readonly MessageBusInterface $eventBus
    ) {}

    public function __invoke(VerifyUserEmailCommand $verifyUserEmailCommand)
    {
        $userId = $verifyUserEmailCommand->getId();
        $signedUrl = $verifyUserEmailCommand->getSignedUrl();

        $user = $this->entityManager
            ->getRepository(User::class)
            ->find($userId);

        $this->verifyEmailHelper->validateEmailConfirmation(
            $signedUrl,
            $user->getId(),
            $user->getEmail()
        );

        $this->eventBus->dispatch(new UserVerifiedEvent($user->getId()));
    }
}