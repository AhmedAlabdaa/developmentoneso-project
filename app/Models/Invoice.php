<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $primaryKey = 'invoice_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'invoice_number',
        'agreement_reference_no',
        'customer_id',
        'CL_Number',
        'CN_Number',
        'reference_no',
        'invoice_type',
        'payment_method',
        'invoice_date',
        'due_date',
        'total_amount',
        'received_amount',
        'discount_amount',
        'tax_amount',
        'balance_due',
        'status',
        'notes',
        'payment_proof',
        'upcoming_payment_date',
        'has_finance',
        'refunded',
        'created_by',
    ];

    protected $casts = [
        'refunded' => 'boolean',
        'has_finance' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'invoice_id');
    }

    public function candidate()
    {
        return $this->belongsTo(NewCandidate::class, 'CN_Number', 'CN_Number');
    }

    public function customer()
    {
        return $this->belongsTo(CRM::class, 'customer_id', 'id');
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_reference_no', 'reference_no');
    }

    public function contract()
    {
        return $this->belongsTo(
            Contract::class,
            'agreement_reference_no',
            'agreement_reference_no'
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function receiptVouchers()
    {
        return $this->morphMany(ReceiptVoucher::class, 'source');
    }

    public function journal()
    {
        return $this->morphOne(JournalHeader::class, 'source');
    }
}
