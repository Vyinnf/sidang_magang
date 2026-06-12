<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Riwayat Gaji Berkala</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
            color: #222;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px 6px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>Riwayat Gaji Berkala</h1>
    <table>
        <thead>
            <tr>
                <th>Pegawai</th>
                <th>NIP</th>
                <th>Golongan Lama</th>
                <th>Golongan Baru</th>
                <th class="text-right">Gaji Lama</th>
                <th class="text-right">Gaji Baru</th>
                <th>Status SK</th>
                <th>TMT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayats as $riwayat)
                <tr>
                    <td>{{ $riwayat->pegawai->user->name ?? 'Belum Lengkap' }}</td>
                    <td>{{ $riwayat->pegawai->nip ?? '-' }}</td>
                    <td>{{ $riwayat->golonganLama->golongan ?? '-' }}</td>
                    <td>{{ $riwayat->golonganBaru->golongan ?? '-' }}</td>
                    <td class="text-right">{{ number_format($riwayat->gaji_pokok_lama, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($riwayat->gaji_pokok_baru, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($riwayat->status_sk) }}</td>
                    <td>{{ $riwayat->tmt_sk?->format('d/m/Y') ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
