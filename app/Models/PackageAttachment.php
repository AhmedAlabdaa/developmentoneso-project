<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageAttachment extends Model
{
    protected $table = 'package_attachments';

    protected $fillable = [
        'package_id',
        'attachment_type',
        'attachment_file',
        'attachment_name',
        'attachment_number',
        'issued_on',
        'expired_on',
        'created_by',
    ];

    protected $dates = [
        'issued_on',
        'expired_on',
        'created_at',
        'updated_at',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
