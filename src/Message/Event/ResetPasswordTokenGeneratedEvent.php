<?php

declare(strict_types=1);

namespace App\Message\Event;

final class ResetPasswordTokenGeneratedEvent
{
    public function __construct(private readonly string $resetToken)
    {
    }

    public function getResetToken(): string
    {
        return $this->resetToken;
    }
}