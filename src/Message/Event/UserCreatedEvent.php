<?php

declare(strict_types=1);

namespace App\Message\Event;

use App\Dto\UserDto;

final class UserCreatedEvent
{
    public function __construct(
        private readonly string $id,
        private readonly string $email
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public static function fromDto(UserDto $userDto): self
    {
        return new self(
            $userDto->getId(),
            $userDto->getEmail()
        );
    }

}