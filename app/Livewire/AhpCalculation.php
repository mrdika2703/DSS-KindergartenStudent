<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kriteria;
use App\Models\AhpBobot;
use App\Models\AhpMatriks;
use Livewire\Attributes\Title;

#[Title('AHP')]
class AhpCalculation extends Component
{
    public $kriterias = [];
    public $inputMatriks = []; // Menyimpan inputan user (Skala 1-9)
    
    // Hasil Perhitungan
    public $matriksAwal = [];
    public $jumlahKolom = [];
    public $matriksNormalisasi = [];
    public $bobotEigen = [];
    public $lambdaMax = 0;
    public $ci = 0;
    public $cr = 0;
    
    public $sudahDihitung = false;
    public $isKonsisten = false;

    public function mount()
    {
        $this->kriterias = Kriteria::all();
        $savedMatriks = AhpMatriks::all();
        
        if ($savedMatriks->isNotEmpty()) {
            // Jika ada data di database, muat ke dalam inputan
            foreach ($savedMatriks as $matriks) {
                $this->inputMatriks[$matriks->kriteria_1_id][$matriks->kriteria_2_id] = $matriks->nilai_perbandingan;
            }
            // Langsung eksekusi perhitungan agar hasil tampil di layar
            $this->hitungBobot();
        } else {
            // Inisialisasi default matriks input (1 = Sama Penting) jika database kosong
            foreach ($this->kriterias as $i => $k1) {
                foreach ($this->kriterias as $j => $k2) {
                    if ($i < $j) {
                        $this->inputMatriks[$k1->id][$k2->id] = 1;
                    }
                }
            }
        }
    }

    public function hitungBobot1()
    {
        $n = count($this->kriterias);
        if ($n < 3) {
            session()->flash('error', 'Minimal harus ada 3 kriteria untuk perhitungan AHP.');
            return;
        }

        $this->matriksAwal = [];
        $this->jumlahKolom = [];

        foreach ($this->kriterias as $k) {
            $this->jumlahKolom[$k->id] = 0;
        }

        // Mulai perhitungan matriks
        foreach ($this->kriterias as $k1) {
            foreach ($this->kriterias as $k2) {
                if ($k1->id == $k2->id) {
                    $nilai = 1; // Diagonal selalu 1
                } elseif (isset($this->inputMatriks[$k1->id][$k2->id]) && $this->inputMatriks[$k1->id][$k2->id] != '') {
                    $nilai = (float) $this->inputMatriks[$k1->id][$k2->id];
                } elseif (isset($this->inputMatriks[$k2->id][$k1->id]) && $this->inputMatriks[$k2->id][$k1->id] != '') {
                    $val_kebalikan = (float) $this->inputMatriks[$k2->id][$k1->id];
                    // PERBAIKAN: Mencegah error pembagian dengan 0
                    $nilai = $val_kebalikan > 0 ? (1 / $val_kebalikan) : 1; 
                } else {
                    $nilai = 1; // Fallback aman
                }
                
                $this->matriksAwal[$k1->id][$k2->id] = $nilai;
                $this->jumlahKolom[$k2->id] += $nilai;
            }
        }

        $this->matriksNormalisasi = [];
        $this->bobotEigen = [];

        foreach ($this->kriterias as $k1) {
            $totalBaris = 0;
            foreach ($this->kriterias as $k2) {
                // PERBAIKAN: Mencegah division by zero jika jumlah kolom 0
                $jKolom = $this->jumlahKolom[$k2->id] > 0 ? $this->jumlahKolom[$k2->id] : 1;
                $nilaiNormalisasi = $this->matriksAwal[$k1->id][$k2->id] / $jKolom;
                $this->matriksNormalisasi[$k1->id][$k2->id] = $nilaiNormalisasi;
                $totalBaris += $nilaiNormalisasi;
            }
            $this->bobotEigen[$k1->id] = $totalBaris / $n;
        }

        $this->lambdaMax = 0;
        foreach ($this->kriterias as $k) {
            $this->lambdaMax += $this->jumlahKolom[$k->id] * $this->bobotEigen[$k->id];
        }

        $this->ci = ($this->lambdaMax - $n) / ($n - 1);
        
        $ri_table = [1 => 0.00, 2 => 0.00, 3 => 0.58, 4 => 0.90, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45];
        $ri = $ri_table[$n] ?? 1.49;

        // PERBAIKAN: Mencegah error jika RI 0
        $this->cr = $ri > 0 ? ($this->ci / $ri) : 0; 
        $this->isKonsisten = $this->cr <= 0.1;
        $this->sudahDihitung = true;

        if ($this->isKonsisten) {
            $this->simpanKeDatabase();
        }
    }

    public function hitungBobot()
    {
        $n = count($this->kriterias);
        if ($n < 3) {
            session()->flash('error', 'Minimal harus ada 3 kriteria untuk perhitungan AHP.');
            return;
        }

        // 1. Membentuk Matriks Perbandingan Awal
        $this->matriksAwal = [];
        $this->jumlahKolom = [];

        foreach ($this->kriterias as $k) {
            $this->jumlahKolom[$k->id] = 0;
        }

        foreach ($this->kriterias as $k1) {
            foreach ($this->kriterias as $k2) {
                if ($k1->id == $k2->id) {
                    $nilai = 1;
                } elseif (isset($this->inputMatriks[$k1->id][$k2->id]) && $this->inputMatriks[$k1->id][$k2->id] != '') {
                    $nilai = (float) $this->inputMatriks[$k1->id][$k2->id];
                } elseif (isset($this->inputMatriks[$k2->id][$k1->id]) && $this->inputMatriks[$k2->id][$k1->id] != '') {
                    $val_kebalikan = (float) $this->inputMatriks[$k2->id][$k1->id];
                    $nilai = $val_kebalikan > 0 ? (1 / $val_kebalikan) : 1; 
                } else {
                    $nilai = 1;
                }
                
                // PERBAIKAN 1: Bulatkan nilai matriks 2 angka di belakang koma (Sesuai Proposal: 0.33, 0.20, 0.14)
                $nilai_bulat = round($nilai, 2);
                
                $this->matriksAwal[$k1->id][$k2->id] = $nilai_bulat;
                $this->jumlahKolom[$k2->id] += $nilai_bulat;
            }
        }

        // 2. Normalisasi Matriks & Menghitung Bobot Prioritas (W)
        $this->matriksNormalisasi = [];
        $this->bobotEigen = [];

        foreach ($this->kriterias as $k1) {
            $totalBaris = 0;
            foreach ($this->kriterias as $k2) {
                $jKolom = $this->jumlahKolom[$k2->id] > 0 ? $this->jumlahKolom[$k2->id] : 1;
                
                // PERBAIKAN 2: Bulatkan hasil bagi menjadi 3 angka di belakang koma
                $nilaiNormalisasi = round($this->matriksAwal[$k1->id][$k2->id] / $jKolom, 3);
                $this->matriksNormalisasi[$k1->id][$k2->id] = $nilaiNormalisasi;
                $totalBaris += $nilaiNormalisasi;
            }
            // PERBAIKAN 3: Bulatkan Rata-rata Bobot Prioritas (W) menjadi 3 angka
            $this->bobotEigen[$k1->id] = round($totalBaris / $n, 3);
        }

        // 3. Menghitung Rasio Konsistensi (CR) sesuai gaya Proposal (Lewat WSV)
        $this->lambdaMax = 0;
        
        foreach ($this->kriterias as $k1) {
            $wsv = 0;
            foreach ($this->kriterias as $k2) {
                // Menghitung Weighted Sum Vector (WSV)
                $wsv += $this->matriksAwal[$k1->id][$k2->id] * $this->bobotEigen[$k2->id];
            }
            $wsv = round($wsv, 3); // Pembulatan WSV
            
            // Lambda (λi) = WSV / Bobot Eigen
            $lambda_i = round($wsv / $this->bobotEigen[$k1->id], 3);
            $this->lambdaMax += $lambda_i;
        }

        // Lambda Max = Rata-rata dari semua Lambda_i
        $this->lambdaMax = round($this->lambdaMax / $n, 3);

        // Menghitung CI dengan pembulatan 3 angka
        $this->ci = round(($this->lambdaMax - $n) / ($n - 1), 3);
        
        $ri_table = [1 => 0.00, 2 => 0.00, 3 => 0.58, 4 => 0.90, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45];
        $ri = $ri_table[$n] ?? 1.49;

        // Menghitung Final CR dengan pembulatan 3 angka (Agar dapat 0.039)
        $this->cr = $ri > 0 ? round($this->ci / $ri, 3) : 0; 
        
        $this->isKonsisten = $this->cr <= 0.1;
        $this->sudahDihitung = true;

        // 4. Jika Konsisten, Simpan
        if ($this->isKonsisten) {
            $this->simpanKeDatabase();
        }
    }

    private function simpanKeDatabase()
    {
        // Simpan Bobot Akhir
        foreach ($this->bobotEigen as $kriteria_id => $bobot) {
            AhpBobot::updateOrCreate(
                ['kriteria_id' => $kriteria_id],
                ['bobot_eigen' => $bobot]
            );
        }

        // Simpan Matriks Input (Opsional, berguna untuk history)
        foreach ($this->kriterias as $i => $k1) {
            foreach ($this->kriterias as $j => $k2) {
                if ($i < $j) {
                    AhpMatriks::updateOrCreate(
                        ['kriteria_1_id' => $k1->id, 'kriteria_2_id' => $k2->id],
                        ['nilai_perbandingan' => $this->inputMatriks[$k1->id][$k2->id]]
                    );
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.ahp.index')->layout('layouts.app');
    }
}
