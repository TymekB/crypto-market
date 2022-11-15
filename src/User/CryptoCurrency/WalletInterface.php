<?php

namespace App\User\CryptoCurrency;

use App\API\Binance\CryptoCurrency\Asset;

interface WalletInterface
{
    public function addAsset(Asset $asset): void;

    public function getAssets(): array;

    public function getUserBalance(): float;
}