<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PregnancyExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregnancy_id',
        'clinic_id',
        'week_number',
        'exam_date',
        'weight_kg',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'fundal_height_cm',
        'fetal_heart_rate',
        'weight_fetus_grams',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'exam_date' => 'date',
            'week_number' => 'integer',
            'weight_kg' => 'decimal:2',
            'blood_pressure_systolic' => 'decimal:1',
            'blood_pressure_diastolic' => 'decimal:1',
            'fundal_height_cm' => 'decimal:1',
            'fetal_heart_rate' => 'decimal:1',
            'weight_fetus_grams' => 'decimal:2',
        ];
    }

    public function pregnancy(): BelongsTo
    {
        return $this->belongsTo(Pregnancy::class);
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }
}
