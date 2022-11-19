<?php

declare(strict_types=1);

namespace App\Message\CommandHandler;

use App\Entity\User;
use App\Message\Command\BuyCryptoCurrencyCommand;
use App\User\CryptoCurrency\Manager\UserCryptoCurrencyManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class BuyCryptoCurrencyCommandHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserCryptoCurrencyManagerInterface $userCryptoCurrencyManager
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

        $this->userCryptoCurrencyManager->buy($user, $symbol, $quantity);
    }
}