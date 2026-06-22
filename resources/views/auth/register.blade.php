<x-guest-layout>
    <div class="auth-shell">
        <div>
            <div class="auth-kicker">
                <span style="width:10px;height:10px;border-radius:999px;background:#F59E0B;display:inline-block;"></span>
                Daftar akun Bilus Fest
            </div>
            <h1 class="auth-title" style="margin-top:1rem;">Buat akun baru.</h1>
            <p class="auth-description" style="margin-top:1rem;">
                Daftarkan akun untuk membeli tiket, melihat pesanan, dan menyimpan e-ticket dengan lebih mudah.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="auth-field">
                <label for="name" class="auth-label">Name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nama lengkap"
                    class="auth-input"
                >
                @error('name')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field">
                <label for="email" class="auth-label">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
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
                    autocomplete="new-password"
                    placeholder="Buat password"
                    class="auth-input"
                >
                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password_confirmation" class="auth-label">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                    class="auth-input"
                >
                @error('password_confirmation')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-footer">
                <p class="auth-note">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="auth-link">Masuk sekarang</a>
                </p>

                <button type="submit" class="auth-submit">Register</button>
            </div>
        </form>
    </div>
</x-guest-layout>
