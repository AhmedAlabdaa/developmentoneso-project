<?php

namespace App\Enum;

enum AmReturnAction: int
{
    case Pending = 1;
    case ReplacementRequested = 2;
    case RefundRaised = 3;
    case DueAmountOnCustomer = 4;

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::ReplacementRequested => 'Customer Want Replacement',
            self::RefundRaised => 'Raise a Refund',
            self::DueAmountOnCustomer => 'Due Amount on Customer',
        };
    }
}
