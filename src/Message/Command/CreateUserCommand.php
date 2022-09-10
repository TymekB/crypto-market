<?php

declare(strict_types=1);

namespace App\Message\Command;

use App\Dto\UserDto;

final class CreateUserCommand
{
    public function __construct(
        private readonly string $email,
        private readonly string $password
    ) {}

    public static function fromDto(UserDto $user)
    {
        return new self(
            $user->getEmail(),
            $user->getPassword()
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}