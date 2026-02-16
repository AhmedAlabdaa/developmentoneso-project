<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_category',
        'candidate_id',
        'candidate_name',
        'employer_name',
        'reference_no',
        'ref_no',
        'country',
        'company',
        'branch',
        'nationality',
        'incident_reason',
        'incident_expiry_date',
        'other_reason',
        'proof',
        'note',
        'created_by',
    ];

    public function candidate()
    {
        return $this->belongsTo(NewCandidate::class, 'candidate_id');
    }
}
