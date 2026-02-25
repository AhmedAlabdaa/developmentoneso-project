<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budgets';
    protected $primaryKey = 'budget_id';

    protected $fillable = [
        'account_id',
        'fiscal_year',
        'allocated_budget',
        'spent_amount',
        'remaining_budget',
        'created_at',
        'updated_at',
    ];

    public function account()
    {
        return $this->belongsTo(ChartOfAccounts::class, 'account_id');
    }
}
