<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed all tables with real Arabic e-commerce data
        $this->call([
            AdminUserSeeder::class,
            SettingsSeeder::class,
            RealArabicDataSeeder::class,
        ]);
    }
}
