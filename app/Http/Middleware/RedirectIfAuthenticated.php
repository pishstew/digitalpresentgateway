<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
   public function handle(Request $request, Closure $next, string ...$guards): Response
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            // Jika user yang sudah login mencoba mengakses form login/register, langsung arahkan ke dashboard sesuai role-nya
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'), // Arahkan admin ke dashboard admin
                'guru', 'walikelas', 'kakon'  => redirect()->route('guru.dashboard'), // Arahkan guru ke dashboard guru
                'siswa' => redirect()->route('siswa.dashboard'), // Arahkan siswa ke dashboard siswa
                default => redirect('/'), // Default kembalikan ke halaman utama jika rolenya tidak valid
            };
        }
    }

    return $next($request);
}
}
