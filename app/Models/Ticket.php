<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_detail_id',
        'ticket_number',
        'status',
    ];

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }

    public function qrCode()
    {
        return $this->hasOne(TicketQrCode::class);
    }
}
