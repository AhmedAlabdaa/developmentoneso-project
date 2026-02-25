<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = 'installments';

    protected $fillable = [
        'reference_no',
        'agreement_no',
        'invoice_number',
        'CL_Number',
        'CN_Number',
        'customer_name',
        'employee_name',
        'passport_no',
        'contract_duration',
        'contract_start_date',
        'contract_end_date',
        'package',
        'contract_amount',
        'number_of_installments',
        'paid_installments',
        'created_by',
    ];

    public function items()
    {
        return $this->hasMany(InstallmentItem::class);
    }
}
