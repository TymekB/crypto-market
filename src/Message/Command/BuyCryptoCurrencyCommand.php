<?php

declare(strict_types=1);

namespace App\Message\Command;

final class BuyCryptoCurrencyCommand
{
    public function __construct(
        private readonly string $symbol,
        private readonly float $quantity,
        private readonly string $userId,
    )
    {
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }
}