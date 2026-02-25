<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\JournalHeader;

class PaymentVoucher extends Model
{
    protected $fillable = [
        'voucher_no',
        'voucher_date',
        'payee',
        'mode_of_payment',
        'reference_no',
        'total_debit',
        'total_credit',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'cancelled_by',
        'cancelled_at',
        'narration',
        'lines_json',
        'attachments',
    ];

    protected $casts = [
        'voucher_date' => 'date',
        'approved_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'lines_json' => 'array',
        'attachments' => 'array',
        'created_by' => 'integer',
        'approved_by' => 'integer',
        'cancelled_by' => 'integer',
    ];

    public function journal(): MorphOne
    {
        return $this->morphOne(JournalHeader::class, 'source');
    }
}
