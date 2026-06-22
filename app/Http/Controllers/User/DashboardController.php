<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::where('user_id', auth()->id())->count();

        $successOrders = Order::where('user_id', auth()->id())
            ->where('status', 'success')
            ->count();

        $myTickets = Ticket::whereHas('orderDetail.order', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->count();

        $latestEvents = Event::where('status', 'active')->latest()->limit(3)->get();

        return view('user.dashboard', compact(
            'totalOrders',
            'successOrders',
            'myTickets',
            'latestEvents'
        ));
    }
}
