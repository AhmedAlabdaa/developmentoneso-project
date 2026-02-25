<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesiredCountry extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_name',
    ];

    public function fraNames()
    {
        return $this->hasMany(FraName::class);
    }
}
