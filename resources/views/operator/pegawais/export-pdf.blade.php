<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Pegawai</title>
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
    <h1>Daftar Pegawai</h1>
    <table>
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Jenis ASN</th>
                <th>Golongan</th>
                <th>Pangkat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->pegawai->nip ?? 'Belum Lengkap' }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->pegawai->jabatan ?? 'Belum Lengkap' }}</td>
                    <td>{{ $user->pegawai->asn ?? 'Belum Lengkap' }}</td>
                    <td>{{ $user->pegawai->golongan->golongan ?? 'Belum Lengkap' }}</td>
                    <td>{{ $user->pegawai->golongan->pangkat ?? 'Belum Lengkap' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
