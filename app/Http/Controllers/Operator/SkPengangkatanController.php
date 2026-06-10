<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Golongan;
use App\Services\FileStorageService;
use App\Models\SkCpnsPppk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SkPengangkatanController extends Controller
{
    use InteractsWithTableQuery;

    protected FileStorageService $fileStorageService;

    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    public function index(Request $request)
    {
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['created_at', 'tanggal_sk', 'tmt', 'nomor_sk'],
            'created_at',
            'desc',
            10
        );
        $asn = $this->resolveFilter($request, 'asn', ['PNS', 'PPPK']);
        $unitKerjaId = Auth::user()->unit_kerja_id;

        $query = SkCpnsPppk::with(['pegawai.user'])
            ->whereHas('pegawai.user', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerja_id', $unitKerjaId);
            });

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sk', 'like', "%{$search}%")
                    ->orWhere('pejabat_sk', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', function ($pegawaiQuery) use ($search) {
                        $pegawaiQuery
                            ->where('nip', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($userQuery) use ($search) {
                                $userQuery->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        if ($asn) {
            $query->whereHas('pegawai', function ($pegawaiQuery) use ($asn) {
                $pegawaiQuery->where('asn', $asn);
            });
        }

        if (filled($tableQuery['from'])) {
            $query->whereDate('tanggal_sk', '>=', $tableQuery['from']);
        }

        if (filled($tableQuery['to'])) {
            $query->whereDate('tanggal_sk', '<=', $tableQuery['to']);
        }

        $skPengangkatan = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->paginate($tableQuery['per_page'])
            ->withQueryString();

        return view('operator.sk-pengangkatan.index', compact('skPengangkatan', 'tableQuery', 'asn'));
    }

    public function show(SkCpnsPppk $skPengangkatan)
    {
        return view('operator.sk-pengangkatan.show', compact('skPengangkatan'));
    }

    public function edit(SkCpnsPppk $skPengangkatan)
    {
        $golongans = Golongan::all();
        return view('operator.sk-pengangkatan.edit', compact('skPengangkatan', 'golongans'));
    }

    public function update(Request $request, SkCpnsPppk $skPengangkatan)
    {
        $data = $request->validate([
            'nomor_sk' => 'required|string',
            'tanggal_sk' => 'required|date',
            'tmt' => 'required|date',
            'pejabat_sk' => 'required|string',
            'golongan_id' => 'required|exists:golongans,id',
            'tahun_masa_kerja_pra_pengangkatan' => 'nullable|integer|min:0',
            'bulan_masa_kerja_pra_pengangkatan' => 'nullable|integer|min:0|max:11',
            'sk_path' => 'nullable|file|mimes:pdf|max:2048', // Maks 2MB
        ]);

        // Hitung gaji pokok berdasarkan golongan dan masa kerja
        $data['gaji_pokok'] = $this->hitungGajiPokok($data['golongan_id'], $data['tahun_masa_kerja_pra_pengangkatan'] ?? 0);

        // Handle upload file SK jika ada
        if ($request->hasFile('sk_path')) {
            // Hapus file lama jika ada
            if ($skPengangkatan->sk_path && Storage::disk('local')->exists($skPengangkatan->sk_path)) {
                Storage::disk('local')->delete($skPengangkatan->sk_path);
            }

            // Simpan file
            $data['sk_path'] = $this->fileStorageService->upload($request->file('sk_path'), 'sk-pengangkatan', $skPengangkatan->pegawai->user);
        }

        $skPengangkatan->update($data);

        return redirect()->route('operator.sk-pengangkatan.index')->with('success', 'Data SK Pengangkatan berhasil diperbarui.');
    }

    public function download(SkCpnsPppk $skPengangkatan)
    {
        if (!$skPengangkatan->sk_path) {
            abort(404, 'File SK tidak ditemukan.');
        }

        return $this->fileStorageService->download($skPengangkatan->sk_path, 'SK_Pengangkatan_' . $skPengangkatan->pegawai->nip . '.' . pathinfo($skPengangkatan->sk_path, PATHINFO_EXTENSION));
    }

    private function hitungGajiPokok($golonganId, $masaKerjaTahun)
    {
        $gaji = Gaji::where('golongan_id', $golonganId)->where('masa_kerja', '<=', $masaKerjaTahun)->orderBy('masa_kerja', 'desc')->first();

        return $gaji ? $gaji->gaji_pokok : 0;
    }
}
