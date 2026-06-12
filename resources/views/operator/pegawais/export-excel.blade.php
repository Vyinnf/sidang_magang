<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Pegawai</title>
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
