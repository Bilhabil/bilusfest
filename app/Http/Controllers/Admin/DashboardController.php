<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalTicketsSold = Ticket::count();
        $totalRevenue = Order::where('status', 'success')->sum('total_price');

        $salesChart = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('status', 'success')
            ->groupBy('date')
            ->orderBy('date')
            ->limit(7)
            ->get();

        $latestOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEvents',
            'totalUsers',
            'totalTicketsSold',
            'totalRevenue',
            'salesChart',
            'latestOrders'
        ));
    }
}
