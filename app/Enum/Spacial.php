<?php

namespace App\Enum;

enum Spacial: int
{
    case None = 0;
    case MAID_ASSETS = 1;
    case payment_method = 2;
    case customer = 3;
   

    public function label(): string
    {
        return match ($this) {
            self::None => 'None',
            self::MAID_ASSETS => 'MAID Assets',
            self::payment_method => 'Payment Method',
            self::customer => 'Customer',
          
       
        };
    }
}
