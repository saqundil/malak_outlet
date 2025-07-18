<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use Illuminate\Support\Facades\DB;

class FixProductSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear all existing product sizes
        ProductSize::truncate();

        // Get all products
        $allProducts = Product::all();
        
        foreach ($allProducts as $product) {
            // Check product name to determine if it's shoes, clothes, or general
            if ($this->isShoeProduct($product)) {
                $this->createShoeSizes($product);
            } elseif ($this->isClothingProduct($product)) {
                $this->createClothesSizes($product);
            } else {
                $this->createGeneralSizes($product);
            }
        }

        $this->command->info('تم تحديث جدول المقاسات بنجاح لجميع المنتجات!');
        $this->command->info('إجمالي المنتجات: ' . $allProducts->count());
    }

    private function isShoeProduct($product)
    {
        $shoeKeywords = ['حذاء', 'حذائ', 'بوت', 'صندل', 'شبشب', 'كوتشي', 'سنيكر'];
        
        foreach ($shoeKeywords as $keyword) {
            if (str_contains($product->name, $keyword)) {
                return true;
            }
        }
        
        return false;
    }

    private function isClothingProduct($product)
    {
        $clothingKeywords = ['فستان', 'تيشيرت', 'بنطلون', 'شورت', 'جاكيت', 'معطف', 'بيجامة', 'ملابس'];
        
        foreach ($clothingKeywords as $keyword) {
            if (str_contains($product->name, $keyword)) {
                return true;
            }
        }
        
        return false;
    }

    private function createShoeSizes($product)
    {
        // Kids shoe sizes (EU sizes)
        $kidsShoeSizes = [
            ['size' => '28', 'age_group' => '3-4 سنوات'],
            ['size' => '29', 'age_group' => '4-5 سنوات'],
            ['size' => '30', 'age_group' => '4-5 سنوات'],
            ['size' => '31', 'age_group' => '5-6 سنوات'],
            ['size' => '32', 'age_group' => '5-6 سنوات'],
            ['size' => '33', 'age_group' => '6-7 سنوات'],
            ['size' => '34', 'age_group' => '6-7 سنوات'],
            ['size' => '35', 'age_group' => '7-8 سنوات'],
            ['size' => '36', 'age_group' => '8-9 سنوات'],
            ['size' => '37', 'age_group' => '9-10 سنوات'],
            ['size' => '38', 'age_group' => '10-11 سنة'],
            ['size' => '39', 'age_group' => '11-12 سنة'],
        ];

        // Select 4-6 random sizes for each shoe product
        $selectedSizes = collect($kidsShoeSizes)->random(rand(4, 6));

        foreach ($selectedSizes as $index => $sizeData) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $sizeData['size'],
                'stock_quantity' => rand(5, 25),
                'additional_price' => $index < 2 ? 0 : rand(0, 15), // First 2 sizes no extra cost
                'size_type' => 'shoe_eu',
                'is_available' => true,
                'is_popular' => in_array($sizeData['size'], ['32', '33', '34', '35']), // Popular kids sizes
                'description' => 'مقاس ' . $sizeData['size'] . ' أوروبي - ' . $sizeData['age_group']
            ]);
        }
    }

    private function createClothesSizes($product)
    {
        // Kids clothes sizes
        $clothesSizes = [
            ['size' => '2-3Y', 'description' => 'سنتان إلى 3 سنوات'],
            ['size' => '3-4Y', 'description' => '3 إلى 4 سنوات'],
            ['size' => '4-5Y', 'description' => '4 إلى 5 سنوات'],
            ['size' => '5-6Y', 'description' => '5 إلى 6 سنوات'],
            ['size' => '6-7Y', 'description' => '6 إلى 7 سنوات'],
            ['size' => '7-8Y', 'description' => '7 إلى 8 سنوات'],
            ['size' => '8-9Y', 'description' => '8 إلى 9 سنوات'],
            ['size' => '9-10Y', 'description' => '9 إلى 10 سنوات'],
            ['size' => '10-12Y', 'description' => '10 إلى 12 سنة'],
        ];

        // Select 3-5 sizes for each clothing product
        $selectedSizes = collect($clothesSizes)->random(rand(3, 5));

        foreach ($selectedSizes as $index => $sizeData) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $sizeData['size'],
                'stock_quantity' => rand(8, 30),
                'additional_price' => $index > 5 ? rand(5, 15) : 0, // Larger sizes cost more
                'size_type' => 'clothing_age',
                'is_available' => true,
                'is_popular' => in_array($sizeData['size'], ['4-5Y', '5-6Y', '6-7Y']), // Popular sizes
                'description' => $sizeData['description']
            ]);
        }
    }

    private function createGeneralSizes($product)
    {
        // General sizes for toys and other products
        $generalSizes = [
            ['size' => 'صغير', 'description' => 'حجم صغير'],
            ['size' => 'متوسط', 'description' => 'حجم متوسط'],
            ['size' => 'كبير', 'description' => 'حجم كبير'],
        ];

        // For toys, usually 1-2 sizes are enough
        $selectedSizes = collect($generalSizes)->random(rand(1, 2));

        foreach ($selectedSizes as $index => $sizeData) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $sizeData['size'],
                'stock_quantity' => rand(10, 40),
                'additional_price' => $index * rand(0, 10),
                'size_type' => 'general',
                'is_available' => true,
                'is_popular' => $sizeData['size'] === 'متوسط',
                'description' => $sizeData['description']
            ]);
        }
    }
}
