<?php

declare(strict_types=1);

namespace App\Message\Command;

final class ResetUserPasswordCommand
{
    public function __construct(
        private readonly string $token,
        private readonly string $newPassword
    )
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

}