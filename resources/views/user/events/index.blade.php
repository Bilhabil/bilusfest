@extends('layouts.app')

@section('content')
<style>
    .events-page {
        padding: 1rem 0 2.5rem;
    }

    .events-hero {
        position: relative;
        overflow: hidden;
        padding: 2.6rem;
        border-radius: 30px;
        background:
            radial-gradient(circle at top right, rgba(245, 158, 11, 0.16), transparent 24%),
            radial-gradient(circle at top left, rgba(124, 58, 237, 0.16), transparent 30%),
            linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.94));
        border: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.06);
    }

    .events-hero::after {
        content: "";
        position: absolute;
        inset: auto -45px -70px auto;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.10), rgba(124, 58, 237, 0.10));
        filter: blur(6px);
    }

    .events-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
    }

    .summary-card {
        padding: 1.2rem;
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.84);
        border: 1px solid rgba(148, 163, 184, 0.15);
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.04);
    }

    .summary-card small {
        display: block;
        color: #64748B;
        font-weight: 700;
        margin-bottom: 0.45rem;
    }

    .summary-card strong {
        display: block;
        color: #0F172A;
        font-size: 1.55rem;
        line-height: 1.1;
        letter-spacing: -0.04em;
    }

    .events-grid {
        padding-top: 2rem;
    }

    .event-card-premium {
        height: 100%;
        overflow: hidden;
        border-radius: 26px;
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 0 20px 38px rgba(15, 23, 42, 0.05);
        transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease;
    }

    .event-card-premium:hover {
        transform: translateY(-6px);
        box-shadow: 0 28px 52px rgba(15, 23, 42, 0.10);
        border-color: rgba(79, 70, 229, 0.18);
    }

    .event-banner {
        position: relative;
        height: 250px;
        background:
            linear-gradient(180deg, rgba(15, 23, 42, 0.04), rgba(15, 23, 42, 0.42)),
            linear-gradient(135deg, rgba(79, 70, 229, 0.16), rgba(124, 58, 237, 0.14));
        background-size: cover;
        background-position: center;
    }

    .event-banner::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at top right, rgba(245, 158, 11, 0.14), transparent 30%),
            linear-gradient(180deg, rgba(15, 23, 42, 0.02), rgba(15, 23, 42, 0.28));
    }

    .event-pill {
        position: absolute;
        top: 18px;
        left: 18px;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.55rem 0.85rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.90);
        color: #0F172A;
        font-size: 0.82rem;
        font-weight: 800;
    }

    .event-pill::before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #F59E0B;
        box-shadow: 0 0 0 5px rgba(245, 158, 11, 0.12);
    }

    .event-card-body {
        padding: 1.55rem;
    }

    .event-name {
        font-size: 1.5rem;
        line-height: 1.16;
        letter-spacing: -0.04em;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 1rem;
    }

    .event-description {
        color: #64748B;
        font-size: 0.96rem;
        line-height: 1.75;
        margin-bottom: 1.1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .event-meta-list {
        display: grid;
        gap: 0.85rem;
        margin-bottom: 1.35rem;
    }

    .event-meta-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        color: #475569;
        font-weight: 500;
    }

    .event-meta-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.10), rgba(124, 58, 237, 0.08));
        color: #4F46E5;
    }

    .event-meta-label {
        display: block;
        color: #94A3B8;
        font-size: 0.84rem;
        font-weight: 700;
        margin-bottom: 0.1rem;
        letter-spacing: 0.02em;
    }

    .event-meta-value {
        display: block;
        color: #0F172A;
        font-weight: 600;
    }

    .event-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(148, 163, 184, 0.14);
    }

    .event-status {
        color: #64748B;
        font-size: 0.94rem;
    }

    .event-status strong {
        display: block;
        color: #4F46E5;
        font-size: 1rem;
        font-weight: 800;
    }

    .event-detail-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 0 1.2rem;
        border-radius: 14px;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: #fff;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 14px 28px rgba(79, 70, 229, 0.18);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .event-detail-btn:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 18px 34px rgba(79, 70, 229, 0.24);
    }

    .empty-state {
        padding: 2rem;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(148, 163, 184, 0.16);
        color: #64748B;
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.04);
    }

    .pagination-shell nav {
        display: flex;
        justify-content: center;
    }

    .pagination-shell .pagination {
        gap: 0.45rem;
        flex-wrap: wrap;
    }

    .pagination-shell .page-link {
        border: 1px solid rgba(148, 163, 184, 0.16);
        color: #475569;
        border-radius: 12px !important;
        min-width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.03);
    }

    .pagination-shell .page-item.active .page-link {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        border-color: transparent;
    }

    @media (max-width: 991.98px) {
        .events-summary {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767.98px) {
        .events-page {
            padding-top: 0.25rem;
        }

        .events-hero {
            padding: 1.5rem;
        }

        .event-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .event-detail-btn {
            width: 100%;
        }
    }
</style>

<div class="container events-page">
    <section class="events-hero">
        <div class="events-summary">
            <div class="summary-card">
                <small>Total Event Aktif</small>
                <strong>{{ $events->total() }}</strong>
            </div>
            <div class="summary-card">
                <small>Tampil di Halaman Ini</small>
                <strong>{{ $events->count() }}</strong>
            </div>
            <div class="summary-card">
                <small>Status Katalog</small>
                <strong>Live</strong>
            </div>
        </div>
    </section>

    <section class="events-grid">
        <div class="row g-4">
            @forelse($events as $event)
                <div class="col-md-6 col-xl-4">
                    <article class="event-card-premium">
                        <div
                            class="event-banner"
                            style="background-image: linear-gradient(180deg, rgba(15, 23, 42, 0.04), rgba(15, 23, 42, 0.42)), url('{{ $event->display_banner_url }}');"
                        >
                            <span class="event-pill">Event Aktif</span>
                        </div>

                        <div class="event-card-body">
                            <h3 class="event-name">{{ $event->name }}</h3>
                            <p class="event-description">{{ $event->display_description }}</p>

                            <div class="event-meta-list">
                                <div class="event-meta-item">
                                    <span class="event-meta-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11z"></path>
                                            <circle cx="12" cy="10" r="2.5"></circle>
                                        </svg>
                                    </span>
                                    <span>
                                        <span class="event-meta-label">Lokasi</span>
                                        <span class="event-meta-value">{{ $event->location }}</span>
                                    </span>
                                </div>

                                <div class="event-meta-item">
                                    <span class="event-meta-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <rect x="3" y="5" width="18" height="16" rx="3"></rect>
                                            <path d="M16 3v4M8 3v4M3 11h18"></path>
                                        </svg>
                                    </span>
                                    <span>
                                        <span class="event-meta-label">Jadwal</span>
                                        <span class="event-meta-value">{{ $event->event_date->format('d M Y, H:i') }}</span>
                                    </span>
                                </div>
                            </div>

                            <div class="event-footer">
                                <div class="event-status">
                                    Status
                                    <strong>Siap Dipesan</strong>
                                </div>

                                <a href="{{ route('user.events.show', $event) }}" class="event-detail-btn">Lihat Detail</a>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        Belum ada event yang tersedia saat ini. Silakan cek kembali nanti untuk jadwal terbaru.
                    </div>
                </div>
            @endforelse
        </div>

        @if($events->hasPages())
            <div class="pagination-shell mt-5">
                {{ $events->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </section>
</div>
@endsection
