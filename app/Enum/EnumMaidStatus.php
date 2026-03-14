<?php

namespace App\Enum;

enum EnumMaidStatus :int
{
    case PENDING = 0;
    case OFFICE = 1 ;
    case HIRED  = 2;
    case INCIDENTED = 3 ;

   public function label(): string

        {
        return match ($this) {
          self::PENDING => "Outside",
          self::OFFICE => "Office",
          self::HIRED => "Hired",
          self::INCIDENTED => "Incidented"
        };
    }
}
