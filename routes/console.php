<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('midtrans:check', function () {
    $isProduction = config('midtrans.is_production');
    $serverKey = config('midtrans.server_key');
    $clientKey = config('midtrans.client_key');
    $baseUrl = $isProduction
        ? 'https://api.midtrans.com'
        : 'https://api.sandbox.midtrans.com';

    $this->info('Checking Midtrans credentials...');
    $this->line('Mode: '.($isProduction ? 'production' : 'sandbox'));
    $this->line('Server key prefix: '.(blank($serverKey) ? '(empty)' : substr($serverKey, 0, 14).'...'));
    $this->line('Client key prefix: '.(blank($clientKey) ? '(empty)' : substr($clientKey, 0, 14).'...'));

    if (blank($serverKey) || blank($clientKey)) {
        $this->error('MIDTRANS_SERVER_KEY atau MIDTRANS_CLIENT_KEY masih kosong.');

        return self::FAILURE;
    }

    $expectedServerPrefix = $isProduction ? 'Mid-server-' : 'SB-Mid-server-';
    $expectedClientPrefix = $isProduction ? 'Mid-client-' : 'SB-Mid-client-';

    if (! str_starts_with($serverKey, $expectedServerPrefix) || ! str_starts_with($clientKey, $expectedClientPrefix)) {
        $this->error('Mode Midtrans dan prefix key tidak cocok.');
        $this->line('Sandbox harus memakai SB-Mid-server-* dan SB-Mid-client-*.');
        $this->line('Production harus memakai Mid-server-* dan Mid-client-*.');

        return self::FAILURE;
    }

    $response = Http::withBasicAuth($serverKey, '')
        ->acceptJson()
        ->get($baseUrl.'/v2/BILUSFEST-CREDENTIAL-CHECK/status');

    $this->line('HTTP status: '.$response->status());
    $this->line('Response: '.$response->body());

    if ($response->status() === 401) {
        $this->error('Credential ditolak Midtrans. Ambil ulang server key dari dashboard Midtrans yang sama dengan client key ini.');

        return self::FAILURE;
    }

    $this->info('Credential berhasil mencapai Midtrans. Jika response 404/order not found, itu normal untuk order dummy.');

    return self::SUCCESS;
})->purpose('Check Midtrans server key against the selected sandbox/production endpoint');

Artisan::command('midtrans:snap-check', function () {
    $isProduction = config('midtrans.is_production');
    $serverKey = config('midtrans.server_key');
    $clientKey = config('midtrans.client_key');

    $this->info('Checking Midtrans Snap token creation...');
    $this->line('Mode: '.($isProduction ? 'production' : 'sandbox'));
    $this->line('Server key prefix: '.(blank($serverKey) ? '(empty)' : substr($serverKey, 0, 14).'...'));
    $this->line('Client key prefix: '.(blank($clientKey) ? '(empty)' : substr($clientKey, 0, 14).'...'));

    if (blank($serverKey) || blank($clientKey)) {
        $this->error('MIDTRANS_SERVER_KEY atau MIDTRANS_CLIENT_KEY masih kosong.');

        return self::FAILURE;
    }

    $expectedServerPrefix = $isProduction ? 'Mid-server-' : 'SB-Mid-server-';
    $expectedClientPrefix = $isProduction ? 'Mid-client-' : 'SB-Mid-client-';

    if (! str_starts_with($serverKey, $expectedServerPrefix) || ! str_starts_with($clientKey, $expectedClientPrefix)) {
        $this->error('Mode Midtrans dan prefix key tidak cocok.');
        $this->line('Sandbox harus memakai SB-Mid-server-* dan SB-Mid-client-*.');
        $this->line('Production harus memakai Mid-server-* dan Mid-client-*.');

        return self::FAILURE;
    }

    MidtransConfig::$serverKey = $serverKey;
    MidtransConfig::$isProduction = $isProduction;
    MidtransConfig::$isSanitized = config('midtrans.is_sanitized');
    MidtransConfig::$is3ds = config('midtrans.is_3ds');

    $orderId = 'BILUSFEST-SNAP-CHECK-'.Str::upper(Str::random(10));
    $params = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => 10000,
        ],
        'customer_details' => [
            'first_name' => 'BILUS FEST',
            'email' => 'test@example.com',
            'phone' => '081234567890',
        ],
        'item_details' => [
            [
                'id' => 'SNAP-CHECK',
                'price' => 10000,
                'quantity' => 1,
                'name' => 'Snap Credential Check',
            ],
        ],
    ];

    try {
        $transaction = Snap::createTransaction($params);
    } catch (\Throwable $exception) {
        $this->error('Snap token gagal dibuat.');
        $this->line('Exception: '.$exception::class);
        $this->line('Message: '.$exception->getMessage());

        return self::FAILURE;
    }

    $this->info('Snap token berhasil dibuat.');
    $this->line('Order ID: '.$orderId);
    $this->line('Token prefix: '.substr($transaction->token, 0, 12).'...');
    $this->line('Redirect URL: '.$transaction->redirect_url);

    return self::SUCCESS;
})->purpose('Check Midtrans Snap token creation with the selected credentials');
