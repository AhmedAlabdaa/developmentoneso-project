<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Agreement;

class Package extends Model
{
    protected $table = 'packages';

    protected $fillable = [
        'candidate_id',
        'cn_number_series',
        'CN_Number',
        'hr_ref_no',
        'contract_no',
        'agreement_no',
        'sales_name',
        'candidate_name',
        'foreign_partner',
        'current_status',
        'inside_status',
        'passport_no',
        'passport_expiry_date',
        'date_of_birth',
        'branch_in_uae',
        'visa_type',
        'CL_Number',
        'sponsor_name',
        'eid_no',
        'nationality',
        'CL_nationality',
        'wc_date',
        'dw_number',
        'visa_date',
        'incident_type',
        'incident_date',
        'arrived_date',
        'package',
        'sales_comm_status',
        'remark',
        'inside_country_or_outside',
        'missing_file',
        'change_status_date',
        'cs_date',
        'change_status_proof',
        'penalty_payment_amount',
        'penalty_payment_proof',
        'penalty_paid_by',
        'istiraha_proof',
        'created_at',
        'updated_at',
        'montly_salary',
        'contract_period',
        'religion',
        'place_of_birth',
        'living_town',
        'maritial_status',
        'no_of_childrens',
        'weight',
        'height',
        'education',
        'languages',
        'working_experience',
        'previous_employements',
        'family_contract_no',
        'passport_issue_date',
        'place_of_issue',
        'expiry_date',
        'salary',
        'marital_status',
        'children_count',
        'experience_years',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_title_ar',
        'meta_keywords_ar',
        'meta_description_ar',
    ];

    public $timestamps = true;

    protected $casts = [
        'passport_expiry_date'   => 'date',
        'date_of_birth'          => 'date',
        'wc_date'                => 'date',
        'visa_date'              => 'date',
        'incident_date'          => 'date',
        'arrived_date'           => 'date',
        'change_status_date'     => 'date',
        'cs_date'                => 'date',
        'passport_issue_date'    => 'date',
        'expiry_date'            => 'date',
        'montly_salary'          => 'decimal:2',
        'salary'                 => 'decimal:2',
        'penalty_payment_amount' => 'decimal:2',
        'no_of_childrens'        => 'integer',
        'children_count'         => 'integer',
        'experience_years'       => 'integer',
        'marital_status'         => 'integer',
        'weight'                 => 'decimal:2',
        'height'                 => 'decimal:2',
    ];

    public function currentStatus(): BelongsTo
    {
        return $this->belongsTo(CurrentStatus::class, 'current_status');
    }

    public function trial(): HasOne
    {
        return $this->hasOne(Trial::class, 'candidate_id', 'id')
            ->where('trial_type', 'package')
            ->where('trial_status', 'Active');
    }

    public function office(): HasOne
    {
        return $this->hasOne(Office::class, 'candidate_id', 'id')
            ->where('type', 'package')
            ->where('status', 1);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(PackageAttachment::class, 'package_id', 'id');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(PackageExperience::class, 'package_id');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(PackageSkill::class, 'package_id');
    }

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class, 'agreement_no', 'reference_no')
            ->withDefault([
                'status' => null,
                'agreement_status' => null,
            ]);
    }

    public function getAgreementStatusAttribute(): ?string
    {
        $a = $this->agreement;
        return $a->status ?? $a->agreement_status ?? null;
    }
}
