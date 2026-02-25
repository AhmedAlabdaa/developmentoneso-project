<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntries extends Model
{
    use HasFactory;

    protected $table = 'journal_entries';
    protected $primaryKey = 'journal_id';

    protected $fillable = [
        'journal_date',
        'description',
        'reference_no',
        'total_debit',
        'total_credit',
        'status',
        'created_at',
        'updated_at',
    ];

    public function details()
    {
        return $this->hasMany(JournalEntryDetails::class, 'journal_id');
    }
}
