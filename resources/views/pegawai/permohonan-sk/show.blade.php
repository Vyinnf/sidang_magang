@extends('layouts.app')

@section('title', 'Detail Permohonan SK')

@section('content')
    @php
        $previewableExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
    @endphp
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Detail Permohonan SK</h2>
                                <small class="text-muted">Informasi lengkap tentang permohonan Anda</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Detail Permohonan -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-info-circle me-2"></i>Detail Permohonan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Tanggal Pengajuan</div>
                        <div class="col-sm-8">{{ $permohonanSk->tanggal_pengajuan->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Status</div>
                        <div class="col-sm-8">
                            @if ($permohonanSk->status === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif ($permohonanSk->status === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif ($permohonanSk->status === 'diproses')
                                <span class="badge bg-primary">Sedang Diproses</span>
                            @else
                                <span class="badge bg-warning text-dark">Diajukan</span>
                            @endif

                        </div>
                    </div>
                    @if ($permohonanSk->catatan_pegawai)
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Catatan dari Anda</div>
                            <div class="col-sm-8">{{ $permohonanSk->catatan_pegawai }}</div>
                        </div>
                    @endif
                    @if (!empty($permohonanSk->dokumen_pendukung))
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Dokumen Pendukung</div>
                            <div class="col-sm-8">
                                <div class="d-flex flex-column gap-3">
                                    @foreach ($permohonanSk->dokumen_pendukung as $index => $dokumen)
                                        @php
                                            $namaDokumen = $dokumen['original_name'] ?? 'Dokumen Pendukung ' . ($index + 1);
                                            $extension = strtolower(pathinfo($namaDokumen, PATHINFO_EXTENSION) ?: pathinfo($dokumen['path'] ?? '', PATHINFO_EXTENSION));
                                            $previewUrl = route('pegawai.permohonan-sk.attachments.preview', [$permohonanSk, $index]);
                                        @endphp
                                        <div class="border rounded p-3 bg-light-subtle">
                                            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap mb-3">
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $namaDokumen }}</div>
                                                    <small class="text-muted text-uppercase">{{ $extension ?: 'file' }}</small>
                                                </div>
                                                <div class="d-flex gap-2 flex-wrap">
                                                    <a href="{{ $previewUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                        <i class="ti ti-external-link me-1"></i>Buka Penuh
                                                    </a>
                                                    <a href="{{ route('pegawai.permohonan-sk.attachments.download', [$permohonanSk, $index]) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="ti ti-download me-1"></i>Unduh
                                                    </a>
                                                </div>
                                            </div>

                                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                                <img src="{{ $previewUrl }}" alt="{{ $namaDokumen }}" class="img-fluid rounded border"
                                                    style="max-height: 420px; width: auto;">
                                            @elseif ($extension === 'pdf')
                                                <iframe src="{{ $previewUrl }}#toolbar=0" class="w-100 border rounded"
                                                    style="height: 480px;" title="{{ $namaDokumen }}"></iframe>
                                            @elseif (in_array($extension, $previewableExtensions))
                                                <iframe src="{{ $previewUrl }}" class="w-100 border rounded"
                                                    style="height: 480px;" title="{{ $namaDokumen }}"></iframe>
                                            @else
                                                <div class="border rounded p-3 bg-white text-muted">
                                                    Browser biasanya tidak menampilkan preview langsung untuk format ini. Gunakan tombol Buka Penuh untuk mencoba preview di tab baru atau Unduh bila perlu.
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($permohonanSk->catatan_operator)
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Catatan Operator</div>
                            <div class="col-sm-8">{{ $permohonanSk->catatan_operator }}</div>
                        </div>
                    @endif
                    @if ($permohonanSk->diproses_oleh)
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Diproses Oleh</div>
                            <div class="col-sm-8">{{ $permohonanSk->diprosesOleh->name ?? '-' }}</div>
                        </div>
                    @endif
                    @if ($permohonanSk->tanggal_disetujui)
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Tanggal Disetujui</div>
                            <div class="col-sm-8">{{ $permohonanSk->tanggal_disetujui->format('d F Y H:i') }}</div>
                        </div>
                    @endif
                    @if ($permohonanSk->tanggal_ditolak)
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Tanggal Ditolak</div>
                            <div class="col-sm-8">{{ $permohonanSk->tanggal_ditolak->format('d F Y H:i') }}</div>
                        </div>
                    @endif
                    @if ($permohonanSk->sk_path && $permohonanSk->status === 'disetujui')
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Dokumen SK</div>
                            <div class="col-sm-8">
                                <a href="{{ Storage::url($permohonanSk->sk_path) }}" class="btn btn-sm btn-success">
                                    <i class="ti ti-download me-1"></i> Unduh SK
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('pegawai.permohonan-sk.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali ke Daftar Permohonan
                </a>
            </div>

        </div>
    </div>
@endsection
