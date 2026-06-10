<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use App\Models\PermohonanSk;
use App\Models\RiwayatGbk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FileStorageService;
use App\Services\AttachmentPdfConverterService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PermohonanController extends Controller
{
    use InteractsWithTableQuery;

    protected FileStorageService $fileStorageService;
    protected AttachmentPdfConverterService $attachmentPdfConverterService;

    public function __construct(FileStorageService $fileStorageService, AttachmentPdfConverterService $attachmentPdfConverterService)
    {
        $this->fileStorageService = $fileStorageService;
        $this->attachmentPdfConverterService = $attachmentPdfConverterService;
    }

    public function index(Request $request)
    {
        $pegawai = Auth::user()->pegawai;
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['created_at', 'tanggal_pengajuan', 'status'],
            'created_at',
            'desc',
            10
        );
        $status = $this->resolveFilter($request, 'status', ['diajukan', 'diproses', 'disetujui', 'ditolak']);

        $query = PermohonanSk::where('pegawai_id', $pegawai->id);

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->where(function ($q) use ($search) {
                $q->where('catatan_pegawai', 'like', "%{$search}%")
                    ->orWhere('catatan_operator', 'like', "%{$search}%");
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

        $permohonanSks = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->paginate($tableQuery['per_page'])
            ->withQueryString();

        $tanggalKgbBerikutnya = $pegawai->tanggal_kenaikan_gaji_berkala_berikutnya
            ? Carbon::parse($pegawai->tanggal_kenaikan_gaji_berkala_berikutnya)->startOfDay()
            : null;

        $tanggalMulaiPengajuan = $tanggalKgbBerikutnya?->copy()->subMonths(3);
        $hariMenujuPengajuan = null;
        $canAjukanPermohonan = false;
        $infoPengajuan = null;

        if (!$tanggalKgbBerikutnya) {
            $infoPengajuan = 'Tanggal Kenaikan Gaji Berkala berikutnya belum tersedia, jadi pengajuan SK belum dapat dilakukan.';
        } else {
            $hariMenujuPengajuan = now()->startOfDay()->diffInDays($tanggalMulaiPengajuan, false);
            $canAjukanPermohonan = $hariMenujuPengajuan <= 0;

            if ($canAjukanPermohonan) {
                $infoPengajuan = 'Pengajuan SK sudah dapat dilakukan karena sudah masuk periode 3 bulan sebelum KGB berikutnya.';
            } else {
                $infoPengajuan = 'Pengajuan SK bisa dilakukan dalam ' . $hariMenujuPengajuan . ' hari lagi, mulai ' . $tanggalMulaiPengajuan->translatedFormat('d F Y') . '.';
            }
        }

        return view('pegawai.permohonan-sk.index', compact('permohonanSks', 'canAjukanPermohonan', 'hariMenujuPengajuan', 'tanggalKgbBerikutnya', 'tanggalMulaiPengajuan', 'infoPengajuan', 'tableQuery', 'status'));
    }

    public function create()
    {
        $pegawai = Auth::user()->pegawai;
        $pengajuanWindowError = $this->getPengajuanWindowErrorMessage($pegawai->tanggal_kenaikan_gaji_berkala_berikutnya);

        if ($pengajuanWindowError) {
            return redirect()->route('pegawai.permohonan-sk.index')->with('warning', $pengajuanWindowError);
        }

        $riwayatGbkTerbaru = $pegawai->riwayatGbks()->latest()->first();
        $permohonanTerbaru = $pegawai->permohonanSks()->latest()->first();
        $wordConversionHealthMessage = $this->attachmentPdfConverterService->getWordConversionHealthMessage();

        if (!$riwayatGbkTerbaru) {
            if ($permohonanTerbaru && $permohonanTerbaru->status !== 'disetujui' && $permohonanTerbaru->status !== 'ditolak') {
                return redirect()->route('pegawai.permohonan-sk.show', $permohonanTerbaru->id)->with('warning', 'Anda sudah memiliki permohonan SK yang sedang diproses.');
            }
            return view('pegawai.permohonan-sk.create', [
                'warning' => 'Anda belum memiliki riwayat Gaji Berkala. Perhitungan Gaji Berkala didasarkan pada SK Pengangkatan.',
                'wordConversionHealthMessage' => $wordConversionHealthMessage,
            ]);
        } else {
            if ($riwayatGbkTerbaru->status_sk === 'tidak_lengkap') {
                return redirect()->route('pegawai.riwayat-gbk.edit', $riwayatGbkTerbaru->id)->with('error', 'Harap lengkapi data Riwayat Gaji Berkala sebelumnya.');
            }
            if ($permohonanTerbaru && $permohonanTerbaru->status !== 'disetujui') {
                return redirect()->route('pegawai.permohonan-sk.show', $permohonanTerbaru->id)->with('warning', 'Anda sudah memiliki permohonan SK yang sedang diproses.');
            }
            return view('pegawai.permohonan-sk.create', compact('wordConversionHealthMessage'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'catatan_pegawai' => 'nullable|string',
            'dokumen_pendukung' => 'nullable|array|max:10',
            'dokumen_pendukung.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:4096',
        ]);

        $pegawai = Auth::user()->pegawai;
        $pengajuanWindowError = $this->getPengajuanWindowErrorMessage($pegawai->tanggal_kenaikan_gaji_berkala_berikutnya);

        if ($pengajuanWindowError) {
            return redirect()->route('pegawai.permohonan-sk.index')->with('warning', $pengajuanWindowError);
        }

        $dokumenPendukung = [];
        $tempConversionFiles = [];
        $dokumenFiles = $request->file('dokumen_pendukung', []);

        $hasWordDocument = collect($dokumenFiles)
            ->filter()
            ->contains(fn($file) => in_array(strtolower($file->getClientOriginalExtension()), ['doc', 'docx'], true));

        if ($hasWordDocument && !$this->attachmentPdfConverterService->isWordConversionAvailable()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Upload DOC/DOCX belum dapat diproses karena mesin konversi PDF belum aktif di server. Silakan unggah PDF terlebih dahulu atau hubungi operator sistem.');
        }

        try {
            DB::beginTransaction();

            foreach ($dokumenFiles as $file) {
                if (!$file) {
                    continue;
                }

                $conversion = $this->attachmentPdfConverterService->convertToPdf($file);

                $tempConversionFiles = array_merge($tempConversionFiles, $conversion['cleanup_paths']);
                $path = $this->fileStorageService->upload($conversion['file'], 'permohonan-sk-pendukung', Auth::user());
                $dokumenPendukung[] = [
                    'path' => $path,
                    'original_name' => $conversion['display_name'],
                ];
            }

            PermohonanSk::create([
                'pegawai_id' => $pegawai->id,
                'tanggal_pengajuan' => now(),
                'catatan_pegawai' => $request->catatan_pegawai,
                'dokumen_pendukung' => $dokumenPendukung,
                'status' => 'diajukan',
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            foreach ($dokumenPendukung as $dokumen) {
                if (!empty($dokumen['path'])) {
                    $this->fileStorageService->delete($dokumen['path']);
                }
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Dokumen pendukung gagal diunggah. ' . $e->getMessage());
        } finally {
            foreach (array_unique($tempConversionFiles) as $tempFile) {
                if (is_string($tempFile) && file_exists($tempFile)) {
                    @unlink($tempFile);
                }
            }
        }

        return redirect()->route('pegawai.permohonan-sk.index')->with('success', 'Permohonan SK berhasil diajukan!');
    }

    public function show(PermohonanSk $permohonanSk)
    {
        abort_unless($permohonanSk->pegawai_id === Auth::user()->pegawai?->id, 403);

        return view('pegawai.permohonan-sk.show', compact('permohonanSk'));
    }

    public function downloadAttachment(PermohonanSk $permohonanSk, int $attachment)
    {
        abort_unless($permohonanSk->pegawai_id === Auth::user()->pegawai?->id, 403);

        $dokumen = $permohonanSk->dokumen_pendukung[$attachment] ?? null;

        if (!$dokumen || empty($dokumen['path'])) {
            return redirect()->back()->with('error', 'Dokumen pendukung tidak ditemukan.');
        }

        $downloadName = $dokumen['original_name'] ?? ('dokumen_pendukung_' . ($attachment + 1) . '.' . pathinfo($dokumen['path'], PATHINFO_EXTENSION));

        return $this->fileStorageService->download($dokumen['path'], $downloadName);
    }

    public function previewAttachment(PermohonanSk $permohonanSk, int $attachment)
    {
        abort_unless($permohonanSk->pegawai_id === Auth::user()->pegawai?->id, 403);

        $dokumen = $permohonanSk->dokumen_pendukung[$attachment] ?? null;

        if (!$dokumen || empty($dokumen['path'])) {
            return redirect()->back()->with('error', 'Dokumen pendukung tidak ditemukan.');
        }

        return $this->fileStorageService->access($dokumen['path']);
    }

    public function download(RiwayatGbk $riwayatGbk)
    {
        if (!$riwayatGbk->sk_path) {
            return redirect()->back()->with('error', 'File SK tidak ditemukan.');
        }

        return $this->fileStorageService->download($riwayatGbk->sk_path, 'SK_Gaji_Berkala_' . $riwayatGbk->pegawai->nip . '_' . now()->format('YmdHis') . '.docx');
    }

    private function getPengajuanWindowErrorMessage($tanggalKgbBerikutnya): ?string
    {
        if (!$tanggalKgbBerikutnya) {
            return 'Permohonan SK belum dapat diajukan karena tanggal Kenaikan Gaji Berkala berikutnya belum tersedia.';
        }

        $tanggalKgb = Carbon::parse($tanggalKgbBerikutnya)->startOfDay();
        $batasPengajuan = now()->startOfDay()->addMonths(3);

        if ($tanggalKgb->greaterThan($batasPengajuan)) {
            return 'Permohonan SK hanya dapat diajukan jika tanggal Kenaikan Gaji Berkala berikutnya sudah kurang dari atau sama dengan 3 bulan. Tanggal KGB Anda saat ini: ' . $tanggalKgb->translatedFormat('d F Y') . '.';
        }

        return null;
    }
}
