<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'description',
        'location',
        'planted_date',
        'image',
        'status',
        'optimal_moisture_min',
        'optimal_moisture_max',
        'optimal_temperature_min',
        'optimal_temperature_max',
    ];

    protected $casts = [
        'planted_date' => 'date',
        'optimal_moisture_min' => 'integer',
        'optimal_moisture_max' => 'integer',
        'optimal_temperature_min' => 'integer',
        'optimal_temperature_max' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function irrigationSchedules(): HasMany
    {
        return $this->hasMany(IrrigationSchedule::class);
    }

    public function sensorData(): HasMany
    {
        return $this->hasMany(SensorData::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function wateringHistory(): HasMany
    {
        return $this->hasMany(WateringHistory::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function getLatestSensorData()
    {
        return $this->sensorData()->latest()->first();
    }
}
