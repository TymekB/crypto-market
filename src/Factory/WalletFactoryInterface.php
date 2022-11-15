<?php

namespace App\Factory;

use App\Entity\User;
use App\User\CryptoCurrency\Wallet;

interface WalletFactoryInterface
{
    public function create(User $user): Wallet;
}