<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\TicketService;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('details.ticketCategory.event')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order, TicketService $ticketService)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        if ($order->status === 'success') {
            $ticketService->generateTickets($order);
        }

        $order->load(
            'details.ticketCategory.event',
            'details.tickets.qrCode',
            'payment'
        );

        return view('user.orders.show', compact('order'));
    }
}
