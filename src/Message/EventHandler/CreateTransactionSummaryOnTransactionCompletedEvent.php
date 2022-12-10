<?php

declare(strict_types=1);

namespace App\Message\EventHandler;

use App\Entity\CryptoCurrency\TransactionSummary;
use App\Entity\User;
use App\Message\Event\TransactionCompletedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateTransactionSummaryOnTransactionCompletedEvent
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }


    public function __invoke(TransactionCompletedEvent $transactionCompletedEvent)
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->find($transactionCompletedEvent->getUserId());

        if(!$user) {
            throw new \Exception();
        }

        $transactionSummary = new TransactionSummary();
        $transactionSummary->setUser($user);
        $transactionSummary->setType($transactionCompletedEvent->getTransactionType());
        $transactionSummary->setSymbol($transactionCompletedEvent->getSymbol());
        $transactionSummary->setQuantity($transactionCompletedEvent->getQuantity());
        $transactionSummary->setPrice($transactionCompletedEvent->getTotalValue());
        $transactionSummary->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($transactionSummary);
        $this->entityManager->flush();
    }
}