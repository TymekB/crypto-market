<?php

declare(strict_types=1);

namespace App\API\Binance;

final class CryptoCurrency
{
    private string $symbol;
    private float $lastPrice;
    private float $priceChange;
    private float $priceChangePercent;

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    public function setLastPrice(string $lastPrice): void
    {
        $this->lastPrice = (float)$lastPrice;
    }

    public function getLastPrice(): float
    {
        return $this->lastPrice;
    }

    public function setPriceChange(string $priceChange): void
    {
        $this->priceChange = (float)$priceChange;
    }

    public function getPriceChange(): float
    {
        return $this->priceChange;
    }

    public function setPriceChangePercent(string $priceChangePercent): void
    {
        $this->priceChangePercent = (float)$priceChangePercent;
    }

    public function getPriceChangePercent(): float
    {
        return $this->priceChangePercent;
    }
}