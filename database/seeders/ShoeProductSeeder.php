<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Illuminate\Support\Str;

class ShoeProductSeeder extends Seeder
{
    private $skuCounter = 600;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and brands
        $categories = Category::all()->keyBy('name');
        $brands = Brand::all()->keyBy('name');

        // Find suitable category for shoes (use boys or girls categories)
        $boysCategory = $categories['ألعاب الأولاد'] ?? null;
        $girlsCategory = $categories['ألعاب البنات'] ?? null;

        if ($boysCategory) {
            $this->createShoeProducts($boysCategory, $brands, 'boys');
        }

        if ($girlsCategory) {
            $this->createShoeProducts($girlsCategory, $brands, 'girls');
        }

        $this->command->info('تم إنشاء منتجات الأحذية مع المقاسات الحقيقية!');
    }

    private function createShoeProducts($category, $brands, $type)
    {
        $shoeProducts = [
            'boys' => [
                ['name' => 'حذاء رياضي أديداس للأولاد', 'description' => 'حذاء رياضي مريح ومتين للأولاد من أديداس', 'price' => 180.00, 'brand' => 'أديداس'],
                ['name' => 'حذاء كرة قدم نايكي', 'description' => 'حذاء كرة قدم احترافي للأولاد من نايكي', 'price' => 220.00, 'brand' => 'نايكي'],
                ['name' => 'بوت المطر للأطفال', 'description' => 'بوت مطر مقاوم للماء وآمن للأطفال', 'price' => 95.00, 'brand' => 'أديداس'],
            ],
            'girls' => [
                ['name' => 'حذاء باليه للبنات', 'description' => 'حذاء باليه أنيق ومريح للبنات', 'price' => 120.00, 'brand' => 'أديداس'],
                ['name' => 'صندل صيفي للبنات', 'description' => 'صندل صيفي جميل ومريح للبنات', 'price' => 85.00, 'brand' => 'نايكي'],
                ['name' => 'حذاء مدرسي كلاسيكي', 'description' => 'حذاء مدرسي أنيق ومتين للاستخدام اليومي', 'price' => 150.00, 'brand' => 'بوما'],
            ]
        ];

        $products = $shoeProducts[$type] ?? [];

        foreach ($products as $productData) {
            $product = $this->createProduct($productData, $category, $brands);
            $this->createShoeSizes($product);
        }
    }

    private function createProduct($productData, $category, $brands)
    {
        $brandName = $productData['brand'] ?? null;
        $brand = $brandName ? ($brands[$brandName] ?? null) : null;

        unset($productData['brand']);

        $productData['category_id'] = $category->id;
        $productData['brand_id'] = $brand ? $brand->id : null;
        $productData['slug'] = Str::slug($productData['name']) . '-' . $this->skuCounter;
        $productData['sku'] = 'SHOE-' . str_pad($this->skuCounter++, 4, '0', STR_PAD_LEFT);
        $productData['stock'] = rand(20, 100);
        $productData['stock_quantity'] = $productData['stock'];
        $productData['is_active'] = true;
        $productData['is_featured'] = true;
        $productData['country_of_origin'] = 'فيتنام';
        $productData['warranty_period'] = 'سنة واحدة';
        $productData['weight'] = rand(200, 800) . ' جرام';
        $productData['standards'] = 'ISO, CE';
        $productData['suitable_age'] = '3-12 سنة';
        $productData['materials'] = 'جلد طبيعي، مطاط';

        $product = Product::create($productData);

        // Create product images
        $this->createProductImages($product);

        return $product;
    }

    private function createProductImages($product)
    {
        $imageCount = rand(3, 5);
        for ($i = 1; $i <= $imageCount; $i++) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/shoes-' . $product->id . '-image-' . $i . '.jpg',
                'is_primary' => $i == 1
            ]);
        }
    }

    private function createShoeSizes($product)
    {
        // Kids shoe sizes (EU sizes) - the realistic ones you requested
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
            ['size' => '42', 'age_group' => '12+ سنة'], // The Adidas 42 you mentioned!
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
