<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'admin' => redirect()
                    ->intended(route('admin.dashboard'))
                    ->with('success', 'Login sukses. Selamat datang, ' . Auth::user()->name . '!'),
                'pegawai' => redirect()
                    ->intended(route('pegawai.dashboard'))
                    ->with('success', 'Login sukses. Selamat datang, ' . Auth::user()->name . '!'),
                'operator' => redirect()
                    ->intended(route('operator.dashboard'))
                    ->with('success', 'Login sukses. Selamat datang, ' . Auth::user()->name . '!'),
                default => redirect()->route('login')->with('error', 'Role tidak dikenali.'),
            };
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email'); // biar email tetap terisi, password kosong
    }

    public function logout(Request $request)
    {
        // Hapus sesi login
        Auth::logout();

        // Hancurkan semua data session
        $request->session()->invalidate();

        // Regenerasi CSRF token
        $request->session()->regenerateToken();

        // Hapus cookie remember me (kalau ada)
        $cookie = Cookie::forget(Auth::getRecallerName());

        return redirect('/login')->withCookie($cookie);
    }
}
