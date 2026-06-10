@extends('layouts.app')

@section('title', 'Manajemen Template SK')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Manajemen Template SK</h2>
                                <small class="text-muted">Kelola template surat keputusan untuk unit kerja Anda</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="ti ti-file-invoice me-2"></i>Template SK Unit Kerja
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            @if ($unitKerja && $unitKerja->templateSk)
                                <!-- Jika template sudah ada -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="text-muted small">Nama Template</label>
                                        <p class="fw-semibold mb-0">{{ $unitKerja->templateSk->nama_template }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small">Unit Kerja</label>
                                        <p class="fw-semibold mb-0">{{ $unitKerja->nama_unit_kerja }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-muted small">Path File</label>
                                        <p class="fw-semibold mb-0 text-break">{{ $unitKerja->templateSk->template_path }}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start align-items-center">
                                    @if ($unitKerja->templateSk->template_path)
                                        <a href="{{ route('operator.template-sk.download', $unitKerja->templateSk->id) }}"
                                            class="btn btn-sm btn-success me-2" title="Unduh Template">
                                            <i class="ti ti-download"></i><span class="d-none d-sm-inline ms-1">Unduh Template</span>
                                        </a>
                                    @endif
                                    <a href="{{ route('operator.template-sk.edit') }}" class="btn btn-sm btn-primary me-2" title="Ubah Template">
                                        <i class="ti ti-edit"></i><span class="d-none d-sm-inline ms-1">Ubah Template</span>
                                    </a>
                                    <form action="{{ route('operator.template-sk.destroy') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="ti ti-trash"></i><span class="d-none d-sm-inline ms-1">Hapus Template</span>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <!-- Jika template belum ada -->
                                <div class="alert alert-info border-0 shadow-sm text-center" role="alert">
                                    <p class="mb-2">Saat ini belum ada template SK yang diunggah untuk unit kerja Anda.
                                    </p>
                                    <a href="{{ route('operator.template-sk.create') }}" class="btn btn-primary">
                                        <i class="ti ti-upload"></i> Unggah Template Baru
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
