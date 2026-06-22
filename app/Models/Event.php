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
}
