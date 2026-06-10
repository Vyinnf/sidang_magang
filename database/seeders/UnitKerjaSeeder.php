<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('unit_kerjas')->insert([
            'nama_unit_kerja' => 'Badan Riset dan Inovasi Daerah Kabupaten Sumenep',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
