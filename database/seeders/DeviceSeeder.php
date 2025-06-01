<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('devices')->insert([
            [
                'plant_id' => 1,
                'device_name' => 'Soil Moisture Sensor',
                'device_type' => 'sensor',
                'device_id' => 'SM12345',
                'status' => 'active',
                'battery_level' => 85,
                'last_connected' => now(),
                'firmware_version' => '1.0.3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plant_id' => 2,
                'device_name' => 'Irrigation Pump',
                'device_type' => 'pump',
                'device_id' => 'IP67890',
                'status' => 'maintenance',
                'battery_level' => null,
                'last_connected' => now()->subDays(2),
                'firmware_version' => '2.1.0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plant_id' => 3,
                'device_name' => 'Weather Station',
                'device_type' => 'weather_station',
                'device_id' => 'WS11223',
                'status' => 'active',
                'battery_level' => 60,
                'last_connected' => now()->subHours(5),
                'firmware_version' => '3.4.5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
