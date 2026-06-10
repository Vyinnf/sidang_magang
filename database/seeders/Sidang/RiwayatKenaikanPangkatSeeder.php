<?php

namespace Database\Seeders\Sidang;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatKenaikanPangkatSeeder extends Seeder
{
    public function run(): void
    {
        // Hanya PNS yang punya kenaikan pangkat (golongan)
        $pegawais = DB::table('pegawais')
            ->where('pegawais.asn', 'PNS')
            ->join('golongans', 'golongans.id', '=', 'pegawais.golongan_id')
            ->select('pegawais.id as pegawai_id', 'pegawais.golongan_id', 'golongans.golongan')
            ->get();

        $pejabatSk = [
            'BUPATI SIDOARJO',
            'WALIKOTA SURABAYA',
            'GUBERNUR JAWA TIMUR',
            'KEPALA BKN REGIONAL II',
        ];

        $rows = [];

        foreach ($pegawais as $p) {
            // Buat 1–2 riwayat kenaikan pangkat
            $jumlah = rand(1, 2);

            // Golongan awal (2 atau 1 level di bawah sekarang)
            $golAwalId = max(1, $p->golongan_id - $jumlah);

            for ($j = 0; $j < $jumlah; $j++) {
                $golLamaId = $golAwalId + $j;
                $golBaruId = $golAwalId + $j + 1;

                // Pastikan golongan masih dalam range PNS (1–17)
                if ($golBaruId > 17) {
                    break;
                }

                $tmtSk = Carbon::now()->subYears(rand(1, 8))->startOfQuarter();
                $tanggalSk = $tmtSk->copy()->subMonths(rand(1, 2));
                $nomorSk = 'KP.'.$tanggalSk->format('Y').'.'.str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

                $masaKerjaLamaTahun = rand(2, 10);
                $masaKerjaBaruTahun = 0;   // biasanya mulai dari 0 di golongan baru

                $gajiLama = DB::table('gajis')
                    ->where('golongan_id', $golLamaId)
                    ->where('asn', 'PNS')
                    ->where('masa_kerja', '<=', $masaKerjaLamaTahun)
                    ->orderBy('masa_kerja', 'desc')
                    ->value('gaji_pokok') ?? 2785700;

                $gajiBaru = DB::table('gajis')
                    ->where('golongan_id', $golBaruId)
                    ->where('asn', 'PNS')
                    ->where('masa_kerja', '<=', $masaKerjaBaruTahun)
                    ->orderBy('masa_kerja', 'desc')
                    ->value('gaji_pokok') ?? ($gajiLama + rand(100000, 250000));

                $rows[] = [
                    'pegawai_id' => $p->pegawai_id,
                    'golongan_lama_id' => $golLamaId,
                    'golongan_baru_id' => $golBaruId,
                    'masa_kerja_golongan_lama_tahun' => $masaKerjaLamaTahun,
                    'masa_kerja_golongan_lama_bulan' => rand(0, 11),
                    'masa_kerja_golongan_baru_tahun' => $masaKerjaBaruTahun,
                    'masa_kerja_golongan_baru_bulan' => 0,
                    'tmt_sk' => $tmtSk->toDateString(),
                    'nomor_sk' => $nomorSk,
                    'tanggal_sk' => $tanggalSk->toDateString(),
                    'pejabat_sk' => $pejabatSk[array_rand($pejabatSk)],
                    'sk_path' => 'placeholder/kenaikan-pangkat/kp-'.$p->pegawai_id.'-'.($j + 1).'.pdf',
                    'status_sk' => rand(0, 3) > 0 ? 'lengkap' : 'tidak_lengkap',
                    'permohonan_kenaikan_pangkat_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach (array_chunk($rows, 50) as $chunk) {
            DB::table('riwayat_kenaikan_pangkats')->insert($chunk);
        }
    }
}
