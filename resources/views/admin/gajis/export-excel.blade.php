<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Gaji Pokok</title>
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
                <th>ID</th>
                <th>Golongan</th>
                <th>Masa Kerja</th>
                <th>Jenis ASN</th>
                <th>Gaji Pokok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gajis as $gaji)
                <tr>
                    <td>{{ $gaji->id }}</td>
                    <td>{{ $gaji->golongan->golongan }}{{ $gaji->golongan->pangkat ? ' - ' . $gaji->golongan->pangkat : '' }}</td>
                    <td>{{ $gaji->masa_kerja }}</td>
                    <td>{{ $gaji->asn }}</td>
                    <td>{{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
