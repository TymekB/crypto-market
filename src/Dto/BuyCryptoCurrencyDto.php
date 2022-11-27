<?php

declare(strict_types=1);

namespace App\Dto;

class BuyCryptoCurrencyDto extends AbstractCryptoCurrencyDto
{
    private float $userBalance;

    public function getUserBalance(): float
    {
        return $this->userBalance;
    }

    public function setUserBalance(float $userBalance): self
    {
        $this->userBalance = $userBalance;

        return $this;
    }
}