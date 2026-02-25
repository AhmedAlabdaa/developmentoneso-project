<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enum\MCStatus;
use App\Enum\AmReturnAction;

class AmReturnMaid extends Model
{
    
    protected $table = 'am_return_maids';

    protected $fillable = [
        'date',
        'am_movment_id',
        'note',
        'status',
        'action',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => MCStatus::class,
        'action' => AmReturnAction::class,
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
