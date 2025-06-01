<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Plant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $plants = Plant::all();
        $devices = Device::all();

        $notificationTypes = [
            'low_moisture' => 'Kelembaban tanah rendah',
            'high_temperature' => 'Suhu terlalu tinggi',
            'watering_reminder' => 'Reminder penyiraman',
            'device_offline' => 'Perangkat tidak aktif',
            'plant_health' => 'Status kesehatan tanaman'
        ];

        foreach ($users as $user) {
            for ($i = 0; $i < fake()->numberBetween(5, 15); $i++) {
                $type = fake()->randomKey($notificationTypes);
                $plant = $plants->random();
                $device = $devices->random();

                DB::table('notifications')->insert([
                    'user_id' => $user->id,
                    'plant_id' => fake()->boolean(70) ? $plant->id : null,
                    'device_id' => fake()->boolean(70) ? $device->id : null,
                    'type' => $type,
                    'title' => $notificationTypes[$type],
                    'message' => $this->generateNotificationMessage($type, $plant->name),
                    'priority' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
                    'is_read' => fake()->boolean(60),
                    'read_at' => fake()->boolean(60) ? fake()->dateTimeBetween('-7 days', 'now') : null,
                    'data' => json_encode(['additional_info' => fake()->sentence()]),
                    'created_at' => fake()->dateTimeBetween('-7 days', 'now'),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function generateNotificationMessage($type, $plantName): string
    {
        $messages = [
            'low_moisture' => "Tanaman {$plantName} membutuhkan penyiraman. Kelembaban tanah saat ini di bawah batas optimal.",
            'high_temperature' => "Suhu di sekitar tanaman {$plantName} terlalu tinggi. Pertimbangkan untuk memberikan naungan.",
            'watering_reminder' => "Waktunya menyiram tanaman {$plantName} sesuai jadwal yang telah ditentukan.",
            'device_offline' => "Sensor untuk tanaman {$plantName} tidak merespons. Periksa koneksi perangkat.",
            'plant_health' => "Status kesehatan tanaman {$plantName} perlu perhatian khusus."
        ];

        return $messages[$type] ?? "Notifikasi untuk tanaman {$plantName}";
    }
}
