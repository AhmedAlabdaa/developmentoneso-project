<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalTranLine extends Model
{
    protected $table = 'journal_tran_lines';

    protected $fillable = [
        'journal_header_id',
        'employee_id',
        'cn_number',
        'ledger_id',
        'debit',
        'credit',
        'note',
        'created_by',
    ];

    protected $casts = [
        'debit'  => 'decimal:2',
        'credit' => 'decimal:2',
    ];

    public function header(): BelongsTo
    {
        return $this->belongsTo(JournalHeader::class, 'journal_header_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function ledger(): BelongsTo
    {
        return $this->belongsTo(LedgerOfAccount::class, 'ledger_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
