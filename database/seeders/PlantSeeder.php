<?php

namespace Database\Seeders;

use App\Models\Plant;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $plantTypes = [
            'Tomato' => ['Tomat Cherry', 'Tomat Beefsteak', 'Tomat Roma'],
            'Lettuce' => ['Selada Hijau', 'Selada Merah', 'Selada Keriting'],
            'Chili' => ['Cabai Rawit', 'Cabai Merah', 'Cabai Hijau'],
            'Spinach' => ['Bayam Hijau', 'Bayam Merah'],
            'Mint' => ['Mint Spearmint', 'Mint Peppermint'],
            'Basil' => ['Kemangi', 'Basil Sweet']
        ];

        foreach ($users as $user) {
            foreach ($plantTypes as $type => $varieties) {
                foreach ($varieties as $variety) {
                    Plant::create([
                        'user_id' => $user->id,
                        'name' => $variety,
                        'type' => $type,
                        'description' => "Tanaman {$variety} yang sehat dan produktif",
                        'location' => fake()->randomElement(['Greenhouse A', 'Greenhouse B', 'Outdoor Garden', 'Indoor Hydroponic']),
                        'planted_date' => fake()->dateTimeBetween('-6 months', '-1 month'),
                        'image' => null,
                        'status' => fake()->randomElement(['healthy', 'healthy', 'healthy', 'sick', 'dormant']),
                        'optimal_moisture_min' => fake()->numberBetween(30, 50),
                        'optimal_moisture_max' => fake()->numberBetween(60, 80),
                        'optimal_temperature_min' => fake()->numberBetween(18, 22),
                        'optimal_temperature_max' => fake()->numberBetween(28, 32),
                    ]);
                }
            }
        }
    }
}
