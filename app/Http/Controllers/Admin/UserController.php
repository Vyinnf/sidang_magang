<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use InteractsWithTableQuery;

    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }

        $tableQuery = $this->resolveTableQuery(
            $request,
            ['created_at', 'name', 'email', 'role'],
            'created_at',
            'desc',
            10
        );
        $role = $this->resolveFilter($request, 'role', ['admin', 'operator', 'pegawai']);
        $unitKerjaId = $request->query('unit_kerja_id');

        $query = User::with('unitKerja');

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        if (!empty($unitKerjaId) && ctype_digit((string) $unitKerjaId)) {
            $query->where('unit_kerja_id', (int) $unitKerjaId);
        }

        if (filled($tableQuery['from'])) {
            $query->whereDate('created_at', '>=', $tableQuery['from']);
        }

        if (filled($tableQuery['to'])) {
            $query->whereDate('created_at', '<=', $tableQuery['to']);
        }

        $users = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->paginate($tableQuery['per_page'])
            ->withQueryString();

        $unitKerjas = UnitKerja::orderBy('nama_unit_kerja')->get(['id', 'nama_unit_kerja']);

        return view('admin.users.index', compact('users', 'tableQuery', 'role', 'unitKerjaId', 'unitKerjas'));
    }

    /**
     * Tampilkan form untuk menambah user.
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }

        $unitKerjas = UnitKerja::all();
        $roles = ['admin', 'operator', 'pegawai'];
        return view('admin.users.create', compact('unitKerjas', 'roles'));
    }

    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['admin', 'operator', 'pegawai'])],
            'unit_kerja_id' => 'required|exists:unit_kerjas,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'unit_kerja_id' => $request->unit_kerja_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Tampilkan form untuk mengedit user.
     */
    public function edit(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }

        $unitKerjas = UnitKerja::all();
        $roles = ['admin', 'operator', 'pegawai'];
        return view('admin.users.edit', compact('user', 'unitKerjas', 'roles'));
    }

    /**
     * Perbarui user.
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'operator', 'pegawai'])],
            'unit_kerja_id' => 'required|exists:unit_kerjas,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'unit_kerja_id' => $request->unit_kerja_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Gagal menghapus user. Error: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        $user->load('pegawai.golongan', 'unitKerja');
        return view('admin.users.show', compact('user'));
    }
}
