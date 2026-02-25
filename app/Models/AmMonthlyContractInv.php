<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class AmMonthlyContractInv extends Model
{
    protected $fillable = [
        'date',
        'serial_no',
        'am_monthly_contract_id',
        'crm_id',
        'am_installment_id',
        'note',
        'amount',
        'paid_amount',
        'refunded_amount',
        'attachment',
    ];


    public function contractMovment()
    {
        return $this->belongsTo(AmContractMovment::class, 'am_monthly_contract_id');
    }

    public function crm()
    {
        return $this->belongsTo(CRM::class);
    }

    public function installment()
    {
        return $this->belongsTo(AmInstallment::class, 'am_installment_id');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $lastId = self::max('id') + 1;
            $model->serial_no = 'p3-INV-' . str_pad($lastId, 6, '0', STR_PAD_LEFT);
        });
    }

    public function journal(): MorphOne
    {
        return $this->morphOne(JournalHeader::class, 'source');
    }

    
}
