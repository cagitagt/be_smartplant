<?php

namespace Database\Seeders;

use App\Models\Plant;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WateringHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plants = Plant::all();

        foreach ($plants as $plant) {
            for ($i = 0; $i < 10; $i++) {
                DB::table('watering_histories')->insert([
                    'plant_id' => $plant->id,
                    'watered_at' => Carbon::now()->subDays(rand(1, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                    'duration_minutes' => rand(5, 30),
                    'water_amount_ml' => rand(100, 1000),
                    'method' => ['manual', 'automatic', 'scheduled', 'emergency'][array_rand(['manual', 'automatic', 'scheduled', 'emergency'])],
                    'moisture_before' => rand(10, 50) / 10,
                    'moisture_after' => rand(50, 100) / 10,
                    'notes' => 'Sample note for plant ' . $plant->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
