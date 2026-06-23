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

        $this->call([
            EventSeeder::class,
        ]);

        Event::query()->get()->each(function (Event $event) {
            $ticketBlueprints = [
                ['name' => 'VIP', 'price' => 750000, 'quota' => 100],
                ['name' => 'Festival', 'price' => 350000, 'quota' => 300],
                ['name' => 'Early Bird', 'price' => 200000, 'quota' => 150],
                ['name' => 'Presale', 'price' => 250000, 'quota' => 200],
            ];

            foreach ($ticketBlueprints as $blueprint) {
                TicketCategory::updateOrCreate(
                    [
                        'event_id' => $event->id,
                        'name' => $blueprint['name'],
                    ],
                    [
                        'price' => $blueprint['price'],
                        'quota' => $blueprint['quota'],
                        'sold' => 0,
                        'status' => 'active',
                    ]
                );
            }
        });
    }
}
