<?php

namespace App\Services;

use Illuminate\Http\RedirectResponse;

final class RedirectService
{
    public static function redirectWithSessionFlash(string $route, string $sessionName, array|string $sessionParams): RedirectResponse
    {
        session()->flash($sessionName, $sessionParams);
        return redirect()->route($route);
    }
}
