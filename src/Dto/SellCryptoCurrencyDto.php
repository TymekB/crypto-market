<?php

declare(strict_types=1);

namespace App\Dto;

final class SellCryptoCurrencyDto extends AbstractCryptoCurrencyDto
{
    protected float $userQuantity;

    public function getUserQuantity(): float
    {
        return $this->userQuantity;
    }

    public function setUserQuantity(float $userQuantity): void
    {
        $this->userQuantity = $userQuantity;
    }
}