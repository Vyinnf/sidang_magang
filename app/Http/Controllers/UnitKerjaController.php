<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\InteractsWithTableQuery;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    use InteractsWithTableQuery;

    public function index(Request $request)
    {
        $tableQuery = $this->resolveTableQuery(
            $request,
            ['created_at', 'id', 'nama_unit_kerja'],
            'created_at',
            'desc',
            10
        );

        $query = UnitKerja::query();

        if ($tableQuery['q'] !== '') {
            $search = $tableQuery['q'];
            $query->where('nama_unit_kerja', 'like', "%{$search}%");
        }

        if (filled($tableQuery['from'])) {
            $query->whereDate('created_at', '>=', $tableQuery['from']);
        }

        if (filled($tableQuery['to'])) {
            $query->whereDate('created_at', '<=', $tableQuery['to']);
        }

        $unitKerjas = $query
            ->orderBy($tableQuery['sort'], $tableQuery['dir'])
            ->paginate($tableQuery['per_page'])
            ->withQueryString();

        return view('admin.unit_kerjas.index', compact('unitKerjas', 'tableQuery'));
    }

    public function create()
    {
        return view('admin.unit_kerjas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit_kerja' => 'required|string|max:255|unique:unit_kerjas,nama_unit_kerja',
        ]);

        UnitKerja::create($request->all());

        return redirect()->route('admin.unit-kerjas.index')->with('success', 'Unit Kerja berhasil ditambahkan!');
    }

    public function show(UnitKerja $unitKerja)
    {
        return view('admin.unit_kerjas.show', compact('unitKerja'));
    }

    public function edit(UnitKerja $unitKerja)
    {
        return view('admin.unit_kerjas.edit', compact('unitKerja'));
    }

    public function update(Request $request, UnitKerja $unitKerja)
    {
        $request->validate([
            'nama_unit_kerja' => 'required|string|max:255|unique:unit_kerjas,nama_unit_kerja,' . $unitKerja->id,
        ]);

        $unitKerja->update($request->all());

        return redirect()->route('admin.unit-kerjas.index')->with('success', 'Unit Kerja berhasil diperbarui!');
    }

    public function destroy(UnitKerja $unitKerja)
    {
        try {
            $unitKerja->delete();
            return redirect()->route('admin.unit-kerjas.index')->with('success', 'Unit Kerja berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('admin.unit-kerjas.index')->with('error', 'Tidak bisa menghapus Unit Kerja ini karena ada data terkait.');
        }
    }
}
