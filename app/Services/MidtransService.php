<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use RuntimeException;

class MidtransService
{
    public function __construct()
    {
        $this->validateConfig();

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    private function validateConfig(): void
    {
        $serverKey = config('midtrans.server_key');
        $clientKey = config('midtrans.client_key');
        $expectedPrefix = config('midtrans.is_production') ? 'Mid-server-' : 'SB-Mid-server-';
        $clientPrefix = config('midtrans.is_production') ? 'Mid-client-' : 'SB-Mid-client-';

        if (blank($serverKey) || blank($clientKey)) {
            throw new RuntimeException('Konfigurasi Midtrans belum lengkap. Isi MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY di file .env.');
        }

        if (str_starts_with($serverKey, $clientPrefix)) {
            throw new RuntimeException('MIDTRANS_SERVER_KEY masih berisi client key. Gunakan server key dari dashboard Midtrans.');
        }

        if (! str_starts_with($serverKey, $expectedPrefix)) {
            throw new RuntimeException('MIDTRANS_SERVER_KEY tidak sesuai dengan mode Midtrans saat ini. Gunakan server key sandbox untuk MIDTRANS_IS_PRODUCTION=false.');
        }
    }

    public function createSnapToken(Order $order): string
    {
        $order->load('user', 'details.ticketCategory.event');

        $items = [];

        foreach ($order->details as $detail) {
            $items[] = [
                'id' => $detail->ticketCategory->id,
                'price' => (int) $detail->price,
                'quantity' => $detail->quantity,
                'name' => $detail->ticketCategory->event->name . ' - ' . $detail->ticketCategory->name,
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '081234567890',
            ],
            'item_details' => $items,
        ];

        return Snap::getSnapToken($params);
    }

    public function getTransactionStatus(string $orderCode): object
    {
        return Transaction::status($orderCode);
    }
}
