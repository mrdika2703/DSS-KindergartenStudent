<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilAkhir;

class CetakController extends Controller
{
    public function hasilAkhir(Request $request)
    {
        // Tangkap parameter dari URL
        $kelas = $request->kelas;
        $tahun = $request->tahun;
        $semester = $request->semester;

        // Cegah akses jika parameter kosong
        if (empty($kelas) || empty($tahun) || empty($semester)) {
            return abort(403, 'Harap pilih Kelas, Tahun Ajaran, dan Semester terlebih dahulu.');
        }

        // Ambil data tanpa paginate (get all)
        $hasilAkhir = HasilAkhir::with('siswa')
            ->whereHas('siswa', function ($q) use ($kelas, $tahun, $semester) {
                $q->where('kelas', $kelas)
                  ->where('tahun_ajaran', $tahun)
                  ->where('semester', $semester);
            })
            ->orderBy('total_skor_z', 'desc')
            ->get();

        return view('livewire.hasil.cetak', [
            'hasilAkhir' => $hasilAkhir,
            'kelas' => $kelas,
            'tahun' => $tahun,
            'semester' => $semester
        ]);
    }
}