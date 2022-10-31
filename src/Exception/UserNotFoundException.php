<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;

class UserNotFoundException extends \Exception
{
    public function __construct(
        string $message = "User with this email address does not exist.",
        int $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

}