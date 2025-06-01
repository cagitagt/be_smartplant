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
        Schema::create('irrigation_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->time('schedule_time');
            $table->integer('duration_minutes')->comment('Duration in minutes');
            $table->json('repeat_days')->nullable()->comment('Days of the week for repeating schedule');
            $table->boolean('is_active')->default(true);
            $table->boolean('auto_mode')->default(false)->comment('Automatic mode based on moisture threshold');
            $table->integer('moisture_threshold')->nullable()->comment('Minimum moisture level to trigger watering');
            $table->timestamps();

            $table->index(['plant_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irrigation_schedules');
    }
};
