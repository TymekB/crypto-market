<?php

declare(strict_types=1);

namespace App\Exception\User\CryptoCurrency;

use Throwable;

final class UserDoesNotHaveEnoughBalanceException extends \Exception
{
    public function __construct(string $message = "User does not have enough balance to buy this cryptocurrency.", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}