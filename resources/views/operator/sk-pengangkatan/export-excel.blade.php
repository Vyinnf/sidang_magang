<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar SK Pengangkatan</title>
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
                <th>Nama Pegawai</th>
                <th>NIP</th>
                <th>Nomor SK</th>
                <th>Tanggal SK</th>
                <th>TMT</th>
                <th>Pejabat SK</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($skPengangkatan as $sk)
                <tr>
                    <td>{{ $sk->pegawai?->user?->name ?? '-' }}</td>
                    <td>{{ $sk->pegawai?->nip ?? '-' }}</td>
                    <td>{{ $sk->nomor_sk ?? '-' }}</td>
                    <td>{{ $sk->tanggal_sk?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $sk->tmt?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $sk->pejabat_sk ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
