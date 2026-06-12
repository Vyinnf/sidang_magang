<table>
    <thead>
        <tr>
            <th>No</th>
            <th>TMT SK</th>
            <th>Nomor SK</th>
            <th>Tanggal SK</th>
            <th>Golongan Lama</th>
            <th>Golongan Baru</th>
            <th>Gaji Lama</th>
            <th>Gaji Baru</th>
            <th>Status SK</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($riwayatGbks as $index => $riwayat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $riwayat->tmt_sk?->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $riwayat->nomor_sk ?? '-' }}</td>
                <td>{{ $riwayat->tanggal_sk ? \Carbon\Carbon::parse($riwayat->tanggal_sk)->format('d/m/Y') : '-' }}</td>
                <td>{{ $riwayat->golonganLama?->nama ?? '-' }}</td>
                <td>{{ $riwayat->golonganBaru?->nama ?? '-' }}</td>
                <td>{{ number_format($riwayat->gaji_pokok_lama ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format($riwayat->gaji_pokok_baru ?? 0, 0, ',', '.') }}</td>
                <td>
                    @if ($riwayat->status_sk === 'lengkap')
                        Lengkap
                    @elseif ($riwayat->status_sk === 'tidak_lengkap')
                        Tidak Lengkap
                    @else
                        {{ $riwayat->status_sk }}
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>
