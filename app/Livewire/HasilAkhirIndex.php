<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\AhpBobot;
use App\Models\HimpunanFuzzy;
use App\Models\FuzzyAturan;
use App\Models\HasilAkhir;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Hasil')]
class HasilAkhirIndex extends Component
{
    use WithPagination;
    public $searchSiswa = '';
    public $pilihKelas = '';
    public $pilihTahunAjaran = '';
    public $pilihSemester = '';

    public $filterKelas = '';
    public $filterTahunAjaran = '';
    public $filterSemester = '';

    // Modal Detail
    public $isModalDetailOpen = false;
    public $detailSiswa = null;

    public function updatingSearchSiswa()
    {
        $this->resetPage();
    }

    // --- FUNGSI MATEMATIS FUZZIFIKASI ---
    private function hitungKeanggotaan($x, $himpunan)
    {
        $a = $himpunan->batas_bawah;
        $b = $himpunan->batas_tengah;
        $c = $himpunan->batas_atas;
        $nama = strtolower($himpunan->nama_himpunan);

        // Kurva Turun (Rendah)
        if ($nama == 'rendah') {
            if ($x <= $b) return 1;
            if ($x > $b && $x < $c) return ($c - $x) / ($c - $b);
            return 0;
        }
        // Kurva Segitiga (Sedang)
        elseif ($nama == 'sedang') {
            if ($x <= $a || $x >= $c) return 0;
            if ($x > $a && $x <= $b) return ($x - $a) / ($b - $a);
            if ($x > $b && $x < $c) return ($c - $x) / ($c - $b);
        }
        // Kurva Naik (Tinggi)
        elseif ($nama == 'tinggi') {
            if ($x <= $a) return 0;
            if ($x > $a && $x <= $b) return ($x - $a) / ($b - $a);
            return 1;
        }
        return 0;
    }

    // --- FUNGSI DEFUZZIFIKASI Z (Sesuai Proposal) ---
    private function hitungZRule($alpha, $kesimpulan, $x)
    {
        $kesimpulan = strtolower(trim($kesimpulan));

        if ($kesimpulan == 'sangat terampil') {
            // Sangat Terampil selalu Kurva Naik
            return 80 + ($alpha * 20);
        } elseif ($kesimpulan == 'terampil') {
            // KUNCI PERBAIKAN: Pisahkan lereng agar Z selalu berbanding lurus dengan nilai asli
            if ($x > 60) {
                // Jika x di atas 60 (Lereng Turun pada input Sedang)
                // Maka Output Z harus pakai rumus Kurva Turun (100 ke 60)
                return 100 - ($alpha * 40);
            } else {
                // Jika x di bawah 60 (Lereng Naik pada input Sedang)
                // Maka Output Z pakai rumus Kurva Naik (60 ke 80)
                return 60 + ($alpha * 20);
            }
        } else {
            // Cukup Terampil selalu Kurva Turun
            return 60 - ($alpha * 60);
        }
    }

    // --- EKSEKUSI DSS ---
    public function prosesPerankingan()
    {
        if (empty($this->pilihKelas) || empty($this->pilihTahunAjaran) || empty($this->pilihSemester)) {
            session()->flash('error', 'Pilih Kelas, Tahun Ajaran, dan Semester terlebih dahulu untuk memulai proses!');
            return;
        }

        $bobotAhp = AhpBobot::all()->keyBy('kriteria_id');
        if ($bobotAhp->isEmpty()) {
            session()->flash('error', 'Bobot AHP belum dihitung. Silakan proses AHP terlebih dahulu.');
            return;
        }

        // PENCEGAHAN OVER-SCORE: Hitung total bobot untuk menormalkan AHP (mengatasi pembulatan 1.002)
        $totalBobotAHP = $bobotAhp->sum('bobot_eigen');

        $himpunans = HimpunanFuzzy::all()->groupBy('kriteria_id');
        $aturans = FuzzyAturan::all();

        $siswas = Siswa::with('penilaians')
            ->where('kelas', $this->pilihKelas)
            ->where('tahun_ajaran', $this->pilihTahunAjaran)
            ->where('semester', $this->pilihSemester)
            ->whereHas('penilaians')
            ->get();

        DB::beginTransaction();
        try {
            $siswaIds = $siswas->pluck('id')->toArray();
            HasilAkhir::whereIn('siswa_id', $siswaIds)->delete();

            $hasilList = [];

            foreach ($siswas as $siswa) {
                $rincian_log = [];
                $final_z_score = 0;

                foreach ($siswa->penilaians as $penilaian) {
                    $k_id = $penilaian->kriteria_id;
                    $nilai_x = $penilaian->nilai;

                    // NORMALISASI BOBOT: Memastikan jumlah semua bobot persis 1.0
                    $bobot_mentah = $bobotAhp[$k_id]->bobot_eigen ?? 0;
                    $w_kriteria = $totalBobotAHP > 0 ? ($bobot_mentah / $totalBobotAHP) : 0;

                    $pembilang = 0;
                    $penyebut = 0;
                    $log_kriteria = ['nilai_asli' => $nilai_x, 'bobot_ahp' => $w_kriteria, 'rules' => []];

                    $aturan_kriteria = $aturans->filter(function ($a) use ($k_id) {
                        return isset($a->kondisi['kriteria_id']) && $a->kondisi['kriteria_id'] == $k_id;
                    });

                    foreach ($aturan_kriteria as $rule) {
                        $nama_himp = $rule->kondisi['himpunan'];
                        $himpunan = $himpunans[$k_id]->firstWhere('nama_himpunan', $nama_himp);

                        if ($himpunan) {
                            $alpha = $this->hitungKeanggotaan($nilai_x, $himpunan);

                            // LEMPAR $nilai_x KE DALAM FUNGSI UNTUK MENCEGAH PARADOKS
                            $z_rule = $this->hitungZRule($alpha, $rule->kesimpulan, $nilai_x);

                            $pembilang += ($alpha * $z_rule);
                            $penyebut += $alpha;

                            $log_kriteria['rules'][] = [
                                'kode' => $rule->kode_aturan,
                                'himpunan' => $nama_himp,
                                'alpha' => round($alpha, 4),
                                'z_rule' => round($z_rule, 4),
                                'kesimpulan' => $rule->kesimpulan
                            ];
                        }
                    }

                    $z_kriteria = $penyebut > 0 ? ($pembilang / $penyebut) : 0;
                    $log_kriteria['z_kriteria'] = round($z_kriteria, 4);

                    $rincian_log[$k_id] = $log_kriteria;

                    $final_z_score += ($z_kriteria * $w_kriteria);
                }

                // Capping keamanan agar nilai tidak pernah bocor melampaui 100
                if ($final_z_score > 100) {
                    $final_z_score = 100;
                }

                $status = 'Cukup Terampil';
                if ($final_z_score >= 80) {
                    $status = 'Sangat Terampil';
                } elseif ($final_z_score >= 60) {
                    $status = 'Terampil';
                }

                $hasilList[] = [
                    'siswa_id' => $siswa->id,
                    'total_skor_z' => $final_z_score,
                    'status' => $status,
                    'rincian' => json_encode($rincian_log),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            HasilAkhir::insert($hasilList);

            $hasilTersimpan = HasilAkhir::whereIn('siswa_id', $siswaIds)
                ->orderByDesc('total_skor_z')
                ->get();

            foreach ($hasilTersimpan as $index => $hasil) {
                $hasil->update(['peringkat' => $index + 1]);
            }

            DB::commit();
            session()->flash('pesan', 'Perankingan berhasil dieksekusi menggunakan AHP dan Fuzzy Tsukamoto!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
    public function bukaDetail($siswa_id)
    {
        $this->detailSiswa = HasilAkhir::with('siswa.penilaians.kriteria')->where('siswa_id', $siswa_id)->first();
        $this->isModalDetailOpen = true;
    }

    public function cetakLaporan()
    {
        // 1. Tentukan parameter pencarian (prioritaskan filter, jika kosong gunakan pilihan dropdown)
        $kelas = $this->filterKelas ?: $this->pilihKelas;
        $tahun = $this->filterTahunAjaran ?: $this->pilihTahunAjaran;
        $semester = $this->filterSemester ?: $this->pilihSemester;

        // 2. Validasi: Pastikan parameter tidak kosong
        if (empty($kelas) || empty($tahun) || empty($semester)) {
            session()->flash('error', 'Pilih Kelas, Tahun Ajaran, dan Semester terlebih dahulu sebelum mencetak!');
            return;
        }

        // 3. Validasi Data: Cek apakah hasil akhir sudah ada/dihitung di database
        $dataSudahDihitung = \App\Models\HasilAkhir::whereHas('siswa', function ($query) use ($kelas, $tahun, $semester) {
            $query->where('kelas', $kelas)
                ->where('tahun_ajaran', $tahun)
                ->where('semester', $semester);
        })->exists();

        // Jika belum ada data (belum dihitung), tolak cetak dan tampilkan error
        if (!$dataSudahDihitung) {
            session()->flash('error', 'Data belum dihitung! Silakan klik tombol "Mulai Hitung" terlebih dahulu.');
            return;
        }

        // 4. Jika lolos validasi, buat URL cetak
        $url = route('cetak.hasil', [
            'kelas' => $kelas,
            'tahun' => $tahun,
            'semester' => $semester
        ]);

        // 5. Kirim event ke frontend untuk membuka tab baru
        $this->dispatch('buka-tab-cetak', url: $url);
    }

    public function updatedPilihKelas()
    {
        // Jika Kelas diganti, reset Tahun Ajaran dan Semester
        $this->pilihTahunAjaran = '';
        $this->pilihSemester = '';
    }

    public function updatedPilihTahunAjaran()
    {
        // Jika Tahun Ajaran diganti, reset Semester
        $this->pilihSemester = '';
    }

    // --- FUNGSI RENDER ---
    public function render()
    {
        // 1. Ambil List Kelas (Selalu Tampil Semua)
        $listKelas = Siswa::select('kelas')->whereNotNull('kelas')->distinct()->pluck('kelas');

        // 2. Ambil List Tahun Ajaran (HANYA BERDASARKAN KELAS YANG DIPILIH)
        $listTahun = collect();
        if (!empty($this->pilihKelas)) {
            $listTahun = Siswa::where('kelas', $this->pilihKelas)
                ->select('tahun_ajaran')
                ->whereNotNull('tahun_ajaran')
                ->distinct()
                ->pluck('tahun_ajaran');
        }

        // 3. Ambil List Semester (HANYA BERDASARKAN KELAS & TAHUN AJARAN YANG DIPILIH)
        $listSemester = collect();
        if (!empty($this->pilihKelas) && !empty($this->pilihTahunAjaran)) {
            $listSemester = Siswa::where('kelas', $this->pilihKelas)
                ->where('tahun_ajaran', $this->pilihTahunAjaran)
                ->select('semester')
                ->whereNotNull('semester')
                ->distinct()
                ->pluck('semester');
        }

        // 4. Query Data Tabel Hasil Akhir
        $hasilAkhir = HasilAkhir::with('siswa')
            ->whereHas('siswa', function ($q) {

                // Gunakan properti filter tabel Anda
                if ($this->filterKelas) {
                    $q->where('kelas', $this->filterKelas);
                }
                if ($this->filterTahunAjaran) {
                    $q->where('tahun_ajaran', $this->filterTahunAjaran);
                }
                if ($this->filterSemester) {
                    $q->where('semester', $this->filterSemester);
                }

                if (!empty($this->searchSiswa)) {
                    $q->where(function ($query) {
                        $query->where('nama_siswa', 'like', '%' . $this->searchSiswa . '%')
                            ->orWhere('nis', 'like', '%' . $this->searchSiswa . '%');
                    });
                }
            })
            ->orderBy('total_skor_z', 'desc')
            ->paginate(15);

        return view('livewire.hasil.index', [
            'listKelas' => $listKelas,
            'listTahun' => $listTahun,
            'hasilAkhir' => $hasilAkhir,
            'listSemester' => $listSemester,
        ])->layout('layouts.app');
    }
}
