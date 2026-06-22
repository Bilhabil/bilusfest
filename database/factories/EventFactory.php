<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'BILUS FEST Jakarta',
                'BILUS FEST Bandung',
                'BILUS FEST Bali',
                'BILUS FEST Surabaya',
            ]),
            'description' => fake()->paragraph(),
            'event_date' => fake()->dateTimeBetween('+1 month', '+6 months'),
            'location' => fake()->randomElement([
                'Jakarta Convention Center',
                'Lapangan Gasibu Bandung',
                'Beachwalk Bali',
                'Surabaya Expo Center',
            ]),
            'banner' => null,
            'status' => 'active',
        ];
    }
}
