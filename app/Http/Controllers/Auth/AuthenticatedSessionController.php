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

        $user = auth()->user();

        // Cek apakah akun aktif
        if (!$user->is_active) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.',
            ]);
        }

        // Arahkan user ke halaman dashboard yang sesuai dengan rolenya masing-masing
        return match($user->role) {
            'admin' => redirect()->intended(route('admin.dashboard')), // Jika role admin, arahkan ke dashboard admin
            'guru'  => redirect()->intended(route('guru.dashboard')), // Jika role guru, arahkan ke dashboard guru
            'siswa' => redirect()->intended(route('siswa.dashboard')), // Jika role siswa, arahkan ke dashboard siswa
            'walikelas' => redirect()->intended(route('walikelas.dashboard')), // Jika role walikelas, arahkan ke dashboard walikelas
            default => redirect()->route('login'), // Jika role tidak dikenali, kembalikan ke halaman login
        };
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
}