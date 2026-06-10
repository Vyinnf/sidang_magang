<?php

namespace Database\Seeders\Sidang;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAndPegawaiSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------------
        // Helper: buat NIP PNS / PPPK realistis
        // Format NIP PNS: YYYYMMDD YYYYMM 1/2 XXX  (18 digit)
        // ---------------------------------------------------------------
        $makeNip = function (Carbon $tglLahir, Carbon $tglCpns, string $gender, int $seq): string {
            $genderCode = $gender === 'L' ? '1' : '2';

            return $tglLahir->format('Ymd')
                .$tglCpns->format('Ym')
                .$genderCode
                .str_pad($seq, 3, '0', STR_PAD_LEFT);
        };

        // ---------------------------------------------------------------
        // Data master
        // ---------------------------------------------------------------
        $namaDepanL = ['Agus', 'Budi', 'Deni', 'Eko', 'Fandi', 'Gatot', 'Hendra', 'Irwan',
            'Joko', 'Kurnia', 'Lukman', 'Muhamad', 'Nanda', 'Oki', 'Prayoga',
            'Rendi', 'Samsul', 'Taufiq', 'Ucup', 'Wahyu', 'Yoga', 'Zulfikar'];
        $namaDepanP = ['Ani', 'Bunga', 'Citra', 'Dewi', 'Erna', 'Fitri', 'Gita', 'Hani',
            'Indah', 'Juwita', 'Kartika', 'Lestari', 'Maya', 'Nisa', 'Ovi',
            'Putri', 'Rini', 'Sari', 'Tika', 'Uci', 'Vina', 'Wulandari'];
        $namaBelakang = ['Santoso', 'Prasetyo', 'Wibowo', 'Kusuma', 'Rahayu', 'Susanto',
            'Nugroho', 'Purwanto', 'Hartono', 'Setiawan', 'Purnomo', 'Wijaya',
            'Hidayat', 'Firmansyah', 'Ramadhan', 'Saputra', 'Hakim', 'Basuki',
            'Gunawan', 'Maulana', 'Apriyanto', 'Kurniawan', 'Nurdiana'];
        $tempatLahir = ['Surabaya', 'Jakarta', 'Bandung', 'Semarang', 'Yogyakarta',
            'Malang', 'Madiun', 'Sidoarjo', 'Gresik', 'Blitar',
            'Kediri', 'Mojokerto', 'Pasuruan', 'Probolinggo', 'Jember'];
        $jabatanPns = [
            'Analis Kebijakan', 'Analis Keuangan', 'Analis Kepegawaian',
            'Perencana', 'Pranata Komputer', 'Auditor', 'Pengelola Keuangan',
            'Pengelola BMD', 'Pengawas Sekolah', 'Guru Madya',
            'Dokter Umum', 'Perawat', 'Bidan', 'Apoteker', 'Sanitarian',
            'Arsiparis', 'Pustakawan', 'Statistisi', 'Widyaiswara', 'Penyuluh Pertanian',
        ];
        $jabatanPppk = [
            'Guru PPPK', 'Perawat PPPK', 'Bidan PPPK', 'Dokter PPPK',
            'Pranata Komputer PPPK', 'Analis Kebijakan PPPK',
            'Pengelola Keuangan PPPK', 'Arsiparis PPPK',
        ];

        // Golongan PNS (id 1–17) yang umum dipakai
        $golPnsBawah = [5, 6, 7, 8];   // II/a – II/d   → staf junior
        $golPnsMeneng = [9, 10, 11, 12]; // III/a – III/d → fungsional / eselon IV
        $golPnsAtas = [13, 14, 15];    // IV/a – IV/c   → eselon III/II

        // Golongan PPPK (id 18–34), III setara gol 20
        $golPppk = [20, 21, 22, 23, 24, 25];

        $unitKerjaIds = DB::table('unit_kerjas')->pluck('id')->toArray();

        // ---------------------------------------------------------------
        // 1. Admin (1 akun)
        // ---------------------------------------------------------------
        DB::table('users')->insert([
            'name' => 'Administrator BKD',
            'email' => 'admin@bkd.go.id',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'unit_kerja_id' => 6, // BKD
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ---------------------------------------------------------------
        // 2. Operator per unit kerja (10 orang)
        // ---------------------------------------------------------------
        foreach ($unitKerjaIds as $ukId) {
            DB::table('users')->insert([
                'name' => 'Operator Unit-'.$ukId,
                'email' => 'operator.unit'.$ukId.'@bkd.go.id',
                'password' => Hash::make('12345678'),
                'role' => 'operator',
                'unit_kerja_id' => $ukId,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ---------------------------------------------------------------
        // 3. Pegawai — 50 PNS + 15 PPPK
        // ---------------------------------------------------------------
        $pegawaiData = [];

        // --- 50 PNS ---
        for ($i = 1; $i <= 50; $i++) {
            $gender = ($i % 3 === 0) ? 'P' : 'L';
            $namaList = $gender === 'L' ? $namaDepanL : $namaDepanP;
            $namaD = $namaList[array_rand($namaList)];
            $namaB = $namaBelakang[array_rand($namaBelakang)];
            $nama = $namaD.' '.$namaB;

            $tglLahir = Carbon::now()
                ->subYears(rand(28, 56))
                ->subMonths(rand(0, 11))
                ->subDays(rand(0, 27));

            // CPNS minimal usia 18 dan maks 35
            $usiaCpns = rand(22, 35);
            $tglCpns = $tglLahir->copy()->addYears($usiaCpns)->addMonths(rand(0, 6));
            $masaKerja = Carbon::now()->diffInYears($tglCpns);

            // Tentukan golongan berdasarkan masa kerja
            if ($masaKerja < 6) {
                $golId = $golPnsBawah[array_rand($golPnsBawah)];
            } elseif ($masaKerja < 16) {
                $golId = $golPnsMeneng[array_rand($golPnsMeneng)];
            } else {
                $golId = $golPnsAtas[array_rand($golPnsAtas)];
            }

            // Kenaikan gaji berkala berikutnya (2 tahun sekali)
            $tglGbjTerakhir = $tglCpns->copy()->addYears(floor($masaKerja / 2) * 2);
            $tglGbjBerikut = $tglGbjTerakhir->copy()->addYears(2);

            $email = strtolower(str_replace(' ', '.', $namaD)).$i.'@bkd.go.id';
            $nip = $makeNip($tglLahir, $tglCpns, $gender, $i);

            $pegawaiData[] = [
                'asn' => 'PNS',
                'gender' => $gender,
                'nama' => $nama,
                'email' => $email,
                'nip' => $nip,
                'tglLahir' => $tglLahir,
                'tglCpns' => $tglCpns,
                'masaKerja' => $masaKerja,
                'golId' => $golId,
                'jabatan' => $jabatanPns[array_rand($jabatanPns)],
                'tempatLahir' => $tempatLahir[array_rand($tempatLahir)],
                'unitKerjaId' => $unitKerjaIds[array_rand($unitKerjaIds)],
                'tglGbjBerikut' => $tglGbjBerikut,
                'seq' => $i,
            ];
        }

        // --- 15 PPPK ---
        for ($i = 1; $i <= 15; $i++) {
            $gender = ($i % 2 === 0) ? 'P' : 'L';
            $namaList = $gender === 'L' ? $namaDepanL : $namaDepanP;
            $namaD = $namaList[array_rand($namaList)];
            $namaB = $namaBelakang[array_rand($namaBelakang)];
            $nama = $namaD.' '.$namaB.' (PPPK)';

            $tglLahir = Carbon::now()->subYears(rand(25, 50))->subMonths(rand(0, 11))->subDays(rand(0, 27));
            $tglMasuk = Carbon::now()->subYears(rand(1, 5))->subMonths(rand(0, 11));
            $masaKerja = Carbon::now()->diffInYears($tglMasuk);
            $golId = $golPppk[array_rand($golPppk)];

            $tglGbjBerikut = $tglMasuk->copy()->addYears(($masaKerja + 1) * 2);

            $email = strtolower(str_replace(' ', '.', $namaD)).'pppk'.$i.'@bkd.go.id';
            $nip = $makeNip($tglLahir, $tglMasuk, $gender, 800 + $i);

            $pegawaiData[] = [
                'asn' => 'PPPK',
                'gender' => $gender,
                'nama' => $nama,
                'email' => $email,
                'nip' => $nip,
                'tglLahir' => $tglLahir,
                'tglCpns' => $tglMasuk,
                'masaKerja' => $masaKerja,
                'golId' => $golId,
                'jabatan' => $jabatanPppk[array_rand($jabatanPppk)],
                'tempatLahir' => $tempatLahir[array_rand($tempatLahir)],
                'unitKerjaId' => $unitKerjaIds[array_rand($unitKerjaIds)],
                'tglGbjBerikut' => $tglGbjBerikut,
                'seq' => 800 + $i,
            ];
        }

        // ---------------------------------------------------------------
        // Insert users & pegawais
        // ---------------------------------------------------------------
        foreach ($pegawaiData as $p) {
            $userId = DB::table('users')->insertGetId([
                'name' => $p['nama'],
                'email' => $p['email'],
                'password' => Hash::make('12345678'),
                'role' => 'pegawai',
                'unit_kerja_id' => $p['unitKerjaId'],
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('pegawais')->insert([
                'user_id' => $userId,
                'golongan_id' => $p['golId'],
                'nip' => $p['nip'],
                'asn' => $p['asn'],
                'jabatan' => $p['jabatan'],
                'tempat_lahir' => $p['tempatLahir'],
                'tanggal_lahir' => $p['tglLahir']->toDateString(),
                'tanggal_kenaikan_gaji_berkala_berikutnya' => $p['tglGbjBerikut']->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
