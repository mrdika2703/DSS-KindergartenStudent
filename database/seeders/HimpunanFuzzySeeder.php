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
        \Illuminate\Support\Facades\DB::table('himpunan_fuzzies')->truncate();

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
            // PERBAIKAN: Ekor kurva diperpanjang hingga 100 agar beririsan sempurna
            HimpunanFuzzy::create([
                'kriteria_id' => $k->id,
                'nama_himpunan' => 'Sedang',
                'batas_bawah' => 40,
                'batas_tengah' => 60,
                'batas_atas' => 100,
            ]);

            // Himpunan TINGGI (Kurva Naik)
            // PERBAIKAN: Kurva baru mencapai puncak mutlak di angka 100
            HimpunanFuzzy::create([
                'kriteria_id' => $k->id,
                'nama_himpunan' => 'Tinggi',
                'batas_bawah' => 60,
                'batas_tengah' => 100,
                'batas_atas' => 100,
            ]);
        }
    }
}
