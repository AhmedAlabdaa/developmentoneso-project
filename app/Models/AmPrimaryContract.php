<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmPrimaryContract extends Model
{
    protected $table = 'am_primary_contracts';

    protected $fillable = [
        'serial_no',
        'date',
        'crm_id',
        'end_date',
        'note',
        'status',
        'type',
        'created_by',
        'updated_by',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (!empty($model->serial_no)) {
                return;
            }

            $maxSerialNumber = self::query()
                ->pluck('serial_no')
                ->reduce(function (int $max, ?string $serial): int {
                    if (!is_string($serial)) {
                        return $max;
                    }

                    if (!preg_match('/^CT-(\d+)$/', $serial, $matches)) {
                        return $max;
                    }

                    return max($max, (int) $matches[1]);
                }, 0);

            $model->serial_no = 'CT-' . str_pad((string) ($maxSerialNumber + 1), 4, '0', STR_PAD_LEFT);
        });
    }

    public function crm()
    {
        return $this->belongsTo(CRM::class)
        ->select(['id', 'first_name', 'last_name', 'mobile', 'CL_Number', 'ledger_id' , 'payment_methods']);
    }

    public function contractMovments()
    {
        return $this->hasMany(AmContractMovment::class, 'am_contract_id');
    }

  
}
