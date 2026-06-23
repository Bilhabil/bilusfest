@extends('layouts.app')

@section('content')
<style>
    .validation-page {
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0 3rem;
    }

    .validation-card {
        width: 100%;
        max-width: 760px;
        border-radius: 30px;
        overflow: hidden;
        background:
            radial-gradient(circle at top right, rgba(34, 197, 94, 0.10), transparent 28%),
            radial-gradient(circle at bottom left, rgba(79, 70, 229, 0.10), transparent 30%),
            linear-gradient(180deg, #ffffff, #f8fafc);
        border: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 0 26px 58px rgba(15, 23, 42, 0.08);
    }

    .validation-topbar {
        height: 12px;
        background: linear-gradient(90deg, #22c55e, #4F46E5, #7C3AED);
    }

    .validation-body {
        padding: 2rem;
    }

    .validation-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.6rem 0.95rem;
        border-radius: 999px;
        background: rgba(34, 197, 94, 0.10);
        color: #166534;
        font-weight: 800;
        letter-spacing: 0.04em;
        font-size: 0.84rem;
        text-transform: uppercase;
    }

    .validation-title {
        margin: 1rem 0 0.65rem;
        font-size: clamp(2rem, 4vw, 3rem);
        line-height: 1.02;
        letter-spacing: -0.06em;
        color: #0F172A;
        font-weight: 800;
    }

    .validation-desc {
        color: #64748B;
        line-height: 1.8;
        max-width: 60ch;
        margin-bottom: 1.5rem;
    }

    .validation-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .info-card {
        padding: 1rem 1.05rem;
        border-radius: 20px;
        border: 1px solid rgba(148, 163, 184, 0.14);
        background: rgba(255,255,255,0.9);
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.04);
    }

    .info-card small {
        display: block;
        color: #94A3B8;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 0.2rem;
    }

    .info-card strong {
        color: #0F172A;
        font-size: 1rem;
        line-height: 1.5;
        word-break: break-word;
    }

    .status-strip {
        margin-top: 1.2rem;
        padding: 1rem 1.1rem;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.10), rgba(16, 185, 129, 0.08));
        border: 1px solid rgba(34, 197, 94, 0.14);
        color: #166534;
        font-weight: 700;
    }

    .actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-top: 1.5rem;
    }

    .btn-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 0 1.2rem;
        border-radius: 14px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        background: rgba(255,255,255,0.9);
        color: #0F172A;
        font-weight: 700;
        text-decoration: none;
    }

    @media (max-width: 767.98px) {
        .validation-body {
            padding: 1.35rem;
        }

        .validation-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container validation-page">
    <div class="validation-card">
        <div class="validation-topbar"></div>
        <div class="validation-body">
            <span class="validation-badge">Check-in berhasil</span>
            <h1 class="validation-title">Tiket valid dan sudah ditandai sebagai digunakan.</h1>
            <p class="validation-desc">
                QR code ini sukses diverifikasi di sistem. Data tiket sekarang tersimpan sebagai check-in pertama dan tidak bisa dipakai ulang.
            </p>

            <div class="validation-grid">
                <div class="info-card">
                    <small>Nomor Tiket</small>
                    <strong>{{ $ticket->ticket_number }}</strong>
                </div>
                <div class="info-card">
                    <small>Nama Pemesan</small>
                    <strong>{{ $ticket->orderDetail->order->user->name }}</strong>
                </div>
                <div class="info-card">
                    <small>Event</small>
                    <strong>{{ $ticket->orderDetail->ticketCategory->event->name }}</strong>
                </div>
                <div class="info-card">
                    <small>Kategori</small>
                    <strong>{{ $ticket->orderDetail->ticketCategory->name }}</strong>
                </div>
                <div class="info-card">
                    <small>Tanggal</small>
                    <strong>{{ $ticket->orderDetail->ticketCategory->event->event_date->format('d M Y H:i') }}</strong>
                </div>
                <div class="info-card">
                    <small>Lokasi</small>
                    <strong>{{ $ticket->orderDetail->ticketCategory->event->location }}</strong>
                </div>
            </div>

            <div class="status-strip">
                Status tiket: {{ strtoupper($ticket->status) }}
                @if($ticket->qrCode?->used_at)
                    <span> - Dipindai pada {{ $ticket->qrCode->used_at->format('d M Y H:i') }}</span>
                @endif
            </div>

            <div class="actions">
                <a href="{{ route('user.orders.index') }}" class="btn-soft">Lihat Pesanan</a>
                <a href="{{ route('landing') }}" class="btn-soft">Kembali ke Landing</a>
            </div>
        </div>
    </div>
</div>
@endsection
