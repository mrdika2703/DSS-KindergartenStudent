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
        Schema::create('ahp_matriks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_1_id')->constrained('kriterias')->cascadeOnDelete();
            $table->foreignId('kriteria_2_id')->constrained('kriterias')->cascadeOnDelete();
            $table->decimal('nilai_perbandingan', 8, 4); // Menyimpan nilai 1-9 atau pecahannya (misal 0.33)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahp_matriks');
    }
};
