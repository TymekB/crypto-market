<?php

namespace App\API\Binance\CryptoCurrency\Manager;

use App\API\Binance\CryptoCurrency;

interface CryptoCurrencyManagerInterface
{
    public function getCryptoCurrency(string $symbol): CryptoCurrency;
    public function getCryptoCurrencies(array $symbols = null): array;
}