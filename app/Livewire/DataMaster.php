<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Siswa;
use App\Models\Kriteria;

class DataMaster extends Component
{
    use WithPagination;

    // Properti untuk Tab & Search
    public $tabAktif = 'siswa';
    public $searchSiswa = '';
    public $searchKriteria = '';

    // Properti Filter Tabel
    public $filterKelas = '';
    public $filterTahunAjaran = '';

    // Properti untuk Form Siswa
    public $siswa_id;
    public $nis;
    public $nama_siswa;
    public $jenis_kelamin;
    public $kelas;
    public $tahun_ajaran;
    
    // Kontrol Modal
    public $isModalOpen = false;

    // Reset pagination setiap kali melakukan pencarian atau filter
    public function updatingSearchSiswa() { $this->resetPage(); }
    public function updatedFilterKelas() { $this->resetPage(); }
    public function updatedFilterTahunAjaran() { $this->resetPage(); }

    public function switchTab($tab)
    {
        $this->tabAktif = $tab;
    }

    // -- FUNGSI CRUD SISWA -- //
    public function bukaModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function tutupModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->siswa_id = '';
        $this->nis = '';
        $this->nama_siswa = '';
        $this->jenis_kelamin = '';
        $this->kelas = '';
        $this->tahun_ajaran = '';
    }

    public function simpanSiswa()
    {
        // Validasi input
        $this->validate([
            'nis' => 'required|unique:siswas,nis,' . $this->siswa_id,
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas' => 'required|string',
            'tahun_ajaran' => 'required|string',
        ], [
            'nis.required' => 'NIS tidak boleh kosong.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nama_siswa.required' => 'Nama Siswa tidak boleh kosong.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'kelas.required' => 'Kelas tidak boleh kosong.',
            'tahun_ajaran.required' => 'Tahun Ajaran tidak boleh kosong.',
        ]);

        // Create atau Update data
        Siswa::updateOrCreate(
            ['id' => $this->siswa_id],
            [
                'nis' => $this->nis,
                'nama_siswa' => $this->nama_siswa,
                'jenis_kelamin' => $this->jenis_kelamin,
                'kelas' => $this->kelas,
                'tahun_ajaran' => $this->tahun_ajaran
            ]
        );

        session()->flash('pesan', $this->siswa_id ? 'Data siswa berhasil diperbarui!' : 'Siswa baru berhasil ditambahkan!');
        $this->tutupModal();
    }

    public function editSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $this->siswa_id = $id;
        $this->nis = $siswa->nis;
        $this->nama_siswa = $siswa->nama_siswa;
        $this->jenis_kelamin = $siswa->jenis_kelamin;
        $this->kelas = $siswa->kelas;
        $this->tahun_ajaran = $siswa->tahun_ajaran;
        
        $this->isModalOpen = true;
    }

    public function hapusSiswa($id)
    {
        Siswa::findOrFail($id)->delete();
        session()->flash('pesan', 'Data siswa berhasil dihapus!');
    }

    // Fungsi untuk menghapus seluruh data siswa (Hard Reset)
    public function resetDataSiswa()
    {
        // Menghapus seluruh data siswa. Karena di migration Anda menggunakan cascadeOnDelete(),
        // tabel terkait (penilaians, hasil_akhirs, rapor_mentahs) akan otomatis ikut terhapus.
        Siswa::query()->delete();
        session()->flash('pesan', 'Seluruh data siswa dan riwayat penilaiannya berhasil di-reset!');
        $this->resetPage();
    }

    // -- RENDER VIEW -- //
    public function render()
    {
        // Menarik data dengan fitur Filter, Search & Pagination
        $dataSiswa = Siswa::query()
            ->when($this->filterKelas, function($query) {
                $query->where('kelas', $this->filterKelas);
            })
            ->when($this->filterTahunAjaran, function($query) {
                $query->where('tahun_ajaran', $this->filterTahunAjaran);
            })
            ->where(function($query) {
                $query->where('nama_siswa', 'like', '%' . $this->searchSiswa . '%')
                      ->orWhere('nis', 'like', '%' . $this->searchSiswa . '%');
            })
            ->latest()
            ->paginate(10);

        $dataKriteria = Kriteria::where('nama_kriteria', 'like', '%' . $this->searchKriteria . '%')->get();

        // Mengambil daftar dropdown dinamis
        $listKelas = Siswa::select('kelas')->whereNotNull('kelas')->distinct()->pluck('kelas');
        $listTahun = Siswa::select('tahun_ajaran')->whereNotNull('tahun_ajaran')->distinct()->pluck('tahun_ajaran');

        return view('livewire.data-master', [
            'dataSiswa' => $dataSiswa,
            'dataKriteria' => $dataKriteria,
            'listKelas' => $listKelas,
            'listTahun' => $listTahun
        ])->layout('layouts.app');
    }
}