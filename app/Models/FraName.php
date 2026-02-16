<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraName extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'fra_name',
    ];

    public function country()
    {
        return $this->belongsTo(DesiredCountry::class, 'country_id');
    }
}
