<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class UpdateProductSpecsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('No products found.');
            return;
        }

        $specifications = [
            [
                'suitable_age' => '3-12 سنة',
                'pieces_count' => '150 قطعة',
                'standards' => 'CE, FCC, IC',
                'battery_type' => 'شحن سريع 25 واط',
                'washable' => false,
            ],
            [
                'suitable_age' => '2-8 سنوات',
                'pieces_count' => '75 قطعة',
                'standards' => 'EN71, ASTM',
                'battery_type' => 'AA × 4',
                'washable' => true,
            ],
            [
                'suitable_age' => '5+ سنوات',
                'pieces_count' => '200 قطعة',
                'standards' => 'CE, RoHS',
                'battery_type' => 'ليثيوم قابلة للشحن',
                'washable' => false,
            ],
            [
                'suitable_age' => '0-3 سنوات',
                'pieces_count' => '1 قطعة',
                'standards' => 'Oeko-Tex Standard',
                'battery_type' => null,
                'washable' => true,
            ],
            [
                'suitable_age' => '6+ سنوات',
                'pieces_count' => '300 قطعة',
                'standards' => 'CE, ISO 9001',
                'battery_type' => 'USB قابل للشحن',
                'washable' => false,
            ]
        ];

        foreach ($products as $index => $product) {
            $spec = $specifications[$index % count($specifications)];
            $product->update($spec);
            $this->command->info("Updated product: {$product->name}");
        }

        $this->command->info('All product specifications updated successfully!');
    }
}
