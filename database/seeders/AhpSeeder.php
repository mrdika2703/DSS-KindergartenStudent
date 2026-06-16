<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AhpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kosongkan tabel terlebih dahulu agar tidak terjadi duplikasi data
        DB::table('ahp_matriks')->truncate();
        DB::table('ahp_bobots')->truncate();

        $waktuSekarang = now();

        // 2. Data untuk tabel ahp_matriks (Menggunakan nama kolom yang sesuai)
        $matriks = [
            ['kriteria_1_id' => 1, 'kriteria_2_id' => 2, 'nilai_perbandingan' => 3.0000],
            ['kriteria_1_id' => 1, 'kriteria_2_id' => 3, 'nilai_perbandingan' => 5.0000],
            ['kriteria_1_id' => 1, 'kriteria_2_id' => 4, 'nilai_perbandingan' => 7.0000],
            ['kriteria_1_id' => 2, 'kriteria_2_id' => 3, 'nilai_perbandingan' => 3.0000],
            ['kriteria_1_id' => 2, 'kriteria_2_id' => 4, 'nilai_perbandingan' => 5.0000],
            ['kriteria_1_id' => 3, 'kriteria_2_id' => 4, 'nilai_perbandingan' => 3.0000],
        ];

        $insertMatriks = [];
        foreach ($matriks as $m) {
            $insertMatriks[] = [
                'kriteria_1_id'      => $m['kriteria_1_id'],
                'kriteria_2_id'      => $m['kriteria_2_id'],
                'nilai_perbandingan' => $m['nilai_perbandingan'],
                'created_at'         => $waktuSekarang,
                'updated_at'         => $waktuSekarang,
            ];
        }
        DB::table('ahp_matriks')->insert($insertMatriks);


        // 3. Data untuk tabel ahp_bobots
        $bobots = [
            ['kriteria_id' => 1, 'bobot_eigen' => 0.5590],
            ['kriteria_id' => 2, 'bobot_eigen' => 0.2640],
            ['kriteria_id' => 3, 'bobot_eigen' => 0.1220],
            ['kriteria_id' => 4, 'bobot_eigen' => 0.0570],
        ];

        $insertBobots = [];
        foreach ($bobots as $b) {
            $insertBobots[] = [
                'kriteria_id' => $b['kriteria_id'],
                'bobot_eigen' => $b['bobot_eigen'],
                'created_at'  => $waktuSekarang,
                'updated_at'  => $waktuSekarang,
            ];
        }
        DB::table('ahp_bobots')->insert($insertBobots);
    }
}
