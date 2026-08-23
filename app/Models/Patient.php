<?php

namespace App\Models;

use App\Models\Traits\BelongsToClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Patient extends Model
{
    use HasFactory, BelongsToClinic;

    protected $fillable = [
        'clinic_id',
        'name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'national_id',
        'address',
        'medical_history',
        'allergies',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function pregnancies(): HasMany
    {
        return $this->hasMany(Pregnancy::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
