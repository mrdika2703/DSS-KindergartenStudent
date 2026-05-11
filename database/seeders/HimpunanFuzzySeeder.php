<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use App\Models\HimpunanFuzzy;

class HimpunanFuzzySeeder extends Seeder
{
    public function run(): void
    {
        $kriterias = Kriteria::all();

        foreach ($kriterias as $k) {
            // Himpunan RENDAH (Kurva Turun)
            HimpunanFuzzy::create([
                'kriteria_id' => $k->id,
                'nama_himpunan' => 'Rendah',
                'batas_bawah' => 0,
                'batas_tengah' => 40,
                'batas_atas' => 60,
            ]);

            // Himpunan SEDANG (Kurva Segitiga)
            HimpunanFuzzy::create([
                'kriteria_id' => $k->id,
                'nama_himpunan' => 'Sedang',
                'batas_bawah' => 50,
                'batas_tengah' => 70,
                'batas_atas' => 85,
            ]);

            // Himpunan TINGGI (Kurva Naik)
            HimpunanFuzzy::create([
                'kriteria_id' => $k->id,
                'nama_himpunan' => 'Tinggi',
                'batas_bawah' => 80,
                'batas_tengah' => 90,
                'batas_atas' => 100,
            ]);
        }
    }
}