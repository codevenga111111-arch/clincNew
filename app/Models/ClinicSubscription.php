<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'subscription_plan_id',
        'status',
        'starts_at',
        'ends_at',
        'amount_paid',
        'payment_method',
        'transaction_id',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'date',
            'ends_at' => 'date',
            'amount_paid' => 'decimal:2',
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->ends_at->isFuture();
    }
}
