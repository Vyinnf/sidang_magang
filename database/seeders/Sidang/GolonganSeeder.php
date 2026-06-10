<?php

namespace Database\Seeders\Sidang;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    public function run(): void
    {
        $golongans = [
            // PNS
            ['golongan' => 'I/a',  'pangkat' => 'Juru Muda',                   'asn' => 'PNS'],
            ['golongan' => 'I/b',  'pangkat' => 'Juru Muda Tingkat I',          'asn' => 'PNS'],
            ['golongan' => 'I/c',  'pangkat' => 'Juru',                         'asn' => 'PNS'],
            ['golongan' => 'I/d',  'pangkat' => 'Juru Tingkat I',               'asn' => 'PNS'],
            ['golongan' => 'II/a', 'pangkat' => 'Pengatur Muda',                'asn' => 'PNS'],
            ['golongan' => 'II/b', 'pangkat' => 'Pengatur Muda Tingkat I',      'asn' => 'PNS'],
            ['golongan' => 'II/c', 'pangkat' => 'Pengatur',                     'asn' => 'PNS'],
            ['golongan' => 'II/d', 'pangkat' => 'Pengatur Tingkat I',           'asn' => 'PNS'],
            ['golongan' => 'III/a', 'pangkat' => 'Penata Muda',                  'asn' => 'PNS'],
            ['golongan' => 'III/b', 'pangkat' => 'Penata Muda Tingkat I',        'asn' => 'PNS'],
            ['golongan' => 'III/c', 'pangkat' => 'Penata',                       'asn' => 'PNS'],
            ['golongan' => 'III/d', 'pangkat' => 'Penata Tingkat I',             'asn' => 'PNS'],
            ['golongan' => 'IV/a', 'pangkat' => 'Pembina',                      'asn' => 'PNS'],
            ['golongan' => 'IV/b', 'pangkat' => 'Pembina Tingkat I',            'asn' => 'PNS'],
            ['golongan' => 'IV/c', 'pangkat' => 'Pembina Utama Muda',           'asn' => 'PNS'],
            ['golongan' => 'IV/d', 'pangkat' => 'Pembina Utama Madya',          'asn' => 'PNS'],
            ['golongan' => 'IV/e', 'pangkat' => 'Pembina Utama',                'asn' => 'PNS'],

            // PPPK
            ['golongan' => 'I',    'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'II',   'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'III',  'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'IV',   'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'V',    'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'VI',   'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'VII',  'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'VIII', 'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'IX',   'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'X',    'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'XI',   'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'XII',  'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'XIII', 'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'XIV',  'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'XV',   'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'XVI',  'pangkat' => null,  'asn' => 'PPPK'],
            ['golongan' => 'XVII', 'pangkat' => null,  'asn' => 'PPPK'],
        ];

        DB::table('golongans')->insert(array_map(function ($item) {
            return array_merge($item, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $golongans));
    }
}
