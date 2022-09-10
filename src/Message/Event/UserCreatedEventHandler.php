<?php

declare(strict_types=1);

namespace App\Message\Event;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UserCreatedEventHandler implements MessageHandlerInterface
{
    public function __invoke(UserCreatedEvent $userCreatedEvent)
    {
    }
}