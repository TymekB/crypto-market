<?php

declare(strict_types=1);

namespace App\API\Binance\CryptoCurrency;

use App\API\Binance\CryptoCurrency;

final class Asset
{
    private CryptoCurrency $cryptoCurrency;
    private float $value;
    private float $quantity;
    private float $priceChangePercent;

    public function getCryptoCurrency(): CryptoCurrency
    {
        return $this->cryptoCurrency;
    }

    public function setCryptoCurrency(CryptoCurrency $cryptoCurrency): void
    {
        $this->cryptoCurrency = $cryptoCurrency;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function setQuantity(float $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getPriceChangePercent(): float
    {
        return $this->priceChangePercent;
    }

    public function setPriceChangePercent(float $priceChangePercent): void
    {
        $this->priceChangePercent = $priceChangePercent;
    }
}