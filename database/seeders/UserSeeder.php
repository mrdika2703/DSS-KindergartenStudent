<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Guru
        User::updateOrCreate(
            ['email' => 'guru@tkraudlatulhikmah.com'],
            [
                'name' => 'Guru Penilai',
                'password' => Hash::make('password123'), // Passwordnya adalah: password123
                'role' => 'guru'
            ]
        );

        // Akun Kepala Sekolah
        User::updateOrCreate(
            ['email' => 'kepsek@tkraudlatulhikmah.com'],
            [
                'name' => 'Kepala Sekolah',
                'password' => Hash::make('password123'),
                'role' => 'kepala_sekolah'
            ]
        );
    }
}