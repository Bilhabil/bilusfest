<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BILUS FEST</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #7C3AED;
            --accent: #F59E0B;
            --bg: #F8FAFC;
            --surface: #FFFFFF;
            --text: #0F172A;
            --muted: #64748B;
            --border: rgba(148, 163, 184, 0.18);
            --shadow-soft: 0 20px 50px rgba(15, 23, 42, 0.07);
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, 0.10), transparent 24%),
                linear-gradient(180deg, #ffffff 0%, var(--bg) 100%);
            color: var(--text);
            padding-top: 104px;
        }

        .site-navbar {
            position: fixed;
            inset: 0 0 auto 0;
            z-index: 1000;
            padding: 1rem 0;
            transition: all 0.25s ease;
        }

        .site-navbar.scrolled {
            background: rgba(248, 250, 252, 0.74);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 10px 34px rgba(15, 23, 42, 0.05);
        }

        .nav-shell {
            padding: 0.55rem 0.8rem;
            border-radius: 22px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.85rem;
            color: var(--text);
            text-decoration: none;
        }

        .brand:hover {
            color: var(--text);
        }

        .brand-logo {
            height: 58px;
            width: 58px;
            display: block;
            object-fit: cover;
            border-radius: 18px;
            box-shadow: 0 14px 26px rgba(15, 23, 42, 0.10);
        }

        .brand-text {
            display: inline-flex;
            flex-direction: column;
            line-height: 1;
        }

        .brand-name {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.07em;
            color: #0F172A;
        }

        .brand-subtitle {
            margin-top: 0.18rem;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: #6366F1;
        }

        .nav-link-custom {
            color: rgba(15, 23, 42, 0.76);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: var(--primary);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            border: 0;
            border-radius: 14px;
            padding: 0.82rem 1.25rem;
            font-weight: 700;
            box-shadow: 0 14px 28px rgba(79, 70, 229, 0.20);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary-custom:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 20px 36px rgba(79, 70, 229, 0.24);
        }

        .btn-light-custom {
            background: rgba(255, 255, 255, 0.92);
            color: var(--text);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 14px;
            padding: 0.82rem 1.25rem;
            font-weight: 700;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
        }

        .btn-light-custom:hover {
            color: var(--primary);
        }

        .page-shell {
            padding-bottom: 3rem;
        }

        .surface-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: var(--shadow-soft);
        }

        @media (max-width: 991.98px) {
            body {
                padding-top: 92px;
            }

            .site-navbar {
                padding: 0.8rem 0;
            }
        }
    </style>
</head>

<body>
<nav class="site-navbar" id="siteNavbar">
    <div class="container">
        <div class="nav-shell d-flex align-items-center justify-content-between">
            <a class="brand" href="{{ route('landing') }}">
                <img src="{{ asset('images/bilus-fest-logo.png') }}" alt="Bilus Fest" class="brand-logo">
                <span class="brand-text">
                    <span class="brand-name">BILUS FEST</span>
                    <span class="brand-subtitle">E-Ticketing</span>
                </span>
            </a>

            <div class="d-flex align-items-center gap-3 gap-lg-4">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <a class="nav-link-custom {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">Event</a>
                        <a class="nav-link-custom d-none d-md-inline-flex {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}" href="{{ route('admin.tickets.index') }}">Tiket</a>
                        <a class="nav-link-custom d-none d-md-inline-flex {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">Laporan</a>
                    @else
                        <a class="nav-link-custom {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">Dashboard</a>
                        <a class="nav-link-custom {{ request()->routeIs('user.events.*') ? 'active' : '' }}" href="{{ route('user.events.index') }}">Event</a>
                        <a class="nav-link-custom {{ request()->routeIs('user.orders.*') ? 'active' : '' }}" href="{{ route('user.orders.index') }}">Pesanan</a>
                    @endif

                    <form method="POST" action="{{ route('logout', absolute: false) }}" class="mb-0">
                        @csrf
                        <button class="btn btn-light-custom">Logout</button>
                    </form>
                @else
                    <a class="nav-link-custom" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-primary-custom" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="page-shell">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const navbar = document.getElementById('siteNavbar');

function updateNavbarState() {
    if (window.scrollY > 18) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
}

document.querySelectorAll('.delete-form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin hapus data?',
            text: 'Data akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});

updateNavbarState();
window.addEventListener('scroll', updateNavbarState, { passive: true });
</script>

@yield('scripts')
</body>
</html>
