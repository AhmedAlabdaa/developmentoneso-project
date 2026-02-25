<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProof extends Model
{
    use HasFactory;

    protected $table = 'payment_proofs';

    protected $fillable = [
        'candidate_id',
        'client_name',
        'invoice_id',
        'invoice_amount',
        'payment_method',
        'created_by',
    ];

    public function candidate()
    {
        return $this->belongsTo(NewCandidate::class, 'candidate_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
