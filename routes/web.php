<?php

use App\Livewire\Auth\Login;
use App\Livewire\DataMaster;
use App\Livewire\AhpCalculation;
use App\Livewire\FuzzyConfig;
use App\Livewire\PenilaianSiswa;
use App\Livewire\HasilAkhirIndex;
use App\Livewire\DashboardIndex;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CetakController;

Route::middleware(['guest'])->group(function () {
    // Route::view('/', 'welcome')->name('home');
    Route::get('/', Login::class)->name('login');
    
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');
    // Route::get('/data-master', DataMaster::class)->name('master.index');
    Route::get('/perhitungan-ahp', AhpCalculation::class)->name('ahp.index');
    Route::get('/konfigurasi-fuzzy', FuzzyConfig::class)->name('fuzzy.index');
    Route::get('/penilaian-siswa', PenilaianSiswa::class)->name('penilaian.index');
    Route::get('/hasil-akhir', HasilAkhirIndex::class)->name('hasil.index');
    Route::get('/cetak/hasil-akhir', [CetakController::class, 'hasilAkhir'])->name('cetak.hasil');
});
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');