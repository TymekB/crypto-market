<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\User;
use App\Enum\TransactionTypeEnum;

final class TransactionSummaryDto
{
    public function __construct(
        private readonly User $user,
        private readonly string $symbol,
        private readonly float $quantity,
        private readonly float $totalValue,
        private readonly TransactionTypeEnum $transactionType
    )
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getTotalValue(): float
    {
        return $this->totalValue;
    }

    public function getTransactionType(): TransactionTypeEnum
    {
        return $this->transactionType;
    }
}