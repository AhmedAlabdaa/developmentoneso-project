<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentItem extends Model
{
    protected $table = 'installment_items';

    protected $fillable = [
        'installment_id',
        'particular',
        'amount',
        'payment_date',
        'invoice_generated',
        'reference_no',
        'payment_proof',
        'paid_date',
        'status',
        'invoice_number',
    ];

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
}
