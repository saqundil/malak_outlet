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

class MassiveProductSeeder extends Seeder
{
    private $skuCounter = 300;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and brands
        $categories = Category::all()->keyBy('name');
        $brands = Brand::all()->keyBy('name');

        // Add many more products
        $this->seedMassiveProducts($categories, $brands);

        $this->command->info('تم إضافة عدد كبير من المنتجات بنجاح!');
    }

    private function seedMassiveProducts($categories, $brands)
    {
        $massiveProducts = [
            // الألعاب التعليمية - منتجات إضافية
            'الألعاب التعليمية' => [
                ['name' => 'لوحة الرسم المغناطيسية الكبيرة', 'description' => 'لوحة رسم مغناطيسية كبيرة مع قلم وختم وأشكال متنوعة', 'price' => 95.00, 'brand' => 'فيشر برايس'],
                ['name' => 'مجموعة الحروف الخشبية المغناطيسية', 'description' => 'مجموعة من الحروف الخشبية المغناطيسية الملونة لتعلم القراءة والكتابة', 'price' => 75.00, 'brand' => 'فيشر برايس'],
                ['name' => 'كتاب الأنشطة التفاعلي الناطق', 'description' => 'كتاب تفاعلي مع أصوات وموسيقى لتعليم المفاهيم الأساسية', 'price' => 125.00, 'brand' => 'سوني'],
                ['name' => 'مجموعة أدوات الهندسة للأطفال', 'description' => 'مجموعة كاملة من أدوات الهندسة الآمنة للأطفال مع دليل تعليمي', 'price' => 65.00, 'brand' => 'هاسبرو'],
                ['name' => 'لعبة البرمجة للمبتدئين', 'description' => 'لعبة تعليمية لتعلم أساسيات البرمجة بطريقة ممتعة ومبسطة', 'price' => 150.00, 'brand' => 'سوني'],
            ],

            // ليجو ومكعبات البناء - منتجات إضافية
            'ليجو ومكعبات البناء' => [
                ['name' => 'مجموعة ليجو فريندز - منزل الأحلام', 'description' => 'مجموعة ليجو لبناء منزل أحلام البنات مع أثاث وشخصيات', 'price' => 380.00, 'brand' => 'ليجو'],
                ['name' => 'مكعبات البناء العملاقة - 100 قطعة', 'description' => 'مكعبات بناء كبيرة الحجم وآمنة للأطفال الصغار', 'price' => 180.00, 'brand' => 'بلايموبيل'],
                ['name' => 'مجموعة ليجو النينجا - القتال الأسطوري', 'description' => 'مجموعة ليجو نينجا مع معبد وآليات قتال وشخصيات متنوعة', 'price' => 420.00, 'brand' => 'ليجو'],
                ['name' => 'مكعبات البناء المضيئة', 'description' => 'مكعبات بناء شفافة مع إضاءة LED داخلية ملونة', 'price' => 220.00, 'brand' => 'بلايموبيل'],
                ['name' => 'مجموعة ليجو الفضاء - محطة الفضاء', 'description' => 'مجموعة ليجو لبناء محطة فضائية مع مركبات فضائية ورواد فضاء', 'price' => 480.00, 'brand' => 'ليجو'],
            ],

            // ألعاب الأطفال الصغار - منتجات إضافية
            'ألعاب الأطفال الصغار' => [
                ['name' => 'دمية تفاعلية ناطقة', 'description' => 'دمية ناعمة تتفاعل مع الطفل وتصدر أصوات وكلمات مشجعة', 'price' => 120.00, 'brand' => 'فيشر برايس'],
                ['name' => 'مجموعة الحيوانات المطاطية', 'description' => 'مجموعة من الحيوانات المطاطية الملونة والآمنة للأطفال الصغار', 'price' => 45.00, 'brand' => 'فيشر برايس'],
                ['name' => 'لعبة الكرات الملونة مع النفق', 'description' => 'مجموعة كرات ملونة مع نفق للعب والاستكشاف', 'price' => 85.00, 'brand' => 'فيشر برايس'],
                ['name' => 'طاولة الأنشطة التفاعلية', 'description' => 'طاولة أنشطة متعددة الوظائف مع أضواء وأصوات وألعاب', 'price' => 180.00, 'brand' => 'فيشر برايس'],
                ['name' => 'سيارة الدفع للأطفال', 'description' => 'سيارة آمنة للأطفال للدفع والركوب مع مقعد مريح', 'price' => 200.00, 'brand' => 'ماتيل'],
            ],

            // الألعاب الإلكترونية - منتجات إضافية
            'الألعاب الإلكترونية' => [
                ['name' => 'جهاز لعب محمول تعليمي', 'description' => 'جهاز لعب محمول مع شاشة ملونة وألعاب تعليمية متنوعة', 'price' => 180.00, 'brand' => 'سوني'],
                ['name' => 'سيارة تحكم عن بُعد سريعة', 'description' => 'سيارة سباق بتحكم عن بُعد عالية السرعة ومقاومة للصدمات', 'price' => 150.00, 'brand' => 'شاومي'],
                ['name' => 'روبوت كلب ذكي', 'description' => 'روبوت على شكل كلب يتفاعل ويرقص ويستجيب للأوامر الصوتية', 'price' => 320.00, 'brand' => 'سوني'],
                ['name' => 'كاميرا رقمية للأطفال', 'description' => 'كاميرا رقمية مصممة خصيصاً للأطفال مع ألعاب وفلاتر ممتعة', 'price' => 120.00, 'brand' => 'سامسونج'],
                ['name' => 'جهاز الواقع الافتراضي للأطفال', 'description' => 'جهاز واقع افتراضي آمن للأطفال مع ألعاب تعليمية وترفيهية', 'price' => 250.00, 'brand' => 'سامسونج'],
            ],

            // ألعاب الأولاد - منتجات إضافية
            'ألعاب الأولاد' => [
                ['name' => 'مجموعة الأبطال الخارقين', 'description' => 'مجموعة من الأبطال الخارقين مع إكسسوارات وقوى خاصة', 'price' => 95.00, 'brand' => 'هاسبرو'],
                ['name' => 'مدينة السيارات الكاملة', 'description' => 'مجموعة كاملة لبناء مدينة السيارات مع طرق وإشارات ومباني', 'price' => 280.00, 'brand' => 'ماتيل'],
                ['name' => 'مجموعة القراصنة والكنز', 'description' => 'مجموعة القراصنة مع سفينة وكنز وشخصيات متنوعة', 'price' => 160.00, 'brand' => 'بلايموبيل'],
                ['name' => 'مجموعة رجال الإطفاء الشجعان', 'description' => 'مجموعة شاملة لرجال الإطفاء مع شاحنة إطفاء ومعدات', 'price' => 200.00, 'brand' => 'بلايموبيل'],
                ['name' => 'مجموعة استكشاف الفضاء', 'description' => 'مجموعة رواد الفضاء مع مركبة فضائية ومعدات استكشاف', 'price' => 220.00, 'brand' => 'هاسبرو'],
            ],

            // ألعاب البنات - منتجات إضافية
            'ألعاب البنات' => [
                ['name' => 'صالون تجميل الأميرات', 'description' => 'صالون تجميل كامل مع مرآة ومقعد وأدوات تجميل آمنة', 'price' => 180.00, 'brand' => 'ماتيل'],
                ['name' => 'مجموعة الطبخ الصغيرة', 'description' => 'مجموعة أدوات طبخ صغيرة وآمنة مع وصفات سهلة للأطفال', 'price' => 95.00, 'brand' => 'فيشر برايس'],
                ['name' => 'دمية العروس الفاخرة', 'description' => 'دمية عروس جميلة مع فستان فاخر وإكسسوارات متنوعة', 'price' => 150.00, 'brand' => 'ماتيل'],
                ['name' => 'مجموعة الحيوانات الأليفة المحشوة', 'description' => 'مجموعة من الحيوانات المحشوة الناعمة والجميلة', 'price' => 85.00, 'brand' => 'ماتيل'],
                ['name' => 'قلعة الأميرات السحرية', 'description' => 'قلعة كبيرة وجميلة للأميرات مع أثاث وشخصيات', 'price' => 320.00, 'brand' => 'ماتيل'],
            ],

            // أحذية أطفال - منتجات إضافية
            'أحذية أطفال' => [
                ['name' => 'حذاء باليه للبنات', 'description' => 'حذاء باليه أنيق ومريح للبنات مع تصميم كلاسيكي', 'price' => 85.00, 'brand' => 'أديداس'],
                ['name' => 'بوت المطر الملون', 'description' => 'بوت مطر مقاوم للماء وملون للأطفال مع نعل مانع للانزلاق', 'price' => 65.00, 'brand' => 'نايكي'],
                ['name' => 'حذاء كرة القدم للأطفال', 'description' => 'حذاء كرة قدم مناسب للأطفال مع تصميم رياضي ونعل متين', 'price' => 150.00, 'brand' => 'أديداس'],
                ['name' => 'شبشب منزلي مريح', 'description' => 'شبشب منزلي ناعم ومريح للأطفال مع تصميم كرتوني', 'price' => 35.00, 'brand' => 'نايكي'],
                ['name' => 'حذاء المدرسة الكلاسيكي', 'description' => 'حذاء مدرسة كلاسيكي أسود اللون مريح ومتين للاستخدام اليومي', 'price' => 120.00, 'brand' => 'بوما'],
            ],

            // ملابس أطفال - منتجات إضافية
            'ملابس أطفال' => [
                ['name' => 'مجموعة ملابس الشتاء الدافئة', 'description' => 'مجموعة ملابس شتوية دافئة ومريحة للأطفال', 'price' => 150.00, 'brand' => 'زارا'],
                ['name' => 'تيشيرت بأكمام طويلة ملون', 'description' => 'تيشيرت قطني بأكمام طويلة مع طبعات ملونة وجميلة', 'price' => 45.00, 'brand' => 'إتش آند إم'],
                ['name' => 'جاكيت شتوي مقاوم للرياح', 'description' => 'جاكيت شتوي عملي ومقاوم للرياح والبرد للأطفال', 'price' => 180.00, 'brand' => 'نايكي'],
                ['name' => 'شورت صيفي مريح', 'description' => 'شورت صيفي خفيف ومريح للأطفال مناسب للأنشطة الرياضية', 'price' => 55.00, 'brand' => 'أديداس'],
                ['name' => 'فستان الحفلات الأنيق', 'description' => 'فستان أنيق وجميل للبنات مناسب للحفلات والمناسبات الخاصة', 'price' => 200.00, 'brand' => 'زارا'],
            ],

            // مستحضرات عناية بالأطفال - منتجات إضافية
            'مستحضرات عناية بالأطفال' => [
                ['name' => 'صابون الأطفال الطبيعي', 'description' => 'صابون طبيعي ولطيف مناسب لبشرة الأطفال الحساسة', 'price' => 25.00, 'brand' => 'جونسون آند جونسون'],
                ['name' => 'بودرة الأطفال المعطرة', 'description' => 'بودرة أطفال ناعمة ومعطرة لحماية البشرة من التهيج', 'price' => 30.00, 'brand' => 'جونسون آند جونسون'],
                ['name' => 'زيت تدليك الأطفال', 'description' => 'زيت طبيعي ولطيف لتدليك الأطفال وترطيب البشرة', 'price' => 40.00, 'brand' => 'جونسون آند جونسون'],
                ['name' => 'كريم الحماية من الشمس للأطفال', 'description' => 'كريم حماية عالي من أشعة الشمس مناسب للأطفال', 'price' => 55.00, 'brand' => 'نيفيا'],
                ['name' => 'مناديل مبللة للأطفال', 'description' => 'مناديل مبللة ناعمة وآمنة للأطفال خالية من الكحول', 'price' => 20.00, 'brand' => 'جونسون آند جونسون'],
            ],

            // كتب تعليمية - منتجات إضافية
            'كتب تعليمية' => [
                ['name' => 'أطلس العالم للأطفال', 'description' => 'أطلس ملون وتفاعلي للأطفال لتعلم جغرافيا العالم', 'price' => 95.00, 'brand' => null],
                ['name' => 'كتاب تعليم الرياضيات المبسط', 'description' => 'كتاب ممتع لتعليم الرياضيات للأطفال مع أمثلة عملية', 'price' => 65.00, 'brand' => null],
                ['name' => 'قاموس الأطفال المصور', 'description' => 'قاموس مصور ومبسط للأطفال لتعلم المفردات الجديدة', 'price' => 75.00, 'brand' => null],
                ['name' => 'كتاب التلوين التعليمي', 'description' => 'كتاب تلوين مع معلومات تعليمية مفيدة وممتعة', 'price' => 35.00, 'brand' => null],
                ['name' => 'مجموعة كتب الحيوانات', 'description' => 'مجموعة من الكتب المصورة عن الحيوانات وبيئاتها', 'price' => 120.00, 'brand' => null],
            ],
        ];

        foreach ($massiveProducts as $categoryName => $products) {
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
        $productData['stock'] = rand(10, 80);
        $productData['stock_quantity'] = $productData['stock'];
        $productData['is_active'] = true;
        $productData['is_featured'] = rand(0, 3) == 1; // 25% chance of being featured
        $productData['country_of_origin'] = 'الصين';
        $productData['warranty_period'] = 'سنة واحدة';
        $productData['weight'] = rand(100, 2000) . ' جرام';
        $productData['standards'] = 'CE, EN71, ASTM';
        $productData['suitable_age'] = $productData['suitable_age'] ?? '3-12 سنة';
        $productData['materials'] = $productData['materials'] ?? 'بلاستيك آمن';

        // Add sale price for 30% of products
        if (rand(0, 9) < 3) {
            $discount = rand(10, 25); // 10% to 25% discount
            $productData['sale_price'] = round($productData['price'] * (1 - $discount/100), 2);
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
        $imageCount = rand(3, 5);
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
        $sizes = ['صغير', 'متوسط', 'كبير'];
        $selectedSizes = array_slice($sizes, 0, rand(1, 3));

        foreach ($selectedSizes as $index => $size) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $size,
                'stock_quantity' => rand(5, 30),
                'additional_price' => $index * rand(0, 15),
                'size_type' => 'custom',
                'is_available' => true,
                'is_popular' => rand(0, 1) == 1
            ]);
        }
    }
}
