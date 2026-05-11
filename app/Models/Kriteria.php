<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'nama_kriteria'];

    // Relasi One-to-Many ke tabel Penilaian
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    // Relasi One-to-One ke tabel Bobot AHP
    public function ahpBobot()
    {
        return $this->hasOne(AhpBobot::class);
    }

    // Relasi One-to-Many ke Himpunan Fuzzy (Batas Kurva)
    public function himpunanFuzzies()
    {
        return $this->hasMany(HimpunanFuzzy::class);
    }

    // Relasi untuk Matriks AHP (Sebagai Kriteria Baris dan Kolom)
    public function matriksSebagaiBaris()
    {
        return $this->hasMany(AhpMatriks::class, 'kriteria_1_id');
    }

    public function matriksSebagaiKolom()
    {
        return $this->hasMany(AhpMatriks::class, 'kriteria_2_id');
    }
}
