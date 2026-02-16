<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSent extends Model
{
    protected $table = 'email_sent';

    protected $fillable = [
        'to_email',
        'action',
        'passport_no',
        'candidate_name',
        'foreign_partner',
        'ref_no',
        'action_date',
        'file',
        'other',
        'subject',
        'status',
        'error_message',
    ];
}
