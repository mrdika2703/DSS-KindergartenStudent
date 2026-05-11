<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            KriteriaSeeder::class, FuzzyDataSeeder::class, HimpunanFuzzySeeder::class, UserSeeder::class, FuzzyRulesSeeder::class
            // Anda juga bisa menambahkan seeder lain di sini nanti, 
            // misalnya UserSeeder untuk akun Kepala Sekolah dan Guru
        ]);
    }
}
