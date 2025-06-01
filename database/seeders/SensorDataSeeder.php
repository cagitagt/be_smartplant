<?php

namespace Database\Seeders;

use App\Models\Plant;
use App\Models\SensorData;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SensorDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plants = Plant::all();

        foreach ($plants as $plant) {
            // Generate sensor data for the last 30 days
            for ($i = 30; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);

                // Generate 4-6 readings per day (every 4-6 hours)
                $readingsPerDay = fake()->numberBetween(4, 6);

                for ($j = 0; $j < $readingsPerDay; $j++) {
                    $recordedAt = $date->copy()->addHours($j * (24 / $readingsPerDay));

                    // Generate realistic sensor values based on plant's optimal ranges
                    $moistureVariation = fake()->numberBetween(-10, 10);
                    $tempVariation = fake()->numberBetween(-5, 5);

                    SensorData::create([
                        'plant_id' => $plant->id,
                        'soil_moisture' => max(0, min(
                            100,
                            fake()->numberBetween(
                                $plant->optimal_moisture_min + $moistureVariation,
                                $plant->optimal_moisture_max + $moistureVariation
                            )
                        )),
                        'temperature' => fake()->numberBetween(
                            $plant->optimal_temperature_min + $tempVariation,
                            $plant->optimal_temperature_max + $tempVariation
                        ),
                        'air_humidity' => fake()->numberBetween(40, 80),
                        'light_intensity' => fake()->numberBetween(200, 1000),
                        'ph_level' => fake()->randomFloat(2, 5.5, 7.5),
                        'recorded_at' => $recordedAt,
                    ]);
                }
            }
        }
    }
}
