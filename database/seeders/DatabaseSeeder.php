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
        // Create some test users
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@malakoutlet.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

                // Seed all tables in order
                // Core seeders
        $this->call([
            CategorySeeder::class,
            SimplifiedBrandSeeder::class,
            SimpleProductSeeder::class,
            ExpandedProductSeeder::class,
            SubcategoryProductSeeder::class,
            MassiveProductSeeder::class,
            SeasonalProductSeeder::class,
        ]);
    }
}
