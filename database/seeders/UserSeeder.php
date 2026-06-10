<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $unitKerjaId = 1;

        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@sigala.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'unit_kerja_id' => null,
        ]);

        User::create([
            'name' => 'Operator BRIDA',
            'email' => 'operatorbrida@sigala.com',
            'password' => Hash::make('12345678'),
            'role' => 'operator',
            'unit_kerja_id' => $unitKerjaId,
        ]);

        // 3. Pegawai
        $pegawaiData = [
            ['nama' => 'Ir. BENNY IRAWAN ST., M.T'],
            ['nama' => 'ABDUL KAHIR SE, M.Si'],
            ['nama' => 'RACHMAT RACHMAN S.A.N., M.A.P.'],
            ['nama' => 'MOH. ARIS'],
            ['nama' => 'IDA OKVINITA SH'],
            ['nama' => 'ANITA RACHMASARI S.Sos'],
            ['nama' => 'ANDY CHANDRA KUSUMA ST'],
            ['nama' => 'ABDUR RASYID S.Sos., M.A.P.'],
            ['nama' => 'PYEPIT RINEKSO ANDRIYANTO M.Kom.'],
            ['nama' => 'MOHAMMAD ALFIN WIDYANTO M.Han'],
            ['nama' => 'ABDUL GANI S.A.N'],
            ['nama' => 'MEILANY EKAWATI SE'],
            ['nama' => 'HIKMATUL AMALIYAH ST'],
            ['nama' => 'FATIMAH SALEH SE., M.A.P.'],
            ['nama' => 'SITI MUNAWAROH ST'],
            ['nama' => 'VEBRIANI RETNOSARI A.Md.Keb'],
            ['nama' => 'NUSURI'],
            ['nama' => 'MASRAWI']
        ];

        foreach ($pegawaiData as $p) {
            User::create([
                'name' => $p['nama'],
                'email' => strtolower(str_replace(' ', '', $p['nama'])) . '@sigala.com',
                'password' => Hash::make('12345678'),
                'role' => 'pegawai',
                'unit_kerja_id' => $unitKerjaId,
            ]);
        }
    }
}
