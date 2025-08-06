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
        // Seed all tables in order with real Arabic data
        $this->call([
            RealArabicDataSeeder::class,
            ExpandedArabicProductsSeeder::class,
            ToysSeeder::class,
        ]);
    }
}
