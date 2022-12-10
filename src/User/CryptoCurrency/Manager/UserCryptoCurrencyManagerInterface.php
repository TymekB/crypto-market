<?php

namespace App\User\CryptoCurrency\Manager;

use App\Dto\TransactionSummaryDto;
use App\Entity\User;

interface UserCryptoCurrencyManagerInterface
{
    public function buy(User $user, string $symbol, float $quantity): TransactionSummaryDto;

    public function sell(User $user, string $symbol, float $quantity): TransactionSummaryDto;
}