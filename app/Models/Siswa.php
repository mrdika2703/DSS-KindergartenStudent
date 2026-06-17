<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = ['nis', 'nama_siswa', 'jenis_kelamin', 'kelas', 'tahun_ajaran', 'semester'];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasilAkhir()
    {
        return $this->hasOne(HasilAkhir::class);
    }
    
}
