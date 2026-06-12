<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Golongan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #222;
            margin: 20px;
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
    <h1>Daftar Golongan</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Golongan</th>
                <th>Pangkat</th>
                <th>ASN</th>
                <th>Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($golongans as $golongan)
                <tr>
                    <td>{{ $golongan->id }}</td>
                    <td>{{ $golongan->golongan }}</td>
                    <td>{{ $golongan->pangkat ?? '-' }}</td>
                    <td>{{ $golongan->asn }}</td>
                    <td>{{ $golongan->created_at?->format('Y-m-d H:i:s') ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
