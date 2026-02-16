<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'role', 
        'request_from', 
        'attachments', 
        'description', 
        'status',
        'created_at', 
        'updated_at'
    ];

    public function attachments()
    {
        return $this->hasMany(ComplaintAttachment::class);
    }
}
