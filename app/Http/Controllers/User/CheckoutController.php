<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TicketCategory;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function create(TicketCategory $ticketCategory)
    {
        $ticketCategory->load('event');

        return view('user.checkout.create', compact('ticketCategory'));
    }

    public function store(Request $request, TicketCategory $ticketCategory)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $order = $this->orderRepository->createOrder($ticketCategory, $request->quantity);

            return redirect()
                ->route('user.orders.show', $order)
                ->with('success', 'Order berhasil dibuat. Silakan lanjutkan pembayaran.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
