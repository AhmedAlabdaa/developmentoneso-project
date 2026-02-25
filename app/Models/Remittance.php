<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remittance extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'candidate_id',
        'candidate_name',
        'passport_no',
        'nationality',
        'foreign_partner',
        'amount',
        'sales_name',
        'status',
        'payment_method',
        'payment_proof',
        'paid_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_date' => 'date',
    ];
}
