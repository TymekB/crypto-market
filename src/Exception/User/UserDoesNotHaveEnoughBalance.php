<?php

declare(strict_types=1);

namespace App\Exception\User;

use Throwable;

final class UserDoesNotHaveEnoughBalance extends \Exception
{
    #[Pure] public function __construct(string $message = "You don't have enough balance to buy this cryptocurrency.", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}