<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_id',
        'type',
        'title',
        'message',
        'priority',
        'is_read',
        'read_at',
        'data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
}
