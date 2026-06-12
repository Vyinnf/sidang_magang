<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar SK Pengangkatan</title>
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
    <h1>Daftar SK Pengangkatan</h1>
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
