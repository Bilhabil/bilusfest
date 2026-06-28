<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;
use App\Services\TicketService;
use Illuminate\Support\Facades\Log;
use Throwable;

class MidtransController extends Controller
{
    public function pay(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        if ($order->status !== 'pending') {
            return redirect()
                ->route('user.orders.show', $order)
                ->with('error', 'Order ini sudah tidak bisa dibayar.');
        }

        $payment = Payment::where('order_id', $order->id)->latest()->first();

        if ($payment?->status === 'pending' && filled($payment->snap_token)) {
            return view('user.payment.pay', [
                'order' => $order,
                'snapToken' => $payment->snap_token,
            ]);
        }

        try {
            $midtransService = app(MidtransService::class);
            $snapToken = $midtransService->createSnapToken($order);
        } catch (Throwable $exception) {
            Log::error('Midtrans payment failed', $this->midtransLogContext($order, $exception));

            if ($payment?->status === 'pending' && filled($payment->snap_token)) {
                Log::warning('Reusing existing Midtrans snap token after token creation failed', [
                    'order_id' => $order->id,
                    'order_code' => $order->order_code,
                    'payment_id' => $payment->id,
                ]);

                return view('user.payment.pay', [
                    'order' => $order,
                    'snapToken' => $payment->snap_token,
                ]);
            }

            return redirect()
                ->route('user.orders.show', $order)
                ->with('error', 'Pembayaran belum bisa diproses. Periksa konfigurasi server key Midtrans.');
        }

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'snap_token' => $snapToken,
                'status' => 'pending',
            ]
        );

        return view('user.payment.pay', compact('order', 'snapToken'));
    }

    private function midtransLogContext(Order $order, Throwable $exception): array
    {
        return [
            'order_id' => $order->id,
            'order_code' => $order->order_code,
            'midtrans_mode' => config('midtrans.is_production') ? 'production' : 'sandbox',
            'server_key_prefix' => $this->keyPrefix(config('midtrans.server_key')),
            'client_key_prefix' => $this->keyPrefix(config('midtrans.client_key')),
            'exception_class' => $exception::class,
            'exception_message' => $exception->getMessage(),
        ];
    }

    private function keyPrefix(?string $key): ?string
    {
        if (blank($key)) {
            return null;
        }

        return substr($key, 0, 14).'...';
    }

    public function success(Order $order, MidtransService $midtransService, TicketService $ticketService)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        if ($order->status !== 'success') {
            $this->syncOrderStatus($order, $midtransService, $ticketService);
            $order->refresh();
        }

        return view('user.payment.success', compact('order'));
    }

    public function failed(Order $order)
    {
        return view('user.payment.failed', compact('order'));
    }

    private function syncOrderStatus(Order $order, MidtransService $midtransService, TicketService $ticketService): void
    {
        try {
            $response = $midtransService->getTransactionStatus($order->order_code);
            $status = $this->mapMidtransStatus(
                $response->transaction_status ?? null,
                $response->fraud_status ?? null,
            );

            if ($status === null) {
                return;
            }

            $oldStatus = $order->status;

            $order->update(['status' => $status]);

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'transaction_id' => $response->transaction_id ?? null,
                    'payment_type' => $response->payment_type ?? null,
                    'status' => $status,
                    'payload' => json_decode(json_encode($response), true),
                ]
            );

            if ($status === 'success' && $oldStatus !== 'success') {
                $ticketService->generateTickets($order->fresh());
            }
        } catch (Throwable $exception) {
            Log::warning('Failed to sync Midtrans payment status', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'exception_class' => $exception::class,
                'exception_message' => $exception->getMessage(),
            ]);
        }
    }

    private function mapMidtransStatus(?string $transactionStatus, ?string $fraudStatus): ?string
    {
        if ($transactionStatus === 'settlement') {
            return 'success';
        }

        if ($transactionStatus === 'capture') {
            return $fraudStatus === 'accept' ? 'success' : 'pending';
        }

        if (in_array($transactionStatus, ['deny', 'cancel', 'failure'], true)) {
            return 'failed';
        }

        if ($transactionStatus === 'expire') {
            return 'expired';
        }

        if ($transactionStatus === 'pending') {
            return 'pending';
        }

        return null;
    }
}
