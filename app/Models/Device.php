<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_id',
        'device_name',
        'device_type',
        'device_id',
        'status',
        'battery_level',
        'last_connected',
        'firmware_version',
    ];

    protected $casts = [
        'battery_level' => 'integer',
        'last_connected' => 'datetime',
    ];

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
}
