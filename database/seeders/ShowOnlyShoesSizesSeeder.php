<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSize;

class ShowOnlyShoesSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== جدول المقاسات الآن مخصص للأحذية فقط ===');
        $this->command->info('');
        
        $shoeProducts = Product::whereHas('sizes')->with('sizes')->get();
        
        foreach ($shoeProducts as $product) {
            $this->command->info('🔹 ' . $product->name);
            $this->command->info('   المقاسات المتوفرة:');
            
            foreach ($product->sizes as $size) {
                $price = $product->price + $size->additional_price;
                $popular = $size->is_popular ? ' ⭐ (شائع)' : '';
                $this->command->info('   - مقاس ' . $size->size . ' - ' . $price . ' ريال' . $popular);
            }
            $this->command->info('');
        }
        
        $this->command->info('=== الإحصائيات ===');
        $this->command->info('إجمالي منتجات الأحذية: ' . $shoeProducts->count());
        $this->command->info('إجمالي المقاسات: ' . ProductSize::count());
        $this->command->info('جميع المقاسات من نوع أحذية EU: ' . ProductSize::where('size_type', 'shoe_eu')->count());
        $this->command->info('');
        $this->command->info('✅ تم! جدول المقاسات الآن مخصص للأحذية فقط');
    }
}
