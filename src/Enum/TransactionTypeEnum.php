<?php

namespace App\Enum;

enum TransactionTypeEnum: string
{
    case SELL = 'Sell';
    case BUY = 'Buy';
}
