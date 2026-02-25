<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmInstallment extends Model
{
    
    protected $table = 'am_installments';

    protected $fillable = [
        'date',
        'am_movment_id',
        'note',
        'status',
        'amount',
        'created_by',
        'updated_by',
    ];

    public function contractMovment()
    {
        return $this->belongsTo(AmContractMovment::class, 'am_movment_id');
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
