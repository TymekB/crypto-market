<?php

declare(strict_types=1);

namespace App\Entity;

final class CryptoCurrency
{
    private ?string $id = null;

    private ?User $user;

    private string $symbol;

    private float $quantity;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
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

    public function addQuantity(float $quantity): void
    {
        $this->quantity += $quantity;
    }
}