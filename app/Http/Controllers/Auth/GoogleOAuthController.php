<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class GoogleOAuthController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        $clientId = config('services.google.client_id');
        $redirectUri = config('services.google.redirect');

        if (! $clientId || ! $redirectUri) {
            return redirect()
                ->route('login')
                ->with('status', 'Login Google belum dikonfigurasi di server.');
        }

        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'access_type' => 'online',
            'prompt' => 'select_account',
            'state' => $state,
        ]);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?'.$query);
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $this->validateState($request);

            $tokens = $this->exchangeCodeForTokens($request->string('code')->toString());
            $googleUser = $this->fetchGoogleUser($tokens['access_token']);

            $user = User::query()
                ->where('google_id', $googleUser['id'])
                ->orWhere('email', $googleUser['email'])
                ->first();

            if (! $user) {
                $user = User::create([
                    'name' => $googleUser['name'] ?? $googleUser['email'],
                    'email' => $googleUser['email'],
                    'google_id' => $googleUser['id'],
                    'google_avatar' => $googleUser['picture'] ?? null,
                    'role' => 'user',
                    'password' => Hash::make(Str::random(64)),
                ]);

                $user->forceFill([
                    'email_verified_at' => now(),
                ])->save();
            } else {
                $user->forceFill([
                    'name' => $googleUser['name'] ?? $user->name,
                    'google_id' => $googleUser['id'],
                    'google_avatar' => $googleUser['picture'] ?? $user->google_avatar,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ])->save();
            }

            Auth::login($user, true);

            $request->session()->forget('google_oauth_state');
            $request->session()->regenerate();

            return $this->redirectToDashboard($user->role, intended: true);
        } catch (Throwable $throwable) {
            report($throwable);

            return redirect()
                ->route('login')
                ->with('status', 'Login Google gagal. Silakan coba lagi.');
        }
    }

    protected function validateState(Request $request): void
    {
        $state = $request->session()->pull('google_oauth_state');

        if (! $state || $state !== $request->string('state')->toString()) {
            throw new Exception('Invalid Google OAuth state.');
        }
    }

    protected function exchangeCodeForTokens(string $code): array
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => config('services.google.redirect'),
            'grant_type' => 'authorization_code',
            'code' => $code,
        ])->throw();

        return $response->json();
    }

    protected function fetchGoogleUser(string $accessToken): array
    {
        return Http::withToken($accessToken)
            ->get('https://www.googleapis.com/oauth2/v2/userinfo')
            ->throw()
            ->json();
    }
}
