<?php

declare(strict_types=1);

namespace App\User\CryptoCurrency;

use App\API\Binance\CryptoCurrency\Asset;

final class Wallet implements WalletInterface
{
    private array $assets = [];

    public function addAsset(Asset $asset): void
    {
        $this->assets[] = $asset;
    }

    public function getAssets(): array
    {
        return $this->assets;
    }

    public function getUserBalance(): float
    {
        $assetValues = array_map(function(Asset $asset) {
            return $asset->getValue();
        }, $this->assets);

        return array_sum($assetValues);
    }
}