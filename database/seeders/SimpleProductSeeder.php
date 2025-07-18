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

class SimpleProductSeeder extends Seeder
{
    private $skuCounter = 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and brands
        $categories = Category::all()->keyBy('name');
        $brands = Brand::all()->keyBy('name');

        // Seed products for each category
        $this->seedCategoryProducts($categories, $brands);

        $this->command->info('تم إنشاء منتجات شاملة لجميع الفئات بنجاح!');
    }

    private function seedCategoryProducts($categories, $brands)
    {
        $allProducts = [
            // الألعاب التعليمية
            'الألعاب التعليمية' => [
                [
                    'name' => 'لوحة تعليم الحروف والأرقام المغناطيسية',
                    'description' => 'لوحة تعليمية مغناطيسية تساعد الأطفال على تعلم الحروف العربية والإنجليزية والأرقام بطريقة ممتعة وتفاعلية',
                    'price' => 85.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '3-6 سنوات',
                    'materials' => 'بلاستيك آمن',
                ],
                [
                    'name' => 'مكعبات خشبية تعليمية ملونة',
                    'description' => 'مجموعة من المكعبات الخشبية الملونة لتعليم الألوان والأشكال والحساب، مصنوعة من خشب طبيعي آمن',
                    'price' => 120.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '2-5 سنوات',
                    'materials' => 'خشب طبيعي',
                ],
                [
                    'name' => 'جهاز تعليم الكلمات الناطق',
                    'description' => 'جهاز إلكتروني تعليمي ينطق الكلمات العربية والإنجليزية مع الصور لتعزيز مهارات النطق والفهم',
                    'price' => 200.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '3-7 سنوات',
                    'materials' => 'بلاستيك متين',
                    'battery_type' => '3 بطاريات AA',
                ],
            ],

            // ليجو ومكعبات البناء
            'ليجو ومكعبات البناء' => [
                [
                    'name' => 'مجموعة ليجو سيتي - محطة الإطفاء',
                    'description' => 'مجموعة ليجو سيتي الكاملة لبناء محطة إطفاء مع شاحنات الإطفاء والشخصيات، تحتوي على 752 قطعة',
                    'price' => 450.00,
                    'brand' => 'ليجو',
                    'suitable_age' => '6-12 سنة',
                    'materials' => 'بلاستيك ABS عالي الجودة',
                    'pieces_count' => '752 قطعة',
                ],
                [
                    'name' => 'ليجو كريتور - ديناصور تيرانوصورس',
                    'description' => 'مجموعة ليجو كريتور لبناء ديناصور تيرانوصورس ضخم مع إمكانية تحريك الفك والذراعين',
                    'price' => 380.00,
                    'brand' => 'ليجو',
                    'suitable_age' => '7-14 سنة',
                    'materials' => 'بلاستيك ABS عالي الجودة',
                    'pieces_count' => '619 قطعة',
                ],
                [
                    'name' => 'مكعبات بناء ملونة للأطفال - 200 قطعة',
                    'description' => 'مجموعة من مكعبات البناء الملونة المتوافقة مع ليجو، مثالية لتطوير الإبداع والخيال',
                    'price' => 95.00,
                    'brand' => 'بلايموبيل',
                    'suitable_age' => '3-8 سنوات',
                    'materials' => 'بلاستيك آمن',
                    'pieces_count' => '200 قطعة',
                ],
            ],

            // ألعاب الأطفال الصغار
            'ألعاب الأطفال الصغار' => [
                [
                    'name' => 'خشخيشة موسيقية ملونة للرضع',
                    'description' => 'خشخيشة آمنة للرضع مع أصوات موسيقية هادئة وألوان زاهية لتحفيز الحواس',
                    'price' => 35.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '0-12 شهر',
                    'materials' => 'بلاستيك آمن خالي من BPA',
                ],
                [
                    'name' => 'كرسي هزاز موسيقي للأطفال',
                    'description' => 'كرسي هزاز مريح مع موسيقى هادئة وألعاب معلقة، مثالي لتهدئة الطفل وتطوير مهاراته',
                    'price' => 320.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '0-18 شهر',
                    'materials' => 'قماش ناعم وبلاستيك آمن',
                ],
                [
                    'name' => 'لعبة الهاتف الذكي التعليمية للأطفال',
                    'description' => 'هاتف ذكي تعليمي للأطفال مع أضواء وأصوات تفاعلية لتعليم الأرقام والحروف',
                    'price' => 65.00,
                    'brand' => 'فيشر برايس',
                    'suitable_age' => '6 أشهر - 3 سنوات',
                    'materials' => 'بلاستيك متين',
                ],
            ],

            // الألعاب الإلكترونية
            'الألعاب الإلكترونية' => [
                [
                    'name' => 'روبوت ذكي قابل للبرمجة',
                    'description' => 'روبوت تفاعلي ذكي يمكن برمجته وتحكم به عن بُعد، مع إمكانيات تعليم البرمجة للأطفال',
                    'price' => 550.00,
                    'brand' => 'سوني',
                    'suitable_age' => '8-16 سنة',
                    'materials' => 'معدن وبلاستيك عالي الجودة',
                    'connectivity' => 'WiFi, Bluetooth',
                    'battery_type' => 'بطارية ليثيوم قابلة للشحن',
                ],
                [
                    'name' => 'طائرة درون صغيرة للأطفال',
                    'description' => 'طائرة درون آمنة للأطفال مع جهاز تحكم عن بُعد وكاميرا، مثالية للمبتدئين',
                    'price' => 280.00,
                    'brand' => 'شاومي',
                    'suitable_age' => '10+ سنة',
                    'materials' => 'بلاستيك مقاوم للصدمات',
                    'connectivity' => 'Remote Control',
                    'battery_type' => 'بطارية ليثيوم',
                ],
                [
                    'name' => 'لوحة مفاتيح موسيقية إلكترونية',
                    'description' => 'لوحة مفاتيح موسيقية إلكترونية بـ 61 مفتاح مع أصوات متنوعة وإيقاعات تعليمية',
                    'price' => 220.00,
                    'brand' => 'سوني',
                    'suitable_age' => '5-15 سنة',
                    'materials' => 'بلاستيك ومعدن',
                    'connectivity' => 'Audio Jack',
                    'power_consumption' => '12V DC',
                ],
            ],

            // ألعاب الأولاد
            'ألعاب الأولاد' => [
                [
                    'name' => 'مجموعة سيارات رياضية معدنية',
                    'description' => 'مجموعة من 12 سيارة رياضية معدنية بتفاصيل دقيقة وألوان متنوعة، مقاومة للصدمات',
                    'price' => 150.00,
                    'brand' => 'ماتيل',
                    'suitable_age' => '3-12 سنة',
                    'materials' => 'معدن عالي الجودة',
                    'pieces_count' => '12 سيارة',
                ],
                [
                    'name' => 'مجموعة أدوات ورشة العمل للأطفال',
                    'description' => 'مجموعة كاملة من أدوات العمل الآمنة للأطفال مع طاولة عمل وملحقات متنوعة',
                    'price' => 180.00,
                    'brand' => 'هاسبرو',
                    'suitable_age' => '4-10 سنوات',
                    'materials' => 'بلاستيك متين',
                    'pieces_count' => 'أكثر من 30 قطعة',
                ],
                [
                    'name' => 'شاحنة نقل كبيرة بجرافة متحركة',
                    'description' => 'شاحنة نقل كبيرة مع جرافة متحركة وصندوق قلاب، مثالية للعب في الرمال والحديقة',
                    'price' => 95.00,
                    'brand' => 'ماتيل',
                    'suitable_age' => '2-8 سنوات',
                    'materials' => 'بلاستيك مقاوم للطقس',
                ],
            ],

            // ألعاب البنات
            'ألعاب البنات' => [
                [
                    'name' => 'دمية باربي مع ملابس متنوعة',
                    'description' => 'دمية باربي جميلة مع مجموعة ملابس متنوعة وإكسسوارات أنيقة للعب والتجميل',
                    'price' => 120.00,
                    'brand' => 'ماتيل',
                    'suitable_age' => '3-12 سنة',
                    'materials' => 'بلاستيك عالي الجودة وقماش',
                ],
                [
                    'name' => 'مجموعة مكياج آمنة للأطفال',
                    'description' => 'مجموعة مكياج آمنة ومضادة للحساسية للأطفال مع مرآة وفرش متنوعة',
                    'price' => 85.00,
                    'brand' => 'لوريال',
                    'suitable_age' => '4-12 سنة',
                    'materials' => 'مواد طبيعية آمنة',
                    'washable' => 'نعم',
                ],
                [
                    'name' => 'بيت دمية من طابقين مع أثاث',
                    'description' => 'بيت دمية خشبي جميل من طابقين مع أثاث كامل ودمى صغيرة للعائلة',
                    'price' => 350.00,
                    'brand' => 'ماتيل',
                    'suitable_age' => '3-10 سنوات',
                    'materials' => 'خشب طبيعي وبلاستيك',
                    'pieces_count' => 'أكثر من 50 قطعة',
                ],
            ],
        ];

        foreach ($allProducts as $categoryName => $products) {
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
        $productData['stock'] = rand(10, 100);
        $productData['stock_quantity'] = $productData['stock'];
        $productData['is_active'] = true;
        $productData['is_featured'] = rand(0, 1) == 1;
        $productData['country_of_origin'] = $productData['country_of_origin'] ?? 'الصين';
        $productData['warranty_period'] = $productData['warranty_period'] ?? 'سنة واحدة';
        $productData['weight'] = $productData['weight'] ?? rand(100, 2000) . ' جرام';
        $productData['standards'] = $productData['standards'] ?? 'CE, EN71';

        // Add sale price for some products
        if (rand(0, 1) == 1) {
            $productData['sale_price'] = $productData['price'] * 0.9; // 10% discount
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
        $imageCount = rand(2, 4);
        for ($i = 1; $i <= $imageCount; $i++) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/product-' . $product->id . '-image-' . $i . '.jpg',
                'is_primary' => $i == 1 // First image is primary
            ]);
        }
    }

    private function createProductSizes($product)
    {
        $sizes = ['صغير', 'متوسط', 'كبير'];
        $selectedSizes = array_slice($sizes, 0, rand(1, 3));

        foreach ($selectedSizes as $size) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $size,
                'stock_quantity' => rand(5, 50),
                'additional_price' => rand(0, 20),
                'size_type' => 'custom',
                'is_available' => true,
                'is_popular' => rand(0, 1) == 1
            ]);
        }
    }
}
