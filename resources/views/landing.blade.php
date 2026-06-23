<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bilus Fest | Platform Tiket Festival Musik Modern</title>
    <meta name="description" content="Bilus Fest memudahkan pembelian tiket festival musik dengan checkout cepat, pembayaran aman, QR check-in, dan e-ticket digital.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/bilus-fest-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #7C3AED;
            --accent: #F59E0B;
            --bg: #F8FAFC;
            --surface: #FFFFFF;
            --text: #0F172A;
            --muted: #475569;
            --border: rgba(148, 163, 184, 0.18);
            --shadow-soft: 0 20px 60px rgba(15, 23, 42, 0.08);
            --shadow-card: 0 24px 50px rgba(79, 70, 229, 0.12);
            --radius-xl: 28px;
            --radius-lg: 22px;
            --radius-md: 18px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: "Plus Jakarta Sans", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.12), transparent 28%),
                linear-gradient(180deg, #ffffff 0%, var(--bg) 100%);
        }

        a {
            text-decoration: none;
        }

        .site-navbar {
            position: fixed;
            inset: 0 0 auto 0;
            z-index: 1000;
            padding: 1rem 0;
            transition: all 0.25s ease;
        }

        .site-navbar.scrolled {
            background: rgba(248, 250, 252, 0.72);
            backdrop-filter: blur(16px);
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.06);
            border-bottom: 1px solid rgba(148, 163, 184, 0.14);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.85rem;
            color: var(--text);
        }

        .brand-logo {
            height: 66px;
            width: 66px;
            display: block;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 16px 28px rgba(15, 23, 42, 0.10);
        }

        .brand-text {
            display: inline-flex;
            flex-direction: column;
            line-height: 1;
        }

        .brand-name {
            font-size: 2.15rem;
            font-weight: 800;
            letter-spacing: -0.08em;
            color: #0F172A;
        }

        .brand-subtitle {
            margin-top: 0.2rem;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: #6366F1;
        }

        .nav-shell {
            border-radius: 22px;
            padding: 0.45rem 0.8rem;
        }

        .nav-link-custom {
            color: rgba(15, 23, 42, 0.76);
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .nav-link-custom:hover {
            color: var(--primary);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            border: 0;
            border-radius: 14px;
            padding: 0.9rem 1.4rem;
            font-weight: 700;
            box-shadow: 0 16px 30px rgba(79, 70, 229, 0.22);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary-custom:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 22px 40px rgba(79, 70, 229, 0.28);
        }

        .btn-secondary-custom {
            background: rgba(255, 255, 255, 0.9);
            color: var(--text);
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 14px;
            padding: 0.9rem 1.4rem;
            font-weight: 700;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .btn-secondary-custom:hover {
            color: var(--primary);
            transform: translateY(-2px);
            border-color: rgba(79, 70, 229, 0.28);
        }

        .hero-section {
            position: relative;
            overflow: hidden;
            padding: 9.5rem 0 6rem;
        }

        .hero-section::before,
        .hero-section::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(20px);
            z-index: 0;
        }

        .hero-section::before {
            width: 380px;
            height: 380px;
            top: 80px;
            left: -80px;
            background: rgba(124, 58, 237, 0.14);
        }

        .hero-section::after {
            width: 320px;
            height: 320px;
            right: -90px;
            top: 140px;
            background: rgba(245, 158, 11, 0.12);
        }

        .hero-grid {
            position: relative;
            z-index: 1;
            align-items: center;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.55rem 0.9rem;
            border-radius: 999px;
            color: var(--primary);
            background: rgba(79, 70, 229, 0.08);
            border: 1px solid rgba(79, 70, 229, 0.08);
            font-weight: 700;
            font-size: 0.92rem;
        }

        .hero-title {
            font-size: clamp(2.6rem, 5vw, 4.6rem);
            line-height: 1.02;
            letter-spacing: -0.06em;
            font-weight: 800;
            margin: 1.3rem 0 1.4rem;
            max-width: 10.5ch;
        }

        .hero-subtitle {
            font-size: 1.12rem;
            line-height: 1.8;
            color: var(--muted);
            max-width: 58ch;
            margin-bottom: 2rem;
        }

        .hero-points {
            display: flex;
            flex-wrap: wrap;
            gap: 0.85rem;
            margin-top: 2rem;
        }

        .hero-point {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.8rem 1rem;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(148, 163, 184, 0.16);
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.04);
            color: var(--muted);
            font-weight: 600;
        }

        .hero-point-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 0 6px rgba(245, 158, 11, 0.14);
        }

        .hero-visual {
            position: relative;
            padding: 1.4rem;
            border-radius: 32px;
            background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(255,255,255,0.72));
            border: 1px solid rgba(255,255,255,0.7);
            box-shadow: var(--shadow-card);
            backdrop-filter: blur(10px);
        }

        .visual-stage {
            position: relative;
            min-height: 540px;
            border-radius: 28px;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(15,23,42,0.08), rgba(15,23,42,0.1)),
                url('https://images.unsplash.com/photo-1501386761578-eac5c94b800a?auto=format&fit=crop&w=1400&q=80') center/cover;
        }

        .visual-stage::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.08), rgba(15, 23, 42, 0.58)),
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.34), transparent 38%),
                radial-gradient(circle at top right, rgba(245, 158, 11, 0.18), transparent 28%);
        }

        .floating-card,
        .stats-card,
        .ticket-card {
            position: absolute;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(10px);
        }

        .floating-card {
            top: 24px;
            left: 24px;
            width: min(320px, calc(100% - 48px));
            padding: 1.2rem;
        }

        .stats-card {
            bottom: 24px;
            left: 24px;
            width: 220px;
            padding: 1.2rem;
        }

        .ticket-card {
            right: 24px;
            bottom: 28px;
            width: 230px;
            padding: 1.2rem;
        }

        .mini-label {
            color: var(--primary);
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .mini-title {
            margin: 0.5rem 0 0.45rem;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: -0.03em;
        }

        .mini-text {
            color: var(--muted);
            font-size: 0.94rem;
            line-height: 1.65;
        }

        .price-tag {
            display: inline-block;
            margin-top: 0.9rem;
            padding: 0.45rem 0.75rem;
            border-radius: 999px;
            background: rgba(79, 70, 229, 0.08);
            color: var(--primary);
            font-weight: 800;
        }

        .qr-box {
            width: 84px;
            height: 84px;
            border-radius: 16px;
            margin-bottom: 0.9rem;
            background:
                linear-gradient(90deg, #0F172A 10px, transparent 10px) 0 0 / 20px 20px,
                linear-gradient(#0F172A 10px, transparent 10px) 0 0 / 20px 20px,
                #fff;
            border: 1px solid rgba(148, 163, 184, 0.28);
        }

        .section-spacing {
            padding: 6.2rem 0;
        }

        .section-label {
            color: var(--primary);
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 0.8rem;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.08;
            letter-spacing: -0.05em;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--muted);
            max-width: 58ch;
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .feature-card,
        .event-card,
        .process-card {
            height: 100%;
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            background: var(--surface);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.04);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }

        .feature-card:hover,
        .event-card:hover,
        .process-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 44px rgba(15, 23, 42, 0.08);
            border-color: rgba(79, 70, 229, 0.18);
        }

        .card-body-custom {
            padding: 1.5rem;
        }

        .icon-wrap {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(124, 58, 237, 0.1));
            color: var(--primary);
        }

        .event-image {
            height: 230px;
            border-radius: 22px 22px 0 0;
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }

        .event-image::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15,23,42,0.04), rgba(15,23,42,0.34));
        }

        .event-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            z-index: 2;
            padding: 0.5rem 0.8rem;
            border-radius: 999px;
            background: rgba(255,255,255,0.88);
            color: var(--text);
            font-size: 0.84rem;
            font-weight: 700;
        }

        .meta-row {
            color: #64748B;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            font-size: 0.94rem;
            margin-bottom: 0.9rem;
        }

        .price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 1.25rem;
        }

        .price-text {
            font-size: 1.16rem;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .soft-section {
            background: linear-gradient(180deg, rgba(79, 70, 229, 0.03), rgba(255,255,255,0.7));
        }

        .cta-panel {
            border-radius: 30px;
            padding: 3rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            box-shadow: 0 26px 60px rgba(79, 70, 229, 0.24);
        }

        .cta-panel p {
            color: rgba(255,255,255,0.84);
        }

        .footer {
            padding: 2.5rem 0 3rem;
            color: #64748B;
        }

        .footer-shell {
            border-top: 1px solid rgba(148, 163, 184, 0.16);
            padding-top: 2rem;
        }

        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 991.98px) {
            .hero-title {
                max-width: none;
            }

            .visual-stage {
                min-height: 480px;
            }

            .ticket-card {
                right: 18px;
                bottom: 18px;
                width: 200px;
            }

            .stats-card {
                width: 200px;
            }
        }

        @media (max-width: 767.98px) {
            .site-navbar {
                padding: 0.8rem 0;
            }

            .hero-section {
                padding: 8rem 0 4.5rem;
            }

            .hero-subtitle,
            .section-subtitle {
                font-size: 1rem;
            }

            .hero-visual {
                margin-top: 2rem;
            }

            .visual-stage {
                min-height: 460px;
            }

            .floating-card,
            .stats-card,
            .ticket-card {
                position: static;
                width: 100%;
                margin-top: 1rem;
            }

            .visual-stage {
                display: flex;
                flex-direction: column;
                justify-content: end;
                padding: 1rem;
                gap: 0.75rem;
            }

            .section-spacing {
                padding: 4.5rem 0;
            }

            .cta-panel {
                padding: 2rem;
            }

            .price-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .price-row .btn-primary-custom {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    @php
        $eventsUrl = auth()->check()
            ? (auth()->user()->role === 'admin' ? route('admin.events.index') : route('user.events.index'))
            : route('login');
        $dashboardUrl = auth()->check()
            ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard'))
            : route('register');
    @endphp

    <nav class="site-navbar" id="siteNavbar">
        <div class="container">
            <div class="nav-shell d-flex align-items-center justify-content-between">
                <a href="{{ route('landing') }}" class="brand">
                    <img src="{{ asset('images/bilus-fest-logo.png') }}" alt="Bilus Fest" class="brand-logo">
                    <span class="brand-text">
                        <span class="brand-name">BILUS FEST</span>
                        <span class="brand-subtitle">E-Ticketing</span>
                    </span>
                </a>

                <div class="d-flex align-items-center gap-3">
                    @auth
                        <a href="{{ $dashboardUrl }}" class="nav-link-custom d-none d-md-inline-flex">Dashboard</a>
                        <a href="{{ $eventsUrl }}" class="nav-link-custom d-none d-md-inline-flex">Event</a>
                        <form method="POST" action="{{ route('logout', absolute: false) }}">
                            @csrf
                            <button class="btn btn-primary-custom">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link-custom">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary-custom">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        <section class="hero-section">
            <div class="container">
                <div class="row hero-grid g-4 g-lg-5">
                    <div class="col-lg-6 reveal">
                        <span class="eyebrow">Platform tiket festival musik modern</span>
                        <h1 class="hero-title">Beli tiket festival lebih cepat, rapi, dan tanpa ribet.</h1>
                        <p class="hero-subtitle">
                            Temukan event unggulan, checkout dalam hitungan menit, bayar aman via Midtrans,
                            lalu masuk ke venue dengan e-ticket digital dan QR code yang siap dipindai.
                        </p>

                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="{{ $eventsUrl }}" class="btn btn-primary-custom">Lihat Event</a>
                            <a href="#cara-kerja" class="btn btn-secondary-custom">Cara Kerja</a>
                        </div>

                        <div class="hero-points">
                            <div class="hero-point">
                                <span class="hero-point-dot"></span>
                                Pembayaran aman via Midtrans
                            </div>
                            <div class="hero-point">
                                <span class="hero-point-dot"></span>
                                E-ticket PDF instan
                            </div>
                            <div class="hero-point">
                                <span class="hero-point-dot"></span>
                                Check-in cepat dengan QR code
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 reveal">
                        <div class="hero-visual">
                            <div class="visual-stage">
                                <div class="floating-card">
                                    <div class="mini-label">Event Pilihan</div>
                                    <h3 class="mini-title">Bilus Soundwave 2026</h3>
                                    <p class="mini-text mb-0">Festival musik modern dengan lineup premium, sistem tiket digital, dan pengalaman masuk venue yang jauh lebih cepat.</p>
                                    <div class="price-tag">Mulai Rp275.000</div>
                                </div>

                                <div class="stats-card">
                                    <div class="mini-label">Penjualan Hari Ini</div>
                                    <h3 class="mini-title mb-1">1.248 tiket</h3>
                                    <p class="mini-text mb-0">Checkout singkat, data pesanan rapi, dan validasi tiket real-time.</p>
                                </div>

                                <div class="ticket-card">
                                    <div class="qr-box"></div>
                                    <div class="mini-label">E-ticket Digital</div>
                                    <h3 class="mini-title mb-1">Siap Scan</h3>
                                    <p class="mini-text mb-0">Tiket otomatis tersedia setelah pembayaran berhasil.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-spacing soft-section" id="cara-kerja">
            <div class="container">
                <div class="row align-items-end mb-4 mb-lg-5">
                    <div class="col-lg-7 reveal">
                        <div class="section-label">Cara Kerja</div>
                        <h2 class="section-title">Semua proses pembelian tiket dibuat sesederhana mungkin.</h2>
                        <p class="section-subtitle">
                            Dari memilih event sampai masuk ke venue, alurnya dibuat cepat, jelas, dan mudah dipahami di desktop maupun mobile.
                        </p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-4 reveal">
                        <div class="process-card card-body-custom">
                            <div class="icon-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <rect x="3" y="5" width="18" height="16" rx="3"></rect>
                                    <path d="M16 3v4M8 3v4M3 11h18"></path>
                                </svg>
                            </div>
                            <div class="mini-label">Langkah 1</div>
                            <h3 class="mini-title">Pilih event favorit</h3>
                            <p class="mini-text">Jelajahi konser, festival, dan acara spesial dengan tampilan card yang rapi dan informasi yang jelas.</p>
                        </div>
                    </div>

                    <div class="col-md-4 reveal">
                        <div class="process-card card-body-custom">
                            <div class="icon-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <rect x="2.5" y="5.5" width="19" height="13" rx="3"></rect>
                                    <path d="M2.5 10h19M7 15h3"></path>
                                </svg>
                            </div>
                            <div class="mini-label">Langkah 2</div>
                            <h3 class="mini-title">Bayar dengan aman</h3>
                            <p class="mini-text">Checkout cepat dan terpercaya melalui Midtrans, sehingga transaksi terasa aman dan lebih profesional.</p>
                        </div>
                    </div>

                    <div class="col-md-4 reveal">
                        <div class="process-card card-body-custom">
                            <div class="icon-wrap">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4z"></path>
                                    <path d="M14 14h2v2h-2zM18 14h2v6h-6v-2"></path>
                                </svg>
                            </div>
                            <div class="mini-label">Langkah 3</div>
                            <h3 class="mini-title">Terima e-ticket digital</h3>
                            <p class="mini-text">Setelah pembayaran sukses, tiket PDF dan QR code langsung tersedia untuk check-in yang lebih praktis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-spacing">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6 reveal">
                        <div class="section-label">Kenapa Bilus Fest</div>
                        <h2 class="section-title">Fokus pada pembelian tiket yang cepat dan pengalaman pengguna yang modern.</h2>
                        <p class="section-subtitle">
                            Bilus Fest dirancang untuk membuat platform festival musik terasa lebih bersih, premium, dan mudah digunakan oleh pengunjung maupun penyelenggara.
                        </p>
                    </div>

                    <div class="col-lg-6">
                        <div class="row g-4">
                            <div class="col-sm-6 reveal">
                                <div class="feature-card card-body-custom">
                                    <div class="icon-wrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"></path>
                                            <path d="M14 3v5h5"></path>
                                        </svg>
                                    </div>
                                    <h3 class="mini-title">E-ticket PDF</h3>
                                    <p class="mini-text">Tiket digital siap diunduh kapan saja setelah pembayaran dikonfirmasi.</p>
                                </div>
                            </div>

                            <div class="col-sm-6 reveal">
                                <div class="feature-card card-body-custom">
                                    <div class="icon-wrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <rect x="2.5" y="5.5" width="19" height="13" rx="3"></rect>
                                            <path d="M2.5 10h19"></path>
                                        </svg>
                                    </div>
                                    <h3 class="mini-title">Checkout Cepat</h3>
                                    <p class="mini-text">Alur pembelian dibuat sederhana agar tiket bisa dibeli tanpa banyak langkah.</p>
                                </div>
                            </div>

                            <div class="col-sm-6 reveal">
                                <div class="feature-card card-body-custom">
                                    <div class="icon-wrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4z"></path>
                                            <path d="M14 14h6v6h-6z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="mini-title">QR Check-in</h3>
                                    <p class="mini-text">Proses masuk venue jadi lebih cepat dan validasi tiket lebih akurat.</p>
                                </div>
                            </div>

                            <div class="col-sm-6 reveal">
                                <div class="feature-card card-body-custom">
                                    <div class="icon-wrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path d="M4 19h16"></path>
                                            <path d="M7 15l3-3 3 2 4-5"></path>
                                        </svg>
                                    </div>
                                    <h3 class="mini-title">Data Real-time</h3>
                                    <p class="mini-text">Pantau penjualan tiket dan status pembayaran secara lebih tertata.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-spacing">
            <div class="container">
                <div class="cta-panel reveal">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7">
                            <div class="section-label text-white opacity-75">Siap Mulai</div>
                            <h2 class="section-title text-white mb-3">Buat pengalaman beli tiket festival terasa lebih cepat dan profesional.</h2>
                            <p class="mb-0">Jelajahi event, beli tiket secara online, dan gunakan e-ticket digital untuk akses yang lebih modern.</p>
                        </div>
                        <div class="col-lg-5 text-lg-end">
                            <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-3">
                                <a href="{{ $eventsUrl }}" class="btn btn-light btn-lg rounded-4 fw-bold px-4">Lihat Event</a>
                                <a href="{{ $dashboardUrl }}" class="btn btn-outline-light btn-lg rounded-4 fw-bold px-4">Mulai Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-shell">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center">
                <div>
                    <div class="brand mb-2">
                        <img src="{{ asset('images/bilus-fest-logo.png') }}" alt="Bilus Fest" class="brand-logo">
                        <span class="brand-text">
                            <span class="brand-name">BILUS FEST</span>
                            <span class="brand-subtitle">E-Ticketing</span>
                        </span>
                    </div>
                    <div>Platform tiket festival musik yang lebih modern, bersih, dan mudah digunakan.</div>
                </div>
                <div class="text-lg-end">
                    <div>&copy; 2026 Bilus Fest</div>
                    <div>Checkout cepat, e-ticket digital, dan QR check-in.</div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const navbar = document.getElementById('siteNavbar');
        const revealItems = document.querySelectorAll('.reveal');

        function updateNavbarState() {
            if (window.scrollY > 18) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.14 });

        revealItems.forEach((item) => revealObserver.observe(item));
        updateNavbarState();
        window.addEventListener('scroll', updateNavbarState, { passive: true });
    </script>
</body>
</html>
