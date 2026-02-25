<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CRM extends Model
{
    use HasFactory;
    protected $table = 'crm';
    protected $fillable = [
        'cl',
        'CL_Number',
        'first_name',
        'last_name',
        'slug',
        'state',
        'nationality',
        'email',
        'mobile',
        'address',
        'passport_number',
        'emirates_id',
        'emergency_contact_person',
        'source',
        'passport_copy',
        'id_copy',
        'ledger_id',
        'payment_methods',
    ];

    protected $casts = [
        'payment_methods' => 'array',
    ];

    public function ledger()    
    {
        return $this->belongsTo(Ledger::class);
    }
    
}
