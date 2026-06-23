<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketValidationController extends Controller
{
    public function validateTicket(string $ticketNumber)
    {
        return DB::transaction(function () use ($ticketNumber) {
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

            $ticket->update(['status' => 'used']);

            if ($ticket->qrCode) {
                $ticket->qrCode->update([
                    'is_used' => true,
                    'used_at' => now(),
                ]);
            }

            $ticket->load([
                'qrCode',
                'orderDetail.order.user',
                'orderDetail.ticketCategory.event',
            ]);

            return view('tickets.validation-success', compact('ticket'));
        });
    }
}
