<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

abstract class Controller
{
    protected function dashboardRouteName(?string $role): string
    {
        return $role === 'admin' ? 'admin.dashboard' : 'user.dashboard';
    }

    protected function redirectToDashboard(?string $role, bool $intended = false, string $suffix = ''): RedirectResponse
    {
        $url = route($this->dashboardRouteName($role), absolute: false).$suffix;

        return $intended
            ? redirect()->intended($url)
            : redirect($url);
    }
}
