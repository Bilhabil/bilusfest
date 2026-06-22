@extends('layouts.app')

@section('content')
<div class="container py-5">
    <style>
        .ticket-qr-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .ticket-qr-card {
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .ticket-qr-card .card-body {
            padding: 1.5rem;
        }

        .ticket-qr-frame {
            width: 100%;
            max-width: 260px;
            margin: 0 auto 1rem;
            padding: 14px;
            background: #fff;
            border: 1px solid #dbe3ef;
            border-radius: 18px;
            text-align: center;
        }

        .ticket-qr-image {
            display: block;
            width: 100%;
            height: auto;
            image-rendering: pixelated;
        }

        .ticket-number-badge {
            display: inline-block;
            margin-top: .85rem;
            padding: .55rem .8rem;
            border-radius: 999px;
            background: #eef2ff;
            color: #4338ca;
            font-weight: 700;
            font-size: .95rem;
            word-break: break-all;
        }

        .ticket-qr-note {
            margin-bottom: 0;
            color: #64748b;
            font-size: .95rem;
        }
    </style>

    <h3>Detail Pesanan</h3>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <p><b>Kode Order:</b> {{ $order->order_code }}</p>
            <p><b>Status:</b> {{ $order->status }}</p>
            <p><b>Total:</b> Rp {{ number_format($order->total_price,0,',','.') }}</p>

            <hr>
            <table class="table table-bordered">
                <thead><tr><th>Event</th><th>Kategori</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead>
                <tbody>
                    @foreach($order->details as $detail)
                        <tr>
                            <td>{{ $detail->ticketCategory->event->name }}</td>
                            <td>{{ $detail->ticketCategory->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>Rp {{ number_format($detail->price,0,',','.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal,0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($order->status === 'pending')
                <a href="{{ route('user.payment.pay',$order) }}" class="btn btn-primary">Lanjutkan Pembayaran</a>
            @endif

            @if($order->status === 'success')
                <hr>
                <h5>Tiket Saya</h5>
                <p class="ticket-qr-note">Tunjukkan QR Code ini saat check-in. Ukurannya sudah dibuat lebih besar agar mudah discan lewat HP.</p>

                <div class="ticket-qr-grid">
                    @foreach($order->details as $detail)
                        @foreach($detail->tickets as $ticket)
                            <div class="ticket-qr-card">
                                <div class="card-body">
                                    @if($ticket->qrCode)
                                        <div class="ticket-qr-frame">
                                            <img
                                                src="{{ $ticket->qrCode->data_uri }}"
                                                alt="QR Code tiket {{ $ticket->ticket_number }}"
                                                class="ticket-qr-image"
                                            >
                                            <div class="ticket-number-badge">{{ $ticket->ticket_number }}</div>
                                        </div>
                                    @endif

                                    <p><b>Nomor Tiket:</b> {{ $ticket->ticket_number }}</p>
                                    <p><b>Status:</b> {{ $ticket->status }}</p>
                                    <p><b>Event:</b> {{ $detail->ticketCategory->event->name }}</p>
                                    <p><b>Kategori:</b> {{ $detail->ticketCategory->name }}</p>

                                    <a href="{{ route('user.tickets.download',$ticket) }}" class="btn btn-success btn-sm mt-2">Download E-Ticket PDF</a>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endif

            <a href="{{ route('user.orders.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
