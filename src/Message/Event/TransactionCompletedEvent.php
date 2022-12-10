<?php

declare(strict_types=1);

namespace App\Message\Event;

use App\Dto\TransactionSummaryDto;
use App\Enum\TransactionTypeEnum;

final class TransactionCompletedEvent
{
    public function __construct(
        private readonly string $userId,
        private readonly string $symbol,
        private readonly float $quantity,
        private readonly float $totalValue,
        private readonly TransactionTypeEnum $transactionType
    )
    {
    }

    public static function fromTransactionSummaryDto(TransactionSummaryDto $transactionSummaryDto): self
    {
        return new self(
            $transactionSummaryDto->getUser()->getId(),
            $transactionSummaryDto->getSymbol(),
            $transactionSummaryDto->getQuantity(),
            $transactionSummaryDto->getTotalValue(),
            $transactionSummaryDto->getTransactionType()
        );
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getTotalValue(): float
    {
        return $this->totalValue;
    }

    public function getTransactionType(): TransactionTypeEnum
    {
        return $this->transactionType;
    }
}