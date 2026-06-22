<x-guest-layout>
    <div class="auth-shell">
        <div>
            <div class="auth-kicker">
                <span style="width:10px;height:10px;border-radius:999px;background:#F59E0B;display:inline-block;"></span>
                Login akun Bilus Fest
            </div>
            <h1 class="auth-title" style="margin-top:1rem;">Masuk ke akun Bilus Fest.</h1>
            <p class="auth-description" style="margin-top:1rem;">
                Gunakan akun Google pribadi untuk akses cepat, atau tetap pakai email dan password seperti biasa.
            </p>
        </div>

        @if (session('status'))
            <div class="auth-status">{{ session('status') }}</div>
        @endif

        <a href="{{ route('google.redirect') }}" class="auth-google">
            <svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#EA4335" d="M12 10.2v3.95h5.62c-.24 1.48-1.73 4.33-5.62 4.33-3.39 0-6.15-2.81-6.15-6.3S8.61 6 12 6c1.93 0 3.22.82 3.96 1.52l2.69-2.59C16.92 3.36 14.72 2.4 12 2.4 6.48 2.4 2 6.88 2 12.4s4.48 10 10 10c5.73 0 9.52-4.03 9.52-9.71 0-.65-.07-1.14-.16-1.63H12z"/>
                <path fill="#34A853" d="M3.3 7.64l3.2 2.35C7.37 8.16 9.48 6 12 6c1.93 0 3.22.82 3.96 1.52l2.69-2.59C16.92 3.36 14.72 2.4 12 2.4 8.16 2.4 4.84 4.55 3.3 7.64z"/>
                <path fill="#FBBC05" d="M12 22.4c2.63 0 4.87-.87 6.49-2.36l-3-2.46c-.83.56-1.95.95-3.49.95-3.37 0-6.12-2.27-7.14-5.36l-3.28 2.53C4.59 19.97 8.03 22.4 12 22.4z"/>
                <path fill="#4285F4" d="M21.52 12.69c0-.65-.07-1.14-.16-1.63H12v3.95h5.62c-.26 1.54-1.09 2.86-2.42 3.75l3 2.46c1.73-1.6 3.32-4.09 3.32-8.53z"/>
            </svg>
            <span>Masuk dengan Google</span>
        </a>

        <div class="auth-divider">
            <span class="auth-divider-line"></span>
            <span>Atau</span>
            <span class="auth-divider-line"></span>
        </div>

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="auth-field">
                <label for="email" class="auth-label">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="nama@gmail.com"
                    class="auth-input"
                >
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password" class="auth-label">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                    class="auth-input"
                >
                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-row">
                <label for="remember_me" class="auth-check">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">Forgot your password?</a>
                @endif
            </div>

            <div class="auth-footer">
                <p class="auth-note">
                    Belum punya akun?
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
                    @endif
                </p>

                <button type="submit" class="auth-submit">Log in</button>
            </div>
        </form>
    </div>
</x-guest-layout>
