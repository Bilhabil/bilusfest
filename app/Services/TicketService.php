<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketQrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketService
{
    public function generateTickets(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order->load('details.ticketCategory', 'details.tickets');

            foreach ($order->details as $detail) {
                $existingTickets = $detail->tickets->count();
                $missingTickets = max($detail->quantity - $existingTickets, 0);

                for ($i = 0; $i < $missingTickets; $i++) {
                    $ticketNumber = 'BF-TICKET-' . strtoupper(Str::random(12));

                    $ticket = Ticket::create([
                        'order_detail_id' => $detail->id,
                        'ticket_number' => $ticketNumber,
                        'status' => 'valid',
                    ]);

                    $qrContent = route('ticket.validate', $ticketNumber);

                    $qrCode = base64_encode(
                        QrCode::format('svg')
                            ->size(300)
                            ->margin(2)
                            ->generate($qrContent)
                    );

                    TicketQrCode::create([
                        'ticket_id' => $ticket->id,
                        'qr_code' => $qrCode,
                        'is_used' => false,
                    ]);

                    $detail->ticketCategory->increment('sold');
                }
            }
        });
    }
}
