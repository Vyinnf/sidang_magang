<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use App\Models\Golongan;
use App\Models\Pegawai;
use App\Models\PermohonanKenaikanPangkat;
use App\Models\RiwayatKenaikanPangkat;
use App\Services\FileStorageService;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KenaikanPangkatController extends Controller
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

      $query = $this->buildKenaikanPangkatQuery($unitKerjaId, $tableQuery, $status);

      $permohonans = $query
         ->orderBy($tableQuery['sort'], $tableQuery['dir'])
         ->paginate($tableQuery['per_page'])
         ->withQueryString();

      return view('operator.kenaikan-pangkat.index', compact('permohonans', 'tableQuery', 'status'));
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

      $query = $this->buildKenaikanPangkatQuery($unitKerjaId, $tableQuery, $status);

      $permohonanList = $query
         ->orderBy($tableQuery['sort'], $tableQuery['dir'])
         ->get();

      if ($format === 'pdf') {
         $filename = 'daftar_permohonan_kenaikan_pangkat_' . now()->format('YmdHis') . '.pdf';
         $html = view('operator.kenaikan-pangkat.export-pdf', ['permohonans' => $permohonanList])->render();

         $dompdf = new Dompdf();
         $dompdf->loadHtml($html);
         $dompdf->setPaper('A4', 'landscape');
         $dompdf->render();

         return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{ $filename}\"",
         ]);
      }

      $filename = 'daftar_permohonan_kenaikan_pangkat_' . now()->format('YmdHis') . '.xls';
      $content = view('operator.kenaikan-pangkat.export-excel', ['permohonans' => $permohonanList])->render();

      return response($content, 200, [
         'Content-Type' => 'application/vnd.ms-excel',
         'Content-Disposition' => "attachment; filename=\"{ $filename}\"",
      ]);
   }

   private function buildKenaikanPangkatQuery(int $unitKerjaId, array $tableQuery, ?string $status): Builder
   {
      $query = PermohonanKenaikanPangkat::whereHas('pegawai.user', function ($q) use ($unitKerjaId) {
         $q->where('unit_kerja_id', $unitKerjaId);
      })->with(['pegawai.user']);

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
      $permohonan = PermohonanKenaikanPangkat::with('pegawai.user')->findOrFail($id);
      $this->authorizeUnitKerja($permohonan);
      return view('operator.kenaikan-pangkat.show', compact('permohonan'));
   }

   public function process(Request $request, $id)
   {
      $permohonan = PermohonanKenaikanPangkat::findOrFail($id);
      $this->authorizeUnitKerja($permohonan);
      $request->validate(['catatan_operator' => 'nullable|string']);
      $permohonan->update([
         'status' => 'diproses',
         'catatan_operator' => $request->catatan_operator,
         'diproses_oleh' => Auth::id(),
      ]);
      return back()->with('success', 'Permohonan masuk tahap proses.');
   }

   public function approve(Request $request, $id)
   {
      $permohonan = PermohonanKenaikanPangkat::with('pegawai.golongan')->findOrFail($id);
      $this->authorizeUnitKerja($permohonan);
      $data = $request->validate([
         'golongan_baru_id' => 'required|exists:golongans,id',
         'tmt_sk' => 'required|date',
         'nomor_sk' => 'nullable|string',
         'tanggal_sk' => 'nullable|date',
         'pejabat_sk' => 'nullable|string',
         'masa_kerja_golongan_baru_tahun' => 'required|integer|min:0',
         'masa_kerja_golongan_baru_bulan' => 'required|integer|min:0|max:11',
      ]);

      DB::beginTransaction();
      try {
         $pegawai = $permohonan->pegawai;
         $pathFinal = $permohonan->sk_kenaikan_path;
         $riwayat = RiwayatKenaikanPangkat::create([
            'pegawai_id' => $pegawai->id,
            'golongan_lama_id' => $pegawai->golongan_id,
            'golongan_baru_id' => $data['golongan_baru_id'],
            'masa_kerja_golongan_lama_tahun' => 0, // TODO: hitung jika diperlukan
            'masa_kerja_golongan_lama_bulan' => 0,
            'masa_kerja_golongan_baru_tahun' => $data['masa_kerja_golongan_baru_tahun'],
            'masa_kerja_golongan_baru_bulan' => $data['masa_kerja_golongan_baru_bulan'],
            'tmt_sk' => $data['tmt_sk'],
            'nomor_sk' => $data['nomor_sk'],
            'tanggal_sk' => $data['tanggal_sk'],
            'pejabat_sk' => $data['pejabat_sk'],
            'sk_path' => $pathFinal,
            'status_sk' => 'lengkap',
            'permohonan_kenaikan_pangkat_id' => $permohonan->id,
         ]);

         // Update golongan pegawai
         $pegawai->update([
            'golongan_id' => $data['golongan_baru_id']
         ]);

         $permohonan->update([
            'status' => 'disetujui',
            'diproses_oleh' => Auth::id(),
            'tanggal_disetujui' => now(),
         ]);

         DB::commit();
      } catch (\Exception $e) {
         DB::rollBack();
         return back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
      }

      return redirect()->route('operator.kenaikan-pangkat.index')->with('success', 'Permohonan disetujui.');
   }

   public function reject(Request $request, $id)
   {
      $permohonan = PermohonanKenaikanPangkat::findOrFail($id);
      $this->authorizeUnitKerja($permohonan);
      $request->validate(['catatan_operator' => 'nullable|string']);
      $permohonan->update([
         'status' => 'ditolak',
         'catatan_operator' => $request->catatan_operator,
         'diproses_oleh' => Auth::id(),
         'tanggal_ditolak' => now(),
      ]);
      return redirect()->route('operator.kenaikan-pangkat.index')->with('success', 'Permohonan ditolak.');
   }

   public function download($id)
   {
      $permohonan = PermohonanKenaikanPangkat::with('pegawai.user')->findOrFail($id);
      $this->authorizeUnitKerja($permohonan);
      if (!$permohonan->sk_kenaikan_path) {
         return back()->with('error', 'File tidak ditemukan.');
      }
      return $this->fileStorageService->download($permohonan->sk_kenaikan_path, 'Pengajuan_Kenaikan_Pangkat_' . $permohonan->pegawai->user->name . '.pdf');
   }

   private function authorizeUnitKerja($permohonan)
   {
      if ($permohonan->pegawai->user->unit_kerja_id !== Auth::user()->unit_kerja_id) {
         abort(403, 'Tidak berwenang.');
      }
   }
}
