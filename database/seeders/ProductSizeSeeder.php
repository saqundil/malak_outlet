<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSize;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some existing products
        $products = Product::where('is_active', true)->take(10)->get();
        
        if ($products->count() == 0) {
            $this->command->info('No products found. Please run product seeder first.');
            return;
        }

        // Sample sizes for different categories
        $shoeSizes = ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
        $clothingSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $universalSizes = ['صغير', 'متوسط', 'كبير'];

        // Clear existing sizes
        ProductSize::truncate();

        foreach ($products as $product) {
            // Determine sizes based on category or use universal sizes
            $categoryName = $product->category->name ?? '';
            
            if (str_contains(strtolower($categoryName), 'أحذية') || str_contains(strtolower($categoryName), 'حذاء')) {
                $sizesToUse = $shoeSizes;
            } elseif (str_contains(strtolower($categoryName), 'ملابس') || str_contains(strtolower($categoryName), 'قمصان')) {
                $sizesToUse = $clothingSizes;
            } else {
                $sizesToUse = $universalSizes;
            }

            // Add 3-5 random sizes for each product
            $randomSizes = collect($sizesToUse)->random(rand(3, min(5, count($sizesToUse))));
            
            foreach ($randomSizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'size_type' => 'standard',
                    'description' => "مقاس {$size}",
                    'stock_quantity' => rand(5, 50),
                    'additional_price' => 0,
                    'is_available' => true,
                    'is_popular' => rand(0, 1),
                    'is_deleted' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('ProductSize seeder completed successfully!');
        $this->command->info('Total sizes created: ' . ProductSize::count());
    }
}
