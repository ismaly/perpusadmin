<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthPerpus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Optional: Cek apakah pengguna memiliki role tertentu (misalnya 'admin' atau 'petugas')
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->role !== 'petugas') {
            // Redirect jika pengguna tidak memiliki role yang sesuai
            return redirect()->route('login')->with('error', 'Akses ditolak: Anda tidak memiliki hak akses.');
        }

        // Lanjutkan request jika pengguna sudah login dan memiliki role yang sesuai
        return $next($request);
    }
}
