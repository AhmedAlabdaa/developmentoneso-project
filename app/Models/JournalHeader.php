<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enum\JournalStatus;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalHeader extends Model
{
    protected $fillable = [
        'posting_date',
        'status',

        // morphs
        'source_type',
        'source_id',
        'pre_src_type',
        'pre_src_id',

        'note',
        'meta_json',

        'total_debit',
        'total_credit',

        'created_by',
        'posted_by',
        'posted_at',
    ];

    protected $casts = [
        'status' => JournalStatus::class,
        'meta_json' => 'array',
        'posting_date' => 'date',
        'posted_at' => 'datetime',
        'total_debit' => 'decimal:2',
        'total_credit' => 'decimal:2',
    ];

    public function source(): MorphTo
    {
        return $this->morphTo();
    }

    public function preSrc(): MorphTo
    {
        return $this->morphTo();
    }

    public function lines(): HasMany
    {
        return $this->hasMany(JournalTranLine::class);
    }

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
