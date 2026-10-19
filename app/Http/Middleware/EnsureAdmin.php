<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Prevent guests and teacher accounts from entering the admin panel.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user === null) {
            return redirect()->route('login');
        }

        if ($user->isAdminAkun()) {
            return $next($request);
        }

        $isGuru = \App\Models\Guru::where('user_id', $user->id)->exists();

        if (!$isGuru) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Panel admin hanya untuk administrator. Akun guru diarahkan ke halaman sesuai role-nya.');
    }
}
