<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file',
        'file_path',
        'document_type',
        'document_number',
        'document_date',
        'expiry_date',
        'renewal_required',
        'status',
        'uploaded_by',
        'uploaded_at'
    ];

    public function uploadedByUser()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getIsExpiredAttribute()
    {
        return Carbon::now()->greaterThan(Carbon::parse($this->expiry_date));
    }

    public function setDocumentDateAttribute($value)
    {
        $this->attributes['document_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Mutator to format expiry date to 'Y-m-d' format when saving.
     */
    public function setExpiryDateAttribute($value)
    {
        $this->attributes['expiry_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getRenewalRequiredAttribute($value)
    {
        return $value ? 'Yes' : 'No';
    }

    public function setRenewalRequiredAttribute($value)
    {
        $this->attributes['renewal_required'] = $value === 'Yes' ? 1 : 0;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = Carbon::now()->lessThanOrEqualTo(Carbon::parse($this->expiry_date)) ? 'Valid' : 'Expired';
    }
}
