<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@smartgarden.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'name' => 'Luthfi Hakim',
            'email' => 'luthfyhakim@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('hakim123'),
        ]);

        $this->call([
            PlantSeeder::class,
            DeviceSeeder::class,
            SensorDataSeeder::class,
            IrrigationScheduleSeeder::class,
            WateringHistorySeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
