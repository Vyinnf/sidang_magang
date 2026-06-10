<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Golongan;
use App\Models\Pegawai;
use App\Models\RiwayatGbk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatGajiBerkalaController extends Controller
{
    use InteractsWithTableQuery;

    public function index(Request $request)
    {
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['tmt_sk', 'tanggal_sk', 'gaji_pokok_baru', 'status_sk', 'created_at'],
            'tmt_sk',
            'desc',
            10
        );

        $statusSk = $this->resolveFilter($request, 'status_sk', ['lengkap', 'tidak_lengkap']);
        $unitKerjaId = Auth::user()->unit_kerja_id;

        $query = RiwayatGbk::with(['pegawai.user', 'golonganLama', 'golonganBaru'])
            ->whereHas('pegawai.user', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerja_id', $unitKerjaId);
            });

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sk', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', function ($pegawaiQuery) use ($search) {
                        $pegawaiQuery
                            ->where('nip', 'like', "%{$search}%")
                            ->orWhereHas('user', function ($userQuery) use ($search) {
                                $userQuery->where('name', 'like', "%{$search}%");
                            });
                    });
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

        $riwayats = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->paginate($tableQuery['per_page'])
            ->withQueryString();

        return view('operator.riwayat_gbks.index', compact('riwayats', 'tableQuery', 'statusSk'));
    }

    public function show(RiwayatGbk $riwayat_gbk)
    {
        $riwayat_gbk->load(['pegawai.user', 'golonganLama', 'golonganBaru']);
        // Pass ke view sebagai 'riwayat' supaya Blade tetap konsisten
        return view('operator.riwayat_gbks.show', ['riwayat' => $riwayat_gbk]);
    }

    public function edit(RiwayatGbk $riwayat_gbk)
    {
        $riwayat_gbk->load(['pegawai.user', 'golonganLama', 'golonganBaru']);
        $pegawais = Pegawai::with('user')->get();
        return view('operator.riwayat_gbks.edit', [
            'riwayat' => $riwayat_gbk,
            'pegawais' => $pegawais,
            'golongans' => Golongan::all(),
        ]);
    }

    public function update(Request $request, RiwayatGbk $riwayat_gbk)
    {
        $data = $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tmt_sk' => 'required|date',
            'tanggal_sk' => 'required|date',
            'nomor_sk' => 'required|string',
            'pejabat_sk' => 'required|string',
            'golongan_lama_id' => 'required|exists:golongans,id',
            'masa_kerja_golongan_lama_tahun' => 'required|integer',
            'masa_kerja_golongan_lama_bulan' => 'required|integer',
            'gaji_pokok_lama' => 'nullable|numeric',
            'golongan_baru_id' => 'required|exists:golongans,id',
            'masa_kerja_golongan_baru_tahun' => 'required|integer',
            'masa_kerja_golongan_baru_bulan' => 'required|integer',
            'gaji_pokok_baru' => 'required|numeric',
            'status_sk' => 'required|in:lengkap,tidak_lengkap',
        ]);

        $data['gaji_pokok_lama'] = $this->hitungGajiPokok($data['golongan_lama_id'], $data['masa_kerja_golongan_lama_tahun']);
        $data['gaji_pokok_baru'] = $this->hitungGajiPokok($data['golongan_baru_id'], $data['masa_kerja_golongan_baru_tahun']);

        $riwayat_gbk->update($data);

        return redirect()->route('operator.riwayat_gbks.index')->with('success', 'Riwayat gaji berhasil diupdate');
    }

    public function destroy(RiwayatGbk $riwayat_gbk)
    {
        $pegawai = $riwayat_gbk->pegawai;
        $riwayat_gbk->delete();

        $riwayatTerakhir = $pegawai->riwayatGbks()->latest()->first();

        if ($riwayatTerakhir) {
            $tanggalKenaikan = Carbon::parse($riwayatTerakhir->tmt_sk)->addYears(2);
        } else {
            $riwayatTerakhir = $pegawai->skCpnsPppk->tmt;
            $tanggalKenaikan = Carbon::parse($riwayatTerakhir)->addYears(2);
        }
        $pegawai->update([
            'tanggal_kenaikan_gaji_berkala_berikutnya' => $tanggalKenaikan,
        ]);
        return redirect()->route('operator.riwayat_gbks.index')->with('success', 'Riwayat gaji berhasil dihapus');
    }

    private function hitungGajiPokok($golonganId, $masaKerjaTahun)
    {
        $gaji = Gaji::where('golongan_id', $golonganId)
            ->where('masa_kerja', '<=', $masaKerjaTahun)
            ->orderBy('masa_kerja', 'desc')
            ->first();

        return $gaji ? $gaji->gaji_pokok : 0;
    }
}
