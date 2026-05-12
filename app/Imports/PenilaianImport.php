<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\RaporMentah;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenilaianImport implements ToCollection, WithHeadingRow
{
    protected $kelas;
    protected $tahun_ajaran;
    protected $semester;

    public function __construct($kelas, $tahun_ajaran, $semester)
    {
        $this->kelas = $kelas;
        $this->tahun_ajaran = $tahun_ajaran;
        $this->semester = $semester;
    }

    private function konversiHuruf($huruf)
    {
        $huruf = strtoupper(trim($huruf));
        if ($huruf == 'A') return 90;
        if ($huruf == 'B') return 80;
        if ($huruf == 'C') return 60;
        if ($huruf == 'D') return 40;
        return 0;
    }

    public function collection(Collection $rows)
    {
        $kriteria_c1 = Kriteria::where('kode', 'C1')->first()->id ?? 1;
        $kriteria_c2 = Kriteria::where('kode', 'C2')->first()->id ?? 2;
        $kriteria_c3 = Kriteria::where('kode', 'C3')->first()->id ?? 3;
        $kriteria_c4 = Kriteria::where('kode', 'C4')->first()->id ?? 4;

        foreach ($rows as $row) {
            if (!isset($row['nisn'])) continue;

            $siswa = Siswa::updateOrCreate(
                [
                    'nis' => $row['nisn'],
                    'tahun_ajaran' => $this->tahun_ajaran,
                    'semester' => $this->semester
                ],
                [
                    'nama_siswa' => strtoupper($row['nama']),
                    'jenis_kelamin' => (strpos(strtolower($row['jk']), 'laki') !== false) ? 'L' : 'P',
                    'kelas' => $this->kelas
                ]
            );

            $rawAkademik = []; $rawAbsensi = []; $rawCapaian = []; $rawEkstra = [];
            $totAkademik = 0; $cntAkademik = 0;
            $totCapaian = 0; $cntCapaian = 0;
            $totEkstra = 0; $cntEkstra = 0;

            foreach ($row as $key => $value) {
                $kunciAkademik = ['agama', 'jati', 'math', 'quran', 'hadist', 'doa', 'p3ra', 'p2ra'];
                foreach ($kunciAkademik as $kunci) {
                    if (str_starts_with($key, $kunci)) {
                        $rawAkademik[$key] = $value; 
                        if (!empty($value)) {
                            $totAkademik += $this->konversiHuruf($value);
                            $cntAkademik++;
                        }
                        break;
                    }
                }
                
                if (str_starts_with($key, 'capaian')) {
                    $rawCapaian[$key] = $value;
                    if (!empty($value)) {
                        $totCapaian += $this->konversiHuruf($value);
                        $cntCapaian++;
                    }
                }
                
                if (in_array($key, ['db', 'berenang', 'memanah', 'berkebun', 'menyanyi'])) {
                    $rawEkstra[$key] = $value;
                    if (!empty($value)) {
                        $totEkstra += $this->konversiHuruf($value);
                        $cntEkstra++;
                    }
                }
            }

            $s = (int) ($row['absensis'] ?? 0);
            $i = (int) ($row['absensii'] ?? 0);
            $k = (int) ($row['absensik'] ?? 0);
            $rawAbsensi = ['sakit' => $s, 'izin' => $i, 'alpa' => $k];

            RaporMentah::updateOrCreate(
                ['siswa_id' => $siswa->id],
                [
                    'data_akademik' => $rawAkademik,
                    'data_absensi' => $rawAbsensi,
                    'data_capaian' => $rawCapaian,
                    'data_ekstra' => $rawEkstra,
                ]
            );

            $nilaiC1 = $cntAkademik > 0 ? ($totAkademik / $cntAkademik) : 0;
            $nilaiC2 = max(0, 100 - (($s + $i + $k) * 2));
            $nilaiC3 = $cntCapaian > 0 ? ($totCapaian / $cntCapaian) : 0;
            $nilaiC4 = $cntEkstra > 0 ? ($totEkstra / $cntEkstra) : 0;

            $kriteriaValues = [
                $kriteria_c1 => $nilaiC1, $kriteria_c2 => $nilaiC2, 
                $kriteria_c3 => $nilaiC3, $kriteria_c4 => $nilaiC4,
            ];

            foreach ($kriteriaValues as $kriteria_id => $nilai_akhir) {
                Penilaian::updateOrCreate(
                    ['siswa_id' => $siswa->id, 'kriteria_id' => $kriteria_id],
                    ['nilai' => $nilai_akhir]
                );
            }
        }
    }
}