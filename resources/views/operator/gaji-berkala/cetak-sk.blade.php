@extends('layouts.app')

@section('title', 'Perhitungan Gaji Berkala')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <form action="{{ route('operator.gaji-berkala.print') }}" method="POST">
                @csrf
                <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">

                <div class="mb-4 text-center">
                    <h3 class="fw-bold">Cetak SK Gaji Berkala</h3>
                </div>

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Data Pegawai</h5>
                        <a href="{{ route('operator.pegawais.edit', $pegawai->user->id) }}" class="btn btn-info">Edit Data
                            Pegawai</a>
                    </div>
                    <div class="card-body row">
                        {{-- Data Pegawai --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" readonly
                                value="{{ $pegawai->user->name ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" class="form-control" name="nip" readonly
                                value="{{ $pegawai->nip ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control" name="tanggal_lahir" readonly
                                value="{{ optional($pegawai->tanggal_lahir)->format('d-m-Y') ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Unit Kerja</label>
                            <input type="text" class="form-control" name="unit_kerja" readonly
                                value="{{ $pegawai->user->unitKerja->nama_unit_kerja ?? '-' }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Jenis ASN</label>
                            <input type="text" class="form-control" name="asn" readonly
                                value="{{ $pegawai->asn ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Golongan</label>
                            <input type="text" class="form-control" name="golongan" readonly
                                value="{{ optional($pegawai->golongan)->golongan ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Pangkat</label>
                            <input type="text" class="form-control" name="pangkat" readonly
                                value="{{ optional($pegawai->golongan)->pangkat ?? '-' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" readonly
                                value="{{ $pegawai->jabatan ?? '-' }}">
                        </div>

                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Data SK Gaji Berkala Terakhir</h5>
                    </div>
                    <div class="card-body row">
                        {{-- Data SK Gaji Berkala Terakhir --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nomor SK</label>
                            <input type="text" class="form-control" name="nomor_sk_lama" readonly
                                value="{{ optional($riwayatGbk)->nomor_sk ?? '-' }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal SK</label>
                            <input type="text" class="form-control" name="tanggal_sk_lama" readonly
                                value="{{ optional(optional($riwayatGbk)->tanggal_sk)->format('j F Y') ?? '-' }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">TMT SK</label>
                            <input type="text" class="form-control" name="tmt_lama" readonly
                                value="{{ optional(optional($riwayatGbk)->tmt_sk)->format('j F Y') ?? '-' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pejabat Penandatangan</label>
                            <input type="text" class="form-control" name="pejabat_sk_lama" readonly
                                value="{{ optional($riwayatGbk)->pejabat_sk ?? '-' }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Perhitungan Gaji</h5>
                                <button type="button" class="btn btn-warning" name="hitung">Hitung Ulang</button>
                            </div>
                            <div class="card-body row">
                                {{-- Perhitungan Gaji --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gaji Pokok Lama</label>
                                    <input type="text" class="form-control" name="gaji_lama" readonly
                                        value="Rp {{ number_format(optional($riwayatGbk)->gaji_pokok_baru ?? 0, 0, ',', '.') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gaji Pokok Baru</label>
                                    <input type="text" class="form-control" name="gaji_baru" readonly
                                        value="Rp {{ number_format($data['gaji_pokok_baru'] ?? 0, 0, ',', '.') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Masa Kerja Golongan Lama (Tahun)</label>
                                    <input type="text" class="form-control" name="mkg_lama_tahun"
                                        value="{{ optional($riwayatGbk)->masa_kerja_golongan_baru_tahun ?? 0 }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Masa Kerja Golongan Lama (Bulan)</label>
                                    <input type="text" class="form-control" name="mkg_lama_bulan"
                                        value="{{ optional($riwayatGbk)->masa_kerja_golongan_baru_bulan ?? 0 }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Masa Kerja Golongan Baru (Tahun)</label>
                                    <input type="text" class="form-control" name="mkg_baru_tahun" readonly
                                        value="{{ $data['masa_kerja_tahun_golongan_baru'] ?? '-' }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Masa Kerja Golongan Baru (Bulan)</label>
                                    <input type="text" class="form-control" name="mkg_baru_bulan" readonly
                                        value="{{ $data['masa_kerja_bulan_golongan_baru'] ?? '-' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5>Terhitung Mulai Tanggal (TMT) Baru</h5>
                            </div>
                            <div class="card-body row">
                                {{-- TMT Baru --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">TMT Baru</label>
                                    <input type="text" class="form-control" name="tmt_baru" readonly
                                        value="{{ optional($pegawai->tanggal_kenaikan_gaji_berkala_berikutnya)->format('j F Y') ?? '-' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end align-items-center">
                    <div>
                        <a href="{{ route('operator.gaji-berkala.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary" name="export">Export ke Word</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
