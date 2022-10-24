<?php

declare(strict_types=1);

namespace App\Message\CommandHandler;

use App\Entity\User;
use App\Message\Command\ResetUserPasswordCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[AsMessageHandler]
final class ResetUserPasswordCommandHandler
{
    public function __construct(
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly UserPasswordHasherInterface  $userPasswordHasher,
        private readonly EntityManagerInterface       $entityManager
    )
    {
    }


    public function __invoke(ResetUserPasswordCommand $resetUserPasswordCommand)
    {
        $token = $resetUserPasswordCommand->getToken();
        /** @var User $user */
        $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);

        $this->resetPasswordHelper->removeResetRequest($token);

        $hashedNewPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $resetUserPasswordCommand->getNewPassword()
        );

        $user->setPassword($hashedNewPassword);
        $this->entityManager->flush($user);
    }
}