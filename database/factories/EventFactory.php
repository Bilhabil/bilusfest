<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $events = [
            [
                'name' => 'BILUS FEST Jakarta',
                'description' => 'Jakarta edition menghadirkan malam penuh energi di pusat kota, dengan tata panggung megah, akses yang mudah, dan pengalaman konser yang lebih premium.',
                'event_date' => fake()->dateTimeBetween('+1 month', '+6 months'),
                'location' => 'Jakarta Convention Center',
            ],
            [
                'name' => 'BILUS FEST Bandung',
                'description' => 'Bandung edition dirancang untuk penonton yang ingin suasana festival yang hangat, visual panggung yang hidup, dan area konser yang nyaman di ruang terbuka.',
                'event_date' => fake()->dateTimeBetween('+1 month', '+6 months'),
                'location' => 'Lapangan Gasibu Bandung',
            ],
            [
                'name' => 'BILUS FEST Bali',
                'description' => 'Bali edition membawa nuansa tropis dengan tata lampu yang dramatis, spot foto yang estetik, dan alur masuk venue yang lebih santai untuk menikmati pertunjukan.',
                'event_date' => fake()->dateTimeBetween('+1 month', '+6 months'),
                'location' => 'Beachwalk Bali',
            ],
            [
                'name' => 'BILUS FEST Surabaya',
                'description' => 'Surabaya edition menyajikan panggung besar, area penonton yang luas, dan pengalaman festival malam yang intens dengan ritme kota yang hidup.',
                'event_date' => fake()->dateTimeBetween('+1 month', '+6 months'),
                'location' => 'Grand City Convention Center Surabaya',
            ],
        ];

        $event = fake()->randomElement($events);

        return [
            'name' => $event['name'],
            'description' => $event['description'],
            'event_date' => $event['event_date'],
            'location' => $event['location'],
            'banner' => null,
            'status' => 'active',
        ];
    }
}
