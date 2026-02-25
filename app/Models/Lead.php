<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'respond_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'sales_name',
        'sales_email',
        'source',
        'status',
        'status_date_time',
        'package',
        'nationality',
        'emirate',
        'negotiation',
        'lifecycle',
        'notes',
    ];
}
