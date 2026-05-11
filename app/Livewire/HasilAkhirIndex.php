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

class HasilAkhirIndex extends Component
{
    use WithPagination;
    public $searchSiswa = '';
    public $filterKelas = '';
    public $filterTahunAjaran = '';
    
    // Modal Detail
    public $isModalDetailOpen = false;
    public $detailSiswa = null;

    public function updatingSearchSiswa() { $this->resetPage(); }

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
    private function hitungZRule($alpha, $kesimpulan)
    {
        // Sangat Terampil: a=60, b=100 (Kurva Naik) => Z = a + alpha*(b-a)
        if (strtolower($kesimpulan) == 'sangat terampil') {
            return 60 + ($alpha * 40);
        }
        // Cukup Terampil: a=0, b=60 (Kurva Turun) => Z = b - alpha*(b-a)
        else {
            return 60 - ($alpha * 60);
        }
    }

    // --- EKSEKUSI DSS ---
    public function prosesPerankingan()
    {
        if (empty($this->filterKelas) || empty($this->filterTahunAjaran)) {
            session()->flash('error', 'Pilih Kelas dan Tahun Ajaran terlebih dahulu untuk memulai proses!');
            return;
        }

        $bobotAhp = AhpBobot::all()->keyBy('kriteria_id');
        if ($bobotAhp->isEmpty()) {
            session()->flash('error', 'Bobot AHP belum dihitung. Silakan proses AHP terlebih dahulu.');
            return;
        }

        $himpunans = HimpunanFuzzy::all()->groupBy('kriteria_id');
        $aturans = FuzzyAturan::all();

        $siswas = Siswa::with('penilaians')
            ->where('kelas', $this->filterKelas)
            ->where('tahun_ajaran', $this->filterTahunAjaran)
            ->whereHas('penilaians') // Hanya yang sudah dinilai
            ->get();

        DB::beginTransaction();
        try {
            // Hapus hasil lama untuk kelas & tahun ajaran ini
            $siswaIds = $siswas->pluck('id')->toArray();
            HasilAkhir::whereIn('siswa_id', $siswaIds)->delete();

            $hasilList = [];

            foreach ($siswas as $siswa) {
                $rincian_log = [];
                $final_z_score = 0;

                // Loop setiap kriteria untuk mengevaluasi aturan (Single-Antecedent)
                foreach ($siswa->penilaians as $penilaian) {
                    $k_id = $penilaian->kriteria_id;
                    $nilai_x = $penilaian->nilai;
                    $w_kriteria = $bobotAhp[$k_id]->bobot_eigen ?? 0;

                    $pembilang = 0; // Sum (alpha * z)
                    $penyebut = 0;  // Sum (alpha)
                    $log_kriteria = ['nilai_asli' => $nilai_x, 'bobot_ahp' => $w_kriteria, 'rules' => []];

                    // Cari aturan yang berkaitan dengan kriteria ini
                    $aturan_kriteria = $aturans->filter(function($a) use ($k_id) {
                        return isset($a->kondisi['kriteria_id']) && $a->kondisi['kriteria_id'] == $k_id;
                    });

                    foreach ($aturan_kriteria as $rule) {
                        $nama_himp = $rule->kondisi['himpunan'];
                        $himpunan = $himpunans[$k_id]->firstWhere('nama_himpunan', $nama_himp);
                        
                        if ($himpunan) {
                            $alpha = $this->hitungKeanggotaan($nilai_x, $himpunan);
                            $z_rule = $this->hitungZRule($alpha, $rule->kesimpulan);
                            
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

                    // Z Parsial per Kriteria
                    $z_kriteria = $penyebut > 0 ? ($pembilang / $penyebut) : 0;
                    $log_kriteria['z_kriteria'] = round($z_kriteria, 4);
                    
                    $rincian_log[$k_id] = $log_kriteria;

                    // Weighted Sum Aggregation (Z_kriteria * Bobot_AHP)
                    $final_z_score += ($z_kriteria * $w_kriteria);
                }

                // Tentukan Status (Misal: >= 80 Sangat Terampil, >=60 Terampil, <60 Kurang)
                $status = 'Kurang Terampil';
                if ($final_z_score >= 80) $status = 'Sangat Terampil';
                elseif ($final_z_score >= 60) $status = 'Cukup Terampil';

                $hasilList[] = [
                    'siswa_id' => $siswa->id,
                    'total_skor_z' => $final_z_score,
                    'status' => $status,
                    'rincian' => json_encode($rincian_log),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Insert data baru
            HasilAkhir::insert($hasilList);

            // Update Peringkat
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

    public function render()
    {
        $listKelas = Siswa::select('kelas')->whereNotNull('kelas')->distinct()->pluck('kelas');
        $listTahun = Siswa::select('tahun_ajaran')->whereNotNull('tahun_ajaran')->distinct()->pluck('tahun_ajaran');

        $hasilAkhir = HasilAkhir::with('siswa')
            ->whereHas('siswa', function($q) {
                // 1. Filter Kelas
                if ($this->filterKelas) {
                    $q->where('kelas', $this->filterKelas);
                }
                
                // 2. Filter Tahun Ajaran
                if ($this->filterTahunAjaran) {
                    $q->where('tahun_ajaran', $this->filterTahunAjaran);
                }

                // 3. Filter Pencarian (Search)
                if (!empty($this->searchSiswa)) {
                    $q->where(function($query) {
                        $query->where('nama_siswa', 'like', '%' . $this->searchSiswa . '%')
                              ->orWhere('nis', 'like', '%' . $this->searchSiswa . '%');
                    });
                }
            })
            ->orderBy('total_skor_z', 'desc')
            ->paginate(15);

        return view('livewire.hasil-akhir-index', [
            'listKelas' => $listKelas,
            'listTahun' => $listTahun,
            'hasilAkhir' => $hasilAkhir
        ])->layout('layouts.app');
    }
}