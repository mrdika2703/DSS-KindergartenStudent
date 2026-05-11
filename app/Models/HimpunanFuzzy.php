<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HimpunanFuzzy extends Model
{
    use HasFactory;

    protected $fillable = [
        'kriteria_id', 'nama_himpunan', 'batas_bawah', 'batas_tengah', 'batas_atas'
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
