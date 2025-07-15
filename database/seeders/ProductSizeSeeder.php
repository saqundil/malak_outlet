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
        // أحجام الأحذية (للفئات: Clothing, Sports & Fitness)
        $shoeSizes = ['38', '39', '40', '41', '42', '43', '44', '45', '46'];
        
        // أحجام الملابس
        $clothingSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        
        // أحجام الإلكترونيات (مثل شاشات)
        $electronicSizes = ['32"', '43"', '50"', '55"', '65"', '75"'];

        // الحصول على المنتجات حسب الفئة
        $shoeProducts = Product::whereHas('category', function($q) {
            $q->whereIn('slug', ['clothing', 'sports-fitness']);
        })->whereHas('brand', function($q) {
            $q->whereIn('slug', ['nike', 'adidas', 'converse', 'puma', 'under-armour']);
        })->get();

        $clothingProducts = Product::whereHas('category', function($q) {
            $q->where('slug', 'clothing');
        })->whereHas('brand', function($q) {
            $q->whereIn('slug', ['zara', 'hm']);
        })->get();

        $electronicProducts = Product::whereHas('category', function($q) {
            $q->where('slug', 'electronics');
        })->whereHas('brand', function($q) {
            $q->whereIn('slug', ['samsung', 'lg', 'sony']);
        })->get();

        // إضافة أحجام للأحذية
        foreach ($shoeProducts as $product) {
            foreach ($shoeSizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'size_type' => 'number',
                    'stock_quantity' => rand(5, 25),
                    'additional_price' => 0,
                    'is_available' => true
                ]);
            }
        }

        // إضافة أحجام للملابس
        foreach ($clothingProducts as $product) {
            foreach ($clothingSizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'size_type' => 'letter',
                    'stock_quantity' => rand(10, 30),
                    'additional_price' => 0,
                    'is_available' => true
                ]);
            }
        }

        // إضافة أحجام للإلكترونيات (للشاشات مثلاً)
        foreach ($electronicProducts->take(5) as $product) {
            foreach ($electronicSizes as $size) {
                $additionalPrice = 0;
                // أحجام أكبر = سعر أعلى
                if (str_contains($size, '55') || str_contains($size, '65')) {
                    $additionalPrice = 100;
                } elseif (str_contains($size, '75')) {
                    $additionalPrice = 200;
                }

                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'size_type' => 'custom',
                    'stock_quantity' => rand(3, 15),
                    'additional_price' => $additionalPrice,
                    'is_available' => true
                ]);
            }
        }

        echo "تم إضافة أحجام للمنتجات:\n";
        echo "- أحذية: " . $shoeProducts->count() . " منتج × " . count($shoeSizes) . " حجم\n";
        echo "- ملابس: " . $clothingProducts->count() . " منتج × " . count($clothingSizes) . " حجم\n";
        echo "- إلكترونيات: " . min(5, $electronicProducts->count()) . " منتج × " . count($electronicSizes) . " حجم\n";
    }
}
