@extends('layouts.app')

@section('title', 'Proses Permohonan SK')

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
                                <h2 class="mb-0 fw-bold">Proses Permohonan SK</h2>
                                <small class="text-muted">Tinjau dan ambil keputusan atas permohonan ini</small>
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
                        <div class="col-sm-4 fw-semibold">Nama Pegawai</div>
                        <div class="col-sm-8">{{ $permohonanSk->pegawai?->user?->name ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">NIP</div>
                        <div class="col-sm-8">{{ $permohonanSk->pegawai?->nip ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Jabatan</div>
                        <div class="col-sm-8">{{ $permohonanSk->pegawai?->jabatan ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Unit Kerja</div>
                        <div class="col-sm-8">{{ $permohonanSk->pegawai?->unitKerja?->nama_unit_kerja ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Tanggal Pengajuan</div>
                        <div class="col-sm-8">{{ $permohonanSk->tanggal_pengajuan?->format('d F Y') ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-semibold">Status</div>
                        <div class="col-sm-8">
                            @if ($permohonanSk->status === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif ($permohonanSk->status === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark">Diajukan</span>
                            @endif
                        </div>
                    </div>
                    @if ($permohonanSk->catatan_pegawai)
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Catatan dari Pegawai</div>
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
                                            $previewUrl = route('operator.permohonan-sk.attachments.preview', [$permohonanSk, $index]);
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
                                                    <a href="{{ route('operator.permohonan-sk.attachments.download', [$permohonanSk, $index]) }}"
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

            @if ($riwayatGbk)
                <!-- Detail Riwayat SK Lama -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="ti ti-file-certificate me-2"></i>Riwayat SK Lama
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">TMT SK</div>
                            <div class="col-sm-8">{{ $riwayatGbk->tmt_sk?->format('d F Y') ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Tanggal SK</div>
                            <div class="col-sm-8">{{ $riwayatGbk->tanggal_sk?->format('d F Y') ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Nomor SK</div>
                            <div class="col-sm-8">{{ $riwayatGbk->nomor_sk ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Pejabat SK</div>
                            <div class="col-sm-8">{{ $riwayatGbk->pejabat_sk ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Dalam Golongan</div>
                            <div class="col-sm-8">{{ $riwayatGbk->golonganBaru?->golongan ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Masa Kerja (Tahun)</div>
                            <div class="col-sm-8">{{ $riwayatGbk->masa_kerja_golongan_baru_tahun ?? 0 }}
                                Tahun</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Masa Kerja (Bulan)</div>
                            <div class="col-sm-8">{{ $riwayatGbk->masa_kerja_golongan_baru_bulan ?? 0 }}
                                Bulan</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Gaji Pokok</div>
                            <div class="col-sm-8">Rp
                                {{ number_format($riwayatGbk->gaji_pokok_baru, 0, ',', '.') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-semibold">Status SK</div>
                            <div class="col-sm-8">
                                @if ($riwayatGbk->status_sk === 'lengkap')
                                    <span class="badge bg-success">Lengkap</span>
                                @else
                                    <span class="badge bg-danger">Tidak Lengkap</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            @if ($permohonanSk->status === 'diajukan')
                <!-- Formulir untuk Aksi Operator -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="ti ti-settings me-2"></i>Tindakan Operator
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('operator.permohonan-sk.process', $permohonanSk->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="catatan_operator" class="form-label fw-semibold">Catatan Operator
                                    (Opsional)</label>
                                <textarea name="catatan_operator" id="catatan_operator" class="form-control" rows="3">{{ old('catatan_operator') }}</textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                {{-- Tombol Tolak, memiliki name="action" dengan value="reject" --}}
                                <button type="submit" name="action" value="reject" class="btn btn-danger me-2">
                                    <i class="ti ti-x me-1"></i> Tolak
                                </button>
                                {{-- Tombol Proses, memiliki name="action" dengan value="process" --}}
                                <button type="submit" name="action" value="process" class="btn btn-success">
                                    <i class="ti ti-loader me-1"></i> Proses
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Tombol Kembali -->
            <div class="mt-4 d-flex justify-content-end">
                <a href="{{ route('operator.permohonan-sk.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
