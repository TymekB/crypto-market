<?php

declare(strict_types=1);

namespace App\Security\Exception;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

final class UserNotVerifiedException extends CustomUserMessageAccountStatusException
{
    public function __construct(
        string $message = 'You have to confirm your email.',
        array $messageData = [], int $code = 0,
        \Throwable $previous = null
    )
    {
        parent::__construct($message, $messageData, $code, $previous);
    }

}