<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketQrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'qr_code',
        'is_used',
        'used_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function getDataUriAttribute(): string
    {
        $decoded = base64_decode($this->qr_code, true) ?: '';
        $isSvg = str_contains($decoded, '<svg');
        $mimeType = $isSvg ? 'image/svg+xml' : 'image/png';

        return 'data:'.$mimeType.';base64,'.$this->qr_code;
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
