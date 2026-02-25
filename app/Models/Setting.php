<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'default_role',
        'user_approval',
        'email_notifications',
        'push_notifications',
        'timezone',
        'date_format',
        'language',
    ];

    protected $table = 'settings';
}
