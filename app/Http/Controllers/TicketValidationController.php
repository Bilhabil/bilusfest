<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class TicketValidationController extends Controller
{
    public function validateTicket(string $ticketNumber)
    {
        $ticket = Ticket::with([
            'qrCode',
            'orderDetail.order.user',
            'orderDetail.ticketCategory.event',
        ])->where('ticket_number', $ticketNumber)->first();

        if (!$ticket) {
            return view('tickets.validation-invalid', [
                'message' => 'Tiket tidak ditemukan.',
            ]);
        }

        if ($ticket->status === 'used' || $ticket->qrCode?->is_used) {
            return view('tickets.validation-invalid', [
                'message' => 'Tiket sudah pernah digunakan.',
            ]);
        }

        if ($ticket->status !== 'valid') {
            return view('tickets.validation-invalid', [
                'message' => 'Tiket tidak valid.',
            ]);
        }

        return view('tickets.validation-success', compact('ticket'));
    }
}
