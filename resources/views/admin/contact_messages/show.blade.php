@extends('layouts.app')
@section('title', 'Detail Pesan')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Detail Pesan</h2>
                                <small class="text-muted">Terkirim pada {{ $contactMessage->created_at->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Detail Pesan -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-mail me-2"></i> Detail Pesan
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                        <form action="{{ route('admin.contact-messages.destroy', $contactMessage->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                <i class="ti ti-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Pengirim</label>
                            <p class="text-dark mb-0">{{ $contactMessage->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <p class="mb-0"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Subjek</label>
                            <p class="text-dark mb-0">{{ $contactMessage->subject ?: '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <p class="mb-0">
                                @if($contactMessage->read_at)
                                    <span class="badge bg-secondary">Dibaca</span>
                                @else
                                    <span class="badge bg-danger">Baru</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr class="mt-3 mb-4">

                    <label class="form-label fw-semibold">Isi Pesan</label>
                    <div class="border rounded p-3 bg-light-subtle">
                        <pre class="mb-0" style="white-space:pre-wrap">{{ $contactMessage->message }}</pre>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a class="btn btn-primary" href="mailto:{{ $contactMessage->email }}?subject={{ rawurlencode('Re: '.($contactMessage->subject ?: 'Pesan Anda')) }}">
                            <i class="ti ti-send me-1"></i> Balas via Email
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
