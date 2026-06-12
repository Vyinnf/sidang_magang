<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Gaji Pokok</title>
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
    <h1>Daftar Gaji Pokok</h1>
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
