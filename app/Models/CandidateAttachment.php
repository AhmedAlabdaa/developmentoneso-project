<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'attachment_type',
        'attachment_file',
        'attachment_name',
        'attachment_number',
        'issued_on',
        'expired_on',
        'created_by',
    ];

    public function candidate()
    {
        return $this->belongsTo(NewCandidate::class, 'candidate_id');
    }
}
