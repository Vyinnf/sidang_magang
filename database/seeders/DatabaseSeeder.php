<?php

namespace Database\Seeders;

use Database\Seeders\Sidang\GajiSeeder;
use Database\Seeders\Sidang\GolonganSeeder;
use Database\Seeders\Sidang\RiwayatGbkSeeder;
use Database\Seeders\Sidang\RiwayatKenaikanPangkatSeeder;
use Database\Seeders\Sidang\SkCpnsPppkSeeder;
use Database\Seeders\Sidang\UnitKerjaSeeder;
use Database\Seeders\Sidang\UserAndPegawaiSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UnitKerjaSeeder::class,
            GolonganSeeder::class,
            GajiSeeder::class,
            UserAndPegawaiSeeder::class,
            RiwayatGbkSeeder::class,
            RiwayatKenaikanPangkatSeeder::class,
            SkCpnsPppkSeeder::class,
        ]);
    }
}
