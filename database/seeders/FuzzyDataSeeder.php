<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use App\Models\HimpunanFuzzy;
use App\Models\FuzzyAturan;

class FuzzyDataSeeder extends Seeder
{
    public function run(): void
    {
        $kriterias = Kriteria::all();
        if ($kriterias->count() === 0) {
            $this->command->info('Silakan jalankan KriteriaSeeder terlebih dahulu!');
            return;
        }

        // 1. SEEDING HIMPUNAN KRITERIA (Sesuai Proposal: a, b, c)
        foreach ($kriterias as $k) {
            $himpunan_data = [
                ['nama' => 'Rendah', 'a' => 0,  'b' => 40, 'c' => 60],
                ['nama' => 'Sedang', 'a' => 40, 'b' => 70, 'c' => 90],
                ['nama' => 'Tinggi', 'a' => 80, 'b' => 100, 'c' => 100],
            ];

            foreach ($himpunan_data as $h) {
                HimpunanFuzzy::updateOrCreate(
                    ['kriteria_id' => $k->id, 'nama_himpunan' => $h['nama']],
                    ['batas_bawah' => $h['a'], 'batas_tengah' => $h['b'], 'batas_atas' => $h['c']]
                );
            }
        }

        // 2. SEEDING RULE BASE (12 Aturan)
        $aturan_data = [
            // Akademik (Asumsi C1)
            ['kode' => 'R1', 'kriteria_kode' => 'C1', 'himpunan' => 'Tinggi', 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R2', 'kriteria_kode' => 'C1', 'himpunan' => 'Sedang', 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R3', 'kriteria_kode' => 'C1', 'himpunan' => 'Rendah', 'kesimpulan' => 'Cukup Terampil'],
            // Absensi (Asumsi C2)
            ['kode' => 'R4', 'kriteria_kode' => 'C2', 'himpunan' => 'Tinggi', 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R5', 'kriteria_kode' => 'C2', 'himpunan' => 'Sedang', 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R6', 'kriteria_kode' => 'C2', 'himpunan' => 'Rendah', 'kesimpulan' => 'Cukup Terampil'],
            // Capaian (Asumsi C3)
            ['kode' => 'R7', 'kriteria_kode' => 'C3', 'himpunan' => 'Tinggi', 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R8', 'kriteria_kode' => 'C3', 'himpunan' => 'Sedang', 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R9', 'kriteria_kode' => 'C3', 'himpunan' => 'Rendah', 'kesimpulan' => 'Cukup Terampil'],
            // Ekstrakurikuler (Asumsi C4)
            ['kode' => 'R10', 'kriteria_kode' => 'C4', 'himpunan' => 'Tinggi', 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R11', 'kriteria_kode' => 'C4', 'himpunan' => 'Sedang', 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R12', 'kriteria_kode' => 'C4', 'himpunan' => 'Rendah', 'kesimpulan' => 'Cukup Terampil'],
        ];

        foreach ($aturan_data as $aturan) {
            $kriteria = Kriteria::where('kode', $aturan['kriteria_kode'])->first();
            if ($kriteria) {
                FuzzyAturan::updateOrCreate(
                    ['kode_aturan' => $aturan['kode']],
                    [
                        'kondisi' => ['kriteria_id' => $kriteria->id, 'himpunan' => $aturan['himpunan']],
                        'kesimpulan' => $aturan['kesimpulan']
                    ]
                );
            }
        }
    }
}