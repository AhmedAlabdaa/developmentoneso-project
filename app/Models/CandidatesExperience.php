<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesExperience extends Model
{
    use HasFactory;

    protected $table = 'candidates_experience';

    protected $fillable = [
        'candidate_id',
        'country',
        'experience_years',
        'experience_months',
    ];

    public function candidate()
    {
        return $this->belongsTo(NewCandidate::class, 'candidate_id');
    }
}
