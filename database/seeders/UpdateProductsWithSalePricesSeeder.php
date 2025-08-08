<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class UpdateProductsWithSalePricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::where('is_active', true)->get();
        
        foreach ($products as $index => $product) {
            // Add sale price to some products (every 3rd product)
            if ($index % 3 == 0) {
                $discountPercentage = rand(10, 50); // Random discount between 10% and 50%
                $salePrice = $product->price * (1 - $discountPercentage / 100);
                
                $product->update([
                    'sale_price' => round($salePrice, 2),
                ]);
            }
            
            // Mark some products as featured (every 5th product)
            if ($index % 5 == 0) {
                $product->update([
                    'is_featured' => true,
                ]);
            }
        }
        
        $this->command->info('Updated products with sale prices and featured status!');
    }
}
