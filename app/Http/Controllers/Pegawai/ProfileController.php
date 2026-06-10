<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected FileStorageService $fileStorage;

    public function __construct(FileStorageService $fileStorage)
    {
        $this->fileStorage = $fileStorage;
    }

    public function index()
    {
        $user = Auth::user();
        return view('pegawai.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('pegawai.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data user
        $user->update([
            'name' => $validated['name'],
        ]);

        // Update data pegawai
        $user->pegawai->update([
            'tempat_lahir' => $validated['tempat_lahir'] ?? $user->pegawai->tempat_lahir,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? $user->pegawai->tanggal_lahir,
        ]);

        // Update foto profil (kalau ada upload baru)
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::disk('local')->exists($user->profile_photo)) {
                Storage::disk('local')->delete($user->profile_photo);
            }

            // Simpan foto baru via service
            $path = $this->fileStorage->upload($request->file('profile_photo'), 'profile', $user);

            $user->update([
                'profile_photo' => $path,
            ]);
        }

        return redirect()->route('pegawai.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function view(User $user)
    {
        if (Auth::user()->id != $user->id) {
            abort(403, 'Akses ditolak');
        }
        if (!$user->profile_photo) {
            abort(404, 'Foto profil tidak tersedia');
        }

        $path = $user->profile_photo;
        return $this->fileStorage->access($path);
    }
}
