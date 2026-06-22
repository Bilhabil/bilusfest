<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@bilusfest.com',
            'phone' => '081234567890',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'User Demo',
            'email' => 'user@bilusfest.com',
            'phone' => '081234567891',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        Event::factory(5)->create()->each(function ($event) {
            TicketCategory::factory()->create([
                'event_id' => $event->id,
                'name' => 'VIP',
                'price' => 750000,
                'quota' => 100,
            ]);

            TicketCategory::factory()->create([
                'event_id' => $event->id,
                'name' => 'Festival',
                'price' => 350000,
                'quota' => 300,
            ]);

            TicketCategory::factory()->create([
                'event_id' => $event->id,
                'name' => 'Early Bird',
                'price' => 200000,
                'quota' => 150,
            ]);

            TicketCategory::factory()->create([
                'event_id' => $event->id,
                'name' => 'Presale',
                'price' => 250000,
                'quota' => 200,
            ]);
        });
    }
}
