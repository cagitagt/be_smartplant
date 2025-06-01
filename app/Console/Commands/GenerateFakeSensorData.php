<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SensorData;
use Carbon\Carbon;
use Faker\Factory as Faker;

class GenerateFakeSensorData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sensor:generate-fake-sensor-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate fake sensor data every 1 minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $faker = Faker::create();

        SensorData::create([
            'plant_id' => $faker->numberBetween(1, 30),
            'soil_moisture' => $faker->randomFloat(2, 0, 100),
            'temperature' => $faker->randomFloat(2, -10, 50),
            'air_humidity' => $faker->randomFloat(2, 0, 100),
            'light_intensity' => $faker->randomFloat(2, 0, 1000),
            'ph_level' => $faker->randomFloat(2, 0, 14),
            'recorded_at' => Carbon::now(),
        ]);

        $this->info('Fake sensor data generated every 1 minute.');
    }
}
