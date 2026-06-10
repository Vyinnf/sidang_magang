<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use App\Models\RiwayatKenaikanPangkat;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatKenaikanPangkatController extends Controller
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
         ['tmt_sk', 'tanggal_sk', 'status_sk', 'created_at'],
         'tmt_sk',
         'desc',
         10
      );
      $statusSk = $this->resolveFilter($request, 'status_sk', ['lengkap', 'tidak_lengkap']);
      $unitKerjaId = Auth::user()->unit_kerja_id;
      $query = RiwayatKenaikanPangkat::with(['pegawai.user', 'golonganLama', 'golonganBaru'])
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

      return view('operator.riwayat-kenaikan-pangkat.index', compact('riwayats', 'tableQuery', 'statusSk'));
   }

   public function show($id)
   {
      $riwayat = RiwayatKenaikanPangkat::with(['pegawai.user', 'golonganLama', 'golonganBaru', 'permohonan'])
         ->findOrFail($id);
      $this->authorizeUnitKerja($riwayat);
      return view('operator.riwayat-kenaikan-pangkat.show', compact('riwayat'));
   }

   public function download($id)
   {
      $riwayat = RiwayatKenaikanPangkat::with('pegawai.user')->findOrFail($id);
      $this->authorizeUnitKerja($riwayat);
      if (!$riwayat->sk_path) {
         return back()->with('error', 'File tidak ditemukan.');
      }
      $uniqueName = 'SK_Kenaikan_Pangkat_' . $riwayat->pegawai->user->name . '_' . uniqid() . '.pdf';
      return $this->fileStorageService->download($riwayat->sk_path, $uniqueName);
   }

   private function authorizeUnitKerja($riwayat)
   {
      if ($riwayat->pegawai->user->unit_kerja_id !== Auth::user()->unit_kerja_id) {
         abort(403, 'Tidak berwenang.');
      }
   }
}
