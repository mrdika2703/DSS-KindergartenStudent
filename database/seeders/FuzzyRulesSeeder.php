<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Kriteria;
use App\Models\FuzzyAturan;
use Illuminate\Database\Seeder;

class FuzzyRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $c1 = Kriteria::where('kode', 'C1')->first()->id; // Akademik
        $c2 = Kriteria::where('kode', 'C2')->first()->id; // Absensi
        $c3 = Kriteria::where('kode', 'C3')->first()->id; // Capaian
        $c4 = Kriteria::where('kode', 'C4')->first()->id; // Ekstrakurikuler

        // PERBAIKAN: Format kondisi disesuaikan dengan Controller Livewire (Single-Antecedent)
        // Kesimpulan disesuaikan dengan 3 Himpunan Output (Sangat Terampil, Terampil, Cukup Terampil)
        $rules = [
            // --- Aturan Kriteria Akademik (C1) ---
            ['kode' => 'R1',  'kondisi' => ['kriteria_id' => $c1, 'himpunan' => 'Tinggi'], 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R2',  'kondisi' => ['kriteria_id' => $c1, 'himpunan' => 'Sedang'], 'kesimpulan' => 'Terampil'],
            ['kode' => 'R3',  'kondisi' => ['kriteria_id' => $c1, 'himpunan' => 'Rendah'], 'kesimpulan' => 'Cukup Terampil'],

            // --- Aturan Kriteria Absensi (C2) ---
            ['kode' => 'R4',  'kondisi' => ['kriteria_id' => $c2, 'himpunan' => 'Tinggi'], 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R5',  'kondisi' => ['kriteria_id' => $c2, 'himpunan' => 'Sedang'], 'kesimpulan' => 'Terampil'],
            ['kode' => 'R6',  'kondisi' => ['kriteria_id' => $c2, 'himpunan' => 'Rendah'], 'kesimpulan' => 'Cukup Terampil'],

            // --- Aturan Kriteria Capaian (C3) ---
            ['kode' => 'R7',  'kondisi' => ['kriteria_id' => $c3, 'himpunan' => 'Tinggi'], 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R8',  'kondisi' => ['kriteria_id' => $c3, 'himpunan' => 'Sedang'], 'kesimpulan' => 'Terampil'],
            ['kode' => 'R9',  'kondisi' => ['kriteria_id' => $c3, 'himpunan' => 'Rendah'], 'kesimpulan' => 'Cukup Terampil'],

            // --- Aturan Kriteria Ekstrakurikuler (C4) ---
            ['kode' => 'R10', 'kondisi' => ['kriteria_id' => $c4, 'himpunan' => 'Tinggi'], 'kesimpulan' => 'Sangat Terampil'],
            ['kode' => 'R11', 'kondisi' => ['kriteria_id' => $c4, 'himpunan' => 'Sedang'], 'kesimpulan' => 'Terampil'],
            ['kode' => 'R12', 'kondisi' => ['kriteria_id' => $c4, 'himpunan' => 'Rendah'], 'kesimpulan' => 'Cukup Terampil'],
        ];

        foreach ($rules as $r) {
            FuzzyAturan::updateOrCreate(
                // Kriteria pencarian
                ['kode_aturan' => $r['kode']], 
                
                // Data yang akan di-update atau di-insert
                [
                    'kondisi' => $r['kondisi'], // Array ini akan otomatis menjadi JSON jika di model di-cast ke array
                    'kesimpulan' => $r['kesimpulan']
                ]
            );
        }
    }
}