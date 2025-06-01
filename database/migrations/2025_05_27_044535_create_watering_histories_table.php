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
        Schema::create('watering_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained()->onDelete('cascade');
            $table->timestamp('watered_at');
            $table->integer('duration_minutes')->comment('Duration in minutes');
            $table->integer('water_amount_ml')->nullable()->comment('Water amount in ml');
            $table->enum('method', ['manual', 'automatic', 'scheduled', 'emergency'])->default('manual');
            $table->float('moisture_before')->nullable()->comment('Soil moisture before watering');
            $table->float('moisture_after')->nullable()->comment('Soil moisture after watering');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['plant_id', 'watered_at']);
            $table->index('watered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watering_histories');
    }
};
