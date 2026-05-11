<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateDataSiswa implements WithHeadings, ShouldAutoSize, WithStyles
{
    public function headings(): array
    {
        // 1. Kolom Dasar
        $columns = ['no', 'nisn', 'nama', 'jk'];

        // 2. Tambahkan kolom dinamis dengan prefix dan range
        $groups = [
            'agama'   => 29,
            'jati'    => 16,
            'math'    => 19,
            'quran'   => 15,
            'hadist'  => 10,
            'doa'     => 20,
            'p3ra'    => 20,
            'p2ra'    => 10,
            'capaian' => 5,
        ];

        foreach ($groups as $prefix => $count) {
            for ($i = 1; $i <= $count; $i++) {
                $columns[] = $prefix . $i;
            }
        }

        // 3. Tambahkan kolom akhir (Absensi & Parameter fisik)
        $trailing = [
            'absensiS', 'absensiI', 'absensiK', 'db', 'berenang', 'memanah', 
            'berkebun', 'menyanyi', 'gizi', 'kepala', 'mata', 'telinga', 
            'hidung', 'mulut', 'kulit', 'kuku', 'badan', 'pakaian', 
            'berat', 'tinggi', 'lingkar'
        ];

        return array_merge($columns, $trailing);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Tebalkan header (baris 1)
            1 => ['font' => ['bold' => true]],
        ];
    }
}