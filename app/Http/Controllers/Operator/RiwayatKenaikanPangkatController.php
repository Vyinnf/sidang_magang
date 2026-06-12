<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use App\Models\RiwayatKenaikanPangkat;
use App\Services\FileStorageService;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Builder;
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
         ['id', 'tmt_sk', 'tanggal_sk', 'status_sk', 'created_at'],
         'tmt_sk',
         'desc',
         10
      );
      $statusSk = $this->resolveFilter($request, 'status_sk', ['lengkap', 'tidak_lengkap']);
      $unitKerjaId = Auth::user()->unit_kerja_id;

      $query = $this->buildRiwayatKenaikanPangkatQuery($unitKerjaId, $tableQuery, $statusSk);

      $riwayats = $query
         ->orderBy($tableQuery['sort'], $tableQuery['dir'])
         ->paginate($tableQuery['per_page'])
         ->withQueryString();

      return view('operator.riwayat-kenaikan-pangkat.index', compact('riwayats', 'tableQuery', 'statusSk'));
   }

   public function export(Request $request)
   {
      if (Auth::user()->role !== 'operator') {
         abort(403, 'Unauthorized action.');
      }

      $unitKerjaId = Auth::user()->unit_kerja_id;

      $tableQuery = $this->resolveTableQuery(
         $request,
         ['id', 'tmt_sk', 'tanggal_sk', 'status_sk', 'created_at'],
         'tmt_sk',
         'desc',
         10
      );

      $statusSk = $this->resolveFilter($request, 'status_sk', ['lengkap', 'tidak_lengkap']);
      $format = $request->query('format', 'excel');

      $query = $this->buildRiwayatKenaikanPangkatQuery($unitKerjaId, $tableQuery, $statusSk);

      $riwayatList = $query
         ->orderBy($tableQuery['sort'], $tableQuery['dir'])
         ->get();

      if ($format === 'pdf') {
         $filename = 'riwayat_kenaikan_pangkat_' . now()->format('YmdHis') . '.pdf';
         $html = view('operator.riwayat-kenaikan-pangkat.export-pdf', ['riwayats' => $riwayatList])->render();

         $dompdf = new Dompdf();
         $dompdf->loadHtml($html);
         $dompdf->setPaper('A4', 'landscape');
         $dompdf->render();

         return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{ $filename}\"",
         ]);
      }

      $filename = 'riwayat_kenaikan_pangkat_' . now()->format('YmdHis') . '.xls';
      $content = view('operator.riwayat-kenaikan-pangkat.export-excel', ['riwayats' => $riwayatList])->render();

      return response($content, 200, [
         'Content-Type' => 'application/vnd.ms-excel',
         'Content-Disposition' => "attachment; filename=\"{ $filename}\"",
      ]);
   }

   private function buildRiwayatKenaikanPangkatQuery(int $unitKerjaId, array $tableQuery, ?string $statusSk): Builder
   {
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

      return $query;
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
