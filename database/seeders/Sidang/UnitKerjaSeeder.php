<?php

namespace Database\Seeders\Sidang;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $unitKerjas = [
            ['nama_unit_kerja' => 'Sekretariat Daerah'],
            ['nama_unit_kerja' => 'Dinas Pendidikan'],
            ['nama_unit_kerja' => 'Dinas Kesehatan'],
            ['nama_unit_kerja' => 'Dinas Pekerjaan Umum dan Penataan Ruang'],
            ['nama_unit_kerja' => 'Dinas Perhubungan'],
            ['nama_unit_kerja' => 'Badan Kepegawaian Daerah'],
            ['nama_unit_kerja' => 'Badan Perencanaan Pembangunan Daerah'],
            ['nama_unit_kerja' => 'Dinas Sosial'],
            ['nama_unit_kerja' => 'Dinas Kependudukan dan Pencatatan Sipil'],
            ['nama_unit_kerja' => 'Inspektorat Daerah'],
        ];

        DB::table('unit_kerjas')->insert(array_map(function ($item) {
            return array_merge($item, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $unitKerjas));
    }
}
