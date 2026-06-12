<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Permohonan SK</title>
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
            @foreach ($permohonanSk as $permohonan)
                <tr>
                    <td>{{ $permohonan->pegawai?->user?->name ?? '-' }}</td>
                    <td>{{ $permohonan->pegawai?->nip ?? '-' }}</td>
                    <td>{{ $permohonan->tanggal_pengajuan?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ ucfirst($permohonan->status) }}</td>
                    <td>{{ $permohonan->catatan_operator ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
