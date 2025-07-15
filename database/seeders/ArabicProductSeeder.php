<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ArabicProductSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Clear existing product data
        $this->command->info('Clearing existing product data...');
        
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        ProductImage::truncate();
        Product::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Get categories and brands
        $categories = Category::all();
        $brands = Brand::all();
        
        if ($categories->isEmpty() || $brands->isEmpty()) {
            $this->command->error('Please seed categories and brands first!');
            return;
        }

        $this->command->info('Creating Arabic products...');

        $products = [
            [
                'name' => 'مكعبات البناء التعليمية للأطفال',
                'description' => 'مجموعة رائعة من مكعبات البناء الملونة التي تساعد على تنمية مهارات الطفل الحركية والذهنية. مصنوعة من مواد آمنة وعالية الجودة. تحتوي على أشكال وألوان متنوعة لتحفيز الإبداع والخيال.',
                'price' => 89.99,
                'sale_price' => 69.99,
                'sku' => 'TOY-001',
                'stock_quantity' => 50,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'weight' => '1.2 كيلوجرام',
                'materials' => 'بلاستيك ABS آمن وخالي من المواد الضارة',
                'country_of_origin' => 'الصين',
                'warranty_period' => 'سنة واحدة',
                'dimensions' => '30 × 25 × 15 سم',
                'suitable_age' => '3-8 سنوات',
                'pieces_count' => '150 قطعة',
                'standards' => 'CE, EN71, ASTM',
                'battery_type' => null,
                'washable' => true,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'سيارة التحكم عن بعد الرياضية',
                'description' => 'سيارة سباق رياضية بتحكم عن بعد مع إضاءة LED ومؤثرات صوتية. تتميز بسرعة عالية ومقاومة للصدمات. مثالية للعب في الداخل والخارج.',
                'price' => 199.99,
                'sale_price' => 149.99,
                'sku' => 'TOY-002',
                'stock_quantity' => 25,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'weight' => '800 جرام',
                'materials' => 'بلاستيك مقوى ومعدن',
                'country_of_origin' => 'اليابان',
                'warranty_period' => '6 أشهر',
                'dimensions' => '35 × 18 × 12 سم',
                'suitable_age' => '6+ سنوات',
                'pieces_count' => '1 قطعة',
                'standards' => 'CE, FCC, RoHS',
                'battery_type' => 'AA × 4 + ليثيوم قابلة للشحن',
                'washable' => false,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'دمية الدب الناعمة الكبيرة',
                'description' => 'دمية دب ناعمة ومريحة مصنوعة من أجود أنواع القطن الطبيعي. مثالية للعناق والنوم. تأتي بألوان جميلة ومناسبة لجميع الأعمار.',
                'price' => 79.99,
                'sale_price' => null,
                'sku' => 'TOY-003',
                'stock_quantity' => 40,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'weight' => '500 جرام',
                'materials' => 'قطن طبيعي 100% وحشو بوليستر آمن',
                'country_of_origin' => 'تركيا',
                'warranty_period' => '3 أشهر',
                'dimensions' => '45 × 30 × 20 سم',
                'suitable_age' => '0+ سنوات',
                'pieces_count' => '1 قطعة',
                'standards' => 'Oeko-Tex Standard 100, CE',
                'battery_type' => null,
                'washable' => true,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'لعبة الألغاز الذكية ثلاثية الأبعاد',
                'description' => 'لعبة ألغاز تفاعلية تساعد على تطوير مهارات التفكير المنطقي وحل المشكلات. تحتوي على مستويات صعوبة متدرجة وتحديات ممتعة.',
                'price' => 129.99,
                'sale_price' => 99.99,
                'sku' => 'TOY-004',
                'stock_quantity' => 30,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'weight' => '600 جرام',
                'materials' => 'خشب طبيعي مع طلاء آمن',
                'country_of_origin' => 'ألمانيا',
                'warranty_period' => 'سنة واحدة',
                'dimensions' => '25 × 25 × 8 سم',
                'suitable_age' => '8+ سنوات',
                'pieces_count' => '64 قطعة',
                'standards' => 'CE, FSC, EN71',
                'battery_type' => null,
                'washable' => false,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'مجموعة أدوات الطبخ للأطفال',
                'description' => 'مجموعة كاملة من أدوات الطبخ المصغرة الآمنة للأطفال. تشمل أواني وملاعق وأكواب ملونة. تساعد على تعلم المهارات الحياتية بطريقة ممتعة.',
                'price' => 119.99,
                'sale_price' => 89.99,
                'sku' => 'TOY-005',
                'stock_quantity' => 35,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'weight' => '900 جرام',
                'materials' => 'بلاستيك غذائي آمن ومعدن مطلي',
                'country_of_origin' => 'إيطاليا',
                'warranty_period' => '6 أشهر',
                'dimensions' => '40 × 30 × 15 سم',
                'suitable_age' => '3-10 سنوات',
                'pieces_count' => '25 قطعة',
                'standards' => 'CE, FDA, LFGB',
                'battery_type' => null,
                'washable' => true,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'روبوت تعليمي قابل للبرمجة',
                'description' => 'روبوت ذكي يمكن برمجته لأداء مهام مختلفة. يساعد الأطفال على تعلم أساسيات البرمجة والتكنولوجيا بطريقة تفاعلية وممتعة.',
                'price' => 299.99,
                'sale_price' => 249.99,
                'sku' => 'TOY-006',
                'stock_quantity' => 15,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'weight' => '1.5 كيلوجرام',
                'materials' => 'بلاستيك ABS وقطع إلكترونية',
                'country_of_origin' => 'كوريا الجنوبية',
                'warranty_period' => 'سنتان',
                'dimensions' => '30 × 25 × 20 سم',
                'suitable_age' => '8+ سنوات',
                'pieces_count' => '1 قطعة + إكسسوارات',
                'standards' => 'CE, FCC, KC',
                'battery_type' => 'ليثيوم قابلة للشحن + USB',
                'washable' => false,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'لوحة الرسم المغناطيسية الملونة',
                'description' => 'لوحة رسم مغناطيسية بألوان زاهية مع قلم مغناطيسي وأختام أشكال. يمكن مسح الرسومات بسهولة وإعادة الرسم مرات لا نهائية.',
                'price' => 69.99,
                'sale_price' => 49.99,
                'sku' => 'TOY-007',
                'stock_quantity' => 60,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'weight' => '700 جرام',
                'materials' => 'بلاستيك آمن ومغناطيس',
                'country_of_origin' => 'الصين',
                'warranty_period' => '6 أشهر',
                'dimensions' => '35 × 28 × 5 سم',
                'suitable_age' => '2-8 سنوات',
                'pieces_count' => '1 لوحة + 4 أختام + قلم',
                'standards' => 'CE, EN71, CPSIA',
                'battery_type' => null,
                'washable' => true,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'قطار كهربائي كلاسيكي',
                'description' => 'قطار كهربائي جميل مع مسار دائري وعربات ملونة. يصدر أصوات قطار حقيقية ويضيء عند الحركة. يأتي مع محطة ومناظر طبيعية مصغرة.',
                'price' => 179.99,
                'sale_price' => 139.99,
                'sku' => 'TOY-008',
                'stock_quantity' => 20,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'weight' => '2.1 كيلوجرام',
                'materials' => 'بلاستيك مقوى ومعدن وقطع إلكترونية',
                'country_of_origin' => 'الدنمارك',
                'warranty_period' => 'سنة واحدة',
                'dimensions' => '80 × 60 × 10 سم (مجمع)',
                'suitable_age' => '4+ سنوات',
                'pieces_count' => '45 قطعة',
                'standards' => 'CE, EN71, UL',
                'battery_type' => 'AA × 6',
                'washable' => false,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'كرة القدم الذكية التفاعلية',
                'description' => 'كرة قدم ذكية تتفاعل مع اللمس والحركة. تصدر أصوات وإضاءة عند الركل أو الرمي. مثالية لتطوير المهارات الرياضية والتنسيق الحركي.',
                'price' => 99.99,
                'sale_price' => 79.99,
                'sku' => 'TOY-009',
                'stock_quantity' => 45,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'weight' => '400 جرام',
                'materials' => 'جلد صناعي ومكونات إلكترونية مقاومة للماء',
                'country_of_origin' => 'البرازيل',
                'warranty_period' => '6 أشهر',
                'dimensions' => 'قطر 22 سم',
                'suitable_age' => '5+ سنوات',
                'pieces_count' => '1 قطعة',
                'standards' => 'CE, IPX4, FIFA approved design',
                'battery_type' => 'ليثيوم قابلة للشحن (USB-C)',
                'washable' => true,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name' => 'مجموعة المجوهرات والإكسسوارات',
                'description' => 'مجموعة رائعة من المجوهرات الآمنة للأطفال تشمل قلائد وأساور وخواتم ملونة. تأتي في صندوق جميل مع مرآة صغيرة.',
                'price' => 59.99,
                'sale_price' => null,
                'sku' => 'TOY-010',
                'stock_quantity' => 55,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'weight' => '300 جرام',
                'materials' => 'بلاستيك آمن وخرز ملون وخيوط قطنية',
                'country_of_origin' => 'الهند',
                'warranty_period' => '3 أشهر',
                'dimensions' => '25 × 20 × 8 سم',
                'suitable_age' => '3-12 سنة',
                'pieces_count' => '50+ قطعة',
                'standards' => 'CE, CPSIA, EN71',
                'battery_type' => null,
                'washable' => false,
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $productData) {
            $productData['slug'] = Str::slug($productData['name']);
            $product = Product::create($productData);
            
            // Create sample images for each product
            $this->createProductImages($product);
            
            $this->command->info("Created product: {$product->name}");
        }

        $this->command->info('Arabic products seeded successfully!');
    }

    private function createProductImages(Product $product): void
    {
        // Create local placeholder images paths
        $sampleImages = [
            '/images/placeholder-1.svg',
            '/images/placeholder-2.svg', 
            '/images/placeholder-3.svg',
            '/images/placeholder-4.svg',
        ];

        // Create 2-4 random images for each product
        $imageCount = rand(2, 4);
        for ($i = 0; $i < $imageCount; $i++) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $sampleImages[$i],
                'is_primary' => $i === 0,
            ]);
        }
    }
}
