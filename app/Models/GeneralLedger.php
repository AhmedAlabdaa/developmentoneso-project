<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralLedger extends Model
{
    use HasFactory;

    protected $table = 'general_ledger';
    protected $primaryKey = 'ledger_id';

    protected $fillable = [
        'account_id',
        'transaction_date',
        'reference_no',
        'description',
        'debit_amount',
        'credit_amount',
        'transaction_type',
        'created_at',
        'updated_at',
    ];

    public function account()
    {
        return $this->belongsTo(ChartOfAccounts::class, 'account_id');
    }
}
