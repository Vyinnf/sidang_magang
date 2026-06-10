<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Http\Controllers\Controller;
use App\Models\PermohonanKenaikanPangkat;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
      $pegawai = Auth::user()->pegawai;
      $tableQuery = $this->resolveTableQuery(
         $request,
         ['created_at', 'tanggal_pengajuan', 'status'],
         'created_at',
         'desc',
         10
      );
      $status = $this->resolveFilter($request, 'status', ['diajukan', 'diproses', 'disetujui', 'ditolak']);

      $query = PermohonanKenaikanPangkat::where('pegawai_id', $pegawai->id);

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

      $permohonans = $query
         ->orderBy($tableQuery['sort'], $tableQuery['dir'])
         ->paginate($tableQuery['per_page'])
         ->withQueryString();

      return view('pegawai.kenaikan-pangkat.index', compact('permohonans', 'tableQuery', 'status'));
   }

   public function create()
   {
      $pegawai = Auth::user()->pegawai;
      // Cek apakah ada permohonan aktif (status bukan disetujui/ditolak)
      $aktif = PermohonanKenaikanPangkat::where('pegawai_id', $pegawai->id)
         ->whereIn('status', ['diajukan', 'diproses'])
         ->first();
      if ($aktif) {
         return redirect()->route('pegawai.permohonan-kenaikan-pangkat.index')
            ->with('warning', 'Masih ada permohonan kenaikan pangkat yang aktif.');
      }
      return view('pegawai.kenaikan-pangkat.create');
   }

   public function store(Request $request)
   {
      $request->validate([
         'sk_kenaikan_file' => 'required|file|mimes:pdf,doc,docx|max:4096',
         'catatan_pegawai' => 'nullable|string'
      ]);
      $pegawai = Auth::user()->pegawai;
      $path = $this->fileStorageService->upload($request->file('sk_kenaikan_file'), 'sk-kenaikan-pangkat', Auth::user());
      PermohonanKenaikanPangkat::create([
         'pegawai_id' => $pegawai->id,
         'sk_kenaikan_path' => $path,
         'tanggal_pengajuan' => now(),
         'catatan_pegawai' => $request->catatan_pegawai,
         'status' => 'diajukan'
      ]);
      return redirect()->route('pegawai.permohonan-kenaikan-pangkat.index')->with('success', 'Permohonan kenaikan pangkat diajukan.');
   }

   public function show($id)
   {
      $pegawai = Auth::user()->pegawai;
      $permohonan = PermohonanKenaikanPangkat::where('pegawai_id', $pegawai->id)->findOrFail($id);
      return view('pegawai.kenaikan-pangkat.show', compact('permohonan'));
   }

   public function download($id)
   {
      $pegawai = Auth::user()->pegawai;
      $permohonan = PermohonanKenaikanPangkat::where('pegawai_id', $pegawai->id)->findOrFail($id);
      if (!$permohonan->sk_kenaikan_path) {
         return back()->with('error', 'File tidak ditemukan.');
      }
      return $this->fileStorageService->download($permohonan->sk_kenaikan_path, 'SK_Kenaikan_Pangkat_' . $pegawai->nip . '.pdf');
   }
}
