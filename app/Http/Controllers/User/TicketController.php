<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function download(Ticket $ticket)
    {
        $ticket->load([
            'qrCode',
            'orderDetail.order.user',
            'orderDetail.ticketCategory.event',
        ]);

        abort_if($ticket->orderDetail->order->user_id !== auth()->id(), 403);

        abort_if(
            $ticket->orderDetail->order->status !== 'success',
            403,
            'Tiket hanya bisa diunduh setelah pembayaran berhasil.'
        );

        $pdf = Pdf::loadView('user.tickets.pdf', compact('ticket'))
            ->setPaper('a4', 'portrait');

        return $pdf->download($ticket->ticket_number . '.pdf');
    }
}
