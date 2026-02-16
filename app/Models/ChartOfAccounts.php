<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccounts extends Model
{
    use HasFactory;

    protected $table = 'coa_accounts';
    protected $primaryKey = 'account_id';
    public $timestamps = false;

    protected $casts = [
        'account_id' => 'integer',
        'is_posting' => 'boolean',
        'is_control' => 'boolean',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $fillable = [
        'account_code',
        'account_name',
        'parent_account_code',
        'account_type',
        'normal_balance',
        'is_posting',
        'is_control',
        'currency_code',
        'is_active',
        'sort_order',
    ];

    public function parentAccount()
    {
        return $this->belongsTo(self::class, 'parent_account_code', 'account_code');
    }

    public function childAccounts()
    {
        return $this->hasMany(self::class, 'parent_account_code', 'account_code');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    public function scopePosting($q)
    {
        return $q->where('is_posting', 1);
    }
}
