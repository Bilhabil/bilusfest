@extends('layouts.app')

@section('content')
@php
    $layout = $event->concert_layout;
    $cityLabel = ucfirst($event->city_key);
    $categoryBlueprints = [
        'vip' => ['position' => 'top-left', 'tone' => 'vip', 'note' => 'Dekat panggung'],
        'presale' => ['position' => 'top-right', 'tone' => 'entry', 'note' => 'Akses nyaman'],
        'early bird' => ['position' => 'bottom-left', 'tone' => 'festival', 'note' => 'Zona hemat'],
        'festival' => ['position' => 'bottom-right', 'tone' => 'primary', 'note' => 'Area utama penonton'],
    ];
    $categoryOrder = [
        'vip' => 1,
        'festival' => 2,
        'early bird' => 3,
        'presale' => 4,
    ];
    $fallbackBlueprints = [
        ['position' => 'top-left', 'tone' => 'vip', 'note' => 'Area premium'],
        ['position' => 'top-right', 'tone' => 'entry', 'note' => 'Akses cepat'],
        ['position' => 'bottom-left', 'tone' => 'festival', 'note' => 'Zona belakang kiri'],
        ['position' => 'bottom-right', 'tone' => 'primary', 'note' => 'Zona utama kanan'],
    ];
    $ticketZones = collect($event->ticketCategories)
        ->sortBy(function ($ticket) use ($categoryOrder) {
            return $categoryOrder[strtolower(trim($ticket->name))] ?? 99;
        })
        ->values()
        ->map(function ($ticket, $index) use ($categoryBlueprints, $fallbackBlueprints) {
        $categoryKey = strtolower(trim($ticket->name));
        $blueprint = $categoryBlueprints[$categoryKey] ?? $fallbackBlueprints[$index % count($fallbackBlueprints)];

        return [
            'name' => $ticket->name,
            'price' => $ticket->price,
            'quota' => $ticket->quota - $ticket->sold,
            'position' => $blueprint['position'],
            'tone' => $blueprint['tone'],
            'note' => $blueprint['note'],
        ];
    });
@endphp

<style>
    .event-detail-page {
        padding-top: 1rem;
        padding-bottom: 2.5rem;
    }

    .detail-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(320px, 0.8fr);
        gap: 1.5rem;
        padding: 1.3rem;
        border-radius: 30px;
        background:
            radial-gradient(circle at top right, rgba(245, 158, 11, 0.12), transparent 28%),
            radial-gradient(circle at left center, rgba(124, 58, 237, 0.12), transparent 28%),
            linear-gradient(135deg, rgba(255,255,255,0.98), rgba(248,250,252,0.94));
        border: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 0 22px 52px rgba(15, 23, 42, 0.06);
    }

    .detail-hero-media {
        position: relative;
        min-height: 360px;
        border-radius: 24px;
        overflow: hidden;
        background:
            linear-gradient(180deg, rgba(15, 23, 42, 0.06), rgba(15, 23, 42, 0.52)),
            url('{{ $event->display_banner_url }}') center/cover;
    }

    .detail-hero-media::after {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at top right, rgba(245, 158, 11, 0.18), transparent 25%),
            radial-gradient(circle at bottom left, rgba(124, 58, 237, 0.22), transparent 30%);
    }

    .detail-hero-fallback {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
        color: #fff;
    }

    .detail-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.55rem 0.85rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255,255,255,0.12);
        color: #fff;
        font-size: 0.84rem;
        font-weight: 700;
        letter-spacing: 0.04em;
    }

    .detail-title {
        font-size: clamp(2rem, 4vw, 3.4rem);
        line-height: 1.02;
        letter-spacing: -0.06em;
        font-weight: 800;
        color: #0F172A;
        margin: 0.85rem 0 0.9rem;
    }

    .detail-description {
        color: #475569;
        font-size: 1.04rem;
        line-height: 1.85;
        margin-bottom: 1.2rem;
        max-width: 60ch;
    }

    .detail-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.9rem;
    }

    .meta-chip {
        display: flex;
        gap: 0.85rem;
        align-items: center;
        padding: 1rem 1.05rem;
        border-radius: 18px;
        background: rgba(255,255,255,0.84);
        border: 1px solid rgba(148, 163, 184, 0.14);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.04);
    }

    .meta-chip-icon {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.10), rgba(124, 58, 237, 0.08));
        color: #4F46E5;
        flex: none;
    }

    .meta-chip small {
        display: block;
        color: #94A3B8;
        font-weight: 700;
        margin-bottom: 0.1rem;
    }

    .meta-chip strong {
        display: block;
        color: #0F172A;
        font-size: 0.98rem;
        line-height: 1.5;
    }

    .section-card {
        margin-top: 1.5rem;
        padding: 1.5rem;
        border-radius: 28px;
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.16);
        box-shadow: 0 20px 38px rgba(15, 23, 42, 0.05);
    }

    .section-heading {
        font-size: 1.4rem;
        letter-spacing: -0.04em;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 0.45rem;
    }

    .section-subtitle {
        color: #64748B;
        line-height: 1.75;
        margin-bottom: 0;
    }

    .ticket-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-top: 1.25rem;
    }

    .ticket-card {
        height: 100%;
        padding: 1.2rem;
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.16);
        background:
            radial-gradient(circle at top right, rgba(79, 70, 229, 0.08), transparent 30%),
            linear-gradient(180deg, #fff, #fbfcff);
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.04);
    }

    .ticket-card h5 {
        font-size: 1.2rem;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 0.65rem;
    }

    .ticket-card .price {
        font-size: 1.08rem;
        font-weight: 700;
        color: #4F46E5;
        margin-bottom: 0.8rem;
    }

    .ticket-card .quota {
        color: #64748B;
        margin-bottom: 1rem;
    }

    .ticket-card .btn {
        border-radius: 14px;
        min-height: 46px;
        font-weight: 700;
    }

    .layout-map {
        margin-top: 1rem;
        padding: 1.2rem;
        border-radius: 24px;
        background: linear-gradient(180deg, #F8FAFC, #ffffff);
        border: 1px solid rgba(148, 163, 184, 0.16);
    }

    .map-grid {
        position: relative;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        grid-template-rows: repeat(2, minmax(126px, 1fr));
        gap: 0.8rem;
        min-height: 420px;
        padding: 1rem;
        border-radius: 20px;
        background:
            linear-gradient(135deg, rgba(79, 70, 229, 0.04), rgba(124, 58, 237, 0.02)),
            #fff;
        border: 1px solid rgba(148, 163, 184, 0.14);
        overflow: hidden;
    }

    .map-grid::before {
        content: "";
        position: absolute;
        inset: 50% 1rem auto 1rem;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(148, 163, 184, 0.45), transparent);
    }

    .map-grid::after {
        content: "";
        position: absolute;
        inset: 1rem auto 1rem 50%;
        width: 1px;
        background: linear-gradient(180deg, transparent, rgba(148, 163, 184, 0.45), transparent);
    }

    .map-zone {
        position: relative;
        z-index: 1;
        padding: 0.95rem 1rem;
        border-radius: 18px;
        background: rgba(255,255,255,0.92);
        border: 1px solid rgba(148, 163, 184, 0.14);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.04);
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 0.4rem;
        min-height: 120px;
    }

    .map-zone span {
        display: block;
        font-size: 0.72rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #94A3B8;
        font-weight: 800;
    }

    .map-zone strong {
        font-size: 1rem;
        color: #0F172A;
    }

    .map-zone em {
        font-style: normal;
        color: #64748B;
        font-size: 0.9rem;
        line-height: 1.55;
    }

    .map-zone.primary {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(124, 58, 237, 0.10));
        border-color: rgba(79, 70, 229, 0.20);
        color: #1E1B4B;
    }

    .map-zone.vip {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.14), rgba(251, 191, 36, 0.10));
        border-color: rgba(245, 158, 11, 0.20);
    }

    .map-zone.festival {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.10), rgba(59, 130, 246, 0.08));
        border-color: rgba(14, 165, 233, 0.18);
    }

    .map-zone.food {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.10), rgba(244, 114, 182, 0.08));
        border-color: rgba(236, 72, 153, 0.18);
    }

    .map-zone.entry {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.10), rgba(16, 185, 129, 0.08));
        border-color: rgba(34, 197, 94, 0.18);
    }

    .map-stage {
        grid-column: 2;
        grid-row: 1 / span 2;
        padding: 1.15rem;
        min-height: 100%;
        border-radius: 22px;
        background:
            radial-gradient(circle at top, rgba(79, 70, 229, 0.10), transparent 30%),
            linear-gradient(180deg, rgba(15, 23, 42, 0.03), rgba(255, 255, 255, 0.96));
        border: 1px solid rgba(79, 70, 229, 0.18);
        box-shadow: 0 18px 32px rgba(15, 23, 42, 0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-align: center;
    }

    .map-zone.top-left {
        grid-column: 1;
        grid-row: 1;
    }

    .map-zone.top-center {
        grid-column: 2;
        grid-row: 1;
    }

    .map-zone.top-right {
        grid-column: 3;
        grid-row: 1;
    }

    .map-zone.center-left {
        grid-column: 1;
        grid-row: 2;
    }

    .map-zone.center-right {
        grid-column: 3;
        grid-row: 2;
    }

    .map-zone.bottom-left {
        grid-column: 1;
        grid-row: 2;
    }

    .map-zone.bottom-center {
        grid-column: 2;
        grid-row: 2;
    }

    .map-zone.bottom-right {
        grid-column: 3;
        grid-row: 2;
    }

    .map-stage-top {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        align-self: center;
        padding: 0.55rem 0.9rem;
        border-radius: 999px;
        background: rgba(79, 70, 229, 0.08);
        color: #4338CA;
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .map-stage-center {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1;
        padding: 1rem 0.25rem;
    }

    .map-stage-center strong {
        display: block;
        font-size: 1.3rem;
        line-height: 1.1;
        letter-spacing: -0.04em;
        color: #0F172A;
        margin-top: 0.35rem;
    }

    .map-stage-center p {
        margin: 0.5rem 0 0;
        color: #64748B;
        font-size: 0.92rem;
        line-height: 1.65;
        max-width: 24ch;
    }

    .map-stage-footer {
        display: flex;
        justify-content: space-between;
        gap: 0.75rem;
        align-items: center;
        padding-top: 0.9rem;
        border-top: 1px solid rgba(148, 163, 184, 0.14);
        color: #64748B;
        font-size: 0.88rem;
        text-align: left;
    }

    .layout-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
        color: #64748B;
        font-size: 0.95rem;
    }

    @media (max-width: 991.98px) {
        .detail-hero {
            grid-template-columns: 1fr;
        }

        .ticket-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .event-detail-page {
            padding-top: 0.5rem;
        }

        .detail-hero,
        .section-card {
            border-radius: 24px;
        }

        .detail-meta {
            grid-template-columns: 1fr;
        }

        .ticket-grid {
            grid-template-columns: 1fr;
        }

        .map-grid {
            min-height: 420px;
        }

        .layout-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="container event-detail-page">
    <div class="detail-hero">
        <div class="detail-hero-media">
            <div class="detail-hero-fallback">
                <span class="detail-badge">BILUS FEST {{ $cityLabel }}</span>
            </div>
        </div>

        <div>
            <span class="detail-badge" style="color:#4F46E5;background:rgba(79,70,229,0.08);border-color:rgba(79,70,229,0.10);">
                {{ $event->location }}
            </span>
            <h1 class="detail-title">{{ $event->name }}</h1>
            <p class="detail-description">{{ $event->display_description }}</p>

            <div class="detail-meta">
                <div class="meta-chip">
                    <div class="meta-chip-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <rect x="3" y="5" width="18" height="16" rx="3"></rect>
                            <path d="M16 3v4M8 3v4M3 11h18"></path>
                        </svg>
                    </div>
                    <div>
                        <small>Tanggal</small>
                        <strong>{{ $event->event_date->format('d M Y H:i') }}</strong>
                    </div>
                </div>

                <div class="meta-chip">
                    <div class="meta-chip-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11z"></path>
                            <circle cx="12" cy="10" r="2.5"></circle>
                        </svg>
                    </div>
                    <div>
                        <small>Venue</small>
                        <strong>{{ $event->location }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-heading">Pilih Kategori Tiket</div>
        <p class="section-subtitle">Semua kategori sudah disusun agar mudah dipilih sesuai preferensi tempat duduk dan akses konser.</p>

        <div class="ticket-grid">
            @foreach($event->ticketCategories as $ticket)
                <div class="ticket-card">
                    <h5>{{ $ticket->name }}</h5>
                    <div class="price">Rp {{ number_format($ticket->price,0,',','.') }}</div>
                    <div class="quota">Sisa: {{ $ticket->quota - $ticket->sold }}</div>
                    <a href="{{ route('user.checkout.create', $ticket) }}" class="btn btn-primary w-100">Beli Tiket</a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section-card">
        <div class="section-heading">Denah Konser & Kategori</div>
        <p class="section-subtitle">{{ $layout['subtitle'] }}</p>

        <div class="layout-map">
            <div class="map-grid">
                <div class="map-stage">
                    <div class="map-stage-top">MAIN STAGE</div>
                    <div class="map-stage-center">
                        <small style="color:#6366F1;font-weight:800;letter-spacing:.08em;text-transform:uppercase;">{{ $event->city_key }}</small>
                        <strong>{{ $layout['title'] }}</strong>
                        <p>Area tengah dipakai sebagai panggung utama, dikelilingi zona tiket sesuai kelas akses penonton.</p>
                    </div>
                    <div class="map-stage-footer">
                        <span>Front view</span>
                        <span>Access lane</span>
                    </div>
                </div>

                @foreach ($ticketZones as $zone)
                    @php
                        $positionClass = match ($zone['position']) {
                            'top-left' => 'top-left',
                            'top-center' => 'top-center',
                            'top-right' => 'top-right',
                            'center-left' => 'center-left',
                            'center-right' => 'center-right',
                            'bottom-left' => 'bottom-left',
                            'bottom-center' => 'bottom-center',
                            'bottom-right' => 'bottom-right',
                            default => 'center-stage',
                        };

                        $toneClass = match ($zone['tone']) {
                            'vip' => 'vip',
                            'festival' => 'festival',
                            'food' => 'food',
                            'entry' => 'entry',
                            default => 'primary',
                        };
                    @endphp

                    <div class="map-zone {{ $positionClass }} {{ $toneClass }}">
                        <span>{{ $zone['name'] }}</span>
                        <strong>Rp {{ number_format($zone['price'], 0, ',', '.') }}</strong>
                        <em>{{ $zone['note'] }} • Sisa {{ $zone['quota'] }} tiket</em>
                    </div>
                @endforeach
            </div>

            <div class="layout-footer">
                <div>
                    <strong style="color:#0F172A;">{{ $layout['title'] }}</strong><br>
                    <span>Gunakan denah ini sebagai panduan area masuk, penonton, dan fasilitas konser.</span>
                </div>
                <div>
                    <strong style="color:#4F46E5;">City edition</strong><br>
                    <span>{{ $cityLabel }}</span>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('user.events.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
