<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AmContractMovment extends Model
{
    
    protected $table = 'am_contract_movments';

    protected $fillable = [
        'serial_no',
        'date',
        'am_contract_id',
        'employee_id',
        'note',
        'status',
        'created_by',
        'updated_by',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (!empty($model->serial_no) || empty($model->am_contract_id)) {
                return;
            }

            $primaryContract = AmPrimaryContract::find($model->am_contract_id);
            if (!$primaryContract) {
                return;
            }

            $contractSerial = $primaryContract->serial_no
                ?: ('CT-' . str_pad((string) $primaryContract->id, 4, '0', STR_PAD_LEFT));

            $maxSequence = self::query()
                ->where('am_contract_id', $model->am_contract_id)
                ->pluck('serial_no')
                ->reduce(function (int $max, ?string $serial) use ($contractSerial): int {
                    if (!is_string($serial)) {
                        return $max;
                    }

                    if (!preg_match('/^' . preg_quote($contractSerial, '/') . '-(\d+)$/', $serial, $matches)) {
                        return $max;
                    }

                    return max($max, (int) $matches[1]);
                }, 0);

            $nextSequence = $maxSequence + 1;
            $model->serial_no = $contractSerial . '-' . $nextSequence;
        });
    }

    public function primaryContract()
    {
        return $this->belongsTo(AmPrimaryContract::class, 'am_contract_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)
                    ->select(['id', 'name', 'salary']);
    }
        public function invoice() 
    {
        return $this->hasMany(AmMonthlyContractInv::class, 'am_monthly_contract_id');
    }
  

    public function installments() 
    {
        return $this->hasMany(AmInstallment::class, 'am_movment_id');
    }

    public function returnInfo(): hasOne      
    {
        return $this->hasOne(AmReturnMaid::class, 'am_movment_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }




}
