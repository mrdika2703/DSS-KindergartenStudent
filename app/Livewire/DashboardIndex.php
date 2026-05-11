<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\AhpBobot;
use App\Models\HasilAkhir;
use Livewire\Attributes\Title;

#[Title('Dashboard')]
class DashboardIndex extends Component
{
    public $filterKelas = '';
    public $filterTahunAjaran = '';

    public function render()
    {
        // 1. Ambil daftar dropdown dinamis
        $listKelas = Siswa::select('kelas')->whereNotNull('kelas')->distinct()->pluck('kelas');
        $listTahun = Siswa::select('tahun_ajaran')->whereNotNull('tahun_ajaran')->distinct()->pluck('tahun_ajaran');

        // 2. Hitung Statistik (Cards)
        $totalKriteria = Kriteria::count();
        
        // Cek apakah bobot AHP sudah ada (indikator konsistensi)
        $jumlahBobot = AhpBobot::count();
        $statusAhp = $jumlahBobot > 0 ? 'KONSISTEN' : 'BELUM DIHITUNG';
        $statusAhpColor = $jumlahBobot > 0 ? 'text-green-600' : 'text-red-600';

        // Hitung total siswa yang sudah masuk ke tahap akhir (Selesai Dinilai)
        $querySiswa = HasilAkhir::query();
        
        // 3. Ambil Top 5 Siswa berdasarkan Filter
        $topSiswaQuery = HasilAkhir::with('siswa');

        if ($this->filterKelas || $this->filterTahunAjaran) {
            $querySiswa->whereHas('siswa', function($q) {
                if ($this->filterKelas) $q->where('kelas', $this->filterKelas);
                if ($this->filterTahunAjaran) $q->where('tahun_ajaran', $this->filterTahunAjaran);
            });

            $topSiswaQuery->whereHas('siswa', function($q) {
                if ($this->filterKelas) $q->where('kelas', $this->filterKelas);
                if ($this->filterTahunAjaran) $q->where('tahun_ajaran', $this->filterTahunAjaran);
            });
        }

        $totalSiswaDinilai = $querySiswa->count();
        
        // Ambil 5 peringkat teratas
        $topSiswa = $topSiswaQuery->orderBy('peringkat', 'asc')->take(5)->get();

        return view('livewire.dashboard.index', [
            'listKelas' => $listKelas,
            'listTahun' => $listTahun,
            'totalKriteria' => $totalKriteria,
            'statusAhp' => $statusAhp,
            'statusAhpColor' => $statusAhpColor,
            'totalSiswaDinilai' => $totalSiswaDinilai,
            'topSiswa' => $topSiswa
        ])->layout('layouts.app');
    }
}