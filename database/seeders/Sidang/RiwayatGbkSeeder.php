<?php

namespace Database\Seeders\Sidang;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiwayatGbkSeeder extends Seeder
{
    public function run(): void
    {
        $pegawais = DB::table('pegawais')
            ->join('users', 'users.id', '=', 'pegawais.user_id')
            ->join('golongans', 'golongans.id', '=', 'pegawais.golongan_id')
            ->select(
                'pegawais.id as pegawai_id',
                'pegawais.golongan_id',
                'pegawais.asn',
                'golongans.golongan',
                'users.name'
            )
            ->get();

        $pejabatSk = [
            'BUPATI SIDOARJO',
            'WALIKOTA SURABAYA',
            'KEPALA BKD PROVINSI JAWA TIMUR',
            'SEKRETARIS DAERAH KABUPATEN SIDOARJO',
        ];

        $rows = [];

        foreach ($pegawais as $p) {
            // Buat 1–3 riwayat GBK per pegawai
            $jumlah = rand(1, 3);

            // Golongan lama: satu level di bawah golongan saat ini (jika ada)
            $golBaru = DB::table('golongans')->where('id', $p->golongan_id)->first();
            $golLamaId = null;

            // Cari golongan setingkat di bawah (berdasarkan urutan id, sama asn)
            $golLama = DB::table('golongans')
                ->where('id', '<', $p->golongan_id)
                ->where('asn', $p->asn)
                ->orderBy('id', 'desc')
                ->first();

            if ($golLama) {
                $golLamaId = $golLama->id;
            }

            // TMT SK pertama: sekitar 2 tahun lalu
            $tmtBase = Carbon::now()->subYears(2 * $jumlah)->startOfYear();

            for ($j = 0; $j < $jumlah; $j++) {
                $tmtSk = $tmtBase->copy()->addYears($j * 2)->addMonths(rand(0, 3));
                $tanggalSk = $tmtSk->copy()->subMonths(rand(1, 3));
                $nomorSk = 'SK.GBK/'.$tanggalSk->format('Y').'/'.str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT).'/BKD';

                // Data lama (sebelum GBK ini)
                $masaKerjaLamaTahun = rand(0, 30);
                $masaKerjaLamaBulan = rand(0, 11);
                $gaPokokLama = DB::table('gajis')
                    ->where('golongan_id', $golLamaId ?? $p->golongan_id)
                    ->where('asn', $p->asn)
                    ->where('masa_kerja', '<=', $masaKerjaLamaTahun)
                    ->orderBy('masa_kerja', 'desc')
                    ->value('gaji_pokok') ?? 2785700;

                // Data baru (setelah GBK, masa kerja +2 tahun)
                $masaKerjaBaru = $masaKerjaLamaTahun + 2;
                $masaKerjaBaruBulan = $masaKerjaLamaBulan;
                $gaPokokBaru = DB::table('gajis')
                    ->where('golongan_id', $p->golongan_id)
                    ->where('asn', $p->asn)
                    ->where('masa_kerja', '<=', $masaKerjaBaru)
                    ->orderBy('masa_kerja', 'desc')
                    ->value('gaji_pokok') ?? ($gaPokokLama + rand(50000, 150000));

                $rows[] = [
                    'pegawai_id' => $p->pegawai_id,
                    'tmt_sk' => $tmtSk->toDateString(),
                    'tanggal_sk' => $tanggalSk->toDateString(),
                    'nomor_sk' => $nomorSk,
                    'pejabat_sk' => $pejabatSk[array_rand($pejabatSk)],
                    // Data SK lama (riwayat sebelumnya, kosong untuk GBK pertama)
                    'tmt_sk_lama' => $j === 0 ? null : $tmtBase->copy()->addYears(($j - 1) * 2)->toDateString(),
                    'tanggal_sk_lama' => $j === 0 ? null : $tmtBase->copy()->addYears(($j - 1) * 2)->subMonths(2)->toDateString(),
                    'nomor_sk_lama' => $j === 0 ? null : 'SK.GBK/'.($tanggalSk->year - 2).'/'.str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT).'/BKD',
                    'pejabat_sk_lama' => $j === 0 ? null : $pejabatSk[array_rand($pejabatSk)],
                    'sk_path' => null, // file tidak di-generate seeder
                    'golongan_lama_id' => $golLamaId,
                    'masa_kerja_golongan_lama_tahun' => $masaKerjaLamaTahun,
                    'masa_kerja_golongan_lama_bulan' => $masaKerjaLamaBulan,
                    'gaji_pokok_lama' => $gaPokokLama,
                    'golongan_baru_id' => $p->golongan_id,
                    'masa_kerja_golongan_baru_tahun' => $masaKerjaBaru,
                    'masa_kerja_golongan_baru_bulan' => $masaKerjaBaruBulan,
                    'gaji_pokok_baru' => $gaPokokBaru,
                    'status_sk' => rand(0, 4) > 0 ? 'lengkap' : 'tidak_lengkap',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Chunk insert agar tidak timeout
        foreach (array_chunk($rows, 50) as $chunk) {
            DB::table('riwayat_gbks')->insert($chunk);
        }
    }
}
