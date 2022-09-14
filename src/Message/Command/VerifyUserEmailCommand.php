<?php

declare(strict_types=1);

namespace App\Message\Command;

final class VerifyUserEmailCommand
{
    public function __construct(
        private readonly string $id,
        private readonly string $signedUrl
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getSignedUrl(): string
    {
        return $this->signedUrl;
    }
}