<?php

namespace App\User\CryptoCurrency\Manager;

use App\Entity\User;

interface UserCryptoCurrencyManagerInterface
{
    public function buy(User $user, string $symbol, float $quantity): void;
}