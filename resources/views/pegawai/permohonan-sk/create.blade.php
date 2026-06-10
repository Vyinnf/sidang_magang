@extends('layouts.app')

@section('title', 'Ajukan Permohonan SK')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Ajukan Permohonan SK</h2>
                                <small class="text-muted">Silakan lengkapi formulir berikut untuk mengajukan permohonan SK
                                    Anda.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Formulir -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('pegawai.permohonan-sk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="alert alert-info border-0 shadow-sm" role="alert">
                            @if (isset($warning))
                                {{ $warning }}
                            @else
                                Riwayat Gaji Berkala terbaru Anda sudah lengkap dan dapat digunakan untuk permohonan SK.
                            @endif
                        </div>

                        @if (!empty($wordConversionHealthMessage))
                            <div class="alert alert-warning border-0 shadow-sm" role="alert">
                                <div class="fw-semibold mb-1">Info Sistem Konversi Dokumen</div>
                                <div>{{ $wordConversionHealthMessage }}</div>
                            </div>
                        @endif

                        <!-- Tanggal Pengajuan -->
                        <div class="mb-3">
                            <label for="tanggal_pengajuan" class="form-label fw-semibold">Tanggal Pengajuan</label>
                            <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" class="form-control"
                                value="{{ now()->format('Y-m-d') }}" readonly>
                            <small class="text-muted">Tanggal terisi otomatis saat pengajuan.</small>
                        </div>

                        <!-- Dokumen Pendukung -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mb-2">
                                <label class="form-label fw-semibold mb-0">Dokumen Pendukung</label>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="tambah-dokumen">
                                    <i class="ti ti-plus"></i><span class="ms-1">Tambah Dokumen</span>
                                </button>
                            </div>
                            <div id="dokumen-pendukung-list" class="d-flex flex-column gap-2">
                                <div class="dokumen-item border rounded p-3 bg-light-subtle">
                                    <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                                        <span class="fw-semibold text-dark">Dokumen 1</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger hapus-dokumen d-none">
                                            <i class="ti ti-trash"></i><span class="ms-1">Hapus</span>
                                        </button>
                                    </div>
                                    <input type="file" name="dokumen_pendukung[]"
                                        class="form-control @error('dokumen_pendukung') is-invalid @enderror @error('dokumen_pendukung.*') is-invalid @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                </div>
                            </div>
                            @error('dokumen_pendukung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('dokumen_pendukung.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Semua dokumen akan disimpan dalam format PDF. Jika Anda mengunggah JPG, PNG, DOC, atau DOCX, sistem akan mengonversinya otomatis ke PDF. Maksimal 4 MB per file dan maksimal 10 dokumen.</small>
                        </div>

                        <!-- Catatan Pegawai -->
                        <div class="mb-3">
                            <label for="catatan_pegawai" class="form-label fw-semibold">Catatan Tambahan (Opsional)</label>
                            <textarea name="catatan_pegawai" id="catatan_pegawai" class="form-control" rows="4"
                                placeholder="Tuliskan catatan atau pesan tambahan jika diperlukan...">{{ old('catatan_pegawai') }}</textarea>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('pegawai.permohonan-sk.index') }}" class="btn btn-light me-2">
                                <i class="ti ti-arrow-left"></i><span class="d-none d-sm-inline ms-1">Batal</span>
                            </a>
                            <button type="reset" class="btn btn-secondary me-2">
                                <i class="ti ti-rotate"></i><span class="d-none d-sm-inline ms-1">Reset</span>
                            </button>
                            <button type="submit" class="btn btn-primary" title="Ajukan Permohonan SK">
                                <i class="ti ti-send"></i><span class="d-none d-sm-inline ms-1">Ajukan Permohonan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('dokumen-pendukung-list');
            const tambahButton = document.getElementById('tambah-dokumen');
            const maxDokumen = 10;

            function updateDokumenItems() {
                const items = container.querySelectorAll('.dokumen-item');

                items.forEach(function(item, index) {
                    const title = item.querySelector('.fw-semibold');
                    const removeButton = item.querySelector('.hapus-dokumen');

                    title.textContent = `Dokumen ${index + 1}`;
                    removeButton.classList.toggle('d-none', items.length === 1);
                });

                tambahButton.disabled = items.length >= maxDokumen;
            }

            tambahButton.addEventListener('click', function() {
                const currentItems = container.querySelectorAll('.dokumen-item');

                if (currentItems.length >= maxDokumen) {
                    return;
                }

                const newItem = currentItems[0].cloneNode(true);
                newItem.querySelector('input').value = '';
                container.appendChild(newItem);
                updateDokumenItems();
            });

            container.addEventListener('click', function(event) {
                const removeButton = event.target.closest('.hapus-dokumen');

                if (!removeButton) {
                    return;
                }

                const items = container.querySelectorAll('.dokumen-item');

                if (items.length === 1) {
                    items[0].querySelector('input').value = '';
                    return;
                }

                removeButton.closest('.dokumen-item').remove();
                updateDokumenItems();
            });

            updateDokumenItems();
        });
    </script>
@endpush
