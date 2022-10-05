<?php

declare(strict_types=1);

namespace App\Message\Event;

use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

final class ResetPasswordTokenGeneratedEvent
{
    public function __construct(
        private readonly ResetPasswordToken $resetToken,
        private readonly string             $userEmail
    )
    {
    }

    public function getResetToken(): ResetPasswordToken
    {
        return $this->resetToken;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }
}