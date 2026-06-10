<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PermohonanSk;
use App\Models\User;
use App\Services\AttachmentPdfConverterService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(private AttachmentPdfConverterService $attachmentPdfConverterService) {}

    public function index()
    {
        $user = Auth::user();
        $unitKerjaId = $user->unit_kerja_id;
        $wordConversionHealthMessage = $this->attachmentPdfConverterService->getWordConversionHealthMessage();

        // 1️⃣ Total pegawai di unit kerja operator
        $totalPegawai = Pegawai::whereHas('user', function ($q) use ($unitKerjaId) {
            $q->where('unit_kerja_id', $unitKerjaId);
        })->count();

        // 2️⃣ Ambil 5 permohonan SK terbaru dari pegawai unit kerja operator
        $permohonanSk = PermohonanSk::with('pegawai.user')
            ->whereHas('pegawai.user', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerja_id', $unitKerjaId);
            })
            ->latest()
            ->take(5)
            ->get();

        // 3️⃣ Statistik permohonan SK berdasarkan status
        $permohonanBaru = $permohonanSk->where('status', 'diajukan')->count();
        $permohonanProses = $permohonanSk->where('status', 'diproses')->count();
        $permohonanDisetujui = $permohonanSk->where('status', 'disetujui')->count();
        $permohonanDitolak = $permohonanSk->where('status', 'ditolak')->count();

        // 4️⃣ Ringkasan riwayat gaji terakhir tiap pegawai unit kerja (opsional)
        $pegawaiList = Pegawai::with([
            'riwayatGbks' => function ($q) {
                $q->latest()->take(1); // ambil riwayat terakhir
            },
            'user',
        ])
            ->whereHas('user', function ($q) use ($unitKerjaId) {
                $q->where('unit_kerja_id', $unitKerjaId);
            })
            ->get();

        return view('operator.dashboard', compact('user', 'totalPegawai', 'permohonanSk', 'permohonanBaru', 'permohonanProses', 'permohonanDisetujui', 'permohonanDitolak', 'pegawaiList', 'wordConversionHealthMessage'));
    }
}
