<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_code' => 'BF-' . strtoupper(Str::random(10)),
            'total_price' => fake()->numberBetween(200000, 1000000),
            'status' => 'pending',
        ];
    }
}
