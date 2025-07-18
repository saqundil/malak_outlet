<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductSize;

class ComprehensiveProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and brands
        $categories = Category::all()->keyBy('name');
        $brands = Brand::all()->keyBy('name');

        // Educational Toys Products
        $this->seedEducationalToys($categories, $brands);
        
        // LEGO & Building Blocks Products
        $this->seedLegoProducts($categories, $brands);
        
        // Baby Toys Products
        $this->seedBabyToys($categories, $brands);
        
        // Electronic Toys Products
        $this->seedElectronicToys($categories, $brands);
        
        // Boys Toys Products
        $this->seedBoysToys($categories, $brands);
        
        // Girls Toys Products
        $this->seedGirlsToys($categories, $brands);

        $this->command->info('تم إنشاء منتجات شاملة لجميع الفئات بنجاح!');
    }

    private function seedEducationalToys($categories, $brands)
    {
        $educationalCategory = $categories['الألعاب التعليمية'] ?? null;
        if (!$educationalCategory) return;

        $products = [
            [
                'name' => 'لوحة تعليم الحروف والأرقام المغناطيسية',
                'slug' => 'magnetic-alphabet-board',
                'sku' => 'EDU-001',
                'description' => 'لوحة تعليمية مغناطيسية تساعد الأطفال على تعلم الحروف العربية والإنجليزية والأرقام بطريقة ممتعة وتفاعلية',
                'price' => 85.00,
                'stock' => 50,
                'stock_quantity' => 50,
                'brand_id' => $brands['فيشر برايس']->id ?? null,
                'suitable_age' => '3-6 سنوات',
                'materials' => 'بلاستيك آمن',
                'standards' => 'A+',
                'weight' => '500 جرام',
                'dimensions' => '30x40 سم',
                'country_of_origin' => 'الصين',
                'washable' => 'نعم',
                'images' => ['products/educational/magnetic-board-1.jpg', 'products/educational/magnetic-board-2.jpg'],
                'sizes' => [['size' => 'متوسط', 'stock_quantity' => 30, 'additional_price' => 0]]
            ],
            [
                'name' => 'مكعبات خشبية تعليمية ملونة',
                'slug' => 'wooden-educational-blocks',
                'sku' => 'EDU-002',
                'description' => 'مجموعة من المكعبات الخشبية الملونة لتعليم الألوان والأشكال والحساب، مصنوعة من خشب طبيعي آمن',
                'price' => 120.00,
                'stock' => 35,
                'stock_quantity' => 35,
                'brand_id' => $brands['فيشر برايس']->id ?? null,
                'suitable_age' => '2-5 سنوات',
                'materials' => 'خشب طبيعي',
                'standards' => 'A+',
                'weight' => '800 جرام',
                'dimensions' => '25x25x10 سم',
                'country_of_origin' => 'ألمانيا',
                'washable' => 'لا',
                'images' => ['products/educational/wooden-blocks-1.jpg', 'products/educational/wooden-blocks-2.jpg'],
                'sizes' => [['size' => 'كبير', 'stock_quantity' => 35, 'additional_price' => 0]]
            ],
            [
                'name' => 'جهاز تعليم الكلمات الناطق',
                'slug' => 'speaking-words-device',
                'sku' => 'EDU-003',
                'description' => 'جهاز إلكتروني تعليمي ينطق الكلمات العربية والإنجليزية مع الصور لتعزيز مهارات النطق والفهم',
                'price' => 200.00,
                'stock' => 25,
                'stock_quantity' => 25,
                'brand_id' => $brands['فيشر برايس']->id ?? null,
                'suitable_age' => '3-7 سنوات',
                'materials' => 'بلاستيك متين',
                'standards' => 'A',
                'weight' => '300 جرام',
                'dimensions' => '20x15x3 سم',
                'battery_type' => '3 بطاريات AA',
                'country_of_origin' => 'الصين',
                'washable' => 'نعم',
                'images' => ['products/educational/speaking-device-1.jpg', 'products/educational/speaking-device-2.jpg'],
                'sizes' => [['size' => 'قياس واحد', 'stock_quantity' => 25, 'additional_price' => 0]]
            ]
        ];

        $this->createProducts($products, $educationalCategory);
    }

    private function seedLegoProducts($categories, $brands)
    {
        $legoCategory = $categories['ليجو ومكعبات البناء'] ?? null;
        if (!$legoCategory) return;

        $products = [
            [
                'name' => 'مجموعة ليجو سيتي - محطة الإطفاء',
                'description' => 'مجموعة ليجو سيتي الكاملة لبناء محطة إطفاء مع شاحنات الإطفاء والشخصيات، تحتوي على 752 قطعة',
                'price' => 450.00,
                'stock' => 20,
                'brand_id' => $brands['ليجو']->id ?? null,
                'age_group' => '6-12 سنة',
                'material' => 'بلاستيك ABS عالي الجودة',
                'piece_count' => 752,
                'safety_rating' => 'A+',
                'images' => ['products/lego/fire-station-1.jpg', 'products/lego/fire-station-2.jpg', 'products/lego/fire-station-3.jpg'],
                'sizes' => [['size' => 'قياس واحد', 'stock_quantity' => 20, 'additional_price' => 0]]
            ],
            [
                'name' => 'ليجو كريتور - ديناصور تيرانوصورس',
                'description' => 'مجموعة ليجو كريتور لبناء ديناصور تيرانوصورس ضخم مع إمكانية تحريك الفك والذراعين',
                'price' => 380.00,
                'stock' => 15,
                'brand_id' => $brands['ليجو']->id ?? null,
                'age_group' => '7-14 سنة',
                'material' => 'بلاستيك ABS عالي الجودة',
                'piece_count' => 619,
                'safety_rating' => 'A+',
                'images' => ['products/lego/t-rex-1.jpg', 'products/lego/t-rex-2.jpg'],
                'sizes' => [['size' => 'قياس واحد', 'stock_quantity' => 15, 'additional_price' => 0]]
            ],
            [
                'name' => 'مكعبات بناء ملونة للأطفال - 200 قطعة',
                'description' => 'مجموعة من مكعبات البناء الملونة المتوافقة مع ليجو، مثالية لتطوير الإبداع والخيال',
                'price' => 95.00,
                'stock' => 60,
                'brand_id' => $brands['بلايموبيل']->id ?? null,
                'age_group' => '3-8 سنوات',
                'material' => 'بلاستيك آمن',
                'piece_count' => 200,
                'safety_rating' => 'A',
                'images' => ['products/building/colorful-blocks-1.jpg', 'products/building/colorful-blocks-2.jpg'],
                'sizes' => [['size' => 'متوسط', 'stock_quantity' => 60, 'additional_price' => 0]]
            ]
        ];

        $this->createProducts($products, $legoCategory);
    }

    private function seedBabyToys($categories, $brands)
    {
        $babyCategory = $categories['ألعاب الأطفال الصغار'] ?? null;
        if (!$babyCategory) return;

        $products = [
            [
                'name' => 'خشخيشة موسيقية ملونة للرضع',
                'description' => 'خشخيشة آمنة للرضع مع أصوات موسيقية هادئة وألوان زاهية لتحفيز الحواس',
                'price' => 35.00,
                'stock' => 80,
                'brand_id' => $brands['فيشر برايس']->id ?? null,
                'age_group' => '0-12 شهر',
                'material' => 'بلاستيك آمن خالي من BPA',
                'educational_value' => 'تطوير المهارات الحسية والحركية',
                'safety_rating' => 'A+',
                'images' => ['products/baby/rattle-1.jpg', 'products/baby/rattle-2.jpg'],
                'sizes' => [['size' => 'صغير', 'stock_quantity' => 80, 'additional_price' => 0]]
            ],
            [
                'name' => 'كرسي هزاز موسيقي للأطفال',
                'description' => 'كرسي هزاز مريح مع موسيقى هادئة وألعاب معلقة، مثالي لتهدئة الطفل وتطوير مهاراته',
                'price' => 320.00,
                'stock' => 12,
                'brand_id' => $brands['فيشر برايس']->id ?? null,
                'age_group' => '0-18 شهر',
                'material' => 'قماش ناعم وبلاستيك آمن',
                'educational_value' => 'تطوير التوازن والتنسيق',
                'safety_rating' => 'A+',
                'images' => ['products/baby/rocking-chair-1.jpg', 'products/baby/rocking-chair-2.jpg'],
                'sizes' => [['size' => 'قياس واحد', 'stock_quantity' => 12, 'additional_price' => 0]]
            ],
            [
                'name' => 'لعبة الهاتف الذكي التعليمية للأطفال',
                'description' => 'هاتف ذكي تعليمي للأطفال مع أضواء وأصوات تفاعلية لتعليم الأرقام والحروف',
                'price' => 65.00,
                'stock' => 45,
                'brand_id' => $brands['فيشر برايس']->id ?? null,
                'age_group' => '6 أشهر - 3 سنوات',
                'material' => 'بلاستيك متين',
                'educational_value' => 'تطوير مهارات التعلم المبكر',
                'safety_rating' => 'A',
                'images' => ['products/baby/smart-phone-toy-1.jpg', 'products/baby/smart-phone-toy-2.jpg'],
                'sizes' => [['size' => 'صغير', 'stock_quantity' => 45, 'additional_price' => 0]]
            ]
        ];

        $this->createProducts($products, $babyCategory);
    }

    private function seedElectronicToys($categories, $brands)
    {
        $electronicCategory = $categories['الألعاب الإلكترونية'] ?? null;
        if (!$electronicCategory) return;

        $products = [
            [
                'name' => 'روبوت ذكي قابل للبرمجة',
                'description' => 'روبوت تفاعلي ذكي يمكن برمجته وتحكم به عن بُعد، مع إمكانيات تعليم البرمجة للأطفال',
                'price' => 550.00,
                'stock' => 18,
                'brand_id' => $brands['سوني']->id ?? null,
                'age_group' => '8-16 سنة',
                'material' => 'معدن وبلاستيك عالي الجودة',
                'educational_value' => 'تعليم البرمجة والذكاء الاصطناعي',
                'safety_rating' => 'A',
                'images' => ['products/electronic/smart-robot-1.jpg', 'products/electronic/smart-robot-2.jpg', 'products/electronic/smart-robot-3.jpg'],
                'sizes' => [['size' => 'متوسط', 'stock_quantity' => 18, 'additional_price' => 0]]
            ],
            [
                'name' => 'طائرة درون صغيرة للأطفال',
                'description' => 'طائرة درون آمنة للأطفال مع جهاز تحكم عن بُعد وكاميرا، مثالية للمبتدئين',
                'price' => 280.00,
                'stock' => 25,
                'brand_id' => $brands['شاومي']->id ?? null,
                'age_group' => '10+ سنة',
                'material' => 'بلاستيك مقاوم للصدمات',
                'educational_value' => 'تطوير مهارات التحكم والتنسيق',
                'safety_rating' => 'B+',
                'images' => ['products/electronic/drone-1.jpg', 'products/electronic/drone-2.jpg'],
                'sizes' => [['size' => 'صغير', 'stock_quantity' => 25, 'additional_price' => 0]]
            ],
            [
                'name' => 'لوحة مفاتيح موسيقية إلكترونية',
                'description' => 'لوحة مفاتيح موسيقية إلكترونية بـ 61 مفتاح مع أصوات متنوعة وإيقاعات تعليمية',
                'price' => 220.00,
                'stock' => 30,
                'brand_id' => $brands['سوني']->id ?? null,
                'age_group' => '5-15 سنة',
                'material' => 'بلاستيك ومعدن',
                'educational_value' => 'تعليم الموسيقى وتطوير المواهب',
                'safety_rating' => 'A',
                'images' => ['products/electronic/keyboard-1.jpg', 'products/electronic/keyboard-2.jpg'],
                'sizes' => [['size' => 'كبير', 'stock_quantity' => 30, 'additional_price' => 0]]
            ]
        ];

        $this->createProducts($products, $electronicCategory);
    }

    private function seedBoysToys($categories, $brands)
    {
        $boysCategory = $categories['ألعاب الأولاد'] ?? null;
        if (!$boysCategory) return;

        $products = [
            [
                'name' => 'مجموعة سيارات رياضية معدنية',
                'description' => 'مجموعة من 12 سيارة رياضية معدنية بتفاصيل دقيقة وألوان متنوعة، مقاومة للصدمات',
                'price' => 150.00,
                'stock' => 40,
                'brand_id' => $brands['ماتيل']->id ?? null,
                'age_group' => '3-12 سنة',
                'material' => 'معدن عالي الجودة',
                'educational_value' => 'تطوير الخيال والمهارات الحركية',
                'safety_rating' => 'A',
                'images' => ['products/boys/race-cars-1.jpg', 'products/boys/race-cars-2.jpg'],
                'sizes' => [['size' => 'متنوع', 'stock_quantity' => 40, 'additional_price' => 0]]
            ],
            [
                'name' => 'مجموعة أدوات ورشة العمل للأطفال',
                'description' => 'مجموعة كاملة من أدوات العمل الآمنة للأطفال مع طاولة عمل وملحقات متنوعة',
                'price' => 180.00,
                'stock' => 22,
                'brand_id' => $brands['هاسبرو']->id ?? null,
                'age_group' => '4-10 سنوات',
                'material' => 'بلاستيك متين',
                'educational_value' => 'تطوير المهارات اليدوية والإبداع',
                'safety_rating' => 'A',
                'images' => ['products/boys/workshop-tools-1.jpg', 'products/boys/workshop-tools-2.jpg'],
                'sizes' => [['size' => 'كبير', 'stock_quantity' => 22, 'additional_price' => 0]]
            ],
            [
                'name' => 'شاحنة نقل كبيرة بجرافة متحركة',
                'description' => 'شاحنة نقل كبيرة مع جرافة متحركة وصندوق قلاب، مثالية للعب في الرمال والحديقة',
                'price' => 95.00,
                'stock' => 35,
                'brand_id' => $brands['ماتيل']->id ?? null,
                'age_group' => '2-8 سنوات',
                'material' => 'بلاستيك مقاوم للطقس',
                'educational_value' => 'تطوير المهارات الحركية والتخيل',
                'safety_rating' => 'A+',
                'images' => ['products/boys/dump-truck-1.jpg', 'products/boys/dump-truck-2.jpg'],
                'sizes' => [['size' => 'كبير', 'stock_quantity' => 35, 'additional_price' => 0]]
            ]
        ];

        $this->createProducts($products, $boysCategory);
    }

    private function seedGirlsToys($categories, $brands)
    {
        $girlsCategory = $categories['ألعاب البنات'] ?? null;
        if (!$girlsCategory) return;

        $products = [
            [
                'name' => 'دمية باربي مع ملابس متنوعة',
                'description' => 'دمية باربي جميلة مع مجموعة ملابس متنوعة وإكسسوارات أنيقة للعب والتجميل',
                'price' => 120.00,
                'stock' => 50,
                'brand_id' => $brands['ماتيل']->id ?? null,
                'age_group' => '3-12 سنة',
                'material' => 'بلاستيك عالي الجودة وقماش',
                'educational_value' => 'تطوير الخيال والمهارات الاجتماعية',
                'safety_rating' => 'A+',
                'images' => ['products/girls/barbie-1.jpg', 'products/girls/barbie-2.jpg', 'products/girls/barbie-3.jpg'],
                'sizes' => [['size' => 'قياس واحد', 'stock_quantity' => 50, 'additional_price' => 0]]
            ],
            [
                'name' => 'مجموعة مكياج آمنة للأطفال',
                'description' => 'مجموعة مكياج آمنة ومضادة للحساسية للأطفال مع مرآة وفرش متنوعة',
                'price' => 85.00,
                'stock' => 30,
                'brand_id' => $brands['لوريال']->id ?? null,
                'age_group' => '4-12 سنة',
                'material' => 'مواد طبيعية آمنة',
                'educational_value' => 'تطوير الذوق الفني والثقة بالنفس',
                'safety_rating' => 'A+',
                'images' => ['products/girls/makeup-kit-1.jpg', 'products/girls/makeup-kit-2.jpg'],
                'sizes' => [['size' => 'متوسط', 'stock_quantity' => 30, 'additional_price' => 0]]
            ],
            [
                'name' => 'بيت دمية من طابقين مع أثاث',
                'description' => 'بيت دمية خشبي جميل من طابقين مع أثاث كامل ودمى صغيرة للعائلة',
                'price' => 350.00,
                'stock' => 15,
                'brand_id' => $brands['ماتيل']->id ?? null,
                'age_group' => '3-10 سنوات',
                'material' => 'خشب طبيعي وبلاستيك',
                'educational_value' => 'تطوير الخيال والمهارات التنظيمية',
                'safety_rating' => 'A',
                'images' => ['products/girls/dollhouse-1.jpg', 'products/girls/dollhouse-2.jpg', 'products/girls/dollhouse-3.jpg'],
                'sizes' => [['size' => 'كبير', 'stock_quantity' => 15, 'additional_price' => 0]]
            ]
        ];

        $this->createProducts($products, $girlsCategory);
    }

    private function createProducts($products, $category)
    {
        foreach ($products as $productData) {
            $images = $productData['images'];
            $sizes = $productData['sizes'];
            unset($productData['images'], $productData['sizes']);

            $productData['category_id'] = $category->id;
            $productData['is_active'] = true;

            $product = Product::create($productData);

            // Create product images
            foreach ($images as $index => $imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                    'is_premium' => $index > 0 // First image is free, others are premium
                ]);
            }

            // Create product sizes
            foreach ($sizes as $sizeData) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $sizeData['size'],
                    'stock_quantity' => $sizeData['stock_quantity'],
                    'additional_price' => $sizeData['additional_price'] ?? 0,
                    'size_type' => 'custom',
                    'is_available' => true
                ]);
            }
        }
    }
}
