<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewCandidate extends Model
{
    use HasFactory;

    protected $table = 'new_candidates';

    protected $fillable = [
        'reference_no',
        'ref_no',
        'CN_Number',
        'candidate_name',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'meta_title_ar',
        'meta_keywords_ar',
        'meta_description_ar',
        'passport_no',
        'passport_issue_date',
        'passport_issue_place',
        'nationality',
        'passport_expiry_date',
        'date_of_birth',
        'foreign_partner',
        'branch_in_uae',
        'age',
        'gender',
        'salary',
        'sponsorship',
        'work_skill_general_description',
        'contract_duration',
        'religion',
        'english_skills',
        'arabic_skills',
        'applied_position',
        'work_skill',
        'skill_description',
        'education_level',
        'marital_status',
        'number_of_children',
        'height',
        'weight',
        'preferred_package',
        'desired_country',
        'coc_status',
        'place_of_birth',
        'candidate_current_address',
        'labour_id_date',
        'labour_id_number',
        'family_name',
        'family_contact_number_1',
        'family_contact_number_2',
        'relationship_with_candidate',
        'family_current_address',
        'current_status',
        'visa_status',
        'hold_date',
        'selected_date',
        'wc_date',
        'wc_added_date',
        'visa_date',
        'visa_added_date',
        'uid_number',
        'entry_permit_number',
        'visa_number',
        'phone_number',
        'arrived_date',
        'arrived_added_date',
        'transfer_date',
        'transfer_added_date',
        'office_date',
        'trial_date',
        'confirmed_date',
        'change_status_date',
        'sales_name',
        'visa_type',
        'rejected_date',
        'remarks',
        'created_at',
        'updated_at',
        'updated_by',
        'inside_status',
        'arrived_in_office_date',
        'accomodation',
        'passport_status',
        'visa_issue_date',
        'visa_expiry_date',
        'entry_date',
        'cancellation_date',
        'dw_number',
        'overstay_days',
        'fine_amount',
        'wc_date_remark',
        'incident_before_visa_remark',
        'visa_date_remark',
        'incident_after_visa_remark',
        'updateArrivedDateModalremarks',
        'incident_after_departure_remark',
        'incident_after_arrival_remark',
        'transfer_date_remark',
        'backout_date',
        'incident_before_visa_date',
        'incident_after_visa_date',
        'hospital_name',
        'medical_date',
        'medical_status',
        'medical_status_date',
        'coc_status_date',
        'coc_registration_date',
        'coc_issued_date',
        'coc_expired_on',
        'l_submitted_date',
        'l_issued_date',
        'departure_date',
        'incident_after_departure_date',
        'incident_after_arrival_date',
        'appeal',
        'appeal_date',
        'medical_remarks',
        'coc_remarks',
        'l_submitted_date_remarks',
        'l_issued_date_remarks',
        'departure_date_remarks',
        'l_submission_date',
        'pulled_date',
        'insurance_approved_date',
        'status',
        'pcc_date',
        'pcc_status',
        'embassy_submitted_date',
        'embassy_payment_proof',
        'embassy_released_date',
        'insurance_date',
        'insurance_status',
    ];

    public function candidatesExperience()
    {
        return $this->hasMany(CandidatesExperience::class, 'candidate_id');
    }

    public function attachments()
    {
        return $this->hasMany(CandidateAttachment::class, 'candidate_id');
    }

    public function experiences()
    {
        return $this->hasMany(CandidatesExperience::class, 'candidate_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality');
    }

    public function appliedPosition()
    {
        return $this->belongsTo(AppliedPosition::class, 'applied_position');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'education_level');
    }

    public function desiredCountry()
    {
        return $this->belongsTo(DesiredCountry::class, 'desired_country');
    }

    public function fraName()
    {
        return $this->belongsTo(FraName::class, 'branch_in_uae');
    }

    public function medicalStatus()
    {
        return $this->belongsTo(MedicalStatus::class, 'medical_status');
    }

    public function cocStatus()
    {
        return $this->belongsTo(CocStatus::class, 'coc_status');
    }

    public function currentStatus()
    {
        return $this->belongsTo(CurrentStatus::class, 'current_status');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_name');
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_status');
    }

    public function getRouteKeyName()
    {
        return 'ref_no';
    }

    public function getWorkSkillsAttribute()
    {
        if (empty($this->work_skill)) {
            return collect();
        }

        $skillIds = explode(',', $this->work_skill);
        return WorkSkill::whereIn('id', $skillIds)->get();
    }

    public function agreement()
    {
        return $this->hasOne(Agreement::class, 'candidate_id')->where('agreement_type', 'BOA');
    }

    public function receiptVouchers()
    {
        return $this->morphMany(ReceiptVoucher::class, 'source');
    }
}
