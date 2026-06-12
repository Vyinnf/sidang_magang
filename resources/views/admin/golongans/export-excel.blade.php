<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Golongan</title>
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
