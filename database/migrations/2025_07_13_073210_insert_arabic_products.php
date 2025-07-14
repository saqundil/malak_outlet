<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, ensure we have the required categories and brands
        // Get or create categories
        $electronicsCategory = DB::table('categories')->where('slug', 'electronics')->first();
        if (!$electronicsCategory) {
            $electronicsCategory = (object) ['id' => DB::table('categories')->insertGetId([
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices and gadgets',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ])];
        }

        $toysCategory = DB::table('categories')->where('slug', 'toys-games')->first();
        if (!$toysCategory) {
            $toysCategory = (object) ['id' => DB::table('categories')->insertGetId([
                'name' => 'Toys & Games',
                'slug' => 'toys-games',
                'description' => 'Toys and games for all ages',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ])];
        }

        // Get or create brands
        $samsungBrand = DB::table('brands')->where('slug', 'samsung')->first();
        if (!$samsungBrand) {
            $samsungBrand = (object) ['id' => DB::table('brands')->insertGetId([
                'name' => 'Samsung',
                'slug' => 'samsung',
                'description' => 'South Korean multinational electronics company',
                'created_at' => now(),
                'updated_at' => now(),
            ])];
        }

        $appleBrand = DB::table('brands')->where('slug', 'apple')->first();
        if (!$appleBrand) {
            $appleBrand = (object) ['id' => DB::table('brands')->insertGetId([
                'name' => 'Apple',
                'slug' => 'apple',
                'description' => 'American technology company',
                'created_at' => now(),
                'updated_at' => now(),
            ])];
        }

        $sonyBrand = DB::table('brands')->where('slug', 'sony')->first();
        if (!$sonyBrand) {
            $sonyBrand = (object) ['id' => DB::table('brands')->insertGetId([
                'name' => 'Sony',
                'slug' => 'sony',
                'description' => 'Japanese multinational conglomerate corporation',
                'created_at' => now(),
                'updated_at' => now(),
            ])];
        }

        $products = [
            [
                'name' => 'سيارة التحكم عن بعد الرياضية',
                'description' => 'سيارة سباق رياضية بتحكم عن بعد مع إضاءة LED ومؤثرات صوتية. تتميز بسرعة عالية ومقاومة للصدمات.',
                'price' => 199.99,
                'sale_price' => 149.99,
                'sku' => 'TOY-002',
                'stock_quantity' => 25,
                'category_id' => $electronicsCategory->id,
                'brand_id' => $samsungBrand->id,
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
                'slug' => 'سيارة-التحكم-عن-بعد-الرياضية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'دمية الدب الناعمة الكبيرة',
                'description' => 'دمية دب ناعمة ومريحة مصنوعة من أجود أنواع القطن الطبيعي. مثالية للعناق والنوم.',
                'price' => 79.99,
                'sale_price' => null,
                'sku' => 'TOY-003',
                'stock_quantity' => 40,
                'category_id' => $toysCategory->id,
                'brand_id' => $appleBrand->id,
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
                'slug' => 'دمية-الدب-الناعمة-الكبيرة',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'لعبة الألغاز الذكية ثلاثية الأبعاد',
                'description' => 'لعبة ألغاز تفاعلية تساعد على تطوير مهارات التفكير المنطقي وحل المشكلات.',
                'price' => 129.99,
                'sale_price' => 99.99,
                'sku' => 'TOY-004',
                'stock_quantity' => 30,
                'category_id' => $electronicsCategory->id,
                'brand_id' => $sonyBrand->id,
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
                'slug' => 'لعبة-الألغاز-الذكية-ثلاثية-الأبعاد',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'روبوت تعليمي قابل للبرمجة',
                'description' => 'روبوت ذكي يمكن برمجته لأداء مهام مختلفة. يساعد الأطفال على تعلم أساسيات البرمجة والتكنولوجيا.',
                'price' => 299.99,
                'sale_price' => 249.99,
                'sku' => 'TOY-006',
                'stock_quantity' => 15,
                'category_id' => $electronicsCategory->id,
                'brand_id' => $samsungBrand->id,
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
                'slug' => 'روبوت-تعليمي-قابل-للبرمجة',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'لوحة الرسم المغناطيسية الملونة',
                'description' => 'لوحة رسم مغناطيسية بألوان زاهية مع قلم مغناطيسي وأختام أشكال.',
                'price' => 69.99,
                'sale_price' => 49.99,
                'sku' => 'TOY-007',
                'stock_quantity' => 60,
                'category_id' => $toysCategory->id,
                'brand_id' => $appleBrand->id,
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
                'slug' => 'لوحة-الرسم-المغناطيسية-الملونة',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
            
            // Create sample images for each product
            $productId = DB::getPdo()->lastInsertId();
            $sampleImages = [
                [
                    'product_id' => $productId,
                    'image_path' => 'https://via.placeholder.com/800x600/FF6B6B/FFFFFF?text=' . urlencode('صورة المنتج'),
                    'is_primary' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'product_id' => $productId,
                    'image_path' => 'https://via.placeholder.com/800x600/4ECDC4/FFFFFF?text=' . urlencode('صورة 2'),
                    'is_primary' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'product_id' => $productId,
                    'image_path' => 'https://via.placeholder.com/800x600/45B7D1/FFFFFF?text=' . urlencode('صورة 3'),
                    'is_primary' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];
            
            foreach ($sampleImages as $image) {
                DB::table('product_images')->insert($image);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('product_images')->whereIn('product_id', function($query) {
            $query->select('id')->from('products')->whereIn('sku', ['TOY-002', 'TOY-003', 'TOY-004', 'TOY-006', 'TOY-007']);
        })->delete();
        
        DB::table('products')->whereIn('sku', ['TOY-002', 'TOY-003', 'TOY-004', 'TOY-006', 'TOY-007'])->delete();
    }
};
