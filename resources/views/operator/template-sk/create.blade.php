@extends('layouts.app')

@section('title', 'Unggah Template SK')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Unggah Template SK</h2>
                                <small class="text-muted">Formulir untuk mengunggah template surat keputusan baru</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="ti ti-file-upload me-2"></i>Formulir Unggah Template
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('operator.template-sk.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama_template" class="form-label">Nama Template</label>
                                    <input type="text" class="form-control" id="nama_template" name="nama_template"
                                        value="{{ old('nama_template') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="template_file" class="form-label">Pilih File Template (.docx, .pdf)</label>
                                    <input class="form-control" type="file" id="template_file" name="template_file"
                                        required>
                                </div>
                                <div class="d-flex justify-content-end mt-4">
                                   <a href="{{ route('operator.template-sk.index') }}" class="btn btn-outline-secondary me-2">
                                       <i class="ti ti-arrow-left me-1"></i> Kembali
                                   </a>
                                    <button type="reset" class="btn btn-secondary me-2">
                                        <i class="ti ti-rotate me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-upload me-1"></i> Unggah
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
