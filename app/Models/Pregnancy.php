<?php

namespace App\Models;

use App\Models\Traits\BelongsToClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pregnancy extends Model
{
    use HasFactory, BelongsToClinic;

    protected $fillable = [
        'clinic_id',
        'patient_id',
        'last_menstrual_period',
        'estimated_due_date',
        'status',
        'gestational_age_weeks',
        'notes',
        'delivery_date',
    ];

    protected function casts(): array
    {
        return [
            'last_menstrual_period' => 'date',
            'estimated_due_date' => 'date',
            'delivery_date' => 'date',
            'gestational_age_weeks' => 'integer',
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(PregnancyExam::class);
    }

    public function calculateGestationalAge(): int
    {
        return $this->last_menstrual_period->diffInWeeks(now());
    }

    public function calculateEDD(): \Carbon\Carbon
    {
        return $this->last_menstrual_period->addWeeks(40);
    }

    public function isDueSoon(int $weeks = 2): bool
    {
        return $this->estimated_due_date->diffInWeeks(now(), false) <= $weeks;
    }
}
