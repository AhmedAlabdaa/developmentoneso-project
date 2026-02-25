<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Contract extends Model
{
    use HasFactory;

    public const STATUS_PENDING    = 1;
    public const STATUS_ACTIVE     = 2;
    public const STATUS_EXCEEDED   = 3;
    public const STATUS_CANCELLED  = 4;
    public const STATUS_CONTRACTED = 5;
    public const STATUS_REJECTED   = 6;

    protected $fillable = [
        'agreement_type',
        'agreement_reference_no',
        'candidate_id',
        'CL_Number',
        'CN_Number',
        'emp_reference_no',
        'nationaity',
        'reference_of_candidate',
        'package',
        'candidate_name',
        'foreign_partner',
        'client_id',
        'salary',
        'passport_no',
        'nationality',
        'contract_start_date',
        'contract_end_date',
        'contract_signed_copy',
        'maid_delivered',
        'transferred_date',
        'remarks',
        'reference_no',
        'cancelled_date',
        'status',
        'replacement',
        'replaced_by_name',
        'created_by',
        'sales_name',
    ];

    protected $casts = [
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'transferred_date' => 'date',
        'cancelled_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'number_of_installments',
        'paid_installments',
        'installment_ratio',
        'status_label',
        'status_badge_class',
        'days_to_end',
        'is_expired',
        'next_payment_due_at',
        'has_overdue_installments',
    ];

    public function getRouteKeyName(): string
    {
        return 'reference_no';
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(NewCandidate::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(CRM::class);
    }

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class, 'agreement_reference_no', 'reference_no');
    }

    public function invoice(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\Invoice::class, 'agreement_reference_no', 'agreement_reference_no')
            ->ofMany('invoice_id', 'max');
    }

    public function replacementHistories(): HasMany
    {
        return $this->hasMany(ReplacementHistory::class, 'contract_number', 'reference_no');
    }

    public function latestReplacement(): HasOne
    {
        return $this->hasOne(ReplacementHistory::class, 'contract_number', 'reference_no')->latestOfMany();
    }

    public function salesPerson(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_name', 'id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class, 'agreement_no', 'agreement_reference_no')->with('items');
    }

    public function installmentItems(): HasManyThrough
    {
        return $this->hasManyThrough(
            InstallmentItem::class,
            Installment::class,
            'agreement_no',
            'installment_id',
            'agreement_reference_no',
            'id'
        );
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeExpiringWithin(Builder $query, int $days): Builder
    {
        return $query->whereDate('contract_end_date', '<=', now()->addDays($days));
    }

    public function scopeWithInstallmentsSummary(Builder $query): Builder
    {
        return $query
            ->withCount(['installments as number_of_installments'])
            ->withCount(['installmentItems as paid_installments' => fn (Builder $q) => $q->whereNotNull('paid_date')]);
    }

    protected function numberOfInstallments(): Attribute
    {
        return Attribute::get(function () {
            if ($this->relationLoaded('installments')) {
                return $this->installments->count();
            }
            return $this->installments()->count();
        });
    }

    protected function paidInstallments(): Attribute
    {
        return Attribute::get(function () {
            if ($this->relationLoaded('installmentItems')) {
                return $this->installmentItems->whereNotNull('paid_date')->count();
            }
            return $this->installmentItems()->whereNotNull('paid_date')->count();
        });
    }

    protected function installmentRatio(): Attribute
    {
        return Attribute::get(fn () => sprintf('%d/%d', $this->paid_installments, $this->number_of_installments));
    }

    protected function daysToEnd(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->contract_end_date instanceof Carbon) {
                return null;
            }
            return now()->diffInDays($this->contract_end_date, false);
        });
    }

    protected function isExpired(): Attribute
    {
        return Attribute::get(fn () => $this->days_to_end !== null ? $this->days_to_end < 0 : false);
    }

    protected function nextPaymentDueAt(): Attribute
    {
        return Attribute::get(function () {
            return $this->installmentItems()
                ->whereNull('paid_date')
                ->orderBy('payment_date')
                ->first()?->payment_date;
        });
    }

    protected function hasOverdueInstallments(): Attribute
    {
        return Attribute::get(function () {
            return $this->installmentItems()
                ->whereNull('paid_date')
                ->whereDate('payment_date', '<', now()->toDateString())
                ->exists();
        });
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => self::statusMap()[$this->status]['label'] ?? 'Unknown');
    }

    protected function statusBadgeClass(): Attribute
    {
        return Attribute::get(fn () => self::statusMap()[$this->status]['class'] ?? 'badge bg-secondary');
    }

    public static function statusMap(): array
    {
        return [
            self::STATUS_PENDING    => ['label' => 'Pending',    'class' => 'badge bg-primary'],
            self::STATUS_ACTIVE     => ['label' => 'Active',     'class' => 'badge bg-success'],
            self::STATUS_EXCEEDED   => ['label' => 'Exceeded',   'class' => 'badge bg-warning text-dark'],
            self::STATUS_CANCELLED  => ['label' => 'Cancelled',  'class' => 'badge bg-danger'],
            self::STATUS_CONTRACTED => ['label' => 'Contracted', 'class' => 'badge bg-success'],
            self::STATUS_REJECTED   => ['label' => 'Rejected',   'class' => 'badge bg-danger'],
        ];
    }
}
