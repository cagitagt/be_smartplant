<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WateringHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_id',
        'watered_at',
        'duration_minutes',
        'water_amount_ml',
        'method',
        'moisture_before',
        'moisture_after',
        'notes',
    ];

    protected $casts = [
        'watered_at' => 'datetime',
        'duration_minutes' => 'integer',
        'water_amount_ml' => 'integer',
        'moisture_before' => 'float',
        'moisture_after' => 'float',
    ];

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
}
