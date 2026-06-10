<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatGbkController extends Controller
{
    use InteractsWithTableQuery;

    public function index(Request $request)
    {
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['tmt_sk', 'tanggal_sk', 'status_sk', 'created_at'],
            'tmt_sk',
            'desc',
            10
        );
        $statusSk = $this->resolveFilter($request, 'status_sk', ['lengkap', 'tidak_lengkap']);

        $query = Auth::user()
            ->pegawai->riwayatGbks()
            ->with(['golonganLama', 'golonganBaru']);

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sk', 'like', "%{$search}%")
                    ->orWhere('pejabat_sk', 'like', "%{$search}%");
            });
        }

        if ($statusSk) {
            $query->where('status_sk', $statusSk);
        }

        if (filled($tableQuery['from'])) {
            $query->whereDate('tmt_sk', '>=', $tableQuery['from']);
        }

        if (filled($tableQuery['to'])) {
            $query->whereDate('tmt_sk', '<=', $tableQuery['to']);
        }

        $riwayatGbks = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->paginate($tableQuery['per_page'])
            ->withQueryString();

        return view('pegawai.riwayat-gbk.index', compact('riwayatGbks', 'tableQuery', 'statusSk'));
    }

    public function show($id)
    {
        $riwayat = Auth::user()
            ->pegawai->riwayatGbks()
            ->with(['golonganLama', 'golonganBaru'])
            ->findOrFail($id);
        return view('pegawai.riwayat-gbk.show', compact('riwayat'));
    }

    public function edit($id)
    {
        $riwayat = Auth::user()
            ->pegawai->riwayatGbks()
            ->findOrFail($id);
        return view('pegawai.riwayat-gbk.edit', compact('riwayat'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'tanggal_sk' => 'required|date',
            'nomor_sk' => 'required|string|max:255',
            'pejabat_sk' => 'required|string|max:255',
        ]);

        $riwayat = Auth::user()
            ->pegawai->riwayatGbks()
            ->findOrFail($id);

        $riwayat->update([
            'tanggal_sk' => $request->tanggal_sk,
            'nomor_sk' => $request->nomor_sk,
            'pejabat_sk' => $request->pejabat_sk,
            'status_sk' => 'lengkap',
        ]);

        return redirect()->route('pegawai.riwayat-gbk.index')
            ->with('success', 'Riwayat Gaji Berkala berhasil diperbarui.');
    }

    public function download($id)
    {
        $riwayat = Auth::user()
            ->pegawai->riwayatGbks()
            ->findOrFail($id);

        if (!$riwayat->sk_path) {
            return redirect()->back()->with('error', 'File SK tidak ditemukan.');
        }

        return app('App\Services\FileStorageService')->download($riwayat->sk_path, 'SK_Gaji_Berkala_' . Auth::user()->pegawai->nip . '_' . now()->format('YmdHis') . '.docx');
    }
}
