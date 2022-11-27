<?php

declare(strict_types=1);

namespace App\User\CryptoCurrency\Manager;

use App\API\Binance\CryptoCurrency\Manager\CryptoCurrencyManagerInterface;
use App\Entity\CryptoCurrency;
use App\Entity\User;
use App\Exception\CryptoCurrency\CryptoCurrencyQuantityLessOrEqualZeroException;
use App\Exception\User\CryptoCurrency\UserDoesNotHaveEnoughBalanceException;
use App\Exception\User\CryptoCurrency\UserDoesNotHaveEnoughQuantityException;
use Doctrine\ORM\EntityManagerInterface;

final class UserCryptoCurrencyManager implements UserCryptoCurrencyManagerInterface
{
    public function __construct(
        private readonly CryptoCurrencyManagerInterface $cryptoCurrencyManager,
        private readonly EntityManagerInterface $entityManager,
    )
    {

    }

    private function countTotalValue(string $symbol, float $quantity): float
    {
        $binanceCryptoCurrency = $this->cryptoCurrencyManager->getCryptoCurrency($symbol);

        return round($quantity * $binanceCryptoCurrency->getLastPrice(), 2);
    }

    public function buy(User $user, string $symbol, float $quantity): void
    {
        if($quantity <= 0) {
            throw new CryptoCurrencyQuantityLessOrEqualZeroException();
        }

        $totalValue = $this->countTotalValue($symbol, $quantity);

        if($user->getBalance() < $totalValue) {
            throw new UserDoesNotHaveEnoughBalanceException();
        }

        /** @var CryptoCurrency $cryptoCurrency */
        $cryptoCurrency = $this->entityManager
            ->getRepository(CryptoCurrency::class)
            ->findOneBy(['symbol' => $symbol, 'user' => $user]);

        if(!$cryptoCurrency) {
            $cryptocurrency = new CryptoCurrency();
            $cryptocurrency->setUser($user);
            $cryptocurrency->setSymbol($symbol);
            $cryptocurrency->setQuantity($quantity);

            $this->entityManager->persist($cryptocurrency);
        } else {
            $cryptoCurrency->addQuantity($quantity);
        }

        $this->entityManager->flush();
    }
}