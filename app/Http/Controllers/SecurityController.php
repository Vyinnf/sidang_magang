<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    public function index($mode = null)
    {
        $user = Auth::user();
        $role = $user->role;
        return view("$role.security", compact('user', 'mode'));
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $role = $user->role;

        $request->validate(
            [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
            ],
        );

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak cocok.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route("$role.security.index", ['mode' => 'ubah-password'])->with('success', 'Password berhasil diperbarui.');
    }

    public function updateEmail(Request $request)
    {
        $user = $request->user();
        $role = $user->role;

        $request->validate(
            [
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'required|string',
            ],
        );

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password yang Anda masukkan salah.');
        }

        $user->email = $request->email;
        $user->save();

        return redirect()->route("$role.security.index", ['mode' => 'ubah-profile'])->with('success', 'Email berhasil diperbarui.');
    }
}
