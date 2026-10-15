<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Prevent teacher accounts from entering the admin panel.
     *
     * The administrator is the dedicated "admin" account (or any non-teacher
     * account). Teachers linked to a guru record — including Wali Kelas,
     * Kaprog, and Pembimbing PKL — are blocked except for the profile routes,
     * which their own layouts link to.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('admin.profile', 'admin.profile.update')) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user === null || $user->isAdminAkun()) {
            return $next($request);
        }

        $isGuru = \App\Models\Guru::where('user_id', $user->id)->exists();

        if (!$isGuru) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Panel admin hanya untuk administrator. Akun guru diarahkan ke halaman sesuai role-nya.');
    }
}
