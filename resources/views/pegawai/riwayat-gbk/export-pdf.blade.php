<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>Riwayat Gaji Berkala</h2>
    
    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">TMT SK</th>
                <th class="text-center">Nomor SK</th>
                <th class="text-center">Tanggal SK</th>
                <th class="text-center">Golongan Lama</th>
                <th class="text-center">Golongan Baru</th>
                <th class="text-center">Gaji Lama</th>
                <th class="text-center">Gaji Baru</th>
                <th class="text-center">Status SK</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayatGbks as $index => $riwayat)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $riwayat->tmt_sk?->format('d/m/Y') ?? '-' }}</td>
                    <td class="text-center">{{ $riwayat->nomor_sk ?? '-' }}</td>
                    <td class="text-center">{{ $riwayat->tanggal_sk ? \Carbon\Carbon::parse($riwayat->tanggal_sk)->format('d/m/Y') : '-' }}</td>
                    <td class="text-center">{{ $riwayat->golonganLama?->nama ?? '-' }}</td>
                    <td class="text-center">{{ $riwayat->golonganBaru?->nama ?? '-' }}</td>
                    <td class="text-right">{{ number_format($riwayat->gaji_pokok_lama ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($riwayat->gaji_pokok_baru ?? 0, 0, ',', '.') }}</td>
                    <td class="text-center">
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
                    <td colspan="9" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
