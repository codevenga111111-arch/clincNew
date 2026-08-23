<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'city',
        'logo',
        'description',
        'is_active',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'settings' => 'array',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
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

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(ClinicSubscription::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(ClinicSubscription::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function doctors(): HasMany
    {
        return $this->hasMany(User::class)->where('user_type', 'doctor');
    }

    public function assistants(): HasMany
    {
        return $this->hasMany(User::class)->where('user_type', 'assistant');
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(ClinicSubscription::class)->where('status', 'active')->latest();
    }
}
