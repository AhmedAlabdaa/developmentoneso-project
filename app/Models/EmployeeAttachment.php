<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAttachment extends Model
{
    protected $table = 'employee_attachments';

    protected $fillable = [
        'employee_id',
        'attachment_type',
        'attachment_file',
        'attachment_name',
        'attachment_number',
        'issued_on',
        'expired_on',
        'created_at',
        'updated_at',
        'created_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
