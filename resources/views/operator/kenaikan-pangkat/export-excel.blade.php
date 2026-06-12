<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Permohonan Kenaikan Pangkat</title>
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
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Catatan Operator</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permohonans as $p)
                <tr>
                    <td>{{ $p->pegawai?->user?->name ?? '-' }}</td>
                    <td>{{ $p->pegawai?->nip ?? '-' }}</td>
                    <td>{{ $p->tanggal_pengajuan?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                    <td>{{ $p->catatan_operator ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
