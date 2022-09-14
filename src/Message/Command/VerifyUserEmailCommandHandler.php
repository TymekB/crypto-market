<?php

declare(strict_types=1);

namespace App\Message\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class VerifyUserEmailCommandHandler
{
    public function __construct(
        private readonly VerifyEmailHelperInterface $verifyEmailHelper,
        private readonly EntityManagerInterface $entityManager
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
    }
}