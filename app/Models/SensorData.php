<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SensorData extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_id',
        'soil_moisture',
        'temperature',
        'air_humidity',
        'light_intensity',
        'ph_level',
        'recorded_at',
    ];

    protected $casts = [
        'soil_moisture' => 'float',
        'temperature' => 'float',
        'air_humidity' => 'float',
        'light_intensity' => 'float',
        'ph_level' => 'float',
        'recorded_at' => 'datetime',
    ];

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
}
