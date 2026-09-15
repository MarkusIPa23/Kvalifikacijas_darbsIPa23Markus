<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $this->restoreFavorites($request);

        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function restoreFavorites(Request $request): void
    {
        $sessionFavorites = $request->session()->get('favorite_games', []);
        $user = $request->user();
        $favorites = array_replace($user->favorite_games ?? [], $sessionFavorites);

        if ($favorites !== ($user->favorite_games ?? [])) {
            $user->update(['favorite_games' => $favorites]);
        }

        $request->session()->put('favorite_games', $favorites);
    }
}
