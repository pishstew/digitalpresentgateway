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
            'admin'     => redirect()->intended(route('admin.dashboard')),
            'siswa'     => redirect()->intended(route('siswa.dashboard')),

            // walikelas & kakon adalah guru pengajar — dashboard utama tetap guru
            // tombol switch ke dashboard khusus tersedia di sana
            'guru',
            'walikelas',
            'kakon'     => redirect()->intended(route('guru.dashboard')),

            default     => redirect()->route('login'),
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