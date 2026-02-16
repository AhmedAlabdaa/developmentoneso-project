<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceServiceLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'ledger_account_id',
        'invoice_service_id',
        'amount_debit',
        'amount_credit',
        'vatable',
        'note',
        'source_amount',
    ];

    protected $casts = [
        'vatable' => 'boolean',
        'amount_debit' => 'decimal:2',
        'amount_credit' => 'decimal:2',
        'source_amount' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function invoiceService(): BelongsTo
    {
        return $this->belongsTo(InvoiceService::class, 'invoice_service_id');
    }

    public function ledger(): BelongsTo
    {
        return $this->belongsTo(LedgerOfAccount::class, 'ledger_account_id');
    }
}
