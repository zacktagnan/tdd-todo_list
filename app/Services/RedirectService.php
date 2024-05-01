<?php

namespace App\Services;

use Illuminate\Http\RedirectResponse;

final class RedirectService
{
    public static function redirectWithSessionFlash(array $routeParams, string $sessionName, array|string $sessionParams): RedirectResponse
    {
        // $route = 'tasks.index';
        session()->flash($sessionName, $sessionParams);
        // return redirect()->route($route);
        if ($routeParams[1] > 1) {
            return redirect()->route($routeParams[0], ['page' => $routeParams[1]]);
        }
        return redirect()->route($routeParams[0]);
    }

    // // Actual OK
    // public static function redirectWithSessionFlash(string $route, string $sessionName, array|string $sessionParams): RedirectResponse
    // {
    //     session()->flash($sessionName, $sessionParams);
    //     return redirect()->route($route);
    // }

    // //NOK
    // public static function redirectWithSessionFlash(string $sessionName, array|string $sessionParams, string $route, string $page): RedirectResponse
    // {
    //     session()->flash($sessionName, $sessionParams);
    //     if ($page > 1) {
    //         return redirect()->route($route, ['page' => $page]);
    //     }
    //     return redirect()->route($route);
    // }
}
