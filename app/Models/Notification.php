<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'role',
        'user_id',
        'title',
        'message',
        'ref_no',
        'reference_no',
        'CN_Number',
        'CL_Number',
        'status',
        'filePath',
        'action_by',
        'status_updated_time',
    ];

    public function candidate()
    {
        return $this->belongsTo(NewCandidate::class);
    }

    public function customer()
    {
        return $this->belongsTo(CRM::class);
    }

    public function actionBy()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
