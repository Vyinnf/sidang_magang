<!doctype html>
<html lang="id">

<head>
   <meta charset="utf-8">
   <title>Riwayat Kenaikan Pangkat</title>
   <style>
      body {
         font-family: Arial, sans-serif;
         font-size: 10px;
         margin: 10px;
         color: #222;
      }

      h1 {
         font-size: 14px;
         margin-bottom: 12px;
         text-align: center;
      }

      table {
         width: 100%;
         border-collapse: collapse;
      }

      th,
      td {
         border: 1px solid #000;
         padding: 5px;
         text-align: left;
      }

      th {
         background-color: #f0f0f0;
         font-weight: bold;
      }

      .text-center {
         text-align: center;
      }
   </style>
</head>

<body>
   <h1>Riwayat Kenaikan Pangkat</h1>

   <table>
      <thead>
         <tr>
            <th class="text-center">No</th>
            <th class="text-center">TMT SK</th>
            <th class="text-center">Nomor SK</th>
            <th class="text-center">Tanggal SK</th>
            <th class="text-center">Pejabat SK</th>
            <th class="text-center">Golongan Lama</th>
            <th class="text-center">Golongan Baru</th>
            <th class="text-center">MKG Lama</th>
            <th class="text-center">MKG Baru</th>
            <th class="text-center">Status SK</th>
         </tr>
      </thead>
      <tbody>
         @forelse ($riwayats as $index => $riwayat)
         <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ $riwayat->tmt_sk?->format('d/m/Y') ?? '-' }}</td>
            <td class="text-center">{{ $riwayat->nomor_sk ?? '-' }}</td>
            <td class="text-center">{{ $riwayat->tanggal_sk?->format('d/m/Y') ?? '-' }}</td>
            <td class="text-center">{{ $riwayat->pejabat_sk ?? '-' }}</td>
            <td class="text-center">{{ $riwayat->golonganLama?->golongan ?? '-' }}</td>
            <td class="text-center">{{ $riwayat->golonganBaru?->golongan ?? '-' }}</td>
            <td class="text-center">{{ $riwayat->masa_kerja_golongan_lama_tahun ?? 0 }}/{{
               $riwayat->masa_kerja_golongan_lama_bulan ?? 0 }}</td>
            <td class="text-center">{{ $riwayat->masa_kerja_golongan_baru_tahun ?? 0 }}/{{
               $riwayat->masa_kerja_golongan_baru_bulan ?? 0 }}</td>
            <td class="text-center">
               @if ($riwayat->status_sk === 'lengkap')
               Lengkap
               @elseif ($riwayat->status_sk === 'tidak_lengkap')
               Tidak Lengkap
               @else
               {{ $riwayat->status_sk ?? '-' }}
               @endif
            </td>
         </tr>
         @empty
         <tr>
            <td colspan="10" class="text-center">Tidak ada data</td>
         </tr>
         @endforelse
      </tbody>
   </table>
</body>

</html>