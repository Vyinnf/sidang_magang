<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Permohonan SK</title>
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
    </style>
</head>
<body>
    <h1>Daftar Permohonan SK</h1>
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
