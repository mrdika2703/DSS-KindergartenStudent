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
        Schema::create('himpunan_fuzzies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriterias')->cascadeOnDelete();
            $table->string('nama_himpunan'); // Contoh: Rendah, Sedang, Tinggi
            $table->decimal('batas_bawah', 8, 2);
            $table->decimal('batas_tengah', 8, 2)->nullable(); // Nullable untuk kurva bahu (linear)
            $table->decimal('batas_atas', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('himpunan_fuzzies');
    }
};
