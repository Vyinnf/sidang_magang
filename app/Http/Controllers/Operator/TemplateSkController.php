<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\TemplateSk;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\FileStorageService;

class TemplateSkController extends Controller
{
    protected FileStorageService $fileStorageService; 

    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    public function index()
    {
        $unitKerja = UnitKerja::find(Auth::user()->unit_kerja_id);
        return view('operator.template-sk.index', compact('unitKerja'));
    }

    public function create()
    {
        $unitKerjaId = Auth::user()->unit_kerja_id;
        $existingTemplate = TemplateSk::where('unit_kerja_id', $unitKerjaId)->first();

        // Cek jika template sudah ada, maka tidak perlu membuat lagi
        if ($existingTemplate) {
            return redirect()->route('operator.template-sk.index')->with('error', 'Anda hanya bisa memiliki satu template SK. Silakan edit yang sudah ada.');
        }

        return view('operator.template-sk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'template_file' => 'required|file|mimes:docx,pdf',
        ]);

        $unitKerjaId = Auth::user()->unit_kerja_id;

        // Cek lagi untuk menghindari duplikasi
        if (TemplateSk::where('unit_kerja_id', $unitKerjaId)->exists()) {
            return redirect()->route('operator.template-sk.index')->with('error', 'Template untuk unit kerja Anda sudah ada.');
        }

        $path = $this->fileStorageService->upload($request->file('template_file'), 'template-sk-gbk', Auth::user());

        TemplateSk::create([
            'unit_kerja_id' => $unitKerjaId,
            'nama_template' => $request->nama_template,
            'template_path' => $path,
        ]);

        return redirect()->route('operator.template-sk.index')->with('success', 'Template SK berhasil diunggah.');
    }

    public function edit()
    {
        $unitKerjaId = Auth::user()->unit_kerja_id;
        $template = TemplateSk::where('unit_kerja_id', $unitKerjaId)->firstOrFail();

        return view('operator.template-sk.edit', compact('template'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_template' => 'required|string|max:255',
            'template_file' => 'nullable|file|mimes:docx,pdf',
        ]);

        $unitKerjaId = Auth::user()->unit_kerja_id;
        $template = TemplateSk::where('unit_kerja_id', $unitKerjaId)->firstOrFail();

        $template->nama_template = $request->nama_template;

        if ($request->hasFile('template_file')) {
            if ($template->template_path && Storage::disk('local')->exists($template->template_path)) {
                Storage::disk('local')->delete($template->template_path);
            }
            $path = $this->fileStorageService->upload($request->file('template_file'), 'template-sk-gbk', Auth::user());
            $template->template_path = $path;
        }

        $template->save();

        return redirect()->route('operator.template-sk.index')->with('success', 'Template SK berhasil diperbarui.');
    }

    public function destroy()
    {
        $unitKerjaId = Auth::user()->unit_kerja_id;
        $template = TemplateSk::where('unit_kerja_id', $unitKerjaId)->firstOrFail();

        Storage::disk('local')->delete($template->template_path);
        $template->delete();

        return redirect()->route('operator.template-sk.index')->with('success', 'Template SK berhasil dihapus.');
    }

    public function download(TemplateSk $templateSk)
    {
        if (!$templateSk->template_path) {
            abort(404, 'File SK tidak ditemukan.');
        }

        return $this->fileStorageService->download($templateSk->template_path, 'Template_SK_GBK_' . $templateSk->unitKerja->nama_unit_kerja . '.' . pathinfo($templateSk->template_path, PATHINFO_EXTENSION));
    }
}
