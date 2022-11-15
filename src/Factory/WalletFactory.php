<?php

declare(strict_types=1);

namespace App\Factory;

use App\API\Binance\CryptoCurrency as BinanceCryptoCurrency;
use App\API\Binance\CryptoCurrency\Asset;
use App\API\Binance\CryptoCurrency\Manager\CryptoCurrencyManagerInterface;
use App\Entity\CryptoCurrency;
use App\Entity\User;
use App\User\CryptoCurrency\Wallet;

final class WalletFactory implements WalletFactoryInterface
{
    public function __construct(private readonly CryptoCurrencyManagerInterface $cryptoCurrencyManager)
    {
    }

    public function create(User $user): Wallet {

        $symbols = $user->getCryptoCurrencies()->map(function (CryptoCurrency $cryptoCurrency) {
            return $cryptoCurrency->getSymbol();
        })->toArray();

        $cryptoCurrencies = $this->cryptoCurrencyManager->getCryptoCurrencies($symbols);
        $cryptoCurrenciesArray = [];

        /** @var BinanceCryptoCurrency $cryptoCurrency */
        foreach($cryptoCurrencies as $cryptoCurrency) {
            $cryptoCurrenciesArray[$cryptoCurrency->getSymbol()] = $cryptoCurrency;
        }

        $wallet = new Wallet();

        /** @var CryptoCurrency $userCryptoCurrency */
        foreach($user->getCryptoCurrencies() as $userCryptoCurrency) {
            $asset = new Asset();

            $cryptoCurrency = $cryptoCurrenciesArray[$userCryptoCurrency->getSymbol()];
            $value = $userCryptoCurrency->getQuantity() * $cryptoCurrency->getLastPrice();
            $quantity = $userCryptoCurrency->getQuantity();
            $priceChangePercent = $cryptoCurrency->getPriceChangePercent();

            $asset->setCryptoCurrency($cryptoCurrency);
            $asset->setValue($value);
            $asset->setPriceChangePercent($priceChangePercent);
            $asset->setQuantity($quantity);

            $wallet->addAsset($asset);
        }

        return $wallet;
    }
}