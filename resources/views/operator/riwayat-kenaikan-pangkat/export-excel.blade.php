<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Riwayat Kenaikan Pangkat</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Pegawai</th>
                <th>NIP</th>
                <th>Golongan Lama</th>
                <th>Golongan Baru</th>
                <th>TMT SK</th>
                <th>Nomor SK</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayats as $r)
                <tr>
                    <td>{{ $r->pegawai->user->name ?? '-' }}</td>
                    <td>{{ $r->pegawai->nip ?? '-' }}</td>
                    <td>{{ $r->golonganLama?->golongan ?? '-' }}</td>
                    <td>{{ $r->golonganBaru?->golongan ?? '-' }}</td>
                    <td>{{ $r->tmt_sk?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $r->nomor_sk ?? '-' }}</td>
                    <td>{{ ucfirst($r->status_sk) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
