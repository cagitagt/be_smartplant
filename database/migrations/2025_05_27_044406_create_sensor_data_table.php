<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained()->onDelete('cascade');
            $table->float('soil_moisture')->nullable();
            $table->float('temperature')->nullable();
            $table->float('air_humidity')->nullable();
            $table->float('light_intensity')->nullable();
            $table->float('ph_level')->nullable();
            $table->timestamp('recorded_at');
            $table->timestamps();

            $table->index(['plant_id', 'recorded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
