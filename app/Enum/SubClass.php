<?php

namespace App\Enum;

enum SubClass: int
{
    case CURRENT_ASSET = 1;
    case NON_CURRENT_ASSET = 2;
    case CURRENT_LIABILITY = 3;
    case NON_CURRENT_LIABILITY = 4;
    case EQUITY = 5;
    case INCOME = 6;
    case EXPENSE = 7;
    case COGS= 8;
  
 

    public function label(): string
    {
        return match ($this) {
            self::CURRENT_ASSET => 'Current Asset',
            self::NON_CURRENT_ASSET => 'Non Current Asset',
            self::CURRENT_LIABILITY => 'Current Liability',
            self::NON_CURRENT_LIABILITY => 'Non Current Liability',
            self::EQUITY => 'Equity',
            self::INCOME => 'Income',
            self::EXPENSE => 'Expense',
            self::COGS => 'Cost of Sales (COGS)',
        };
    }
}
