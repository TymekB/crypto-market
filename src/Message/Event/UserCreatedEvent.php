<?php

declare(strict_types=1);

namespace App\Message\Event;

use App\Dto\UserDto;

final class UserCreatedEvent
{
    public function __construct(
        private readonly UserDto $user
    ) {}

    public function getUser(): UserDto
    {
        return $this->user;
    }
}