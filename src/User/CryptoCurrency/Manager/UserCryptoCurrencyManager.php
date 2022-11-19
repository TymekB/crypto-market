<?php

declare(strict_types=1);

namespace App\User\CryptoCurrency\Manager;

use App\API\Binance\CryptoCurrency\Manager\CryptoCurrencyManagerInterface;
use App\Entity\CryptoCurrency;
use App\Entity\User;
use App\Exception\User\UserDoesNotHaveEnoughBalance;
use Doctrine\ORM\EntityManagerInterface;

final class UserCryptoCurrencyManager implements UserCryptoCurrencyManagerInterface
{
    public function __construct(
        private readonly CryptoCurrencyManagerInterface $cryptoCurrencyManager,
        private readonly EntityManagerInterface $entityManager
    )
    {

    }

    public function buy(User $user, string $symbol, float $quantity): void
    {
        $binanceCryptoCurrency = $this->cryptoCurrencyManager->getCryptoCurrency($symbol);

        $totalValue = $quantity * $binanceCryptoCurrency->getLastPrice();

        if($totalValue > $user->getBalance()) {
            throw new UserDoesNotHaveEnoughBalance();
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