<?php

namespace App\Models;

use App\Models\Traits\BelongsToClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory, BelongsToClinic;

    protected $fillable = [
        'clinic_id',
        'patient_id',
        'doctor_id',
        'appointment_date',
        'status',
        'type',
        'reason',
        'notes',
        'duration_minutes',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'datetime',
            'duration_minutes' => 'integer',
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

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
