<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'transaction_id' => null,
            'snap_token' => null,
            'payment_type' => null,
            'status' => 'pending',
            'payload' => null,
        ];
    }
}
