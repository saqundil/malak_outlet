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

class SeasonalProductSeeder extends Seeder
{
    private $skuCounter = 500;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and brands
        $categories = Category::all()->keyBy('name');
        $brands = Brand::all()->keyBy('name');

        // Add seasonal and special offer products
        $this->seedSeasonalProducts($categories, $brands);

        $this->command->info('تم إضافة المنتجات الموسمية والعروض الخاصة بنجاح!');
    }

    private function seedSeasonalProducts($categories, $brands)
    {
        $seasonalProducts = [
            // منتجات العيد والمناسبات
            'الألعاب التعليمية' => [
                ['name' => 'مجموعة الحرف اليدوية للعيد', 'description' => 'مجموعة شاملة للحرف اليدوية لصناعة هدايا العيد', 'price' => 120.00, 'sale_price' => 89.99, 'brand' => 'فيشر برايس'],
                ['name' => 'ألعاب الذكاء والألغاز الموسمية', 'description' => 'مجموعة متنوعة من ألعاب الذكاء والألغاز المناسبة للعطل', 'price' => 95.00, 'sale_price' => 69.99, 'brand' => 'هاسبرو'],
            ],

            'ليجو ومكعبات البناء' => [
                ['name' => 'مجموعة ليجو العيد الخاص', 'description' => 'مجموعة ليجو محدودة الإصدار للعيد مع شخصيات خاصة', 'price' => 450.00, 'sale_price' => 349.99, 'brand' => 'ليجو'],
                ['name' => 'مكعبات البناء الذهبية المميزة', 'description' => 'مكعبات بناء ذهبية اللون لمناسبات خاصة', 'price' => 280.00, 'sale_price' => 219.99, 'brand' => 'ليجو'],
            ],

            'الألعاب الإلكترونية' => [
                ['name' => 'روبوت راقص للعيد', 'description' => 'روبوت راقص مع موسيقى العيد والأضواء الملونة', 'price' => 350.00, 'sale_price' => 269.99, 'brand' => 'سوني'],
                ['name' => 'جهاز الألعاب المحمول الخاص', 'description' => 'جهاز ألعاب محمول مع ألعاب تعليمية وترفيهية خاصة', 'price' => 220.00, 'sale_price' => 169.99, 'brand' => 'سامسونج'],
            ],

            'ألعاب الأولاد' => [
                ['name' => 'مجموعة الفرسان الشجعان', 'description' => 'مجموعة شاملة من الفرسان مع قلعة وخيول وأسلحة', 'price' => 180.00, 'sale_price' => 129.99, 'brand' => 'بلايموبيل'],
                ['name' => 'سيارات السباق المعدنية المجموعة الخاصة', 'description' => 'مجموعة حصرية من سيارات السباق المعدنية', 'price' => 150.00, 'sale_price' => 109.99, 'brand' => 'ماتيل'],
            ],

            'ألعاب البنات' => [
                ['name' => 'مجموعة الأميرات الثلاث', 'description' => 'مجموعة من ثلاث دمى أميرات مع فساتين فاخرة', 'price' => 200.00, 'sale_price' => 149.99, 'brand' => 'ماتيل'],
                ['name' => 'بيت الأحلام الوردي الكبير', 'description' => 'بيت دمى كبير وردي اللون مع جميع الأثاث والإكسسوارات', 'price' => 380.00, 'sale_price' => 299.99, 'brand' => 'ماتيل'],
            ],

            // منتجات الهدايا المميزة
            'ألعاب الأطفال الصغار' => [
                ['name' => 'مجموعة هدايا الطفل الأول', 'description' => 'مجموعة هدايا متكاملة للطفل الأول مع حقيبة أنيقة', 'price' => 160.00, 'sale_price' => 119.99, 'brand' => 'فيشر برايس'],
                ['name' => 'لعبة النوم الهادئ المضيئة', 'description' => 'لعبة ليلية مضيئة مع موسيقى هادئة لمساعدة الطفل على النوم', 'price' => 85.00, 'sale_price' => 64.99, 'brand' => 'فيشر برايس'],
            ],

            // مجموعات الملابس الموسمية
            'ملابس أطفال' => [
                ['name' => 'مجموعة ملابس العيد للأولاد', 'description' => 'مجموعة ملابس أنيقة للأولاد مناسبة لمناسبات العيد', 'price' => 180.00, 'sale_price' => 139.99, 'brand' => 'زارا'],
                ['name' => 'فستان العيد المطرز للبنات', 'description' => 'فستان أنيق مطرز ومزين مناسب لمناسبات العيد', 'price' => 220.00, 'sale_price' => 169.99, 'brand' => 'زارا'],
                ['name' => 'بيجامة الأطفال الدافئة', 'description' => 'بيجامة دافئة ومريحة للأطفال مع تصاميم شتوية', 'price' => 85.00, 'sale_price' => 64.99, 'brand' => 'إتش آند إم'],
                ['name' => 'معطف الشتاء الأنيق', 'description' => 'معطف شتوي أنيق ودافئ للأطفال مقاوم للماء', 'price' => 250.00, 'sale_price' => 199.99, 'brand' => 'نايكي'],
            ],

            // أحذية موسمية
            'أحذية أطفال' => [
                ['name' => 'حذاء الشتاء المبطن للأطفال', 'description' => 'حذاء شتوي مبطن ودافئ مقاوم للماء والثلج', 'price' => 180.00, 'sale_price' => 139.99, 'brand' => 'أديداس'],
                ['name' => 'صنادل الصيف المريحة', 'description' => 'صنادل صيفية مريحة وآمنة للأطفال مع نعل مانع للانزلاق', 'price' => 95.00, 'sale_price' => 74.99, 'brand' => 'نايكي'],
                ['name' => 'حذاء الحفلات اللامع', 'description' => 'حذاء أنيق ولامع للأطفال مناسب للحفلات والمناسبات', 'price' => 120.00, 'sale_price' => 89.99, 'brand' => 'بوما'],
            ],

            // منتجات العناية الموسمية
            'مستحضرات عناية بالأطفال' => [
                ['name' => 'مجموعة العناية الشتوية للأطفال', 'description' => 'مجموعة شاملة للعناية بالأطفال في فصل الشتاء', 'price' => 85.00, 'sale_price' => 64.99, 'brand' => 'جونسون آند جونسون'],
                ['name' => 'كريم الحماية من البرد', 'description' => 'كريم خاص لحماية بشرة الأطفال من البرد والجفاف', 'price' => 45.00, 'sale_price' => 34.99, 'brand' => 'نيفيا'],
                ['name' => 'شامبو الأطفال بالعسل الطبيعي', 'description' => 'شامبو طبيعي للأطفال مع خلاصة العسل المغذي', 'price' => 35.00, 'sale_price' => 26.99, 'brand' => 'جونسون آند جونسون'],
            ],

            // كتب موسمية
            'كتب تعليمية' => [
                ['name' => 'كتاب قصص الشتاء للأطفال', 'description' => 'مجموعة من القصص الجميلة عن فصل الشتاء والثلج', 'price' => 65.00, 'sale_price' => 49.99, 'brand' => null],
                ['name' => 'كتاب الأنشطة الموسمية', 'description' => 'كتاب أنشطة متنوعة حسب فصول السنة والمناسبات', 'price' => 55.00, 'sale_price' => 42.99, 'brand' => null],
                ['name' => 'أطلس الطقس والمناخ للأطفال', 'description' => 'كتاب تعليمي مصور عن الطقس والمناخ والفصول', 'price' => 85.00, 'sale_price' => 64.99, 'brand' => null],
            ],
        ];

        foreach ($seasonalProducts as $categoryName => $products) {
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
        $productData['sku'] = 'SEASONAL-' . str_pad($this->skuCounter++, 4, '0', STR_PAD_LEFT);
        $productData['stock'] = rand(15, 60);
        $productData['stock_quantity'] = $productData['stock'];
        $productData['is_active'] = true;
        $productData['is_featured'] = true; // Seasonal products are always featured
        $productData['country_of_origin'] = rand(0, 1) ? 'الصين' : 'تركيا';
        $productData['warranty_period'] = 'سنة واحدة';
        $productData['weight'] = rand(100, 2500) . ' جرام';
        $productData['standards'] = 'CE, EN71, ASTM, ISO';
        $productData['suitable_age'] = $productData['suitable_age'] ?? '2-10 سنوات';
        $productData['materials'] = $productData['materials'] ?? 'مواد عالية الجودة';

        $product = Product::create($productData);

        // Create product images
        $this->createProductImages($product);

        // Create product sizes
        $this->createProductSizes($product);

        return $product;
    }

    private function createProductImages($product)
    {
        $imageCount = rand(4, 6); // More images for seasonal products
        for ($i = 1; $i <= $imageCount; $i++) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'products/seasonal-' . $product->id . '-image-' . $i . '.jpg',
                'is_primary' => $i == 1
            ]);
        }
    }

    private function createProductSizes($product)
    {
        $sizes = ['صغير', 'متوسط', 'كبير', 'إكسترا كبير'];
        $selectedSizes = array_slice($sizes, 0, rand(2, 4));

        foreach ($selectedSizes as $index => $size) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $size,
                'stock_quantity' => rand(8, 25),
                'additional_price' => $index * rand(5, 20),
                'size_type' => 'standard',
                'is_available' => true,
                'is_popular' => rand(0, 1) == 1
            ]);
        }
    }
}
