<?php

namespace App\API;

interface BinanceInterface
{
    public function getPrices(array $symbols = null);
}