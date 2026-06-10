<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            // PPPK
            ['golongan' => 'I', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'II', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'III', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'IV', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'V', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'VI', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'VII', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'VIII', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'IX', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'X', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'XI', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'XII', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'XIII', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'XIV', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'XV', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'XVI', 'pangkat' => null, 'asn' => 'PPPK'],
            ['golongan' => 'XVII', 'pangkat' => null, 'asn' => 'PPPK'],

            // PNS
            ['golongan' => 'I/a', 'pangkat' => 'Juru Muda', 'asn' => 'PNS'],
            ['golongan' => 'I/b', 'pangkat' => 'Juru Muda Tk I', 'asn' => 'PNS'],
            ['golongan' => 'I/c', 'pangkat' => 'Juru', 'asn' => 'PNS'],
            ['golongan' => 'I/d', 'pangkat' => 'Juru Tk I', 'asn' => 'PNS'],

            ['golongan' => 'II/a', 'pangkat' => 'Pengatur Muda', 'asn' => 'PNS'],
            ['golongan' => 'II/b', 'pangkat' => 'Pengatur Muda Tk I', 'asn' => 'PNS'],
            ['golongan' => 'II/c', 'pangkat' => 'Pengatur', 'asn' => 'PNS'],
            ['golongan' => 'II/d', 'pangkat' => 'Pengatur Tk I', 'asn' => 'PNS'],

            ['golongan' => 'III/a', 'pangkat' => 'Penata Muda', 'asn' => 'PNS'],
            ['golongan' => 'III/b', 'pangkat' => 'Penata Muda Tk I', 'asn' => 'PNS'],
            ['golongan' => 'III/c', 'pangkat' => 'Penata', 'asn' => 'PNS'],
            ['golongan' => 'III/d', 'pangkat' => 'Penata Tk I', 'asn' => 'PNS'],

            ['golongan' => 'IV/a', 'pangkat' => 'Pembina', 'asn' => 'PNS'],
            ['golongan' => 'IV/b', 'pangkat' => 'Pembina Tk I', 'asn' => 'PNS'],
            ['golongan' => 'IV/c', 'pangkat' => 'Pembina Utama Muda', 'asn' => 'PNS'],
            ['golongan' => 'IV/d', 'pangkat' => 'Pembina Utama Madya', 'asn' => 'PNS'],
            ['golongan' => 'IV/e', 'pangkat' => 'Pembina Utama', 'asn' => 'PNS'],
        ];

        foreach ($data as &$row) {
            $row['created_at'] = now();
            $row['updated_at'] = now();
        }

        DB::table('golongans')->insert($data);
    }
}
