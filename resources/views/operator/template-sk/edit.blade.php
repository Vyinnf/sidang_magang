@extends('layouts.app')

@section('title', 'Ubah Template SK')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Ubah Template SK</h2>
                                <small class="text-muted">Formulir untuk memperbarui template surat keputusan</small>
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
                                <i class="ti ti-edit me-2"></i>Formulir Perbarui Template
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('operator.template-sk.update', ) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="nama_template" class="form-label">Nama Template <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_template" name="nama_template"
                                        value="{{ old('nama_template', $template->nama_template) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="template_file" class="form-label">Ganti File Template (.docx, .pdf) <small
                                            class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                                    <input class="form-control" type="file" id="template_file" name="template_file">
                                    <small class="text-muted mt-2 d-block">File saat ini: <a
                                            href="{{ asset('storage/' . $template->template_path) }}"
                                            target="_blank">{{ basename($template->template_path) }}</a></small>
                                </div>
                                <div class="d-flex justify-content-end mt-4">
                                   <a href="{{ route('operator.template-sk.index') }}" class="btn btn-outline-secondary  me-2">
                                       <i class="ti ti-arrow-left"></i><span class="d-none d-sm-inline ms-1">Kembali</span>
                                    </a>
                                    <button type="reset" class="btn btn-secondary me-2">
                                        <i class="ti ti-rotate"></i><span class="d-none d-sm-inline ms-1">Reset</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-device-floppy"></i><span class="d-none d-sm-inline ms-1">Simpan Perubahan</span>
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
