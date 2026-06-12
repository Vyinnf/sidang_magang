<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Models\Golongan;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule untuk validasi unique

class GolonganController extends Controller
{
    use InteractsWithTableQuery;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['id', 'created_at', 'golongan', 'pangkat', 'asn'],
            'created_at',
            'desc',
            10
        );
        $asn = $this->resolveFilter($request, 'asn', ['PNS', 'PPPK']);

        $query = $this->buildGolonganQuery($tableQuery, $asn);

        $golongans = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->paginate($tableQuery['per_page'])
            ->withQueryString();

        return view('admin.golongans.index', compact('golongans', 'tableQuery', 'asn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.golongans.create');
    }

    /**
     * Export golongan data to CSV.
     */
    public function export(Request $request)
    {
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['created_at', 'golongan', 'pangkat', 'asn'],
            'created_at',
            'desc',
            10
        );
        $asn = $this->resolveFilter($request, 'asn', ['PNS', 'PPPK']);
        $format = $request->query('format', 'excel');

        $golongans = $this->buildGolonganQuery($tableQuery, $asn)
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->get();

        if ($format === 'pdf') {
            $filename = 'golongans_' . now()->format('YmdHis') . '.pdf';
            $html = view('admin.golongans.export-pdf', compact('golongans'))->render();

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        $filename = 'golongans_' . now()->format('YmdHis') . '.xls';
        $content = view('admin.golongans.export-excel', compact('golongans'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);

    }

    private function buildGolonganQuery(array $tableQuery, ?string $asn): Builder
    {
        $query = Golongan::query();

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->where(function ($q) use ($search) {
                $q->where('golongan', 'like', "%{$search}%")
                    ->orWhere('pangkat', 'like', "%{$search}%");
            });
        }

        if ($asn) {
            $query->where('asn', $asn);
        }

        if (filled($tableQuery['from'])) {
            $query->whereDate('created_at', '>=', $tableQuery['from']);
        }

        if (filled($tableQuery['to'])) {
            $query->whereDate('created_at', '<=', $tableQuery['to']);
        }

        return $query;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'golongan' => 'required|string|unique:golongans,golongan', // Validasi untuk kolom 'golongan'
            'pangkat' => 'nullable|string|max:255', // Validasi untuk 'pangkat'
            'asn' => ['required', Rule::in(['PNS', 'PPPK'])], // Validasi untuk 'asn' (enum)
        ]);

        Golongan::create($request->all());

        return redirect()->route('admin.golongans.index')->with('success', 'Golongan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Golongan $golongan)
    {
        return view('admin.golongans.edit', compact('golongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Golongan $golongan)
    {
        $request->validate([
            'golongan' => [
                'required',
                'string',
                Rule::unique('golongans', 'golongan')->ignore($golongan->id), // Abaikan ID saat update
            ],
            'pangkat' => 'nullable|string|max:255',
            'asn' => ['required', Rule::in(['PNS', 'PPPK'])],
        ]);

        $golongan->update($request->all());

        return redirect()->route('admin.golongans.index')->with('success', 'Golongan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Golongan $golongan)
    {
        try {
            $golongan->delete();
            return redirect()->route('admin.golongans.index')->with('success', 'Golongan berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani jika ada relasi yang menghalangi penghapusan
            return redirect()->route('admin.golongans.index')->with('error', 'Tidak bisa menghapus Golongan ini karena ada data terkait.');
        }
    }
}
