<?php

namespace App\Enum;

enum PaymentMode : int
{
  case CASH = 1;
  case CREDIT_CARD = 2;
  case DEBIT_CARD = 3;
  case BANK_TRANSFER = 4;


  public function label(): string
  {
    return match ($this) {
      self::CASH => 'Cash',
      self::CREDIT_CARD => 'Credit Card',
      self::DEBIT_CARD => 'Debit Card',
      self::BANK_TRANSFER => 'Bank Transfer',
    };
  } 
}

