<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnancyWeekContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_number',
        'title',
        'description',
        'baby_development',
        'mother_changes',
        'tips',
        'warnings',
    ];

    protected function casts(): array
    {
        return [
            'week_number' => 'integer',
        ];
    }
}
