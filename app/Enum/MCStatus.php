<?php

namespace App\Enum;

enum MCStatus: int
{
    case Pending = 0;
    case ReturnToOffice = 1;
    case RanAway = 2;
    case Cancelled = 3;
    case Hold = 4;
    
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::ReturnToOffice => 'Return To Office',
            self::RanAway => 'Ran Away',
            self::Cancelled => 'Cancelled',
            self::Hold => 'Hold',
        };
    }
   
}
