<?php

namespace App\Decorator;

use App\Entity\User;

interface UserCryptoCurrencyManagerInterface
{
    public function getUserCryptoCurrencyList(User $user): array;
}