<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kriteria;
use App\Models\HimpunanFuzzy;
use App\Models\FuzzyAturan;
use Livewire\Attributes\Title;

#[Title('Fuzzy')]
class FuzzyConfig extends Component
{
    public $tabAktif = 'himpunan';
    public $kriterias;

    // --- State Himpunan Fuzzy ---
    public $isModalHimpunanOpen = false;
    public $himpunan_id, $himpunan_kriteria_nama, $nama_himpunan;
    public $batas_bawah, $batas_tengah, $batas_atas;

    // --- State Rule Base (Aturan Tunggal) ---
    public $isModalAturanOpen = false;
    public $aturan_id, $kode_aturan, $kesimpulan;
    public $aturan_kriteria_id = '';
    public $aturan_himpunan = '';

    public function mount()
    {
        $this->kriterias = Kriteria::all();
    }

    public function switchTab($tab)
    {
        $this->tabAktif = $tab;
    }

    // ==========================================
    // LOGIKA HIMPUNAN & KURVA FUZZY
    // ==========================================
    public function editHimpunan($id)
    {
        $himpunan = HimpunanFuzzy::with('kriteria')->findOrFail($id);
        $this->himpunan_id = $himpunan->id;
        $this->himpunan_kriteria_nama = $himpunan->kriteria->nama_kriteria;
        $this->nama_himpunan = $himpunan->nama_himpunan;
        $this->batas_bawah = $himpunan->batas_bawah;
        $this->batas_tengah = $himpunan->batas_tengah;
        $this->batas_atas = $himpunan->batas_atas;
        
        $this->isModalHimpunanOpen = true;
    }

    public function simpanHimpunan()
    {
        $this->validate([
            'batas_bawah' => 'required|numeric',
            'batas_tengah' => 'nullable|numeric',
            'batas_atas' => 'required|numeric',
        ]);

        HimpunanFuzzy::where('id', $this->himpunan_id)->update([
            'batas_bawah' => $this->batas_bawah,
            'batas_tengah' => $this->batas_tengah,
            'batas_atas' => $this->batas_atas,
        ]);

        session()->flash('pesan', 'Batas kurva himpunan berhasil diperbarui!');
        $this->isModalHimpunanOpen = false;
    }

    // ==========================================
    // LOGIKA RULE BASE (ATURAN TUNGGAL)
    // ==========================================
    public function bukaModalAturan($id = null)
    {
        $this->resetAturanFields();

        if ($id) {
            $aturan = FuzzyAturan::findOrFail($id);
            $this->aturan_id = $aturan->id;
            $this->kode_aturan = $aturan->kode_aturan;
            $this->kesimpulan = $aturan->kesimpulan;
            
            // Ekstrak data dari JSON
            $this->aturan_kriteria_id = $aturan->kondisi['kriteria_id'] ?? '';
            $this->aturan_himpunan = $aturan->kondisi['himpunan'] ?? '';
        }

        $this->isModalAturanOpen = true;
    }

    private function resetAturanFields()
    {
        $this->aturan_id = null;
        $this->kode_aturan = '';
        $this->kesimpulan = '';
        $this->aturan_kriteria_id = '';
        $this->aturan_himpunan = '';
    }

    public function simpanAturan()
    {
        $this->validate([
            'kode_aturan' => 'required|unique:fuzzy_aturans,kode_aturan,' . $this->aturan_id,
            'aturan_kriteria_id' => 'required',
            'aturan_himpunan' => 'required',
            'kesimpulan' => 'required|string',
        ]);

        // Format ulang menjadi JSON untuk disimpan ke database
        $kondisi_json = [
            'kriteria_id' => $this->aturan_kriteria_id,
            'himpunan' => $this->aturan_himpunan
        ];

        FuzzyAturan::updateOrCreate(
            ['id' => $this->aturan_id],
            [
                'kode_aturan' => $this->kode_aturan,
                'kondisi' => $kondisi_json,
                'kesimpulan' => $this->kesimpulan
            ]
        );

        session()->flash('pesan', 'Aturan Fuzzy berhasil disimpan!');
        $this->isModalAturanOpen = false;
    }

    public function hapusAturan($id)
    {
        FuzzyAturan::findOrFail($id)->delete();
        session()->flash('pesan', 'Aturan berhasil dihapus!');
    }

    public function render()
    {
        $dataHimpunan = HimpunanFuzzy::with('kriteria')
                        ->orderBy('kriteria_id')
                        ->orderBy('batas_bawah')
                        ->get();
                        
        // Menampilkan data dan merelasikan manual dari kolom JSON
        $dataAturan = FuzzyAturan::orderBy('kode_aturan')->get()->map(function($aturan) {
            $krit_id = $aturan->kondisi['kriteria_id'] ?? null;
            $aturan->nama_kriteria = $this->kriterias->firstWhere('id', $krit_id)->nama_kriteria ?? 'Kriteria Dihapus';
            $aturan->nama_himpunan = $aturan->kondisi['himpunan'] ?? '-';
            return $aturan;
        });

        return view('livewire.fuzzy.index', [
            'dataHimpunan' => $dataHimpunan,
            'dataAturan' => $dataAturan,
        ])->layout('layouts.app');
    }
}
