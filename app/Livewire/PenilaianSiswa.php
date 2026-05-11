<?php

namespace App\Livewire;

use App\Exports\TemplateDataSiswa;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\RaporMentah;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PenilaianImport;

class PenilaianSiswa extends Component
{
    use WithFileUploads, WithPagination;

    public $tabAktif = 'import';

    public $fileExcel;
    public $search = '';

    // Properti Form Import Baru
    public $inputKelas = '';
    public $inputTahunAjaran = '';

    // Properti Filter Tabel
    public $filterKelas = '';
    public $filterTahunAjaran = '';

    // Properti Modal
    public $isModalNilai = false;
    public $isModalSiswa = false;
    public $isModalDetailOpen = false;
    public $siswa_id;
    public $nama_siswa_aktif;

    // Properti untuk Form Siswa
    public $nis;
    public $nama_siswa;
    public $jenis_kelamin;
    public $kelas;
    public $tahun_ajaran;

    public $inputHuruf = [];
    public $outputAngka = [];

    // Properti Data Mentah (Untuk View Detail)
    public $detailMentah = [];

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedFilterKelas()
    {
        $this->resetPage();
    }
    public function updatedFilterTahunAjaran()
    {
        $this->resetPage();
    }

    public function switchTab($tab)
    {
        $this->tabAktif = $tab;
    }

    public function importExcel()
    {
        // Validasi WAJIB diisi sebelum upload
        $this->validate([
            'inputKelas' => 'required|string',
            'inputTahunAjaran' => 'required|string',
            'fileExcel' => 'required|mimes:xlsx,xls,csv|max:5120',
        ], [
            'inputKelas.required' => 'Kelas harus dipilih!',
            'inputTahunAjaran.required' => 'Tahun Ajaran harus diisi!',
        ]);

        // Lempar variabel ke Class Import
        Excel::import(new PenilaianImport($this->inputKelas, $this->inputTahunAjaran), $this->fileExcel);

        session()->flash('pesan', 'Data Excel berhasil diimpor & dikelompokkan ke ' . $this->inputKelas . ' (' . $this->inputTahunAjaran . ')');

        $this->fileExcel = null;
        $this->inputKelas = '';
        $this->inputTahunAjaran = '';
    }

    public function unduhTemplate()
    {
        return Excel::download(new TemplateDataSiswa, 'template_import_data.xlsx');
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

    public function bukaModal()
    {
        $this->resetInputFields();
        $this->isModalSiswa = true;
    }

    // --- CRUD: READ (View Data Mentah) ---
    public function lihatDetailMentah($id)
    {
        $siswa = Siswa::findOrFail($id);
        $this->nama_siswa_aktif = $siswa->nama_siswa;
        $rapor = RaporMentah::where('siswa_id', $id)->first();

        $this->detailMentah = $rapor ? [
            'akademik' => $rapor->data_akademik,
            'absensi' => $rapor->data_absensi,
            'capaian' => $rapor->data_capaian,
            'ekstra' => $rapor->data_ekstra,
        ] : null;

        $this->isModalDetailOpen = true;
    }

    // --- CRUD: UPDATE (Edit Nilai Akhir) ---
    public function bukaModalManual($id)
    {
        $siswa = Siswa::findOrFail($id);
        $this->siswa_id = $id;
        $this->nama_siswa_aktif = $siswa->nama_siswa;
        $this->inputHuruf = [];

        $penilaians = Penilaian::where('siswa_id', $id)->get();
        foreach (Kriteria::all() as $k) {
            $nilai_ada = $penilaians->firstWhere('kriteria_id', $k->id);
            $this->outputAngka[$k->id] = $nilai_ada ? $nilai_ada->nilai : 0;
            $this->inputHuruf[$k->id] = '';
        }

        $this->isModalNilai = true;
    }

    public function updatedInputHuruf($value, $kriteria_id)
    {
        $huruf = strtoupper(trim($value));
        if ($huruf == 'A') $angka = 90;
        elseif ($huruf == 'B') $angka = 80;
        elseif ($huruf == 'C') $angka = 60;
        elseif ($huruf == 'D') $angka = 40;
        else $angka = 0;

        if (is_numeric($value)) {
            $angka = $value;
        }

        $this->outputAngka[$kriteria_id] = $angka;
    }

    public function simpanManual()
    {
        foreach ($this->outputAngka as $kriteria_id => $nilai) {
            Penilaian::updateOrCreate(
                ['siswa_id' => $this->siswa_id, 'kriteria_id' => $kriteria_id],
                ['nilai' => $nilai]
            );
        }

        session()->flash('pesan', 'Nilai akhir berhasil diperbarui!');
        $this->isModalNilai = false;
    }

    // --- CRUD: DELETE ---
    public function hapusPenilaian($id)
    {
        Penilaian::where('siswa_id', $id)->delete();
        RaporMentah::where('siswa_id', $id)->delete();
        session()->flash('pesan', 'Data penilaian dan arsip rapor mentah siswa berhasil dihapus!');
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
        $this->isModalSiswa = false;
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

        $this->isModalSiswa = true;
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

    public function render()
    {
        // Ambil data siswa berdasarkan Filter Kelas & Tahun Ajaran
        $siswas = Siswa::whereHas('penilaians')
            ->when($this->filterKelas, function ($query) {
                $query->where('kelas', $this->filterKelas);
            })
            ->when($this->filterTahunAjaran, function ($query) {
                $query->where('tahun_ajaran', $this->filterTahunAjaran);
            })
            ->where('nama_siswa', 'like', '%' . $this->search . '%')
            ->orderBy('kelas')
            ->paginate(10);

        $kriterias = Kriteria::orderBy('kode')->get();

        // Ambil daftar Tahun Ajaran dan Kelas unik untuk Dropdown Filter
        $listKelas = Siswa::select('kelas')->whereNotNull('kelas')->distinct()->pluck('kelas');
        $listTahun = Siswa::select('tahun_ajaran')->whereNotNull('tahun_ajaran')->distinct()->pluck('tahun_ajaran');

        return view('livewire.penilaian-siswa', [
            'siswas' => $siswas,
            'kriterias' => $kriterias,
            'listKelas' => $listKelas,
            'listTahun' => $listTahun
        ])->layout('layouts.app');
    }
}
