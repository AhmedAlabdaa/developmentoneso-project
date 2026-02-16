<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'candidate_id',
        'passport_no',
        'nationality',
        'foreign_partner',
        'agreement_no',
        'work_days',
        'total_salary',
        'salary_for_work_days',
        'sales_name',
        'status',
    ];

    protected $casts = [
        'work_days' => 'integer',
        'total_salary' => 'decimal:2',
        'salary_for_work_days' => 'decimal:2',
    ];
}
