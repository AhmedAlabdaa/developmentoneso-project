<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntryDetails extends Model
{
    use HasFactory;

    protected $table = 'journal_entry_details';
    protected $primaryKey = 'detail_id';

    protected $fillable = [
        'journal_id',
        'account_code',
        'debit_amount',
        'credit_amount',
        'description',
    ];

    public function journal()
    {
        return $this->belongsTo(JournalEntries::class, 'journal_id');
    }

    public function account()
    {
        return $this->belongsTo(ChartOfAccounts::class, 'account_code');
    }
}
