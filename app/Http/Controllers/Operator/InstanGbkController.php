<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\PermohonanSk;
use App\Models\RiwayatGbk;
use App\Services\FileStorageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;

class InstanGbkController extends Controller
{
    protected FileStorageService $fileStorageService;

    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    public function index()
    {
        // Ambil semua pegawai untuk dropdown
        $pegawais = Pegawai::with('user')->get();
        return view('operator.instan-gbk.index', compact('pegawais'));
    }

    public function process(Request $request)
    {
        $pegawai = Pegawai::with(['user', 'golongan'])->findOrFail($request->pegawai_id);
        // Ambil riwayat GBK terakhir jika ada
        $riwayatGbk = $pegawai->riwayatGbks()->latest()->first();

        if ($riwayatGbk && $riwayatGbk->status_sk === 'tidak_lengkap') {
            return redirect()->route('operator.riwayat_gbks.edit', $riwayatGbk->id)->with('warning', 'Riwayat Gaji Berkala terakhir belum lengkap. Silakan lengkapi terlebih dahulu.');
        }
        
        $permohonanSk = PermohonanSk::create([
            'pegawai_id' => $pegawai->id,
            'riwayat_gbk_id' => $riwayatGbk ? $riwayatGbk->id : null,
            'tanggal_pengajuan' => Carbon::now(),
            'status' => 'diproses',
            'diproses_oleh' => Auth::id(),
        ]);

        return redirect()->route('operator.permohonan-sk.process-sk', $permohonanSk->id);
    }
}
