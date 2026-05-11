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
        Schema::table('hasil_akhirs', function (Blueprint $table) {
            $table->string('status')->nullable()->after('peringkat'); // Sangat Terampil / Cukup Terampil
            $table->json('rincian')->nullable()->after('status'); // Menyimpan log perhitungan alpha & Z
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_akhirs', function (Blueprint $table) {
            $table->dropColumn(['status', 'rincian']);
        });
    }
};
