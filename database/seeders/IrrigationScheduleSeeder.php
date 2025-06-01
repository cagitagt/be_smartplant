<?php

namespace Database\Seeders;

use App\Models\Plant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IrrigationScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plants = Plant::all();

        foreach ($plants as $plant) {
            DB::table('irrigation_schedules')->insert([
                [
                    'plant_id' => $plant->id,
                    'name' => 'Morning Watering',
                    'schedule_time' => '06:00:00',
                    'duration_minutes' => 15,
                    'repeat_days' => json_encode(['Monday', 'Wednesday', 'Friday']),
                    'is_active' => true,
                    'auto_mode' => false,
                    'moisture_threshold' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'plant_id' => $plant->id,
                    'name' => 'Evening Watering',
                    'schedule_time' => '18:00:00',
                    'duration_minutes' => 10,
                    'repeat_days' => json_encode(['Tuesday', 'Thursday', 'Saturday']),
                    'is_active' => true,
                    'auto_mode' => true,
                    'moisture_threshold' => 30,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
