<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\TicketCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderRepository
{
    public function createOrder(TicketCategory $ticketCategory, int $quantity): Order
    {
        return DB::transaction(function () use ($ticketCategory, $quantity) {
            $ticketCategory = TicketCategory::where('id', $ticketCategory->id)
                ->lockForUpdate()
                ->firstOrFail();

            $available = $ticketCategory->quota - $ticketCategory->sold;

            if ($quantity > $available) {
                throw new \Exception('Jumlah tiket melebihi sisa kuota.');
            }

            $subtotal = $ticketCategory->price * $quantity;

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => 'BF-' . strtoupper(Str::random(10)),
                'total_price' => $subtotal,
                'status' => 'pending',
            ]);

            OrderDetail::create([
                'order_id' => $order->id,
                'ticket_category_id' => $ticketCategory->id,
                'quantity' => $quantity,
                'price' => $ticketCategory->price,
                'subtotal' => $subtotal,
            ]);

            return $order->load('details.ticketCategory.event');
        });
    }
}
