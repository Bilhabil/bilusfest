<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request, TicketService $ticketService)
    {
        Log::info('Midtrans webhook received', [
            'order_id' => $request->order_id,
            'transaction_status' => $request->transaction_status,
            'payment_type' => $request->payment_type,
        ]);

        $serverKey = config('midtrans.server_key');

        $signatureKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $order = Order::where('order_code', $request->order_id)->firstOrFail();

        DB::transaction(function () use ($request, $order, $ticketService) {
            $transactionStatus = $request->transaction_status;
            $fraudStatus = $request->fraud_status;

            $status = 'pending';

            if ($transactionStatus === 'settlement') {
                $status = 'success';
            }

            if ($transactionStatus === 'capture') {
                $status = $fraudStatus === 'accept' ? 'success' : 'pending';
            }

            if (in_array($transactionStatus, ['deny', 'cancel', 'failure'])) {
                $status = 'failed';
            }

            if ($transactionStatus === 'expire') {
                $status = 'expired';
            }

            $oldStatus = $order->status;

            $order->update(['status' => $status]);

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_id' => $request->transaction_id,
                    'payment_type' => $request->payment_type,
                    'status' => $status,
                    'payload' => $request->all(),
                ]
            );

            if ($status === 'success' && $oldStatus !== 'success') {
                $ticketService->generateTickets($order);
            }
        });

        return response()->json(['message' => 'Notification handled successfully']);
    }
}
