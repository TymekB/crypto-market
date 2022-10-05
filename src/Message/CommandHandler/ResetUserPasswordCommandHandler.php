<?php

declare(strict_types=1);

namespace App\Message\CommandHandler;

use App\Entity\User;
use App\Message\Command\ResetUserPasswordCommand;
use App\Message\Event\ResetPasswordTokenGeneratedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[AsMessageHandler]
final class ResetUserPasswordCommandHandler
{
    public function __construct(
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly EntityManagerInterface       $entityManager,
        private readonly MessageBusInterface          $eventBus
    )
    {
    }

    public function __invoke(ResetUserPasswordCommand $resetUserPasswordCommand)
    {
        $userEmail = $resetUserPasswordCommand->getEmail();
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $userEmail,
        ]);

        $resetToken = $this->resetPasswordHelper->generateResetToken($user);

        $this->eventBus->dispatch(
            new ResetPasswordTokenGeneratedEvent($resetToken, $userEmail)
        );
    }
}