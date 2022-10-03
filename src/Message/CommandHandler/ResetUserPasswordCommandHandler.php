<?php

declare(strict_types=1);

namespace App\Message\CommandHandler;

use App\Entity\User;
use App\Message\Command\ResetUserPasswordCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[AsMessageHandler]
final class ResetUserPasswordCommandHandler
{
    public function __construct(
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly EntityManagerInterface       $entityManager
    )
    {
    }

    public function __invoke(ResetUserPasswordCommand $resetUserPasswordCommand)
    {
        $userEmail = $resetUserPasswordCommand->getEmail();
        $user = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $userEmail,
        ]);

        $this->resetPasswordHelper->generateResetToken($user);
    }
}