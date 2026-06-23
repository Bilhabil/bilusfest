<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bilus Fest') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/bilus-fest-logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #7C3AED;
            --accent: #F59E0B;
            --bg: #F8FAFC;
            --surface: rgba(255, 255, 255, 0.88);
            --text: #0F172A;
            --muted: #64748B;
            --border: rgba(148, 163, 184, 0.16);
            --shadow-soft: 0 24px 70px rgba(15, 23, 42, 0.10);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Plus Jakarta Sans", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.16), transparent 28%),
                radial-gradient(circle at bottom right, rgba(245, 158, 11, 0.10), transparent 24%),
                linear-gradient(180deg, #ffffff 0%, var(--bg) 100%);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .guest-shell {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        .guest-shell::before,
        .guest-shell::after {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            filter: blur(20px);
            opacity: 0.75;
            z-index: 0;
        }

        .guest-shell::before {
            top: -120px;
            left: -140px;
            background: rgba(79, 70, 229, 0.10);
        }

        .guest-shell::after {
            bottom: -180px;
            right: -100px;
            background: rgba(245, 158, 11, 0.10);
        }

        .guest-wrap {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 1.25rem 1rem 2rem;
        }

        .guest-header {
            width: 100%;
            max-width: 640px;
            margin: 0 auto 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .guest-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.85rem;
            color: var(--text);
        }

        .guest-brand:hover {
            color: var(--text);
        }

        .guest-brand-logo {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            object-fit: cover;
            box-shadow: 0 14px 26px rgba(15, 23, 42, 0.10);
        }

        .guest-brand-text {
            display: inline-flex;
            flex-direction: column;
            line-height: 1;
        }

        .guest-brand-name {
            font-size: 1.95rem;
            font-weight: 800;
            letter-spacing: -0.07em;
        }

        .guest-brand-subtitle {
            margin-top: 0.18rem;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: #6366F1;
        }

        .guest-back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 999px;
            border: 1px solid rgba(226, 232, 240, 1);
            background: rgba(255, 255, 255, 0.98);
            color: #475569;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            transition: transform 0.2s ease, border-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }

        .guest-back-btn:hover {
            transform: translateY(-1px);
            border-color: rgba(99, 102, 241, 0.24);
            color: #4338CA;
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.10);
        }

        .guest-card {
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
            border: 1px solid var(--border);
            border-radius: 30px;
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(16px);
        }

        .guest-card {
            background: var(--surface);
            padding: 1rem;
            display: flex;
            align-items: stretch;
        }

        .guest-card-inner {
            width: 100%;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(255, 255, 255, 0.78);
            padding: 1.8rem;
        }

        .auth-shell {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .auth-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            align-self: flex-start;
            border-radius: 999px;
            border: 1px solid rgba(79, 70, 229, 0.12);
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.10), rgba(124, 58, 237, 0.08));
            color: #4338CA;
            font-size: 0.88rem;
            font-weight: 700;
            padding: 0.6rem 0.95rem;
        }

        .auth-title {
            margin: 0;
            font-size: clamp(2rem, 4vw, 2.65rem);
            line-height: 1.08;
            letter-spacing: -0.05em;
            color: #111827;
            font-weight: 800;
        }

        .auth-description {
            margin: 0;
            max-width: 52ch;
            color: var(--muted);
            font-size: 1.02rem;
            line-height: 1.7;
        }

        .auth-status {
            border-radius: 18px;
            border: 1px solid rgba(34, 197, 94, 0.18);
            background: rgba(240, 253, 244, 0.95);
            color: #166534;
            padding: 0.9rem 1rem;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .auth-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.9rem;
            width: 100%;
            min-height: 58px;
            border-radius: 18px;
            border: 1px solid rgba(226, 232, 240, 1);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.98));
            color: #1e293b;
            font-size: 0.98rem;
            font-weight: 700;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .auth-google:hover {
            transform: translateY(-1px);
            border-color: rgba(99, 102, 241, 0.24);
            box-shadow: 0 18px 34px rgba(15, 23, 42, 0.08);
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            color: #94A3B8;
            text-transform: uppercase;
            font-size: 0.74rem;
            font-weight: 800;
            letter-spacing: 0.22em;
        }

        .auth-divider-line {
            height: 1px;
            flex: 1;
            background: linear-gradient(90deg, transparent, rgba(148, 163, 184, 0.55), transparent);
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .auth-field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .auth-label {
            color: #1E293B;
            font-size: 0.96rem;
            font-weight: 700;
        }

        .auth-input {
            width: 100%;
            min-height: 54px;
            border-radius: 16px;
            border: 1px solid #D7DEEA;
            background: rgba(255, 255, 255, 0.96);
            padding: 0.9rem 1rem;
            color: #0F172A;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .auth-input::placeholder {
            color: #94A3B8;
        }

        .auth-input:focus {
            border-color: rgba(79, 70, 229, 0.9);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.10);
        }

        .auth-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.9rem;
        }

        .auth-check {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            color: #475569;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .auth-check input {
            width: 18px;
            height: 18px;
            accent-color: #4F46E5;
        }

        .auth-link {
            color: #4F46E5;
            font-size: 0.95rem;
            font-weight: 700;
            transition: color 0.2s ease;
        }

        .auth-link:hover {
            color: #3730A3;
        }

        .auth-footer {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .auth-note {
            color: #64748B;
            font-size: 0.95rem;
        }

        .auth-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 54px;
            border-radius: 16px;
            border: none;
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            color: #fff;
            padding: 0.9rem 1.4rem;
            font-size: 0.98rem;
            font-weight: 800;
            box-shadow: 0 14px 30px rgba(79, 70, 229, 0.22);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .auth-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 36px rgba(79, 70, 229, 0.26);
        }

        .auth-error {
            margin: 0;
            border-radius: 16px;
            border: 1px solid rgba(248, 113, 113, 0.18);
            background: rgba(254, 242, 242, 0.95);
            color: #B91C1C;
            padding: 0.85rem 1rem;
            font-size: 0.93rem;
            line-height: 1.6;
        }

        @media (max-width: 767.98px) {
            .guest-wrap {
                padding: 0.9rem;
            }

            .guest-header,
            .guest-card {
                border-radius: 24px;
            }

            .guest-header {
                margin-bottom: 1rem;
            }

            .guest-card-inner {
                padding: 1.25rem;
            }

            .auth-footer,
            .auth-row {
                align-items: stretch;
            }

            .auth-submit {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="guest-shell">
        <div class="guest-wrap">
            <div class="guest-header">
                <a href="{{ route('landing') }}" class="guest-brand">
                    <img src="{{ asset('images/bilus-fest-logo.png') }}" alt="Bilus Fest" class="guest-brand-logo">
                    <span class="guest-brand-text">
                        <span class="guest-brand-name">BILUS FEST</span>
                        <span class="guest-brand-subtitle">E-Ticketing</span>
                    </span>
                </a>
                <a href="{{ route('landing') }}" aria-label="Kembali ke landing" class="guest-back-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M10 19L3 12L10 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M4 12H21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"></path>
                    </svg>
                </a>
            </div>

            <section class="guest-card">
                <div class="guest-card-inner">
                    {{ $slot }}
                </div>
            </section>
        </div>
    </div>
</body>
</html>
