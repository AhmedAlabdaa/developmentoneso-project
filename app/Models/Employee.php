<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'CN_Number',
        'CL_Number',
        'package',
        'name',
        'slug',
        'nationality',
        'passport_no',
        'passport_expiry_date',
        'date_of_joining',
        'visa_designation',
        'date_of_birth',
        'arrived_date',
        'gender',
        'employment_contract_start_date',
        'employment_contract_end_date',
        'contract_type',
        'file_entry_permit_no',
        'file_entry_permit_issued_date',
        'file_entry_permit_expired_date',
        'uid_no',
        'foreign_partner',
        'personal_no',
        'labor_card_no',
        'labor_card_issued_date',
        'labor_card_expiry_date',
        'iloe_number',
        'iloe_issued_date',
        'iloe_expired_date',
        'residence_visa_start_date',
        'residence_visa_expiry_date',
        'eid_issued_date',
        'eid_expiry_date',
        'insurance_policy_number',
        'insurance_policy_issued_date',
        'insurance_policy_expired_date',
        'salary_as_per_contract',
        'basic',
        'housing',
        'transport',
        'other_allowances',
        'total_salary',
        'payment_type',
        'bank_name',
        'current_status',
        'iban',
        'comments',
        'status',
        'inside_status',
        'visa_status',
        'incident_type',
        'incident_date',
        'remarks',
        'inside_country_or_outside',
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
        'contract_no',
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
        'sponsor_name',
        'emirates_id',
        'visa_type',
        'contract_duration',
        'contract_end_date',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_title_ar',
        'meta_keywords_ar',
        'meta_description_ar',
        'sales_name',
        'sale_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'salary'                           => 'decimal:2',
        'children_count'                   => 'integer',
        'experience_years'                 => 'integer',
        'marital_status'                   => 'integer',
        'passport_expiry_date'             => 'date',
        'date_of_joining'                  => 'date',
        'date_of_birth'                    => 'date',
        'employment_contract_start_date'   => 'date',
        'employment_contract_end_date'     => 'date',
        'labor_card_issued_date'           => 'date',
        'labor_card_expiry_date'           => 'date',
        'file_entry_permit_issued_date'    => 'date',
        'file_entry_permit_expired_date'   => 'date',
        'iloe_issued_date'                 => 'date',
        'iloe_expired_date'                => 'date',
        'residence_visa_start_date'        => 'date',
        'residence_visa_expiry_date'       => 'date',
        'eid_issued_date'                  => 'date',
        'eid_expiry_date'                  => 'date',
        'insurance_policy_issued_date'     => 'date',
        'insurance_policy_expired_date'    => 'date',
        'incident_date'                    => 'date',
        'passport_issue_date'              => 'date',
        'expiry_date'                      => 'date',
    ];

    public function currentStatus(): BelongsTo
    {
        return $this->belongsTo(CurrentStatus::class, 'current_status');
    }

    public function getRouteKeyName(): string
    {
        return 'reference_no';
    }

    public function agreements(): HasMany
    {
        return $this->hasMany(Agreement::class, 'candidate_id', 'id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(EmployeeAttachment::class, 'employee_id', 'id');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(EmployeeExperience::class, 'employee_id', 'id');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(EmployeeSkill::class, 'employee_id', 'id');
    }
}
