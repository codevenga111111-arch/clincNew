<?php

namespace App\Models\Traits;

use App\Models\Scopes\BelongsToClinicScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToClinic
{
    protected static function bootBelongsToClinic(): void
    {
        if (auth()->check()) {
            static::addGlobalScope(new BelongsToClinicScope);
        }
    }

    public function scopeForCurrentClinic(Builder $query): Builder
    {
        return $query->where('clinic_id', auth()->user()->clinic_id);
    }
}
