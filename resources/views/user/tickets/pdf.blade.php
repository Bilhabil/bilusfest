<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket BILUS FEST</title>
    <style>
        @page {
            margin: 26px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            background: #F3F6FF;
            color: #0F172A;
            font-size: 12px;
            margin: 0;
        }

        .ticket {
            position: relative;
            border: 1.8px solid #6366F1;
            border-radius: 22px;
            background: #ffffff;
            overflow: hidden;
            padding: 0;
        }

        .ticket-topbar {
            height: 10px;
            background: linear-gradient(90deg, #4F46E5, #7C3AED, #EC4899);
        }

        .ticket-inner {
            padding: 26px 26px 22px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .brand-box {
            width: 72px;
            vertical-align: top;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            border-radius: 18px;
        }

        .brand-title {
            font-size: 24px;
            line-height: 1;
            margin: 0;
            color: #4F46E5;
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        .brand-subtitle {
            margin-top: 6px;
            color: #EC4899;
            font-size: 11px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .status-pill {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 999px;
            background: #EEF2FF;
            color: #4338CA;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .status-pill.used {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-pill.pending {
            background: #E0F2FE;
            color: #075985;
        }

        .divider {
            border: 0;
            border-top: 2px dashed #F472B6;
            margin: 18px 0 20px;
        }

        .hero-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        .hero-left {
            width: 64%;
            vertical-align: top;
            padding-right: 18px;
        }

        .hero-right {
            width: 36%;
            vertical-align: top;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }

        .meta-table td {
            padding: 5px 0;
            vertical-align: top;
            line-height: 1.45;
        }

        .meta-label {
            width: 128px;
            color: #0F172A;
            font-weight: 700;
        }

        .meta-separator {
            width: 12px;
            color: #94A3B8;
            text-align: center;
        }

        .ticket-card {
            border-radius: 18px;
            background: linear-gradient(180deg, #EEF2FF, #FFFFFF);
            border: 1px solid #DBE2FF;
            padding: 16px 16px 14px;
        }

        .ticket-card-label {
            color: #6366F1;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .ticket-number {
            font-size: 15px;
            font-weight: 700;
            color: #1E1B4B;
            word-break: break-word;
        }

        .ticket-note {
            margin-top: 10px;
            font-size: 10px;
            line-height: 1.6;
            color: #64748B;
        }

        .qr-wrap {
            margin-top: 18px;
            text-align: center;
            page-break-inside: avoid;
        }

        .qr-frame {
            display: inline-block;
            padding: 16px;
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid #E2E8F0;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        }

        .qr-frame img {
            width: 190px;
            height: 190px;
        }

        .barcode {
            margin-top: 12px;
            padding: 10px 14px;
            border-radius: 14px;
            background: linear-gradient(135deg, #EEF2FF, #F5F3FF);
            color: #4338CA;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.03em;
            word-break: break-word;
        }

        .cut-line {
            margin-top: 18px;
            border-top: 1px solid #E2E8F0;
        }

        .footer {
            margin-top: 14px;
            text-align: center;
            color: #64748B;
            font-size: 10px;
            line-height: 1.6;
        }

        .footer strong {
            color: #4F46E5;
        }
    </style>
</head>
<body>
@php
    $detail = $ticket->orderDetail;
    $order = $detail->order;
    $user = $order->user;
    $category = $detail->ticketCategory;
    $event = $category->event;
    $logoPath = public_path('images/bilus-fest-logo.png');
    $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
    $statusClass = match ($ticket->status) {
        'used' => 'used',
        'pending' => 'pending',
        default => 'valid',
    };
@endphp

<div class="ticket">
    <div class="ticket-topbar"></div>

    <div class="ticket-inner">
        <table class="header-table">
            <tr>
                <td class="brand-box">
                    @if ($logoData)
                        <img class="brand-logo" src="data:image/png;base64,{{ $logoData }}" alt="Bilus Fest">
                    @endif
                </td>
                <td>
                    <h1 class="brand-title">BILUS FEST</h1>
                    <div class="brand-subtitle">Official E-Ticket Festival Musik</div>
                </td>
                <td style="text-align:right; vertical-align:top;">
                    <span class="status-pill {{ $statusClass }}">{{ strtoupper($ticket->status) }}</span>
                </td>
            </tr>
        </table>

        <hr class="divider">

        <table class="hero-table">
            <tr>
                <td class="hero-left">
                    <table class="meta-table">
                        <tr><td class="meta-label">Nama Event</td><td class="meta-separator">:</td><td>{{ $event->name }}</td></tr>
                        <tr><td class="meta-label">Nama Pemesan</td><td class="meta-separator">:</td><td>{{ $user->name }}</td></tr>
                        <tr><td class="meta-label">Nomor Tiket</td><td class="meta-separator">:</td><td>{{ $ticket->ticket_number }}</td></tr>
                        <tr><td class="meta-label">Kategori</td><td class="meta-separator">:</td><td>{{ $category->name }}</td></tr>
                        <tr><td class="meta-label">Harga</td><td class="meta-separator">:</td><td>Rp {{ number_format($category->price,0,',','.') }}</td></tr>
                        <tr><td class="meta-label">Tanggal</td><td class="meta-separator">:</td><td>{{ $event->event_date->format('d M Y H:i') }}</td></tr>
                        <tr><td class="meta-label">Lokasi</td><td class="meta-separator">:</td><td>{{ $event->location }}</td></tr>
                    </table>
                </td>
                <td class="hero-right">
                    <div class="ticket-card">
                        <div class="ticket-card-label">Ticket ID</div>
                        <div class="ticket-number">{{ $ticket->ticket_number }}</div>
                        <div class="ticket-note">
                            Simpan tiket ini dan tunjukkan QR Code saat check-in. Tiket hanya berlaku satu kali scan.
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="qr-wrap">
            <div class="qr-frame">
                @if ($ticket->qrCode)
                    <img src="{{ $ticket->qrCode->data_uri }}" alt="QR Code tiket {{ $ticket->ticket_number }}">
                @endif
            </div>
            <div class="barcode">{{ $ticket->ticket_number }}</div>
        </div>

        <div class="cut-line"></div>
        <div class="footer">
            <strong>Bilus Fest</strong> • Official E-Ticket Festival Musik<br>
            Tunjukkan QR Code ini saat memasuki area event.
        </div>
    </div>
</div>
</body>
</html>
