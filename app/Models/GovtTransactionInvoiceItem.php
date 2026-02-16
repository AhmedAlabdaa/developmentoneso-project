<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GovtTransactionInvoiceItem extends Model
{
    protected $table = 'govt_transactions_invoice_items';
    public $timestamps = true;

    protected $fillable = [
        'invoice_number',
        'service_name',
        'dw_number',
        'qty',
        'amount',
        'tax',
        'center_fee',
        'total',
    ];

    protected $casts = [
        'qty'        => 'float',
        'amount'     => 'float',
        'tax'        => 'float',
        'center_fee' => 'float',
        'total'      => 'float',
    ];
}
