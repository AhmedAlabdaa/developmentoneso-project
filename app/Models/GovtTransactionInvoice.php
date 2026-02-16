<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovtTransactionInvoice extends Model
{
    protected $table = 'govt_transactions_invoices';
    protected $primaryKey = 'invoice_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'invoice_number',
        'mohre_ref',
        'invoice_date',
        'customer_type',
        'CL_Number',
        'Customer_name',
        'Customer_mobile_no',
        'candidate_name',
        'CN_Number',
        'Sales_name',
        'total_amount',
        'total_vat',
        'total_center_fee',
        'discount_amount',
        'net_total',
        'received_amount',
        'remaining_amount',
        'status',
        'currency',
        'due_date',
        'payment_reference',
        'notes',
        'payment_mode',
        'payment_proof',
        'payment_note',
        'created_by',
    ];

    protected $casts = [
        'invoice_date'      => 'date',
        'due_date'          => 'date',
        'total_amount'      => 'float',
        'total_vat'         => 'float',
        'total_center_fee'  => 'float',
        'discount_amount'   => 'float',
        'net_total'         => 'float',
        'received_amount'   => 'float',
        'remaining_amount'  => 'float',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(GovtTransactionInvoiceItem::class, 'invoice_number', 'invoice_number');
    }
}
