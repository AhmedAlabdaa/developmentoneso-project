<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplacementHistory extends Model
{
    protected $table = 'replacement_history';

    protected $fillable = [
        'client_id',
        'contract_number',
        'old_candidate_id',
        'new_candidate_id',
        'name',
        'nationality',
        'passport_no',
        'reference_no',
        'agreement_no',
        'old_invoice_number',
        'new_invoice_number',
        'replacement_date',
        'total_amount',
        'replacement_proof',
        'created_by',
    ];

    public function oldCandidate()
    {
        return $this->belongsTo(Employee::class, 'old_candidate_id', 'id');
    }

    public function newCandidate()
    {
        return $this->belongsTo(Employee::class, 'new_candidate_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(CRM::class, 'client_id', 'id');
    }
}
