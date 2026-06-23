<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::updateOrCreate(
            ['name' => 'BILUS FEST Jakarta', 'location' => 'Jakarta Convention Center'],
            [
                'description' => 'Jakarta edition menghadirkan malam penuh energi di pusat kota, dengan tata panggung megah, akses yang mudah, dan pengalaman konser yang lebih premium.',
                'event_date' => '2026-10-19 20:00:00',
                'banner' => null,
                'status' => 'active',
            ]
        );

        Event::updateOrCreate(
            ['name' => 'BILUS FEST Bandung', 'location' => 'Lapangan Gasibu Bandung'],
            [
                'description' => 'Bandung edition dirancang untuk penonton yang ingin suasana festival yang hangat, visual panggung yang hidup, dan area konser yang nyaman di ruang terbuka.',
                'event_date' => '2026-11-16 20:00:00',
                'banner' => null,
                'status' => 'active',
            ]
        );

        Event::updateOrCreate(
            ['name' => 'BILUS FEST Bali', 'location' => 'Beachwalk Bali'],
            [
                'description' => 'Bali edition membawa nuansa tropis dengan tata lampu yang dramatis, spot foto yang estetik, dan alur masuk venue yang lebih santai untuk menikmati pertunjukan.',
                'event_date' => '2026-09-19 19:00:00',
                'banner' => null,
                'status' => 'active',
            ]
        );

        Event::updateOrCreate(
            ['name' => 'BILUS FEST Surabaya', 'location' => 'Grand City Convention Center Surabaya'],
            [
                'description' => 'Surabaya edition menyajikan panggung besar, area penonton yang luas, dan pengalaman festival malam yang intens dengan ritme kota yang hidup.',
                'event_date' => '2026-10-11 18:04:00',
                'banner' => null,
                'status' => 'active',
            ]
        );
    }
}
