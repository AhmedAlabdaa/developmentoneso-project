<?php

namespace App\Models;

use App\Enum\LedgerClass;
use App\Enum\SubClass;
use App\Enum\Spacial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LedgerOfAccount extends Model
{
 
    protected $fillable = [
        'name',
        'class',
        'sub_class',
        'group',
        'spacial',
        'type',
        'note',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'class' => LedgerClass::class,
        'sub_class' => SubClass::class,
        'spacial' => Spacial::class,
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function crm(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CRM::class, 'ledger_id');
    }
}
