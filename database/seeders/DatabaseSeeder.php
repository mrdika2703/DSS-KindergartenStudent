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
        $this->call([
            KriteriaSeeder::class,
            HimpunanFuzzySeeder::class,
            UserSeeder::class,
            FuzzyRulesSeeder::class,
            AhpSeeder::class,
        ]);
    }
}
