@extends('layouts.app')

@section('title', 'Instan SK Gaji Berkala')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Instan SK Gaji Berkala</h2>
                                <small class="text-muted">Proses SK Gaji Berkala tanpa permohonan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Pilih Pegawai -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-user me-2"></i>Pilih Pegawai
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('operator.instan-gbk.process') }}" method="POST">
                     @csrf
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <select name="pegawai_id" class="form-select" required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}">{{ $pegawai->user->name }} ({{ $pegawai->nip }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ti ti-search me-1"></i> Proses SK Instan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('operator.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
