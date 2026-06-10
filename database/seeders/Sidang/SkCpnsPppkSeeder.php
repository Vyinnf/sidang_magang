<?php

namespace Database\Seeders\Sidang;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkCpnsPppkSeeder extends Seeder
{
    public function run(): void
    {
        $pegawais = DB::table('pegawais')
            ->select('id', 'asn', 'golongan_id', 'tanggal_lahir')
            ->get();

        $pejabatSk = [
            'MENTERI PENDAYAGUNAAN APARATUR NEGARA DAN REFORMASI BIROKRASI',
            'BUPATI SIDOARJO',
            'WALIKOTA SURABAYA',
            'GUBERNUR JAWA TIMUR',
        ];

        $rows = [];

        foreach ($pegawais as $p) {
            // TMT CPNS/PPPK: sekitar 3–15 tahun lalu
            $tmt = Carbon::now()->subYears(rand(3, 15))->startOfMonth();
            $tglSk = $tmt->copy()->subMonths(rand(1, 3));
            $nomorSk = ($p->asn === 'PNS' ? 'CPNS' : 'PPPK')
                .'.'.$tglSk->format('Y').'.'
                .str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Gaji pokok awal (masa kerja 0)
            $gajiPokok = DB::table('gajis')
                ->where('golongan_id', $p->golongan_id)
                ->where('asn', $p->asn)
                ->where('masa_kerja', 0)
                ->value('gaji_pokok') ?? 2185000;

            // Masa kerja pra-pengangkatan (pengalaman kerja sebelumnya, 0 jika fresh)
            $praKerjaTahun = rand(0, 3);
            $praKerjaBulan = $praKerjaTahun > 0 ? rand(0, 11) : 0;

            $rows[] = [
                'pegawai_id' => $p->id,
                'nomor_sk' => $nomorSk,
                'tanggal_sk' => $tglSk->toDateString(),
                'tmt' => $tmt->toDateString(),
                'pejabat_sk' => $pejabatSk[array_rand($pejabatSk)],
                'golongan_id' => $p->golongan_id,
                'tahun_masa_kerja_pra_pengangkatan' => $praKerjaTahun,
                'bulan_masa_kerja_pra_pengangkatan' => $praKerjaBulan,
                'gaji_pokok' => $gajiPokok,
                'sk_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($rows, 50) as $chunk) {
            DB::table('sk_cpns_pppks')->insert($chunk);
        }
    }
}
