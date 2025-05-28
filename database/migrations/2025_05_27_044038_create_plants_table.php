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
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->date('planted_date')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['healthy', 'sick', 'dead', 'dormant'])->default('healthy');
            $table->integer('optimal_moisture_min')->nullable();
            $table->integer('optimal_moisture_max')->nullable();
            $table->integer('optimal_temperature_min')->nullable();
            $table->integer('optimal_temperature_max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
