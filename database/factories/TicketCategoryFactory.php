<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketCategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'name' => fake()->randomElement(['VIP', 'Festival', 'Early Bird', 'Presale']),
            'price' => fake()->randomElement([200000, 250000, 350000, 750000]),
            'quota' => fake()->numberBetween(100, 500),
            'sold' => 0,
            'status' => 'active',
        ];
    }
}
