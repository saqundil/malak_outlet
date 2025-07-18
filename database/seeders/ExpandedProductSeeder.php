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

class ExpandedProductSeeder extends Seeder
{
    private $skuCounter = 100;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and brands
        $categories = Category::all()->keyBy('name');
        $brands = Brand::all()->keyBy('name');

        // Add more products for each category
        $this->seedMoreProducts($categories, $brands);

        $this->command->info('تم إضافة المزيد من المنتجات بنجاح!');
    }

    private function seedMoreProducts($categories, $brands)
    {
        $additionalProducts = [
            // المزيد من الألعاب التعليمية
            'الألعاب التعليمية' => [
                [
                    'name' => 'بازل الخريطة العربية التعليمي',
                    'description' => 'بازل تعليمي للخريطة العربية مع أسماء الدول والعواصم، مثالي لتعليم الجغرافيا',
                    'price' => 65.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '5-12 سنة',
                    'materials' => 'ورق مقوى عالي الجودة',
                ],
                [
                    'name' => 'آلة حاسبة تعليمية للأطفال',
                    'description' => 'آلة حاسبة ملونة وسهلة الاستخدام لتعليم الرياضيات والحساب للأطفال',
                    'price' => 45.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '4-10 سنوات',
                    'materials' => 'بلاستيك آمن',
                    'battery_type' => 'بطاريتان AA',
                ],
                [
                    'name' => 'مجموعة التجارب العلمية للأطفال',
                    'description' => 'مجموعة شاملة من التجارب العلمية الآمنة والممتعة لتعليم الأطفال العلوم',
                    'price' => 180.00,
                    'brand' => 'هاسبرو',
                    'suitable_age' => '8-14 سنة',
                    'materials' => 'بلاستيك ومواد آمنة',
                    'pieces_count' => 'أكثر من 40 قطعة',
                ],
            ],

            // المزيد من ليجو ومكعبات البناء
            'ليجو ومكعبات البناء' => [
                [
                    'name' => 'مجموعة ليجو كاسل - القلعة الملكية',
                    'description' => 'مجموعة ليجو لبناء قلعة ملكية ضخمة مع فرسان وأحصنة وملحقات متنوعة',
                    'price' => 520.00,
                    'brand' => 'ليجو',
                    'suitable_age' => '8-16 سنة',
                    'materials' => 'بلاستيك ABS عالي الجودة',
                    'pieces_count' => '984 قطعة',
                ],
                [
                    'name' => 'مكعبات بناء مغناطيسية ملونة',
                    'description' => 'مكعبات بناء مغناطيسية ثلاثية الأبعاد لتطوير الخيال والمهارات الهندسية',
                    'price' => 160.00,
                    'brand' => 'بلايموبيل',
                    'suitable_age' => '3-10 سنوات',
                    'materials' => 'بلاستيك مع مغناطيس آمن',
                    'pieces_count' => '68 قطعة',
                ],
                [
                    'name' => 'ليجو تكنيك - سيارة سباق',
                    'description' => 'مجموعة ليجو تكنيك لبناء سيارة سباق متطورة مع محرك وتروس متحركة',
                    'price' => 340.00,
                    'brand' => 'ليجو',
                    'suitable_age' => '10+ سنة',
                    'materials' => 'بلاستيك ABS عالي الجودة',
                    'pieces_count' => '463 قطعة',
                ],
            ],

            // المزيد من ألعاب الأطفال الصغار
            'ألعاب الأطفال الصغار' => [
                [
                    'name' => 'لعبة القطار الموسيقي الناطق',
                    'description' => 'قطار ملون يتحرك ويصدر أصوات موسيقية ويعلم الألوان والأرقام',
                    'price' => 85.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '1-4 سنوات',
                    'materials' => 'بلاستيك آمن',
                    'battery_type' => '3 بطاريات AA',
                ],
                [
                    'name' => 'مكعبات التكديس والتصنيف',
                    'description' => 'مجموعة مكعبات ملونة للتكديس والتصنيف لتطوير المهارات الحركية الدقيقة',
                    'price' => 55.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '6 أشهر - 3 سنوات',
                    'materials' => 'بلاستيك آمن خالي من BPA',
                ],
                [
                    'name' => 'مشاية أطفال موسيقية متعددة الوظائف',
                    'description' => 'مشاية أطفال آمنة مع ألعاب تعليمية وموسيقى لتعلم المشي بأمان',
                    'price' => 280.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '6-18 شهر',
                    'materials' => 'بلاستيك وقماش آمن',
                ],
            ],

            // المزيد من الألعاب الإلكترونية
            'الألعاب الإلكترونية' => [
                [
                    'name' => 'تابلت تعليمي للأطفال',
                    'description' => 'تابلت تعليمي مصمم خصيصاً للأطفال مع تطبيقات تعليمية وألعاب آمنة',
                    'price' => 420.00,
                    'brand' => 'سامسونج',
                    'suitable_age' => '4-12 سنة',
                    'materials' => 'بلاستيك مقاوم للصدمات',
                    'connectivity' => 'WiFi',
                    'battery_type' => 'بطارية ليثيوم قابلة للشحن',
                ],
                [
                    'name' => 'ساعة ذكية للأطفال مع GPS',
                    'description' => 'ساعة ذكية آمنة للأطفال مع نظام تتبع GPS ومكالمات طوارئ',
                    'price' => 180.00,
                    'brand' => 'شاومي',
                    'suitable_age' => '5-14 سنة',
                    'materials' => 'سيليكون وبلاستيك',
                    'connectivity' => '4G, GPS, WiFi',
                    'battery_type' => 'بطارية ليثيوم',
                ],
                [
                    'name' => 'جهاز ألعاب محمول للأطفال',
                    'description' => 'جهاز ألعاب محمول مع شاشة ملونة وألعاب تعليمية وترفيهية متنوعة',
                    'price' => 150.00,
                    'brand' => 'سوني',
                    'suitable_age' => '6-16 سنة',
                    'materials' => 'بلاستيك عالي الجودة',
                    'battery_type' => 'بطارية ليثيوم قابلة للشحن',
                ],
            ],

            // المزيد من ألعاب الأولاد
            'ألعاب الأولاد' => [
                [
                    'name' => 'مجموعة جنود ومعدات عسكرية',
                    'description' => 'مجموعة من الجنود والمعدات العسكرية المصغرة للعب التخيلي والمغامرات',
                    'price' => 95.00,
                    'brand' => 'هاسبرو',
                    'suitable_age' => '4-12 سنة',
                    'materials' => 'بلاستيك متين',
                    'pieces_count' => '25 قطعة',
                ],
                [
                    'name' => 'مضمار سباق السيارات الكهربائي',
                    'description' => 'مضمار سباق مثير مع سيارتين كهربائيتين وجهازي تحكم عن بُعد',
                    'price' => 250.00,
                    'brand' => 'ماتيل',
                    'suitable_age' => '6-14 سنة',
                    'materials' => 'بلاستيك ومعدن',
                    'battery_type' => 'بطاريات AA',
                ],
                [
                    'name' => 'مجموعة الديناصورات الواقعية',
                    'description' => 'مجموعة من الديناصورات البلاستيكية الواقعية مع كتاب معلومات عن الديناصورات',
                    'price' => 120.00,
                    'brand' => 'ماتيل',
                    'suitable_age' => '3-10 سنوات',
                    'materials' => 'بلاستيك عالي الجودة',
                    'pieces_count' => '12 ديناصور',
                ],
            ],

            // المزيد من ألعاب البنات
            'ألعاب البنات' => [
                [
                    'name' => 'مجموعة تصفيف الشعر والتجميل',
                    'description' => 'مجموعة كاملة لتصفيف الشعر والتجميل مع مرآة وإكسسوارات متنوعة',
                    'price' => 110.00,
                    'brand' => 'ماتيل',
                    'suitable_age' => '4-12 سنة',
                    'materials' => 'بلاستيك وقماش آمن',
                    'washable' => 'نعم',
                ],
                [
                    'name' => 'عربة أطفال للدمى مع إكسسوارات',
                    'description' => 'عربة أطفال أنيقة للدمى مع بطانية وزجاجة رضاعة وإكسسوارات العناية',
                    'price' => 85.00,
                    'brand' => 'ماتيل',
                    'suitable_age' => '3-8 سنوات',
                    'materials' => 'بلاستيك وقماش',
                ],
                [
                    'name' => 'مطبخ الأطفال الشامل مع أدوات الطبخ',
                    'description' => 'مطبخ أطفال كامل مع فرن وثلاجة وحوض ومجموعة شاملة من أدوات الطبخ',
                    'price' => 380.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '3-8 سنوات',
                    'materials' => 'بلاستيك عالي الجودة',
                    'pieces_count' => 'أكثر من 40 قطعة',
                ],
            ],
        ];

        foreach ($additionalProducts as $categoryName => $products) {
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
        $productData['stock'] = rand(5, 80);
        $productData['stock_quantity'] = $productData['stock'];
        $productData['is_active'] = true;
        $productData['is_featured'] = rand(0, 1) == 1;
        $productData['country_of_origin'] = $productData['country_of_origin'] ?? 'الصين';
        $productData['warranty_period'] = $productData['warranty_period'] ?? 'سنة واحدة';
        $productData['weight'] = $productData['weight'] ?? rand(100, 3000) . ' جرام';
        $productData['standards'] = $productData['standards'] ?? 'CE, EN71, ASTM';

        // Add sale price for some products
        if (rand(0, 2) == 1) {
            $discount = rand(5, 25); // 5% to 25% discount
            $productData['sale_price'] = $productData['price'] * (1 - $discount/100);
        }

        $product = Product::create($productData);

        // Create product images
        $this->createProductImages($product);

        // Create product sizes
        $this->createProductSizes($product);

        return $product;
    }

    private function createProductImages($product)
    {
        $imageCount = rand(2, 5);
        for ($i = 1; $i <= $imageCount; $i++) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/product-' . $product->id . '-image-' . $i . '.jpg',
                'is_primary' => $i == 1
            ]);
        }
    }

    private function createProductSizes($product)
    {
        $sizes = ['صغير', 'متوسط', 'كبير', 'كبير جداً'];
        $selectedSizes = array_slice($sizes, 0, rand(1, 3));

        foreach ($selectedSizes as $index => $size) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $size,
                'stock_quantity' => rand(3, 30),
                'additional_price' => $index * rand(5, 30), // Larger sizes cost more
                'size_type' => 'custom',
                'is_available' => true,
                'is_popular' => rand(0, 1) == 1
            ]);
        }
    }
}
