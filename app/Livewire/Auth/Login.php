<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

// #[Layout('layouts.fullscreen-layout')]
class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    public function authenticate()
    {
        // 1. Validasi Input
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.',
        ]);

        // 2. Proses Autentikasi (Cek ke database)
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Jika berhasil, regenerate session untuk keamanan
            session()->regenerate();

            // Redirect ke halaman Dashboard
            return redirect()->route('dashboard');
        }

        // 3. Jika gagal, tampilkan error real-time
        $this->addError('email', 'Email atau Password yang Anda masukkan salah.');
        $this->password = ''; // Kosongkan form password demi keamanan
    }

    public function render()
    {
        // Karena ini halaman login, kita mungkin menggunakan layout yang berbeda 
        // (tanpa sidebar/navbar). Pastikan Anda punya layout khusus atau gunakan app layout bawaan.
        return view('livewire.auth.login')->layout('layouts.guest'); 
        // Catatan: Ubah 'layouts.guest' menjadi 'layouts.app' jika Anda belum membuat file guest.blade.php
    }
}