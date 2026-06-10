@extends('layouts.app')

@section('title', 'Perhitungan Gaji Berkala')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0 fw-bold">Proses Pencetakan SK</h2>
                                <small class="text-muted">Lanjutkan perhitungan dan proses cetak SK pegawai.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('operator.permohonan-sk.print-sk') }}" method="POST">
                @csrf
                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">

                <!-- Card Data Pegawai -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="ti ti-user me-2"></i> Data Pegawai
                        </h5>
                        <a href="{{ route('operator.pegawais.edit', $pegawai->user->id) }}" class="btn btn-info btn-sm">
                            <i class="ti ti-edit me-1"></i> Edit Data
                        </a>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" readonly name="nama"
                                value="{{ $pegawai->user->name ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" class="form-control" readonly name="nip"
                                value="{{ $pegawai->nip ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control" readonly name="tanggal_lahir"
                                value="{{ optional($pegawai->tanggal_lahir)->format('d-m-Y') ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Unit Kerja</label>
                            <input type="text" class="form-control" readonly name="unit_kerja"
                                value="{{ $pegawai->user->unitKerja->nama_unit_kerja ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Jenis ASN</label>
                            <input type="text" class="form-control" readonly name="asn"
                                value="{{ $pegawai->asn ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Golongan</label>
                            <input type="text" class="form-control" readonly name="golongan"
                                value="{{ optional($pegawai->golongan)->golongan ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Pangkat</label>
                            <input type="text" class="form-control" readonly name="pangkat"
                                value="{{ optional($pegawai->golongan)->pangkat ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-control" readonly name="jabatan"
                                value="{{ $pegawai->jabatan ?? '-' }}">
                        </div>
                    </div>
                </div>

                <!-- Card Data SK Lama -->
                @if (isset($riwayatGbk))
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="ti ti-file-text me-2"></i> Data SK Gaji Berkala Terakhir
                            </h5>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nomor SK</label>
                                <input type="text" class="form-control" readonly name="nomor_sk_lama"
                                    value="{{ optional($riwayatGbk)->nomor_sk ?? '-' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal SK</label>
                                <input type="text" class="form-control" readonly name="tanggal_sk_lama"
                                    value="{{ optional(optional($riwayatGbk)->tanggal_sk)->format('j F Y') ?? '-' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">TMT SK</label>
                                <input type="text" class="form-control" readonly name="tmt_lama"
                                    value="{{ optional(optional($riwayatGbk)->tmt_sk)->format('j F Y') ?? '-' }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Pejabat Penandatangan</label>
                                <input type="text" class="form-control" readonly name="pejabat_sk_lama"
                                    value="{{ optional($riwayatGbk)->pejabat_sk ?? '-' }}">
                            </div>
                        </div>
                    </div>
                @endif

                @if (isset($SkPengangkatan))
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold text-dark">
                                <i class="ti ti-file-text me-2"></i> Data SK Pengangkatan
                            </h5>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nomor SK</label>
                                <input type="text" class="form-control" readonly name="nomor_sk_lama"
                                    value="{{ optional($SkPengangkatan)->nomor_sk ?? '-' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tanggal SK</label>
                                <input type="text" class="form-control" readonly name="tanggal_sk_lama"
                                    value="{{ optional(optional($SkPengangkatan)->tanggal_sk)->format('j F Y') ?? '-' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">TMT SK</label>
                                <input type="text" class="form-control" readonly name="tmt_lama"
                                    value="{{ optional(optional($SkPengangkatan)->tmt)->format('j F Y') ?? '-' }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Pejabat Penandatangan</label>
                                <input type="text" class="form-control" readonly name="pejabat_sk_lama"
                                    value="{{ optional($SkPengangkatan)->pejabat_sk ?? '-' }}">
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Row Perhitungan -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                                    <i class="ti ti-calculator"></i> <span>Perhitungan Gaji</span>
                                </h5>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('operator.permohonan-sk.process-sk', $permohonanSk->id) }}" class="btn btn-secondary btn-sm" title="Reset ke perhitungan awal">
                                        Reset
                                    </a>
                                    <button type="button" class="btn btn-warning btn-sm" name="hitung"
                                        data-bs-toggle="modal" data-bs-target="#modalRecalcMkg" title="Hitung ulang dengan MKG baru">Hitung Ulang</button>
                                </div>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gaji Pokok Lama</label>
                                    @if (isset($riwayatGbk))
                                        <input type="text" class="form-control" readonly name="gaji_lama"
                                            value="Rp {{ number_format(optional($riwayatGbk)->gaji_pokok_baru ?? 0, 0, ',', '.') }}">
                                    @else
                                        <input type="text" class="form-control" readonly name="gaji_lama"
                                            value="Rp {{ number_format(optional($SkPengangkatan)->gaji_pokok ?? 0, 0, ',', '.') }}">
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gaji Pokok Baru</label>
                                    <input type="text" class="form-control" readonly name="gaji_baru"
                                        value="Rp {{ number_format($data['gaji_pokok_baru'] ?? 0, 0, ',', '.') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">MKG Lama (Tahun)</label>
                                    @if (isset($riwayatGbk))
                                        <input type="text" class="form-control" readonly
                                            name="mkg_lama_tahun"value="{{ optional($riwayatGbk)->masa_kerja_golongan_baru_tahun ?? 0 }}">
                                    @else
                                        <input type="text" class="form-control" readonly
                                            name="mkg_lama_tahun"value="{{ optional($SkPengangkatan)->tahun_masa_kerja_pra_pengangkatan ?? 0 }}">
                                    @endif

                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">MKG Lama (Bulan)</label>
                                    @if (isset($riwayatGbk))
                                        <input type="text" class="form-control" name="mkg_lama_bulan" readonly
                                            value="{{ optional($riwayatGbk)->masa_kerja_golongan_baru_bulan ?? 0 }}">
                                    @else
                                        <input type="text" class="form-control" name="mkg_lama_bulan" readonly
                                            value="{{ optional($SkPengangkatan)->bulan_masa_kerja_pra_pengangkatan ?? 0 }} ">
                                    @endif
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">MKG Baru (Tahun)</label>
                                    <input type="text" class="form-control" readonly name="mkg_baru_tahun"
                                        value="{{ $data['masa_kerja_tahun_golongan_baru'] ?? '-' }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">MKG Baru (Bulan)</label>
                                    <input type="text" class="form-control" readonly name="mkg_baru_bulan"
                                        value="{{ $data['masa_kerja_bulan_golongan_baru'] ?? '-' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 fw-bold text-dark">
                                    <i class="ti ti-calendar me-2"></i> TMT Baru
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">TMT Baru</label>
                                    <input type="date" class="form-control" name="tmt_baru"
                                           value="{{ $data['tmt_baru_raw'] ?? (optional($pegawai->tanggal_kenaikan_gaji_berkala_berikutnya)?->format('Y-m-d')) }}">
                                    <small class="text-muted">Sesuaikan bila ada penetapan berbeda dari perhitungan otomatis (default +2 tahun dari TMT sebelumnya).</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('operator.permohonan-sk.index') }}" class="btn btn-light me-2">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="reset" class="btn btn-secondary me-2">
                        <i class="ti ti-rotate me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary" name="export">
                        <i class="ti ti-file-export me-1"></i> Cetak SK
                    </button>
                </div>
            </form>
        </div>
    </div>

    <form id="formRecalcMkg" method="POST" action="{{ route('operator.permohonan-sk.process-sk', $permohonanSk->id) }}">
        @csrf
        <div class="modal fade" id="modalRecalcMkg" tabindex="-1" aria-labelledby="modalRecalcMkgLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h6 class="modal-title fw-semibold" id="modalRecalcMkgLabel">Hitung Gaji Pokok Baru</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="hitungUlang" value="1">
                        <div class="mb-3">
                            <label class="form-label small mb-1">MKG Baru (Tahun)</label>
                            <input type="number" min="0" max="50" class="form-control form-control-sm"
                                id="inputMkgBaruTahun" name="mkg_baru_tahun" placeholder="Contoh: 6">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small mb-1">MKG Baru (Bulan)</label>
                            <input type="number" min="0" max="11" class="form-control form-control-sm"
                                id="inputMkgBaruBulan" name="mkg_baru_bulan" placeholder="0-11">
                        </div>
                        <small class="text-muted d-block">Sesuaikan jika ada koreksi data masa kerja golongan.</small>
                        <div class="alert alert-warning mt-2 py-2 px-2 small mb-0" id="alertRecalcInfo"
                            style="display:none">
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="reset" class="btn btn-secondary btn-sm"><i class="ti ti-rotate"></i> Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
