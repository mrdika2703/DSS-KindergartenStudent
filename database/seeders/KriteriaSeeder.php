<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriteria = [
            [
                'kode' => 'C1',
                'nama_kriteria' => 'Akademik',
            ],
            [
                'kode' => 'C2',
                'nama_kriteria' => 'Absensi',
            ],
            [
                'kode' => 'C3',
                'nama_kriteria' => 'Capaian Perkembangan',
            ],
            [
                'kode' => 'C4',
                'nama_kriteria' => 'Ekstrakurikuler',
            ],
        ];

        foreach ($kriteria as $data) {
            Kriteria::updateOrCreate(
                ['kode' => $data['kode']], // Cek agar tidak terjadi duplikat jika di-run 2x
                ['nama_kriteria' => $data['nama_kriteria']]
            );
        }
    }
}
