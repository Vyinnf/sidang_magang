<?php
// app/Http/Controllers/GajiController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Models\Gaji;
use App\Models\Golongan; // Import model Golongan
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule untuk validasi unique

class GajiController extends Controller
{
    use InteractsWithTableQuery;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['id', 'created_at', 'golongan_id', 'masa_kerja', 'asn', 'gaji_pokok'],
            'created_at',
            'desc',
            10
        );
        $asn = $this->resolveFilter($request, 'asn', ['PNS', 'PPPK']);
        $golonganId = $request->query('golongan_id');
        $masaKerjaMin = $request->query('masa_kerja_min');
        $masaKerjaMax = $request->query('masa_kerja_max');

        $query = $this->buildGajiQuery($tableQuery, $asn, $golonganId, $masaKerjaMin, $masaKerjaMax);

        $gajis = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->paginate($tableQuery['per_page'])
            ->withQueryString();

        $golongans = Golongan::orderBy('golongan')->get(['id', 'golongan', 'pangkat']);

        return view('admin.gajis.index', compact('gajis', 'tableQuery', 'asn', 'golonganId', 'masaKerjaMin', 'masaKerjaMax', 'golongans'));
    }

    /**
     * Export gaji pokok data to Excel or PDF.
     */
    public function export(Request $request)
    {
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['created_at', 'golongan_id', 'masa_kerja', 'asn', 'gaji_pokok'],
            'created_at',
            'desc',
            10
        );
        $asn = $this->resolveFilter($request, 'asn', ['PNS', 'PPPK']);
        $golonganId = $request->query('golongan_id');
        $masaKerjaMin = $request->query('masa_kerja_min');
        $masaKerjaMax = $request->query('masa_kerja_max');
        $format = $request->query('format', 'excel');

        $gajis = $this->buildGajiQuery($tableQuery, $asn, $golonganId, $masaKerjaMin, $masaKerjaMax)
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->get();

        if ($format === 'pdf') {
            $filename = 'gaji_pokok_' . now()->format('YmdHis') . '.pdf';
            $html = view('admin.gajis.export-pdf', compact('gajis'))->render();

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        $filename = 'gaji_pokok_' . now()->format('YmdHis') . '.xls';
        $content = view('admin.gajis.export-excel', compact('gajis'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    private function buildGajiQuery(array $tableQuery, ?string $asn, ?string $golonganId, ?string $masaKerjaMin, ?string $masaKerjaMax): Builder
    {
        $query = Gaji::with('golongan');

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->whereHas('golongan', function ($golonganQuery) use ($search) {
                $golonganQuery
                    ->where('golongan', 'like', "%{$search}%")
                    ->orWhere('pangkat', 'like', "%{$search}%");
            });
        }

        if ($asn) {
            $query->where('asn', $asn);
        }

        if (!empty($golonganId) && ctype_digit((string) $golonganId)) {
            $query->where('golongan_id', (int) $golonganId);
        }

        if ($masaKerjaMin !== null && $masaKerjaMin !== '' && is_numeric($masaKerjaMin)) {
            $query->where('masa_kerja', '>=', (int) $masaKerjaMin);
        }

        if ($masaKerjaMax !== null && $masaKerjaMax !== '' && is_numeric($masaKerjaMax)) {
            $query->where('masa_kerja', '<=', (int) $masaKerjaMax);
        }

        return $query;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua golongan untuk dropdown
        $golongans = Golongan::all();
        return view('admin.gajis.create', compact('golongans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'golongan_id' => 'required|exists:golongans,id',
            'masa_kerja' => 'required|integer|min:0|max:32', // Masa kerja biasanya sampai 32 tahun
            'asn' => ['required', Rule::in(['PNS', 'PPPK'])],
            'gaji_pokok' => 'required|numeric|min:0',
            // Validasi unik untuk kombinasi golongan_id, masa_kerja, dan asn
            Rule::unique('gajis')->where(function ($query) use ($request) {
                return $query->where('golongan_id', $request->golongan_id)->where('masa_kerja', $request->masa_kerja)->where('asn', $request->asn);
            }),
        ]);

        Gaji::create($request->all());

        return redirect()->route('admin.gajis.index')->with('success', 'Data Gaji Pokok berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gaji $gaji)
    {
        // Ambil semua golongan untuk dropdown
        $golongans = Golongan::all();
        return view('admin.gajis.edit', compact('gaji', 'golongans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gaji $gaji)
    {
        $request->validate([
            'golongan_id' => 'required|exists:golongans,id',
            'masa_kerja' => 'required|integer|min:0|max:32',
            'asn' => ['required', Rule::in(['PNS', 'PPPK'])],
            'gaji_pokok' => 'required|numeric|min:0',
            // Validasi unik, abaikan record yang sedang diedit
            Rule::unique('gajis')
                ->where(function ($query) use ($request) {
                    return $query->where('golongan_id', $request->golongan_id)->where('masa_kerja', $request->masa_kerja)->where('asn', $request->asn);
                })
                ->ignore($gaji->id),
        ]);

        $gaji->update($request->all());

        return redirect()->route('admin.gajis.index')->with('success', 'Data Gaji Pokok berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gaji $gaji)
    {
        try {
            $gaji->delete();
            return redirect()->route('admin.gajis.index')->with('success', 'Data Gaji Pokok berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.gajis.index')->with('error', 'Tidak bisa menghapus Data Gaji Pokok ini karena ada data terkait.');
        }
    }
}
