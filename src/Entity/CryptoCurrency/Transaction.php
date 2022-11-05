<?php

declare(strict_types=1);

namespace App\Entity\CryptoCurrency;

use App\Entity\User;
use App\Enum\TransactionTypeEnum;

class Transaction
{
    private ?string $id = null;

    private ?User $user;

    private string $symbol;

    private float $quantity;

    private float $price;

    private TransactionTypeEnum $type;

    private \DateTimeImmutable $createdAt;

    public function getId(): string
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getType(): TransactionTypeEnum
    {
        return $this->type;
    }

    public function setType(TransactionTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}