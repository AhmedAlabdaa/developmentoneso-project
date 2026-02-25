<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference_no',
        'name_of_staff',
        'nationality',
        'passport_no',
        'passport_expiry_date',
        'status',
        'slug',
        'date_of_joining',
        'actual_designation',
        'visa_designation',
        'gender',
        'date_of_birth',
        'marital_status',
        'employment_contract_start_date',
        'employment_contract_end_date',
        'contract_type',
        'file_entry_permit_no',
        'uid_no',
        'contact_no',
        'temp_work_permit_no',
        'temp_work_permit_expiry_date',
        'personal_no',
        'labor_card_no',
        'labor_card_expiry_date',
        'residence_visa_start_date',
        'residence_visa_expiry_date',
        'emirates_id_number',
        'eid_expiry_date',
        'salary_as_per_contract',
        'basic',
        'housing',
        'transport',
        'other_allowances',
        'total_salary',
        'pc',
        'laptop',
        'mobile',
        'company_sim',
        'printer',
        'wps_cash',
        'bank_name',
        'iban',
        'comments',
        'remarks',
    ];
}
