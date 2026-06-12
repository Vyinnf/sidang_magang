<?php

namespace App\Http\Controllers\Pegawai;

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
        $pegawai = Auth::user()->pegawai;
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['tmt_sk', 'tanggal_sk', 'status_sk', 'created_at'],
            'tmt_sk',
            'desc',
            10
        );
        $statusSk = $this->resolveFilter($request, 'status_sk', ['lengkap', 'tidak_lengkap']);

        $query = RiwayatKenaikanPangkat::query()->where('pegawai_id', '=', $pegawai->id, 'and')
            ->with(['golonganLama', 'golonganBaru']);

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sk', 'like', "%{$search}%")
                    ->orWhere('pejabat_sk', 'like', "%{$search}%");
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

        return view('pegawai.riwayat-kenaikan-pangkat.index', compact('riwayats', 'tableQuery', 'statusSk'));
    }

    public function show($id)
    {
        $pegawai = Auth::user()->pegawai;
        $item = RiwayatKenaikanPangkat::query()->where('pegawai_id', '=', $pegawai->id, 'and')
            ->with(['golonganLama', 'golonganBaru'])
            ->findOrFail($id);

        return view('pegawai.riwayat-kenaikan-pangkat.show', compact('item'));
    }

    public function download($id)
    {
        $pegawai = Auth::user()->pegawai;
        $item = RiwayatKenaikanPangkat::query()->where('pegawai_id', '=', $pegawai->id, 'and')->findOrFail($id);
        if (! $item->sk_path) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return $this->fileStorageService->download($item->sk_path, 'Riwayat_Kenaikan_Pangkat_'.$pegawai->nip.'.pdf');
    }

    public function export(Request $request, string $format = 'pdf')
    {
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['tmt_sk', 'tanggal_sk', 'status_sk', 'created_at'],
            'tmt_sk',
            'desc',
            9999
        );

        $statusSk = $this->resolveFilter($request, 'status_sk', ['lengkap', 'tidak_lengkap']);
        $query = $this->buildRiwayatKenaikanPangkatQuery($tableQuery, $statusSk);
        $riwayats = $query->orderBy($tableQuery['sort'], $tableQuery['dir'])->get();

        if ($format === 'excel') {
            $content = view('pegawai.riwayat-kenaikan-pangkat.export-excel', compact('riwayats'))->render();

            return response($content, 200, [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'attachment; filename="riwayat_kenaikan_pangkat_'.now()->format('YmdHis').'.xls"',
            ]);
        }

        $html = view('pegawai.riwayat-kenaikan-pangkat.export-pdf', compact('riwayats'))->render();

        $pdf = new Dompdf;
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="riwayat_kenaikan_pangkat_'.now()->format('YmdHis').'.pdf"',
        ]);
    }

    private function buildRiwayatKenaikanPangkatQuery(array $tableQuery, ?string $statusSk): Builder
    {
        $query = RiwayatKenaikanPangkat::query()->where('pegawai_id', '=', Auth::user()->pegawai->id, 'and')
            ->with(['golonganLama', 'golonganBaru']);

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->where(function ($q) use ($search) {
                $q->where('nomor_sk', 'like', "%{$search}%")
                    ->orWhere('pejabat_sk', 'like', "%{$search}%");
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
}
