<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Support\Facades\DB;

class ShoesOnlySizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete ALL product sizes
        $this->command->info('حذف جميع المقاسات الموجودة...');
        ProductSize::truncate();
        
        // Get only shoe products (products with shoe keywords in name)
        $shoeProducts = Product::where(function($query) {
            $query->where('name', 'like', '%حذاء%')
                  ->orWhere('name', 'like', '%بوت%')
                  ->orWhere('name', 'like', '%صندل%')
                  ->orWhere('name', 'like', '%شبشب%')
                  ->orWhere('name', 'like', '%كوتشي%')
                  ->orWhere('name', 'like', '%سنيكر%');
        })->get();

        $this->command->info('العثور على ' . $shoeProducts->count() . ' منتج أحذية');

        // Create sizes only for shoe products
        foreach ($shoeProducts as $product) {
            $this->createShoeSizes($product);
            $this->command->info('تم إنشاء مقاسات للمنتج: ' . $product->name);
        }

        $this->command->info('✅ تم! الآن جدول المقاسات مخصص للأحذية فقط');
        $this->command->info('إجمالي المقاسات المنشأة: ' . ProductSize::count());
    }

    private function createShoeSizes($product)
    {
        // Kids shoe sizes (EU sizes) - realistic shoe sizes
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
            ['size' => '40', 'age_group' => '12+ سنة'],
            ['size' => '41', 'age_group' => '12+ سنة'],
            ['size' => '42', 'age_group' => '12+ سنة'],
        ];

        // Select 6-8 sizes for each shoe product
        $selectedSizes = collect($kidsShoeSizes)->random(rand(6, 8));

        foreach ($selectedSizes as $index => $sizeData) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $sizeData['size'],
                'stock_quantity' => rand(5, 25),
                'additional_price' => $index > 4 ? rand(10, 20) : 0, // Larger sizes cost more
                'size_type' => 'shoe_eu',
                'is_available' => true,
                'is_popular' => in_array($sizeData['size'], ['32', '33', '34', '35', '36']), // Popular kids sizes
                'description' => 'مقاس ' . $sizeData['size'] . ' أوروبي - ' . $sizeData['age_group']
            ]);
        }
    }
}
