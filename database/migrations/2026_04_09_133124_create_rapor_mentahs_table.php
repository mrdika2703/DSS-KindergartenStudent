<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rapor_mentahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->json('data_akademik')->nullable(); // Menyimpan 100+ data agama, math, dll
            $table->json('data_absensi')->nullable();  // Menyimpan data S, I, K
            $table->json('data_capaian')->nullable();  // Menyimpan capaian1-5
            $table->json('data_ekstra')->nullable();   // Menyimpan data db, renang, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapor_mentahs');
    }
};
