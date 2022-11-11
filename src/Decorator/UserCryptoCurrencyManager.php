<?php

declare(strict_types=1);

namespace App\Decorator;

use App\API\Binance\CryptoCurrency as BinanceCryptoCurrency;
use App\API\Binance\CryptoCurrencyManagerInterface;
use App\Entity\CryptoCurrency;
use App\Entity\User;


final class UserCryptoCurrencyManager implements UserCryptoCurrencyManagerInterface
{
    public function __construct(private readonly CryptoCurrencyManagerInterface $cryptoCurrencyManager)
    {
    }


    public function getUserCryptoCurrencyList(User $user): array
    {
        $symbols = $user->getCryptoCurrencies()->map(function (CryptoCurrency $cryptoCurrency) {
            return $cryptoCurrency->getSymbol();
        })->toArray();

        $cryptoCurrencies = [];

        /** @var BinanceCryptoCurrency $cryptoCurrency */
        foreach($this->cryptoCurrencyManager->getCryptoCurrenciesBySymbol($symbols) as $cryptoCurrency) {
            $cryptoCurrencies[$cryptoCurrency->getSymbol()] = [
                'price' => $cryptoCurrency->getLastPrice(),
                'priceChangePercent' => $cryptoCurrency->getPriceChangePercent()
            ];
        }

        return array_map(function (CryptoCurrency $cryptoCurrency) use($cryptoCurrencies) {
            $symbol = $cryptoCurrency->getSymbol();
            $quantity = $cryptoCurrency->getQuantity();

            return [
                'symbol' => $symbol,
                'quantity' => $quantity,
                'value' => $quantity * $cryptoCurrencies[$symbol]['price'],
                'priceChangePercent' => $cryptoCurrencies[$symbol]['priceChangePercent']
            ];
        }, $user->getCryptoCurrencies()->toArray());

    }
}