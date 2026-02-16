<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    use HasFactory;

    protected $table = 'tax_rates';
    protected $primaryKey = 'tax_id';

    protected $fillable = [
        'tax_name',
        'tax_rate',
        'tax_type',
        'created_at',
        'updated_at',
    ];
}
