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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained()->onDelete('cascade');
            $table->string('device_name');
            $table->enum('device_type', ['sensor', 'pump', 'valve', 'controller', 'camera', 'weather_station']);
            $table->string('device_id')->unique()->nullable();
            $table->enum('status', ['active', 'inactive', 'maintenance', 'error'])->default('active');
            $table->integer('battery_level')->nullable()->comment('Battery percentage for wireless devices');
            $table->timestamp('last_connected')->nullable();
            $table->string('firmware_version')->nullable();
            $table->timestamps();

            $table->index(['plant_id', 'status']);
            $table->index('last_connected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
