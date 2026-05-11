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
        Schema::create('fuzzy_aturans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aturan')->unique(); // Contoh: R1, R2 ... R12
            $table->json('kondisi'); // Format JSON: {"C1": "Tinggi", "C2": "Sedang", ...}
            $table->string('kesimpulan'); // Hasil THEN: "Sangat Terampil" / "Terampil"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuzzy_aturans');
    }
};
