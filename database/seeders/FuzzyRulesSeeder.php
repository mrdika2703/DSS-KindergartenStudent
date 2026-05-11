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

        $rules = [
            [
                'kode' => 'R1',
                'kondisi' => [$c1 => 'Tinggi', $c2 => 'Tinggi', $c3 => 'Tinggi', $c4 => 'Tinggi'],
                'kesimpulan' => 'Sangat Terampil'
            ],
            [
                'kode' => 'R2',
                'kondisi' => [$c1 => 'Tinggi', $c2 => 'Sedang', $c3 => 'Tinggi', $c4 => 'Sedang'],
                'kesimpulan' => 'Sangat Terampil'
            ],
            [
                'kode' => 'R3',
                'kondisi' => [$c1 => 'Sedang', $c2 => 'Tinggi', $c3 => 'Sedang', $c4 => 'Tinggi'],
                'kesimpulan' => 'Terampil'
            ],
            [
                'kode' => 'R4',
                'kondisi' => [$c1 => 'Sedang', $c2 => 'Sedang', $c3 => 'Sedang', $c4 => 'Sedang'],
                'kesimpulan' => 'Terampil'
            ],
            [
                'kode' => 'R5',
                'kondisi' => [$c1 => 'Rendah', $c2 => 'Tinggi', $c3 => 'Rendah', $c4 => 'Tinggi'],
                'kesimpulan' => 'Cukup Terampil'
            ],
            [
                'kode' => 'R6',
                'kondisi' => [$c1 => 'Tinggi', $c2 => 'Rendah', $c3 => 'Tinggi', $c4 => 'Rendah'],
                'kesimpulan' => 'Terampil'
            ],
            [
                'kode' => 'R7',
                'kondisi' => [$c1 => 'Sedang', $c2 => 'Rendah', $c3 => 'Sedang', $c4 => 'Rendah'],
                'kesimpulan' => 'Cukup Terampil'
            ],
            [
                'kode' => 'R8',
                'kondisi' => [$c1 => 'Rendah', $c2 => 'Sedang', $c3 => 'Rendah', $c4 => 'Sedang'],
                'kesimpulan' => 'Kurang Terampil'
            ],
            [
                'kode' => 'R9',
                'kondisi' => [$c1 => 'Rendah', $c2 => 'Rendah', $c3 => 'Rendah', $c4 => 'Rendah'],
                'kesimpulan' => 'Kurang Terampil'
            ],
            [
                'kode' => 'R10',
                'kondisi' => [$c1 => 'Tinggi', $c2 => 'Tinggi', $c3 => 'Sedang', $c4 => 'Sedang'],
                'kesimpulan' => 'Sangat Terampil'
            ],
            [
                'kode' => 'R11',
                'kondisi' => [$c1 => 'Sedang', $c2 => 'Sedang', $c3 => 'Tinggi', $c4 => 'Tinggi'],
                'kesimpulan' => 'Terampil'
            ],
            [
                'kode' => 'R12',
                'kondisi' => [$c1 => 'Rendah', $c2 => 'Tinggi', $c3 => 'Tinggi', $c4 => 'Rendah'],
                'kesimpulan' => 'Cukup Terampil'
            ],
        ];

        foreach ($rules as $r) {
            // Mengganti create() dengan updateOrCreate()
            FuzzyAturan::updateOrCreate(
                // Array pertama: kriteria pencarian (cek apakah kode_aturan ini sudah ada?)
                ['kode_aturan' => $r['kode']], 
                
                // Array kedua: data yang akan di-update (jika sudah ada) atau di-insert (jika belum ada)
                [
                    'kondisi' => $r['kondisi'],
                    'kesimpulan' => $r['kesimpulan']
                ]
            );
        }
    }
}
