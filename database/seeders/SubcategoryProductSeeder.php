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

class SubcategoryProductSeeder extends Seeder
{
    private $skuCounter = 200;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and brands
        $categories = Category::all()->keyBy('name');
        $brands = Brand::all()->keyBy('name');

        // Add products for subcategories
        $this->seedSubcategoryProducts($categories, $brands);

        $this->command->info('تم إضافة منتجات للفئات الفرعية بنجاح!');
    }

    private function seedSubcategoryProducts($categories, $brands)
    {
        $subcategoryProducts = [
            // فئة الأحذية
            'أحذية أطفال' => [
                [
                    'name' => 'حذاء رياضي للأطفال مضيء',
                    'description' => 'حذاء رياضي مريح للأطفال مع أضواء LED ملونة وتصميم عصري',
                    'price' => 120.00,
                    'brand' => 'نايكي',
                    'suitable_age' => '3-12 سنة',
                    'materials' => 'جلد صناعي وقماش',
                    'sizes_available' => '22, 23, 24, 25, 26, 27, 28, 29, 30',
                ],
                [
                    'name' => 'صندل صيفي مريح للأطفال',
                    'description' => 'صندل صيفي مريح وآمن للأطفال مع نعل مانع للانزلاق',
                    'price' => 65.00,
                    'brand' => 'أديداس',
                    'suitable_age' => '2-10 سنوات',
                    'materials' => 'مطاط وبلاستيك آمن',
                    'sizes_available' => '20, 21, 22, 23, 24, 25, 26, 27',
                ],
                [
                    'name' => 'حذاء شتوي دافئ للأطفال',
                    'description' => 'حذاء شتوي دافئ ومقاوم للماء للأطفال مع بطانة فرو',
                    'price' => 180.00,
                    'brand' => 'نايكي',
                    'suitable_age' => '3-14 سنة',
                    'materials' => 'جلد طبيعي وفرو',
                    'sizes_available' => '24, 25, 26, 27, 28, 29, 30, 31, 32',
                ],
            ],

            // فئة الملابس
            'ملابس أطفال' => [
                [
                    'name' => 'طقم رياضي للأولاد',
                    'description' => 'طقم رياضي مريح ومرن للأولاد مكون من بنطال وقميص رياضي',
                    'price' => 95.00,
                    'brand' => 'أديداس',
                    'suitable_age' => '4-14 سنة',
                    'materials' => 'قطن وبوليستر',
                    'sizes_available' => 'XS, S, M, L, XL',
                ],
                [
                    'name' => 'فستان أنيق للبنات',
                    'description' => 'فستان أنيق وجميل للبنات مناسب للمناسبات الخاصة',
                    'price' => 110.00,
                    'brand' => 'زارا',
                    'suitable_age' => '3-12 سنة',
                    'materials' => 'قطن وحرير',
                    'sizes_available' => '2-3, 4-5, 6-7, 8-9, 10-11, 12-13',
                ],
                [
                    'name' => 'بيجامة مريحة للأطفال',
                    'description' => 'بيجامة مريحة وناعمة للأطفال من القطن الخالص',
                    'price' => 75.00,
                    'brand' => 'إتش آند إم',
                    'suitable_age' => '2-12 سنة',
                    'materials' => 'قطن 100%',
                    'sizes_available' => '2-3, 4-5, 6-7, 8-9, 10-11, 12-13',
                ],
            ],

            // فئة المراتب والفرش
            'مراتب وفرش أطفال' => [
                [
                    'name' => 'مرتبة طبية للأطفال',
                    'description' => 'مرتبة طبية مريحة ومناسبة لنمو العمود الفقري للأطفال',
                    'price' => 450.00,
                    'brand' => 'إيكيا',
                    'suitable_age' => '0-12 سنة',
                    'materials' => 'إسفنج طبي وقطن',
                    'sizes_available' => '70x140, 80x160, 90x180',
                ],
                [
                    'name' => 'مجموعة أغطية سرير ملونة',
                    'description' => 'مجموعة أغطية سرير ملونة ومرحة للأطفال مع رسومات كرتونية',
                    'price' => 85.00,
                    'brand' => 'هوم سنتر',
                    'suitable_age' => '2-12 سنة',
                    'materials' => 'قطن مخلوط',
                    'sizes_available' => 'مفرد, مزدوج صغير',
                ],
            ],

            // فئة الكتب
            'كتب تعليمية' => [
                [
                    'name' => 'موسوعة الطفل العلمية المصورة',
                    'description' => 'موسوعة علمية شاملة ومصورة للأطفال تغطي جميع المواضيع العلمية',
                    'price' => 150.00,
                    'brand' => null,
                    'suitable_age' => '6-14 سنة',
                    'materials' => 'ورق عالي الجودة',
                    'pieces_count' => '500 صفحة',
                ],
                [
                    'name' => 'كتاب تعليم الحروف العربية بالصور',
                    'description' => 'كتاب تفاعلي لتعليم الحروف العربية مع صور ملونة وأنشطة ممتعة',
                    'price' => 45.00,
                    'brand' => null,
                    'suitable_age' => '3-7 سنوات',
                    'materials' => 'ورق مقوى',
                    'pieces_count' => '32 صفحة',
                ],
                [
                    'name' => 'مجموعة قصص ما قبل النوم',
                    'description' => 'مجموعة من 10 قصص جميلة ومفيدة لما قبل النوم مع رسوم توضيحية',
                    'price' => 85.00,
                    'brand' => null,
                    'suitable_age' => '2-8 سنوات',
                    'materials' => 'ورق عالي الجودة',
                    'pieces_count' => '10 كتب',
                ],
            ],

            // فئة مستحضرات العناية
            'مستحضرات عناية بالأطفال' => [
                [
                    'name' => 'شامبو لطيف للأطفال',
                    'description' => 'شامبو لطيف ومناسب لشعر الأطفال الحساس، خالي من المواد الضارة',
                    'price' => 35.00,
                    'brand' => 'جونسون آند جونسون',
                    'suitable_age' => '0-12 سنة',
                    'materials' => 'مواد طبيعية',
                    'size' => '300 مل',
                ],
                [
                    'name' => 'كريم ترطيب للأطفال',
                    'description' => 'كريم ترطيب ناعم وآمن لبشرة الأطفال الحساسة',
                    'price' => 45.00,
                    'brand' => 'نيفيا',
                    'suitable_age' => '0-12 سنة',
                    'materials' => 'مواد طبيعية مرطبة',
                    'size' => '200 مل',
                ],
                [
                    'name' => 'مجموعة العناية الشاملة للرضع',
                    'description' => 'مجموعة شاملة للعناية بالرضع تشمل شامبو وصابون وكريم ولوشن',
                    'price' => 120.00,
                    'brand' => 'جونسون آند جونسون',
                    'suitable_age' => '0-2 سنة',
                    'materials' => 'مواد طبيعية آمنة',
                    'pieces_count' => '4 منتجات',
                ],
            ],

            // فئة الدراجات والألعاب الحركية
            'دراجات وألعاب حركية' => [
                [
                    'name' => 'دراجة أطفال ثلاثية العجلات',
                    'description' => 'دراجة آمنة ومستقرة للأطفال الصغار مع مقعد مريح ومقود قابل للتعديل',
                    'price' => 180.00,
                    'brand' => null,
                    'suitable_age' => '2-5 سنوات',
                    'materials' => 'معدن وبلاستيك مقاوم',
                    'weight' => '5 كيلو',
                ],
                [
                    'name' => 'سكوتر للأطفال قابل للطي',
                    'description' => 'سكوتر خفيف وآمن للأطفال مع عجلات LED ومكابح يدوية',
                    'price' => 150.00,
                    'brand' => null,
                    'suitable_age' => '5-12 سنة',
                    'materials' => 'ألومنيوم وبلاستيك',
                    'weight' => '3.5 كيلو',
                ],
                [
                    'name' => 'حصان هزاز خشبي كلاسيكي',
                    'description' => 'حصان هزاز خشبي تقليدي وآمن للأطفال مع مقاعد مريحة',
                    'price' => 220.00,
                    'brand' => null,
                    'suitable_age' => '18 شهر - 4 سنوات',
                    'materials' => 'خشب طبيعي',
                    'weight' => '8 كيلو',
                ],
            ],
        ];

        foreach ($subcategoryProducts as $categoryName => $products) {
            $category = $categories[$categoryName] ?? null;
            if (!$category) continue;

            foreach ($products as $productData) {
                $this->createProduct($productData, $category, $brands);
            }
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
        $productData['sku'] = 'PROD-' . str_pad($this->skuCounter++, 4, '0', STR_PAD_LEFT);
        $productData['stock'] = rand(8, 60);
        $productData['stock_quantity'] = $productData['stock'];
        $productData['is_active'] = true;
        $productData['is_featured'] = rand(0, 2) == 1; // 33% chance of being featured
        $productData['country_of_origin'] = $productData['country_of_origin'] ?? 'الصين';
        $productData['warranty_period'] = $productData['warranty_period'] ?? 'سنة واحدة';
        $productData['weight'] = $productData['weight'] ?? rand(150, 2500) . ' جرام';
        $productData['standards'] = $productData['standards'] ?? 'CE, EN71, ASTM';

        // Add sale price for some products (40% chance)
        if (rand(0, 4) < 2) {
            $discount = rand(10, 30); // 10% to 30% discount
            $productData['sale_price'] = round($productData['price'] * (1 - $discount/100), 2);
        }

        $product = Product::create($productData);

        // Create product images
        $this->createProductImages($product);

        // Create product sizes (especially important for shoes and clothes)
        $this->createProductSizes($product, $productData);

        return $product;
    }

    private function createProductImages($product)
    {
        $imageCount = rand(3, 6);
        for ($i = 1; $i <= $imageCount; $i++) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/product-' . $product->id . '-image-' . $i . '.jpg',
                'is_primary' => $i == 1
            ]);
        }
    }

    private function createProductSizes($product, $productData)
    {
        // Check if this product has specific sizes
        if (isset($productData['sizes_available'])) {
            $specificSizes = explode(', ', $productData['sizes_available']);
            foreach ($specificSizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => trim($size),
                    'stock_quantity' => rand(2, 15),
                    'additional_price' => 0,
                    'size_type' => 'number',
                    'is_available' => true,
                    'is_popular' => rand(0, 1) == 1
                ]);
            }
        } else {
            // Default sizes for general products
            $sizes = ['صغير', 'متوسط', 'كبير'];
            $selectedSizes = array_slice($sizes, 0, rand(1, 3));

            foreach ($selectedSizes as $index => $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'stock_quantity' => rand(5, 25),
                    'additional_price' => $index * rand(0, 20),
                    'size_type' => 'custom',
                    'is_available' => true,
                    'is_popular' => rand(0, 1) == 1
                ]);
            }
        }
    }
}
