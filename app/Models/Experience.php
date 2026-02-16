<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id', 'experience_years', 'experience_months', 'country', 'other'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
