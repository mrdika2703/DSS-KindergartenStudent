<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilAkhir extends Model
{
    use HasFactory;

    protected $fillable = ['siswa_id', 'total_skor_z', 'peringkat', 'status', 'rincian'];
    protected $casts = ['rincian' => 'array'];
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
