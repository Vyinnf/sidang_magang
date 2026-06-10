<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    public function run(): void
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
    }
}
