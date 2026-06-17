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
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;

#[Title('Penilaian')]
class PenilaianSiswa extends Component
{
    use WithFileUploads, WithPagination;

    public $tabAktif = 'import';

    public $fileExcel;
    public $search = '';

    // Properti Form Import Baru
    public $inputKelas = '';
    public $inputTahunAjaran = '';
    public $inputSemester = '';

    // Properti Filter Tabel
    public $filterKelas = '';
    public $filterTahunAjaran = '';
    public $filterSemester = '';

    // Properti Modal
    public $isModalNilai = false;
    public $isModalSiswa = false;
    public $isModalDetailOpen = false;
    public $siswa_id;
    public $nama_siswa_aktif;
    public $semester_aktif;

    // Properti untuk Form Siswa
    public $nis;
    public $nama_siswa;
    public $jenis_kelamin;
    public $kelas;
    public $tahun_ajaran;
    public $semester;

    public $inputHuruf = [];
    public $outputAngka = [];

    // Properti Data Mentah (Untuk View Detail)
    public $detailMentah = [];

    // Properti Modal Reset
    public $modeReset = 'semua';
    public $resetKelas = '';
    public $resetTahun = '';
    public $resetSemester = '';

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
            'inputSemester' => 'required|integer|min:1|max:2',
            'fileExcel' => 'required|mimes:xlsx,xls,csv|max:5120',
        ], [
            'inputKelas.required' => 'Kelas harus dipilih!',
            'inputTahunAjaran.required' => 'Tahun Ajaran harus diisi!',
            'inputSemester.required' => 'Semester harus diisi!',
        ]);

        // Lempar variabel ke Class Import
        Excel::import(new PenilaianImport($this->inputKelas, $this->inputTahunAjaran, $this->inputSemester), $this->fileExcel);

        session()->flash('pesan', 'Data Excel berhasil diimpor & dikelompokkan ke ' . $this->inputKelas . ' (' . $this->inputTahunAjaran . ' - Semester: ' . $this->inputSemester . ')');

        $this->fileExcel = null;
        $this->inputKelas = '';
        $this->inputTahunAjaran = '';
        $this->inputSemester = '';
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
        $this->semester = '';
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
        $this->semester_aktif = $siswa->semester;
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
        $this->semester_aktif = $siswa->semester;
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

    public function simpanSiswa1()
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
                'nis' => [
                    'required',
                    Rule::unique('siswas')->where(function ($query) {
                        return $query->where('tahun_ajaran', $this->tahun_ajaran)
                            ->where('semester', $this->semester);
                    })->ignore($this->siswa_id)
                ],
                'nama_siswa' => $this->nama_siswa,
                'jenis_kelamin' => $this->jenis_kelamin,
                'kelas' => $this->kelas,
                'tahun_ajaran' => $this->tahun_ajaran
            ]
        );

        session()->flash('pesan', $this->siswa_id ? 'Data siswa berhasil diperbarui!' : 'Siswa baru berhasil ditambahkan!');
        $this->isModalSiswa = false;
    }

    public function simpanSiswa()
    {
        // Validasi input tingkat lanjut
        $this->validate([
            'nis' => [
                'required',
                Rule::unique('siswas')->where(function ($query) {
                    return $query->where('tahun_ajaran', $this->tahun_ajaran)
                        ->where('semester', $this->semester);
                })->ignore($this->siswa_id)
            ],
            'nama_siswa' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|integer|in:1,2',
        ], [
            'nis.required' => 'NIS tidak boleh kosong.',
            'nis.unique' => 'Siswa dengan NIS ini sudah terdaftar di Tahun Ajaran dan Semester yang sama.',
            'nama_siswa.required' => 'Nama Siswa tidak boleh kosong.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'kelas.required' => 'Kelas tidak boleh kosong.',
            'tahun_ajaran.required' => 'Tahun Ajaran tidak boleh kosong.',
            'semester.required' => 'Semester harus diisi.',
        ]);

        // Create atau Update data
        Siswa::updateOrCreate(
            ['id' => $this->siswa_id],
            [
                'nis' => $this->nis,
                'nama_siswa' => $this->nama_siswa,
                'jenis_kelamin' => $this->jenis_kelamin,
                'kelas' => $this->kelas,
                'tahun_ajaran' => $this->tahun_ajaran,
                'semester' => $this->semester // <-- Simpan semester
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
        $this->semester = $siswa->semester;

        $this->isModalSiswa = true;
    }

    public function hapusSiswa($id)
    {
        Siswa::findOrFail($id)->delete();
        session()->flash('pesan', 'Data siswa berhasil dihapus!');
    }

    // Fungsi untuk menghapus data siswa berdasarkan pilihan Modal Reset
    public function eksekusiReset()
    {
        if ($this->modeReset == 'semua') {
            // Hard Reset Seluruh Data
            Siswa::query()->delete();
            session()->flash('pesan', 'Seluruh data siswa dan riwayat penilaiannya berhasil di-reset!');
        } else {
            // Reset Spesifik (Soft Reset)
            $query = Siswa::query();

            // Jika ada filter yang dipilih, tambahkan ke query. Jika kosong, berarti hapus semua di kategori itu.
            if (!empty($this->resetKelas)) {
                $query->where('kelas', $this->resetKelas);
            }
            if (!empty($this->resetTahun)) {
                $query->where('tahun_ajaran', $this->resetTahun);
            }
            if (!empty($this->resetSemester)) {
                $query->where('semester', $this->resetSemester);
            }

            // Hitung berapa baris yang akan dihapus untuk memberi info ke user
            $jumlahDihapus = $query->count();

            if ($jumlahDihapus > 0) {
                $query->delete();
                session()->flash('pesan', $jumlahDihapus . ' Data siswa berhasil dihapus secara spesifik!');
            } else {
                session()->flash('pesan', 'Tidak ada data siswa yang cocok dengan kriteria filter tersebut untuk dihapus.');
            }
        }

        // Kembalikan form reset ke default
        $this->modeReset = 'semua';
        $this->resetKelas = '';
        $this->resetTahun = '';
        $this->resetSemester = '';

        $this->resetPage();
    }

    public function render()
    {
        // Ambil data siswa berdasarkan Filter Kelas & Tahun Ajaran
        $siswas = Siswa::query()
            ->when($this->filterKelas, function ($query) {
                $query->where('kelas', $this->filterKelas);
            })
            ->when($this->filterTahunAjaran, function ($query) {
                $query->where('tahun_ajaran', $this->filterTahunAjaran);
            })
            ->when($this->filterSemester, function ($query) {
                $query->where('semester', $this->filterSemester);
            })
            ->where('nama_siswa', 'like', '%' . $this->search . '%')
            ->orderBy('kelas')
            ->paginate(10);

        $kriterias = Kriteria::orderBy('kode')->get();

        // Ambil daftar Tahun Ajaran dan Kelas unik untuk Dropdown Filter
        $listKelas = Siswa::select('kelas')->whereNotNull('kelas')->distinct()->pluck('kelas');
        $listTahun = Siswa::select('tahun_ajaran')->whereNotNull('tahun_ajaran')->distinct()->pluck('tahun_ajaran');
        $listSemester = Siswa::select('semester')->whereNotNull('semester')->distinct()->pluck('semester');

        return view('livewire.penilaian.index', [
            'siswas' => $siswas,
            'kriterias' => $kriterias,
            'listKelas' => $listKelas,
            'listTahun' => $listTahun,
            'listSemester' => $listSemester,
        ])->layout('layouts.app');
    }
}
