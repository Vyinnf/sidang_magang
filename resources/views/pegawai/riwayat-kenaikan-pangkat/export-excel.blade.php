<table>
   <thead>
      <tr>
         <th>No</th>
         <th>TMT SK</th>
         <th>Nomor SK</th>
         <th>Tanggal SK</th>
         <th>Pejabat SK</th>
         <th>Golongan Lama</th>
         <th>Golongan Baru</th>
         <th>MKG Lama</th>
         <th>MKG Baru</th>
         <th>Status SK</th>
      </tr>
   </thead>
   <tbody>
      @forelse ($riwayats as $index => $riwayat)
      <tr>
         <td>{{ $index + 1 }}</td>
         <td>{{ $riwayat->tmt_sk?->format('d/m/Y') ?? '-' }}</td>
         <td>{{ $riwayat->nomor_sk ?? '-' }}</td>
         <td>{{ $riwayat->tanggal_sk?->format('d/m/Y') ?? '-' }}</td>
         <td>{{ $riwayat->pejabat_sk ?? '-' }}</td>
         <td>{{ $riwayat->golonganLama?->golongan ?? '-' }}</td>
         <td>{{ $riwayat->golonganBaru?->golongan ?? '-' }}</td>
         <td>{{ $riwayat->masa_kerja_golongan_lama_tahun ?? 0 }}/{{ $riwayat->masa_kerja_golongan_lama_bulan ?? 0 }}
         </td>
         <td>{{ $riwayat->masa_kerja_golongan_baru_tahun ?? 0 }}/{{ $riwayat->masa_kerja_golongan_baru_bulan ?? 0 }}
         </td>
         <td>
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
         <td colspan="10">Tidak ada data</td>
      </tr>
      @endforelse
   </tbody>
</table>