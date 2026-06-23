<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'event_date',
        'location',
        'banner',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function getDisplayBannerUrlAttribute(): string
    {
        if ($this->banner) {
            return asset('storage/'.$this->banner);
        }

        $posterMap = [
            'jakarta' => 'images/events/poster-jakarta.png',
            'bali' => 'images/events/poster-bali.png',
            'bandung' => 'images/events/poster-bandung.png',
            'surabaya' => 'images/events/poster-surabaya.png',
        ];

        $searchableText = Str::lower($this->name.' '.$this->location);

        foreach ($posterMap as $keyword => $path) {
            if (Str::contains($searchableText, $keyword)) {
                return asset($path);
            }
        }

        $fallbackPaths = array_values($posterMap);
        $fallbackIndex = abs(crc32($this->name.'|'.$this->location)) % count($fallbackPaths);

        return asset($fallbackPaths[$fallbackIndex]);
    }

    public function ticketCategories()
    {
        return $this->hasMany(TicketCategory::class);
    }

    public function getCityKeyAttribute(): string
    {
        $searchableText = Str::lower($this->name.' '.$this->location);

        foreach (['jakarta', 'bali', 'bandung', 'surabaya'] as $city) {
            if (Str::contains($searchableText, $city)) {
                return $city;
            }
        }

        return 'bilus';
    }

    public function getDisplayDescriptionAttribute(): string
    {
        return match ($this->city_key) {
            'jakarta' => 'Jakarta edition menghadirkan malam penuh energi di pusat kota, dengan tata panggung megah, akses yang mudah, dan pengalaman konser yang lebih premium.',
            'bandung' => 'Bandung edition dirancang untuk penonton yang ingin suasana festival yang hangat, visual panggung yang hidup, dan area konser yang nyaman di ruang terbuka.',
            'bali' => 'Bali edition membawa nuansa tropis dengan tata lampu yang dramatis, spot foto yang estetik, dan alur masuk venue yang lebih santai untuk menikmati pertunjukan.',
            'surabaya' => 'Surabaya edition menyajikan panggung besar, area penonton yang luas, dan pengalaman festival malam yang intens dengan ritme kota yang hidup.',
            default => $this->description ?: 'Festival musik modern dengan sistem tiket digital, checkout cepat, dan akses masuk venue yang rapi.',
        };
    }

    public function getConcertLayoutAttribute(): array
    {
        return match ($this->city_key) {
            'jakarta' => [
                'title' => 'Denah Jakarta Convention Center',
                'subtitle' => 'Panggung utama berada di tengah hall dengan akses masuk dari sisi utara.',
                'zones' => [
                    ['label' => 'MAIN STAGE', 'position' => 'center', 'tone' => 'primary'],
                    ['label' => 'VIP', 'position' => 'top-left', 'tone' => 'vip'],
                    ['label' => 'FESTIVAL', 'position' => 'bottom-left', 'tone' => 'festival'],
                    ['label' => 'FOOD COURT', 'position' => 'top-right', 'tone' => 'food'],
                    ['label' => 'ENTRY', 'position' => 'bottom-right', 'tone' => 'entry'],
                ],
            ],
            'bandung' => [
                'title' => 'Denah Lapangan Gasibu Bandung',
                'subtitle' => 'Area konser dibuat terbuka dengan panggung di sisi utara dan jalur masuk utama dari timur.',
                'zones' => [
                    ['label' => 'MAIN STAGE', 'position' => 'top-center', 'tone' => 'primary'],
                    ['label' => 'VIP', 'position' => 'top-left', 'tone' => 'vip'],
                    ['label' => 'FESTIVAL', 'position' => 'center', 'tone' => 'festival'],
                    ['label' => 'FOOD COURT', 'position' => 'bottom-left', 'tone' => 'food'],
                    ['label' => 'ENTRY', 'position' => 'bottom-right', 'tone' => 'entry'],
                ],
            ],
            'bali' => [
                'title' => 'Denah Beachwalk Bali',
                'subtitle' => 'Layout tropis dengan panggung menghadap sunset dan zona santai di sisi pantai.',
                'zones' => [
                    ['label' => 'MAIN STAGE', 'position' => 'center', 'tone' => 'primary'],
                    ['label' => 'VIP LOUNGE', 'position' => 'top-left', 'tone' => 'vip'],
                    ['label' => 'FESTIVAL', 'position' => 'bottom-left', 'tone' => 'festival'],
                    ['label' => 'FOOD & BAR', 'position' => 'top-right', 'tone' => 'food'],
                    ['label' => 'ENTRY', 'position' => 'bottom-right', 'tone' => 'entry'],
                ],
            ],
            'surabaya' => [
                'title' => 'Denah Surabaya Expo Center',
                'subtitle' => 'Panggung besar di ujung hall dengan area festival yang memanjang ke depan.',
                'zones' => [
                    ['label' => 'MAIN STAGE', 'position' => 'top-center', 'tone' => 'primary'],
                    ['label' => 'VIP', 'position' => 'center-left', 'tone' => 'vip'],
                    ['label' => 'FESTIVAL', 'position' => 'center', 'tone' => 'festival'],
                    ['label' => 'MERCH AREA', 'position' => 'bottom-left', 'tone' => 'food'],
                    ['label' => 'ENTRY', 'position' => 'bottom-right', 'tone' => 'entry'],
                ],
            ],
            default => [
                'title' => 'Denah Area Konser',
                'subtitle' => 'Panggung utama, area VIP, festival, dan akses masuk disusun agar mudah dipahami penonton.',
                'zones' => [
                    ['label' => 'MAIN STAGE', 'position' => 'center', 'tone' => 'primary'],
                    ['label' => 'VIP', 'position' => 'top-left', 'tone' => 'vip'],
                    ['label' => 'FESTIVAL', 'position' => 'bottom-left', 'tone' => 'festival'],
                    ['label' => 'FOOD COURT', 'position' => 'top-right', 'tone' => 'food'],
                    ['label' => 'ENTRY', 'position' => 'bottom-right', 'tone' => 'entry'],
                ],
            ],
        };
    }
}
