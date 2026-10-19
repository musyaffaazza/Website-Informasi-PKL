<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $requiredRole): Response
    {
        $user = Auth::user();
        $guru = $user?->guru;
        $username = strtolower((string) ($user?->username ?? ''));
        $roles = (array) ($guru?->roles_list ?? []);

        $allowed = match (strtolower($requiredRole)) {
            'kaprog' => str_contains($username, 'kaprog')
                || ($guru && $guru->jurusanKaprog()->exists())
                || in_array('Kaprog', $roles, true),
            'wali-kelas' => str_contains($username, 'walikelas')
                || str_contains($username, 'wali')
                || ($guru && $guru->rombelWali()->exists())
                || in_array('Wali Kelas', $roles, true),
            default => false,
        };

        if (!$allowed) {
            abort(403, 'Akses ditolak. Halaman ini hanya dapat diakses oleh role yang sesuai.');
        }

        return $next($request);
    }
}