<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSize;

class ShowProductSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== أمثلة على مقاسات الأحذية ===');
        
        $shoeProducts = Product::whereHas('sizes', function($q) {
            $q->where('size_type', 'shoe_eu');
        })->with('sizes')->take(3)->get();
        
        foreach ($shoeProducts as $product) {
            $this->command->info($product->name . ':');
            $shoeSizes = $product->sizes->where('size_type', 'shoe_eu');
            foreach ($shoeSizes as $size) {
                $this->command->info('  - مقاس ' . $size->size . ' (' . $size->description . ')');
            }
            $this->command->info('');
        }
        
        $this->command->info('=== أمثلة على مقاسات الملابس ===');
        
        $clothingProducts = Product::whereHas('sizes', function($q) {
            $q->where('size_type', 'clothing_age');
        })->with('sizes')->take(3)->get();
        
        foreach ($clothingProducts as $product) {
            $this->command->info($product->name . ':');
            $clothingSizes = $product->sizes->where('size_type', 'clothing_age');
            foreach ($clothingSizes as $size) {
                $this->command->info('  - مقاس ' . $size->size . ' (' . $size->description . ')');
            }
            $this->command->info('');
        }
        
        $this->command->info('=== إحصائيات المقاسات ===');
        $this->command->info('إجمالي المقاسات: ' . ProductSize::count());
        $this->command->info('مقاسات أحذية (EU): ' . ProductSize::where('size_type', 'shoe_eu')->count());
        $this->command->info('مقاسات ملابس: ' . ProductSize::where('size_type', 'clothing_age')->count());
        $this->command->info('مقاسات عامة: ' . ProductSize::where('size_type', 'general')->count());
    }
}
