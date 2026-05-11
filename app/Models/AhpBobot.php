<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AhpBobot extends Model
{
    use HasFactory;

    protected $fillable = ['kriteria_id', 'bobot_eigen'];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
