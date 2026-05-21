<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: CheckRole
 *
 * Cara pakai di route:
 *   ->middleware('role:admin')
 *   ->middleware('role:guru')
 *   ->middleware('role:kakon')
 *   dll.
 *
 * Kolom yang dibaca: users.role  (string)
 * Role yang tersedia: admin | guru | siswa | walikelas | kakon
 */
class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Belum login → redirect ke halaman login
        if (! $user) {
            return redirect()->route('login');
        }

        // Role tidak cocok → tolak akses
        if (! in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}