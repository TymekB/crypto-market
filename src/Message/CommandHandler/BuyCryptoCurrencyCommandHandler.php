<?php

declare(strict_types=1);

namespace App\Message\CommandHandler;

use App\API\Binance\CryptoCurrency\Manager\CryptoCurrencyManagerInterface;
use App\Entity\CryptoCurrency;
use App\Entity\User;
use App\Message\Command\BuyCryptoCurrencyCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class BuyCryptoCurrencyCommandHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CryptoCurrencyManagerInterface $cryptoCurrencyManager
    )
    {
    }

    public function __invoke(BuyCryptoCurrencyCommand $buyCryptoCurrencyCommand): void
    {
        $userId = $buyCryptoCurrencyCommand->getUserId();
        $symbol = $buyCryptoCurrencyCommand->getSymbol();
        $quantity = $buyCryptoCurrencyCommand->getQuantity();

        $user = $this->entityManager
            ->getRepository(User::class)
            ->find($userId);

        $binanceCryptoCurrency = $this->cryptoCurrencyManager->getCryptoCurrency($symbol);

        if($binanceCryptoCurrency->getSymbol() !== $symbol) {
            throw new \Exception();
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