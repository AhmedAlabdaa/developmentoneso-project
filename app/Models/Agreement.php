<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference_no',
        'agreement_type',
        'candidate_id',
        'CL_Number',
        'CN_Number',
        'candidate_name',
        'reference_of_candidate',
        'ref_no_in_of_previous',
        'package',
        'foreign_partner',
        'nationality',
        'passport_no',
        'passport_expiry_date',
        'date_of_birth',
        'client_id',
        'employer_name',
        'payment_method',
        'total_amount',
        'received_amount',
        'remaining_amount',
        'notes',
        'salary',
        'monthly_payment',
        'payment_cycle',
        'visa_type',
        'agreement_start_date',
        'agreement_end_date',
        'total_amount',
        'received_amount',
        'remaining_amount',
        'payment_proof',
        'agreement_start_date',
        'agreement_end_date',
        'months_count',
        'current_month_salary',
        'expected_arrival_date',
        'upcoming_payment_date',
        'installment_count',
        'cancelled_date',
        'number_of_days',
        'created_by',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(CRM::class, 'client_id', 'id');
    }

    public function candidate()
    {
        return $this->belongsTo(NewCandidate::class, 'CN_Number', 'CN_Number');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'agreement_reference_no', 'reference_no');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class, 'agreement_reference_no', 'reference_no');
    }

    public function installments()
    {
        return $this->hasMany(\App\Models\Installment::class, 'agreement_no', 'reference_no');
    }

    public function getRouteKeyName(): string
    {
        return 'reference_no';
    }
    
}
