<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypingTranGovInv extends Model
{
    /** @use HasFactory<\Database\Factories\TypingTranGovInvFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'serial_no',
        'gov_dw_no',
        'gov_inv_attachments',
        'maid_id',
        'ledger_id',
        'amount_received',
        'amount_of_invoice',
        'services_json',
    ];

    protected $casts = [
        'gov_inv_attachments' => 'array',
        'services_json' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $lastId = self::max('id') + 1;
            $model->serial_no = 'GOV-INV-' . str_pad($lastId, 6, '0', STR_PAD_LEFT);
        });
    }

    public function ledger(): BelongsTo
    {
        return $this->belongsTo(LedgerOfAccount::class, 'ledger_id');
    }

    public function journal(): MorphOne
    {
        return $this->morphOne(JournalHeader::class, 'source');
    }

    public function receiptVoucher(): MorphMany
    {
        return $this->morphMany(ReceiptVoucher::class, 'source');
    }
}
