<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAsset extends Model
{
    use HasFactory;

    protected $table = 'fixed_assets';
    protected $primaryKey = 'asset_id';

    protected $fillable = [
        'asset_name',
        'asset_category',
        'acquisition_date',
        'acquisition_cost',
        'depreciation_method',
        'useful_life_years',
        'salvage_value',
        'net_book_value',
        'created_at',
        'updated_at',
    ];
}
