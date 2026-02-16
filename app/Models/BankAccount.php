<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = 'bank_accounts';
    protected $primaryKey = 'bank_account_id';

    protected $fillable = [
        'account_name',
        'account_number',
        'bank_name',
        'currency',
        'balance',
        'created_at',
        'updated_at',
    ];
}
