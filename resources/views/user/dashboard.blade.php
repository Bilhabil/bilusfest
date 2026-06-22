@extends('layouts.app')

@section('content')
<style>
    .dashboard-page {
        padding: 1rem 0 2rem;
    }

    .dashboard-hero {
        position: relative;
        overflow: hidden;
        padding: 2.4rem;
        border-radius: 30px;
        background:
            radial-gradient(circle at top right, rgba(245, 158, 11, 0.18), transparent 24%),
            radial-gradient(circle at top left, rgba(124, 58, 237, 0.18), transparent 28%),
            linear-gradient(135deg, rgba(79, 70, 229, 0.98), rgba(124, 58, 237, 0.94));
        color: #fff;
        box-shadow: 0 24px 60px rgba(79, 70, 229, 0.18);
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        inset: auto -40px -70px auto;
        width: 210px;
        height: 210px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        filter: blur(4px);
    }

    .eyebrow-label {
        display: inline-flex;
        padding: 0.55rem 0.9rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.92);
        font-size: 0.88rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .dashboard-title {
        font-size: clamp(2rem, 4vw, 3.4rem);
        line-height: 1.02;
        letter-spacing: -0.05em;
        font-weight: 800;
        margin: 1.15rem 0 0.85rem;
    }

    .dashboard-subtitle {
        max-width: 58ch;
        color: rgba(255, 255, 255, 0.82);
        font-size: 1.04rem;
        line-height: 1.75;
        margin-bottom: 0;
    }

    .hero-stat-card {
        height: 100%;
        padding: 1.25rem;
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.14);
        backdrop-filter: blur(10px);
    }

    .hero-stat-card small {
        color: rgba(255, 255, 255, 0.74);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .hero-stat-card h3 {
        margin: 0.55rem 0 0;
        font-size: 2.1rem;
        font-weight: 800;
        letter-spacing: -0.05em;
    }

    .dashboard-actions {
        margin-top: 1.7rem;
    }

    .dashboard-btn-primary {
        background: #fff;
        color: #312E81;
        border: 0;
        border-radius: 14px;
        padding: 0.92rem 1.4rem;
        font-weight: 700;
        box-shadow: 0 16px 28px rgba(15, 23, 42, 0.10);
    }

    .dashboard-btn-primary:hover {
        color: #312E81;
    }

    .dashboard-btn-secondary {
        background: transparent;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 14px;
        padding: 0.92rem 1.4rem;
        font-weight: 700;
    }

    .dashboard-section {
        padding-top: 2.5rem;
    }

    .dashboard-section-label {
        color: #4F46E5;
        font-size: 0.88rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 0.65rem;
    }

    .dashboard-section-title {
        font-size: clamp(1.8rem, 3vw, 2.6rem);
        line-height: 1.08;
        letter-spacing: -0.04em;
        font-weight: 800;
        margin-bottom: 0.85rem;
    }

    .dashboard-section-subtitle {
        color: #64748B;
        max-width: 56ch;
        line-height: 1.75;
        margin-bottom: 0;
    }

    .stat-summary-card,
    .event-card-modern {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 24px;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.05);
    }

    .stat-summary-card {
        padding: 1.5rem;
        height: 100%;
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }

    .stat-summary-card:hover,
    .event-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 24px 44px rgba(15, 23, 42, 0.08);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(124, 58, 237, 0.08));
        color: #4F46E5;
    }

    .stat-summary-card small {
        color: #64748B;
        font-weight: 600;
        font-size: 0.92rem;
    }

    .stat-summary-card h3 {
        margin: 0.5rem 0 0.25rem;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.04em;
    }

    .stat-summary-card p {
        margin: 0;
        color: #94A3B8;
        font-size: 0.95rem;
    }

    .event-card-modern {
        overflow: hidden;
        height: 100%;
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }

    .event-card-banner {
        height: 220px;
        background:
            linear-gradient(180deg, rgba(15, 23, 42, 0.02), rgba(15, 23, 42, 0.38)),
            linear-gradient(135deg, rgba(79,70,229,0.18), rgba(124,58,237,0.12));
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .event-card-banner::before {
        content: "Event Aktif";
        position: absolute;
        top: 16px;
        left: 16px;
        padding: 0.48rem 0.8rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.88);
        color: #0F172A;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .event-card-body {
        padding: 1.5rem;
    }

    .event-title {
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -0.04em;
        margin-bottom: 0.6rem;
    }

    .event-meta {
        color: #64748B;
        line-height: 1.7;
        margin-bottom: 1.2rem;
    }

    .event-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: 0 1.15rem;
        border-radius: 12px;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: #fff;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 14px 26px rgba(79, 70, 229, 0.18);
    }

    .event-link:hover {
        color: #fff;
    }

    @media (max-width: 767.98px) {
        .dashboard-page {
            padding-top: 0.25rem;
        }

        .dashboard-hero {
            padding: 1.5rem;
        }

        .dashboard-actions .btn {
            width: 100%;
        }
    }
</style>

<div class="container dashboard-page">
    <section class="dashboard-hero">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <span class="eyebrow-label">Dashboard Pengguna</span>
                <h1 class="dashboard-title">Selamat datang, {{ auth()->user()->name }}.</h1>
                <p class="dashboard-subtitle">
                    Kelola pesanan, cek tiket digital, dan lihat event terbaru dari satu dashboard yang lebih rapi, cepat, dan selaras dengan pengalaman Bilus Fest.
                </p>

                <div class="dashboard-actions d-flex flex-column flex-sm-row gap-3">
                    <a href="{{ route('user.events.index') }}" class="btn dashboard-btn-primary">Lihat Event</a>
                    <a href="{{ route('user.orders.index') }}" class="btn dashboard-btn-secondary">Riwayat Pesanan</a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-4">
                        <div class="hero-stat-card">
                            <small>Total Pesanan</small>
                            <h3>{{ $totalOrders }}</h3>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="hero-stat-card">
                            <small>Berhasil</small>
                            <h3>{{ $successOrders }}</h3>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="hero-stat-card">
                            <small>Tiket Saya</small>
                            <h3>{{ $myTickets }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="dashboard-section">
        <div class="row align-items-end mb-4 mb-lg-5">
            <div class="col-lg-7">
                <div class="dashboard-section-label">Ringkasan</div>
                <h2 class="dashboard-section-title">Aktivitas tiket Anda dalam satu tampilan.</h2>
                <p class="dashboard-section-subtitle">
                    Angka penting ditampilkan lebih jelas supaya Anda bisa melihat status transaksi dan tiket tanpa perlu membuka banyak halaman.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-summary-card">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path d="M4 19h16"></path>
                            <path d="M7 15l3-3 3 2 4-5"></path>
                        </svg>
                    </div>
                    <small>Total Pesanan</small>
                    <h3>{{ $totalOrders }}</h3>
                    <p>Jumlah seluruh transaksi yang pernah Anda buat di Bilus Fest.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-summary-card">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <rect x="2.5" y="5.5" width="19" height="13" rx="3"></rect>
                            <path d="M2.5 10h19"></path>
                        </svg>
                    </div>
                    <small>Pesanan Berhasil</small>
                    <h3>{{ $successOrders }}</h3>
                    <p>Pesanan yang sudah berhasil dibayar dan siap dilanjutkan ke e-ticket.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-summary-card">
                    <div class="stat-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4z"></path>
                            <path d="M14 14h2v2h-2zM18 14h2v6h-6v-2"></path>
                        </svg>
                    </div>
                    <small>Tiket Saya</small>
                    <h3>{{ $myTickets }}</h3>
                    <p>Total tiket digital yang sudah terhubung ke akun Anda saat ini.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="dashboard-section">
        <div class="row align-items-end mb-4 mb-lg-5">
            <div class="col-lg-7">
                <div class="dashboard-section-label">Event Terbaru</div>
                <h2 class="dashboard-section-title">Temukan event aktif yang siap Anda pesan.</h2>
                <p class="dashboard-section-subtitle">
                    Jelajahi event terbaru dengan tampilan yang lebih bersih dan informatif, lalu lanjutkan ke pembelian tiket dalam beberapa langkah saja.
                </p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($latestEvents as $event)
                <div class="col-md-6 col-xl-4">
                    <article class="event-card-modern">
                        <div
                            class="event-card-banner"
                            style="background-image: linear-gradient(180deg, rgba(15, 23, 42, 0.04), rgba(15, 23, 42, 0.42)), url('{{ $event->display_banner_url }}');"
                        ></div>
                        <div class="event-card-body">
                            <h3 class="event-title">{{ $event->name }}</h3>
                            <div class="event-meta">{{ $event->location }}</div>
                            <a href="{{ route('user.events.show', $event) }}" class="event-link">Lihat Detail</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
