<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trial extends Model
{
    use HasFactory;

    protected $table = 'trials';

    protected $fillable = [
        'candidate_id',
        'reference_no',
        'candidate_name',
        'trial_type',
        'client_id',
        'CL_Number',
        'CN_Number',
        'trial_start_date',
        'trial_end_date',
        'number_of_days',
        'package',
        'trial_status',
        'active_date',
        'confirmed_date',
        'change_status_date',
        'sales_return_date',
        'incident_date',
        'incident_type',
        'agreement_reference_no',
        'agreement_amount',
        'remarks',
        'incident_proof',
        'payment_proof',
        'change_status_proof',
        'created_by',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(NewCandidate::class, 'candidate_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(CRM::class, 'client_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'candidate_id', 'id')
                    ->where('trial_type', 'package');
    }
}
