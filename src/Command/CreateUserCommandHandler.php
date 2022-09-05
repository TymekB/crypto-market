<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateUserCommandHandler implements MessageHandlerInterface
{
    public function __invoke(CreateUserCommand $createUserCommand)
    {

    }
}