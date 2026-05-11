<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuzzyAturan extends Model
{
    use HasFactory;

    protected $fillable = ['kode_aturan', 'kondisi', 'kesimpulan'];

    // Mengubah data JSON di database menjadi Array secara otomatis
    protected $casts = [
        'kondisi' => 'array',
    ];
}
