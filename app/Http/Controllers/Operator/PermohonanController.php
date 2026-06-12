<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\PermohonanSk;
use App\Models\RiwayatGbk;
use App\Notifications\StatusPermohonanDiupdate;
use App\Services\FileStorageService;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;

class PermohonanController extends Controller
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
            ['id', 'created_at', 'tanggal_pengajuan', 'status'],
            'created_at',
            'desc',
            10
        );

        $status = $this->resolveFilter($request, 'status', ['diajukan', 'diproses', 'disetujui', 'ditolak']);
        $unitKerjaId = Auth::user()->unit_kerja_id;

        $query = $this->buildPermohonanQuery($unitKerjaId, $tableQuery, $status);

        $permohonanSk = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->paginate($tableQuery['per_page'])
            ->withQueryString();

        return view('operator.permohonan-sk.index', compact('permohonanSk', 'tableQuery', 'status'));
    }

    public function export(Request $request)
    {
        if (Auth::user()->role !== 'operator') {
            abort(403, 'Unauthorized action.');
        }

        $unitKerjaId = Auth::user()->unit_kerja_id;

        $tableQuery = $this->resolveTableQuery(
            $request,
            ['id', 'created_at', 'tanggal_pengajuan', 'status'],
            'created_at',
            'desc',
            10
        );

        $status = $this->resolveFilter($request, 'status', ['diajukan', 'diproses', 'disetujui', 'ditolak']);
        $format = $request->query('format', 'excel');

        $query = $this->buildPermohonanQuery($unitKerjaId, $tableQuery, $status);

        $permohonanList = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->get();

        if ($format === 'pdf') {
            $filename = 'daftar_permohonan_sk_' . now()->format('YmdHis') . '.pdf';
            $html = view('operator.permohonan-sk.export-pdf', ['permohonanSk' => $permohonanList])->render();

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{ $filename}\"",
            ]);
        }

        $filename = 'daftar_permohonan_sk_' . now()->format('YmdHis') . '.xls';
        $content = view('operator.permohonan-sk.export-excel', ['permohonanSk' => $permohonanList])->render();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{ $filename}\"",
        ]);
    }

    private function buildPermohonanQuery(int $unitKerjaId, array $tableQuery, ?string $status): Builder
    {
        $query = PermohonanSk::with(['pegawai.user'])
            ->whereHas('pegawai.user', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerja_id', $unitKerjaId);
            });

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->whereHas('pegawai', function ($pegawaiQuery) use ($search) {
                $pegawaiQuery
                    ->where('nip', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if (filled($tableQuery['from'])) {
            $query->whereDate('tanggal_pengajuan', '>=', $tableQuery['from']);
        }

        if (filled($tableQuery['to'])) {
            $query->whereDate('tanggal_pengajuan', '<=', $tableQuery['to']);
        }

        return $query;
    }

    public function show($id)
    {
        $permohonanSk = PermohonanSk::findOrFail($id);
        $riwayatGbk = $permohonanSk->pegawai->riwayatGbks()->latest()->first();
        return view('operator.permohonan-sk.show', compact('permohonanSk', 'riwayatGbk'));
    }

    public function downloadAttachment(PermohonanSk $permohonanSk, int $attachment)
    {
        $dokumen = $permohonanSk->dokumen_pendukung[$attachment] ?? null;

        if (!$dokumen || empty($dokumen['path'])) {
            return redirect()->back()->with('error', 'Dokumen pendukung tidak ditemukan.');
        }

        $downloadName = $dokumen['original_name'] ?? ('dokumen_pendukung_' . ($attachment + 1) . '.' . pathinfo($dokumen['path'], PATHINFO_EXTENSION));

        return $this->fileStorageService->download($dokumen['path'], $downloadName);
    }

    public function previewAttachment(PermohonanSk $permohonanSk, int $attachment)
    {
        $dokumen = $permohonanSk->dokumen_pendukung[$attachment] ?? null;

        if (!$dokumen || empty($dokumen['path'])) {
            return redirect()->back()->with('error', 'Dokumen pendukung tidak ditemukan.');
        }

        return $this->fileStorageService->access($dokumen['path']);
    }

    public function process(Request $request, $id)
    {
        // Mencari permohonan SK berdasarkan ID
        $permohonanSk = PermohonanSk::findOrFail($id);
        $action = $request->input('action'); // Mendapatkan nilai dari tombol submit

        try {
            DB::beginTransaction();

            $permohonanSk->catatan_operator = $request->input('catatan_operator');
            $permohonanSk->diproses_oleh = Auth::id();

            if ($action === 'process') {
                $permohonanSk->status = 'diproses';
                $pesan = "Permohonan Diproses.";
            } elseif ($action === 'reject') {
                $permohonanSk->status = 'ditolak';
                $pesan = "Permohonan SK Berhasil Ditolak.";
                $permohonanSk->tanggal_ditolak = now();
            }

            $permohonanSk->save();

            DB::commit();

            // Notifikasi ke pegawai tentang perubahan status
            $pegawaiUser = $permohonanSk->pegawai?->user;
            if ($pegawaiUser) {
                $pegawaiUser->notify(new StatusPermohonanDiupdate($permohonanSk));
            }

            if ($action === 'reject') {
                return redirect()->route('operator.permohonan-sk.index')->with('success', $pesan);
            } else if ($action === 'process') {
                return redirect()->route('operator.permohonan-sk.process-sk', $permohonanSk->id)->with('success', $pesan);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Mencari permohonan SK berdasarkan ID
        $permohonanSk = PermohonanSk::findOrFail($id);

        try {
            DB::beginTransaction();

            $permohonanSk->delete();

            DB::commit();

            return redirect()->route('operator.permohonan-sk.index')->with('success', 'Permohonan SK berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function processSk($id, Request $request)
    {
        $permohonanSk = PermohonanSk::findOrFail($id);
        $pegawai = $permohonanSk->pegawai;
        $riwayatGbk = $pegawai->riwayatGbks()->latest()->first();

        $overrideTahun = null;
        $overrideBulan = null;
        if ($request->has('hitungUlang')) {
            // Validasi sederhana (akan diperketat di langkah selanjutnya)
            $request->validate([
                'mkg_baru_tahun' => 'required|integer|min:0|max:50',
                'mkg_baru_bulan' => 'required|integer|min:0|max:11',
            ]);
            $overrideTahun = (int)$request->mkg_baru_tahun;
            $overrideBulan = (int)$request->mkg_baru_bulan;
        }

        try {
            $data = $this->kalkulasi($pegawai, $riwayatGbk, $overrideTahun, $overrideBulan);
        } catch (\RuntimeException $e) {
            return redirect()->route('operator.permohonan-sk.index')->with('error', $e->getMessage());
        }

        $SkPengangkatan = $riwayatGbk ? null : $pegawai->skCpnsPppk;

        return view('operator.permohonan-sk.proses-sk', compact('pegawai', 'riwayatGbk', 'SkPengangkatan', 'data', 'permohonanSk'));
    }

    private function kalkulasi(Pegawai $pegawai, ?RiwayatGbk $riwayat, ?int $overrideTahun = null, ?int $overrideBulan = null): array
    {
        if ($riwayat) {
            $mkgLamaTahun = $riwayat->masa_kerja_golongan_baru_tahun;
            $mkgLamaBulan = $riwayat->masa_kerja_golongan_baru_bulan;
            $tmtBasis = Carbon::parse($riwayat->tmt_sk);
        } else {
            $sk = $pegawai->skCpnsPppk;
            if (!$sk) {
                throw new \RuntimeException('Data SK Pengangkatan belum tersedia untuk pegawai ini.');
            }
            $mkgLamaTahun = $sk->tahun_masa_kerja_pra_pengangkatan;
            $mkgLamaBulan = $sk->bulan_masa_kerja_pra_pengangkatan;
            $tmtBasis = Carbon::parse($sk->tmt);
        }

        $mkgBaruTahun = $overrideTahun !== null ? $overrideTahun : ($mkgLamaTahun + 2);
        $mkgBaruBulan = $overrideBulan !== null ? $overrideBulan : $mkgLamaBulan;

        // Hitung gaji baru berdasar MKG baru
        $gajiBaru = $this->hitungGajiPokok($pegawai->golongan_id, $mkgBaruTahun);

        return [
            'mkg_lama_tahun' => $mkgLamaTahun,
            'mkg_lama_bulan' => $mkgLamaBulan,
            'masa_kerja_tahun_golongan_baru' => $mkgBaruTahun,
            'masa_kerja_bulan_golongan_baru' => $mkgBaruBulan,
            'gaji_pokok_baru' => $gajiBaru,
            'tmt_baru' => $tmtBasis->copy()->addYears(2)->translatedFormat('j F Y'),
            'tmt_baru_raw' => $tmtBasis->copy()->addYears(2)->format('Y-m-d'),
        ];
    }

    private function hitungGajiPokok($golonganId, $masaKerjaTahun)
    {
        $gaji = Gaji::where('golongan_id', $golonganId)->where('masa_kerja', '<=', $masaKerjaTahun)->orderBy('masa_kerja', 'desc')->first();

        return $gaji ? $gaji->gaji_pokok : 0;
    }

    private function simpanRiwayatGajiBerkala(Pegawai $pegawai, $data)
    {
        $riwayatGbk = $pegawai->riwayatGbks()->create([
            'tmt_sk' => Carbon::parse($data['tmt_baru']),
            'tmt_sk_lama' => Carbon::parse($data['tmt_lama']),
            'tanggal_sk_lama' => Carbon::parse($data['tanggal_sk_lama']),
            'nomor_sk_lama' => $data['nomor_sk_lama'],
            'pejabat_sk_lama' => $data['pejabat_sk_lama'],
            // Data golongan lama
            'golongan_lama_id' => $data['golongan_lama_id'] ?? $pegawai->riwayatGbks()->latest()->first()?->golongan_baru_id,
            'masa_kerja_golongan_lama_tahun' => $data['mkg_lama_tahun'] ?? 0,
            'masa_kerja_golongan_lama_bulan' => $data['mkg_lama_bulan'] ?? 0,
            'gaji_pokok_lama' => $this->hitungGajiPokok($pegawai->golongan_id, $data['mkg_lama_tahun'] ?? 0),
            // Data golongan baru
            'golongan_baru_id' => $data['golongan_baru_id'] ?? $pegawai->golongan_id,
            'masa_kerja_golongan_baru_tahun' => $data['mkg_baru_tahun'] ?? 0,
            'masa_kerja_golongan_baru_bulan' => $data['mkg_baru_bulan'] ?? 0,
            'gaji_pokok_baru' => $this->hitungGajiPokok($pegawai->golongan_id, $data['mkg_baru_tahun'] ?? 0),
            'status_sk' => 'tidak_lengkap',
            'sk_path' => $data['sk_path'],
        ]);

        return $riwayatGbk;
    }

    private function ubahStatusPermohonanSk(PermohonanSk $permohonanSk, $riwayatGbk)
    {
        $permohonanSk->status = 'disetujui';
        $permohonanSk->tanggal_disetujui = Carbon::now();
        $permohonanSk->riwayat_gbk_id = $riwayatGbk ? $riwayatGbk->id : null;
        $permohonanSk->save();
    }

    public function printSk(Request $request)
    {
        $pegawai = Pegawai::findOrFail($request->pegawai_id);

        $templateSkPath = Auth::user()->unitKerja->templateSk->template_path ?? null;

        if (!$templateSkPath) {
            return redirect()->back()->with('error', 'Template SK untuk unit kerja Anda belum diunggah.');
        }

        $templateProcessor = new TemplateProcessor(storage_path('app/private/' . $templateSkPath));

        $tanggalSkLama = Carbon::parse($request->tanggal_sk_lama)->translatedFormat('d F Y');
        $tmtLama = Carbon::parse($request->tmt_lama)->translatedFormat('d F Y');
        $tmtBaru = Carbon::parse($request->tmt_baru)->translatedFormat('d F Y');

        // Recompute kalkulasi server-side agar tidak percaya input dimanipulasi.
        $riwayatTerakhir = $pegawai->riwayatGbks()->latest()->first();
        // Nilai override MKG baru jika (opsional) disertakan, divalidasi ringan.
        $overrideTahun = $request->filled('mkg_baru_tahun') ? (int)$request->mkg_baru_tahun : null;
        $overrideBulan = $request->filled('mkg_baru_bulan') ? (int)$request->mkg_baru_bulan : null;
        if ($overrideTahun !== null && ($overrideTahun < 0 || $overrideTahun > 50)) {
            $overrideTahun = null;
        }
        if ($overrideBulan !== null && ($overrideBulan < 0 || $overrideBulan > 11)) {
            $overrideBulan = null;
        }

        try {
            $kalkulasi = $this->kalkulasi($pegawai, $riwayatTerakhir, $overrideTahun, $overrideBulan);
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Hitung gaji pokok lama secara konsisten berdasarkan basis (riwayat / SK pengangkatan)
        if ($riwayatTerakhir) {
            $gajiLama = $riwayatTerakhir->gaji_pokok_baru;
            $mkgLamaTahun = $riwayatTerakhir->masa_kerja_golongan_baru_tahun;
            $mkgLamaBulan = $riwayatTerakhir->masa_kerja_golongan_baru_bulan;
        } else {
            $sk = $pegawai->skCpnsPppk;
            if (!$sk) {
                return redirect()->back()->with('error', 'Data SK Pengangkatan belum tersedia.');
            }
            $gajiLama = $this->hitungGajiPokok($pegawai->golongan_id, $sk->tahun_masa_kerja_pra_pengangkatan);
            $mkgLamaTahun = $sk->tahun_masa_kerja_pra_pengangkatan;
            $mkgLamaBulan = $sk->bulan_masa_kerja_pra_pengangkatan;
        }

        $templateProcessor->setValues([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nip' => $request->nip,
            'pangkat' => $request->pangkat,
            'golongan' => $request->golongan,
            'jabatan' => $request->jabatan,
            'unit_kerja' => $request->unit_kerja,
            'nomor_sk_lama' => $request->nomor_sk_lama,
            'tanggal_sk_lama' => $tanggalSkLama,
            'tmt_lama' => $tmtLama,
            'pejabat_sk_lama' => $request->pejabat_sk_lama,
            'gaji_lama' => number_format($gajiLama, 0, ',', '.'),
            'gaji_baru' => number_format($kalkulasi['gaji_pokok_baru'], 0, ',', '.'),
            'mkg_lama_tahun' => $mkgLamaTahun,
            'mkg_lama_bulan' => $mkgLamaBulan,
            'mkg_baru_tahun' => $kalkulasi['masa_kerja_tahun_golongan_baru'],
            'mkg_baru_bulan' => $kalkulasi['masa_kerja_bulan_golongan_baru'],
            'tmt_baru' => $tmtBaru,
        ]);

        // Simpan SK lewat FileStorageService
        $fileName = 'SK_Gaji_Berkala_' . $request->nip . '_' . now()->format('YmdHis') . '.docx';

        $tempFileTmp = tempnam(sys_get_temp_dir(), 'sk_');
        $tempFile = $tempFileTmp . '.docx';
        rename($tempFileTmp, $tempFile);
        $templateProcessor->saveAs($tempFile);

        $skPath = $this->fileStorageService->upload(new \Illuminate\Http\File($tempFile), 'sk-gbk', $pegawai->user);

        unlink($tempFile); // hapus file sementara

        $data = $request->all();
        $data['sk_path'] = $skPath;

        $riwayatGbkTerbaru = $this->simpanRiwayatGajiBerkala($pegawai, $data);
        $pegawai->update(['tanggal_kenaikan_gaji_berkala_berikutnya' => Carbon::parse($riwayatGbkTerbaru->tmt_sk)->addYears(2)]);
        $permohonanDisetujui = $pegawai->permohonanSks()->latest()->first();
        $this->ubahStatusPermohonanSk($permohonanDisetujui, $riwayatGbkTerbaru);

        // Notifikasi ke pegawai bahwa permohonan SK-nya telah disetujui
        $pegawaiUser = $pegawai->user;
        if ($pegawaiUser && $permohonanDisetujui) {
            $pegawaiUser->notify(new StatusPermohonanDiupdate($permohonanDisetujui));
        }

        return redirect()->route('operator.permohonan-sk.index')->with('success', 'SK Gaji Berkala berhasil dibuat dan disimpan di sistem.');
    }

    public function download(RiwayatGbk $riwayatGbk)
    {
        if (!$riwayatGbk->sk_path) {
            return redirect()->back()->with('error', 'File SK tidak ditemukan.');
        }

        return $this->fileStorageService->download($riwayatGbk->sk_path, 'SK_Gaji_Berkala_' . $riwayatGbk->pegawai->nip . '_' . now()->format('YmdHis') . '.docx');
    }
}
