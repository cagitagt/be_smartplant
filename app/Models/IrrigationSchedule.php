<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IrrigationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_id',
        'name',
        'schedule_time',
        'duration_minutes',
        'repeat_days',
        'is_active',
        'auto_mode',
        'moisture_threshold',
    ];

    protected $casts = [
        'schedule_time' => 'datetime',
        'repeat_days' => 'array',
        'is_active' => 'boolean',
        'auto_mode' => 'boolean',
        'moisture_threshold' => 'integer',
    ];

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
}
