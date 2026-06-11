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

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
        ]);

        $email = $request->email;
        $token = \Illuminate\Support\Str::random(60);

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => \Illuminate\Support\Facades\Hash::make($token),
                'created_at' => now(),
            ]
        );

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $email]);

        return back()->with([
            'status' => 'Link reset password telah dibuat.',
            'reset_url' => $resetUrl,
            'email' => $email,
        ]);
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'email.exists' => 'Email tidak valid.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ]);

        $record = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !\Illuminate\Support\Facades\Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau telah kadaluarsa.']);
        }

        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $user->save();
        }

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('loginForm')->with('success', 'Password Anda telah berhasil diubah. Silakan login menggunakan password baru.');
    }
}
