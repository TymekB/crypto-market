<?php

namespace App\API\Binance;

interface CryptoCurrencyManagerInterface
{
    public function getCryptoCurrencyBySymbol(string $symbol): CryptoCurrency;
    public function getCryptoCurrenciesBySymbol(array $symbols = null): array;
}