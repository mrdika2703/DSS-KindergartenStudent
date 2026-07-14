<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\RaporMentah;
use App\Exports\TemplateDataSiswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
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

    // Konversi Skala Ordinal: mengubah nilai huruf (A/B/C/D) menjadi skala numerik (A=90, B=80, C=60, D=40)
    // agar data kualitatif dari rapor dapat dihitung secara kuantitatif dalam proses DSS
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
        if ($rows->isEmpty()) {
            throw ValidationException::withMessages(['fileExcel' => 'File Excel yang Anda unggah kosong!']);
        }

        // ==========================================
        // 1. VALIDASI HEADER (KOLOM EXCEL)
        // ==========================================
        $template = new TemplateDataSiswa();

        // Ambil header dari template dan ubah ke huruf kecil (karena WithHeadingRow mengubahnya jadi huruf kecil)
        $expectedHeaders = array_map('strtolower', $template->headings());

        // Ambil header dari file yang diupload (diambil dari keys baris pertama)
        $firstRow = $rows->first()->toArray();
        $importedHeaders = array_keys($firstRow);

        // Cek selisih kolom (Apa yang ada di template tapi tidak ada di file upload)
        $missingHeaders = array_diff($expectedHeaders, $importedHeaders);

        if (count($missingHeaders) > 0) {
            // Ambil maksimal 5 nama kolom yang hilang untuk pesan error agar tidak terlalu panjang
            $missingCols = implode(', ', array_slice($missingHeaders, 0, 5));
            throw ValidationException::withMessages([
                'fileExcel' => "Format file tidak sesuai template! Kolom berikut tidak ditemukan atau namanya diubah: {$missingCols}..."
            ]);
        }


        // ==========================================
        // 2. VALIDASI ISI DATA (HANYA BOLEH A, B, C, D)
        // ==========================================
        $validLetters = ['A', 'B', 'C', 'D'];
        $kunciNilaiHuruf = ['db', 'berenang', 'memanah', 'berkebun', 'menyanyi'];

        // Kumpulkan otomatis nama-nama kolom nilai akademik & capaian
        $baseWords = ['agama', 'jati', 'math', 'quran', 'hadist', 'doa', 'p3ra', 'p2ra', 'capaian'];
        foreach ($expectedHeaders as $header) {
            foreach ($baseWords as $base) {
                if (str_starts_with($header, $base)) {
                    $kunciNilaiHuruf[] = $header;
                    break;
                }
            }
        }

        // Loop untuk mengecek setiap baris
        foreach ($rows as $index => $row) {
            $barisExcel = $index + 2; // +2 karena index array mulai dari 0 dan baris 1 adalah Header excel

            if (empty($row['nisn'])) continue;

            foreach ($kunciNilaiHuruf as $kunci) {
                if (isset($row[$kunci]) && trim($row[$kunci]) !== '') {
                    $nilai = strtoupper(trim($row[$kunci]));
                    if (!in_array($nilai, $validLetters)) {
                        throw ValidationException::withMessages([
                            'fileExcel' => "Upload Ditolak! Pada Baris {$barisExcel}, kolom '{$kunci}' berisi nilai '{$row[$kunci]}'. Nilai hanya boleh diisi dengan huruf A, B, C, atau D."
                        ]);
                    }
                }
            }
        }


        // ==========================================
        // 3. EKSEKUSI INSERT DATA (DB Transaction)
        // ==========================================
        $kriteria_c1 = Kriteria::where('kode', 'C1')->first()->id ?? 1;
        $kriteria_c2 = Kriteria::where('kode', 'C2')->first()->id ?? 2;
        $kriteria_c3 = Kriteria::where('kode', 'C3')->first()->id ?? 3;
        $kriteria_c4 = Kriteria::where('kode', 'C4')->first()->id ?? 4;

        DB::beginTransaction();
        try {
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

                // Agregasi Nilai Per Kriteria: mengelompokkan kolom Excel ke 4 kriteria (C1=Akademik, C3=Capaian, C4=Ekstra),
                // mengkonversi huruf ke numerik, lalu menghitung rata-rata sebagai nilai akhir masing-masing kriteria
                $rawAkademik = [];
                $rawAbsensi = [];
                $rawCapaian = [];
                $rawEkstra = [];
                $totAkademik = 0;
                $cntAkademik = 0;
                $totCapaian = 0;
                $cntCapaian = 0;
                $totEkstra = 0;
                $cntEkstra = 0;

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

                // Transformasi Nilai Absensi (C2): nilaiC2 = max(0, 100 - ((S+I+K) × 2))
                // Setiap hari absen mengurangi 2 poin dari nilai sempurna 100, minimum 0
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
                    $kriteria_c1 => $nilaiC1,
                    $kriteria_c2 => $nilaiC2,
                    $kriteria_c3 => $nilaiC3,
                    $kriteria_c4 => $nilaiC4,
                ];

                foreach ($kriteriaValues as $kriteria_id => $nilai_akhir) {
                    Penilaian::updateOrCreate(
                        ['siswa_id' => $siswa->id, 'kriteria_id' => $kriteria_id],
                        ['nilai' => $nilai_akhir]
                    );
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'fileExcel' => 'Terjadi kesalahan sistem saat menyimpan ke Database: ' . $e->getMessage()
            ]);
        }
    }
}
