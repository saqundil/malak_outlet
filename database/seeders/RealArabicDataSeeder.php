<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\ProductReview;
use App\Models\Discount;
use App\Models\DiscountProduct;
use App\Models\User;

class RealArabicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 بدء إنشاء البيانات العربية الحقيقية...');
        
        // Clear existing data
        $this->clearExistingData();
        
        // Create users
        $users = $this->createUsers();
        
        // Create categories (3 main categories with subcategories)
        $categories = $this->createCategories();
        
        // Create brands (real toy and children brands)
        $brands = $this->createBrands();
        
        // Create discounts
        $discounts = $this->createDiscounts();
        
        // Create products for each category
        $products = $this->createProducts($categories, $brands);
        
        // Create product images
        $this->createProductImages($products);
        
        // Create product sizes (for shoes and some toys)
        $this->createProductSizes($products);
        
        // Create product reviews
        $this->createProductReviews($products, $users);
        
        // Apply discounts to some products
        $this->applyDiscountsToProducts($products, $discounts);
        
        $this->command->info('✅ تم إنشاء جميع البيانات العربية الحقيقية بنجاح!');
        $this->printSummary();
    }
    
    private function clearExistingData()
    {
        $this->command->info('🗑️  تنظيف البيانات الموجودة...');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear in correct order to avoid foreign key constraints
        DB::table('product_reviews')->truncate();
        DB::table('discount_product')->truncate();
        DB::table('discounts')->truncate();
        DB::table('product_sizes')->truncate();
        DB::table('product_images')->truncate();
        DB::table('products')->truncate();
        DB::table('brands')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->where('email', '!=', 'admin@malakoutlet.com')->delete();
        
        // Clear favorites if exists
        if (Schema::hasTable('favorites')) {
            DB::table('favorites')->truncate();
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    
    private function createUsers()
    {
        $this->command->info('👥 إنشاء المستخدمين...');
        
        $users = collect();
        
        // Create test customers
        $customerData = [
            ['أحمد محمد', 'ahmed@test.com'],
            ['فاطمة علي', 'fatima@test.com'], 
            ['خالد حسن', 'khalid@test.com'],
            ['مريم سالم', 'mariam@test.com'],
            ['عمر يوسف', 'omar@test.com'],
        ];
        
        foreach ($customerData as [$name, $email]) {
            $users->push(User::create([
                'name' => $name,
                'email' => $email,
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'is_admin' => false,
                'is_verified' => true,
            ]));
        }
        
        $this->command->info("✅ تم إنشاء {$users->count()} مستخدمين");
        return $users;
    }
    
    private function createCategories()
    {
        $this->command->info('📂 إنشاء التصنيفات...');
        
        $categories = collect();
        
        // Main categories data
        $mainCategoriesData = [
            [
                'name' => 'ألعاب',
                'slug' => 'toys',
                'description' => 'مجموعة واسعة من الألعاب التعليمية والترفيهية للأطفال من جميع الأعمار',
                'subcategories' => [
                    ['ألعاب تعليمية', 'educational-toys', 'ألعاب تساعد على التعلم وتنمية المهارات'],
                    ['ألعاب إلكترونية', 'electronic-toys', 'ألعاب تقنية حديثة وتفاعلية'],
                    ['ألعاب البناء', 'building-toys', 'مكعبات وألعاب البناء والتركيب'],
                    ['دمى وعرائس', 'dolls', 'دمى جميلة ومتنوعة للأطفال'],
                    ['ألعاب خارجية', 'outdoor-toys', 'ألعاب للاستمتاع في الهواء الطلق'],
                    ['ألعاب الطاولة', 'board-games', 'ألعاب جماعية ممتعة للعائلة'],
                ]
            ],
            [
                'name' => 'أحذية',
                'slug' => 'shoes', 
                'description' => 'أحذية مريحة وأنيقة للأطفال بأحجام وألوان متنوعة',
                'subcategories' => [
                    ['أحذية رياضية', 'sports-shoes', 'أحذية رياضية مريحة للأنشطة اليومية'],
                    ['أحذية مدرسية', 'school-shoes', 'أحذية رسمية مناسبة للمدرسة'],
                    ['صنادل صيفية', 'summer-sandals', 'صنادل مريحة لفصل الصيف'],
                    ['أحذية شتوية', 'winter-boots', 'أحذية دافئة ومقاومة للماء'],
                    ['أحذية منزلية', 'home-slippers', 'أحذية مريحة للاستخدام المنزلي'],
                    ['أحذية المناسبات', 'formal-shoes', 'أحذية أنيقة للمناسبات الخاصة'],
                ]
            ],
            [
                'name' => 'مستلزمات أطفال',
                'slug' => 'kids-accessories',
                'description' => 'جميع المستلزمات الضرورية والعملية للأطفال',
                'subcategories' => [
                    ['حقائب مدرسية', 'school-bags', 'حقائب قوية ومريحة للمدرسة'],
                    ['زجاجات مياه', 'water-bottles', 'زجاجات آمنة وملونة للأطفال'],
                    ['أدوات الطعام', 'eating-utensils', 'أطباق وأكواب آمنة للأطفال'],
                    ['إكسسوارات الشعر', 'hair-accessories', 'ربطات وإكسسوارات جميلة للشعر'],
                    ['مستلزمات النوم', 'sleep-accessories', 'وسائد ولحف مريحة للأطفال'],
                    ['مستلزمات الاستحمام', 'bath-accessories', 'منتجات آمنة لوقت الاستحمام'],
                ]
            ]
        ];
        
        foreach ($mainCategoriesData as $mainCatData) {
            // Create main category
            $mainCategory = Category::create([
                'name' => $mainCatData['name'],
                'slug' => $mainCatData['slug'],
                'description' => $mainCatData['description'],
                'is_active' => true,
                'parent_id' => null,
                'is_deleted' => false,
            ]);
            
            $categories->push($mainCategory);
            
            // Create subcategories
            foreach ($mainCatData['subcategories'] as $subCatData) {
                $subCategory = Category::create([
                    'name' => $subCatData[0],
                    'slug' => $subCatData[1],
                    'description' => $subCatData[2],
                    'is_active' => true,
                    'parent_id' => $mainCategory->id,
                    'is_deleted' => false,
                ]);
                
                $categories->push($subCategory);
            }
        }
        
        $this->command->info("✅ تم إنشاء {$categories->count()} تصنيف");
        return $categories;
    }
    
    private function createBrands()
    {
        $this->command->info('🏷️ إنشاء العلامات التجارية...');
        
        $brands = collect();
        
        // Real brands data for toys and kids products
        $brandsData = [
            ['ليجو', 'lego', 'أشهر علامة تجارية في ألعاب البناء'],
            ['باربي', 'barbie', 'الدمى الأكثر شهرة في العالم'],
            ['فيشر برايس', 'fisher-price', 'ألعاب تعليمية عالية الجودة'],
            ['ماتيل', 'mattel', 'ألعاب ممتعة وآمنة للأطفال'],
            ['هاسبرو', 'hasbro', 'ألعاب مبتكرة ومسلية'],
            ['نايكي', 'nike', 'أحذية رياضية عالمية'],
            ['أديداس', 'adidas', 'أحذية رياضية وملابس أطفال'],
            ['كونفيرس', 'converse', 'أحذية كلاسيكية عصرية'],
            ['سكيتشرز', 'skechers', 'أحذية مريحة للأطفال'],
            ['ديزني', 'disney', 'منتجات بشخصيات ديزني المحبوبة'],
            ['هيلو كيتي', 'hello-kitty', 'منتجات بشخصية هيلو كيتي'],
            ['سبايدرمان', 'spiderman', 'منتجات بطل العنكبوت'],
        ];
        
        foreach ($brandsData as [$name, $slug, $description]) {
            $brands->push(Brand::create([
                'name' => $name,
                'slug' => $slug,
                'is_active' => true,
                'is_deleted' => false,
            ]));
        }
        
        $this->command->info("✅ تم إنشاء {$brands->count()} علامة تجارية");
        return $brands;
    }
    
    private function createDiscounts()
    {
        $this->command->info('💰 إنشاء العروض والخصومات...');
        
        $discounts = collect();
        
        $discountsData = [
            [
                'name' => 'عرض العودة للمدارس',
                'description' => 'خصم خاص على جميع المستلزمات المدرسية والحقائب',
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'starts_at' => now()->subDays(10),
                'ends_at' => now()->addDays(30),
            ],
            [
                'name' => 'خصم الألعاب التعليمية',
                'description' => 'خصم على مجموعة مختارة من الألعاب التعليمية',
                'discount_type' => 'percentage', 
                'discount_value' => 15,
                'starts_at' => now()->subDays(5),
                'ends_at' => now()->addDays(20),
            ],
            [
                'name' => 'عرض الأحذية الصيفية',
                'description' => 'خصم ثابت على الصنادل والأحذية الصيفية',
                'discount_type' => 'fixed',
                'discount_value' => 10,
                'starts_at' => now(),
                'ends_at' => now()->addDays(15),
            ],
        ];
        
        foreach ($discountsData as $discountData) {
            $discounts->push(Discount::create([
                'name' => $discountData['name'],
                'description' => $discountData['description'],
                'discount_type' => $discountData['discount_type'],
                'discount_value' => $discountData['discount_value'],
                'starts_at' => $discountData['starts_at'],
                'ends_at' => $discountData['ends_at'],
                'is_active' => true,
                'is_deleted' => false,
            ]));
        }
        
        $this->command->info("✅ تم إنشاء {$discounts->count()} خصومات");
        return $discounts;
    }
    
    private function createProducts($categories, $brands)
    {
        $this->command->info('🛍️ إنشاء المنتجات...');
        
        $products = collect();
        
        // Get categories by name for easier reference
        $toysCategory = $categories->firstWhere('name', 'ألعاب');
        $shoesCategory = $categories->firstWhere('name', 'أحذية');
        $accessoriesCategory = $categories->firstWhere('name', 'مستلزمات أطفال');
        
        // Toys products
        $toysProducts = [
            [
                'name' => 'مكعبات ليجو كلاسيك - مجموعة الإبداع',
                'category' => $categories->firstWhere('name', 'ألعاب البناء'),
                'brand' => $brands->firstWhere('name', 'ليجو'),
                'price' => 85.00,
                'description' => 'مجموعة رائعة من مكعبات ليجو الملونة تحتوي على 484 قطعة لبناء أشكال لا نهائية وتنمية الإبداع',
                'is_sized' => false,
            ],
            [
                'name' => 'دمية باربي أميرة الأحلام',
                'category' => $categories->firstWhere('name', 'دمى وعرائس'),
                'brand' => $brands->firstWhere('name', 'باربي'),
                'price' => 45.00,
                'description' => 'دمية باربي جميلة بفستان وردي لامع مع إكسسوارات متنوعة للعب والتخيل',
                'is_sized' => false,
            ],
            [
                'name' => 'لعبة تعلم الحروف والأرقام التفاعلية',
                'category' => $categories->firstWhere('name', 'ألعاب تعليمية'),
                'brand' => $brands->firstWhere('name', 'فيشر برايس'),
                'price' => 65.00,
                'description' => 'لعبة تعليمية تفاعلية تساعد الأطفال على تعلم الحروف والأرقام بطريقة ممتعة',
                'is_sized' => false,
            ],
            [
                'name' => 'جهاز ألعاب إلكتروني محمول للأطفال',
                'category' => $categories->firstWhere('name', 'ألعاب إلكترونية'),
                'brand' => $brands->firstWhere('name', 'ماتيل'),
                'price' => 120.00,
                'description' => 'جهاز ألعاب محمول يحتوي على 50 لعبة تعليمية وترفيهية مناسبة للأطفال',
                'is_sized' => false,
            ],
            [
                'name' => 'كرة قدم للأطفال - ديزني',
                'category' => $categories->firstWhere('name', 'ألعاب خارجية'),
                'brand' => $brands->firstWhere('name', 'ديزني'),
                'price' => 25.00,
                'description' => 'كرة قدم ملونة بشخصيات ديزني المحبوبة، مناسبة للعب في الحديقة',
                'is_sized' => true,
            ],
            [
                'name' => 'لعبة الثعابين والسلالم العائلية',
                'category' => $categories->firstWhere('name', 'ألعاب الطاولة'),
                'brand' => $brands->firstWhere('name', 'هاسبرو'),
                'price' => 35.00,
                'description' => 'لعبة كلاسيكية ممتعة للعائلة تجمع الأطفال والكبار في أوقات مرحة',
                'is_sized' => false,
            ],
        ];
        
        // Shoes products
        $shoesProducts = [
            [
                'name' => 'حذاء رياضي أطفال نايكي - أبيض وأزرق',
                'category' => $categories->firstWhere('name', 'أحذية رياضية'),
                'brand' => $brands->firstWhere('name', 'نايكي'),
                'price' => 95.00,
                'description' => 'حذاء رياضي مريح ومتين للأطفال، مثالي للأنشطة اليومية والرياضة',
                'is_sized' => true,
            ],
            [
                'name' => 'حذاء مدرسي أسود كلاسيكي',
                'category' => $categories->firstWhere('name', 'أحذية مدرسية'),
                'brand' => $brands->firstWhere('name', 'كونفيرس'),
                'price' => 75.00,
                'description' => 'حذاء مدرسي أنيق ومريح، مناسب للاستخدام اليومي في المدرسة',
                'is_sized' => true,
            ],
            [
                'name' => 'صندل صيفي ملون للأطفال',
                'category' => $categories->firstWhere('name', 'صنادل صيفية'),
                'brand' => $brands->firstWhere('name', 'سكيتشرز'),
                'price' => 55.00,
                'description' => 'صندل مريح وملون مثالي لفصل الصيف والأنشطة المائية',
                'is_sized' => true,
            ],
            [
                'name' => 'حذاء شتوي مقاوم للماء',
                'category' => $categories->firstWhere('name', 'أحذية شتوية'),
                'brand' => $brands->firstWhere('name', 'أديداس'),
                'price' => 110.00,
                'description' => 'حذاء شتوي دافئ ومقاوم للماء، يحافظ على دفء أقدام الأطفال',
                'is_sized' => true,
            ],
            [
                'name' => 'حذاء أنيق للمناسبات الخاصة',
                'category' => $categories->firstWhere('name', 'أحذية المناسبات'),
                'brand' => $brands->firstWhere('name', 'كونفيرس'),
                'price' => 85.00,
                'description' => 'حذاء أنيق مناسب للمناسبات الخاصة والحفلات',
                'is_sized' => true,
            ],
        ];
        
        // Accessories products
        $accessoriesProducts = [
            [
                'name' => 'حقيبة مدرسية سبايدرمان',
                'category' => $categories->firstWhere('name', 'حقائب مدرسية'),
                'brand' => $brands->firstWhere('name', 'سبايدرمان'),
                'price' => 60.00,
                'description' => 'حقيبة مدرسية قوية ومريحة بتصميم سبايدرمان مع جيوب متعددة',
                'is_sized' => false,
            ],
            [
                'name' => 'زجاجة مياه هيلو كيتي',
                'category' => $categories->firstWhere('name', 'زجاجات مياه'),
                'brand' => $brands->firstWhere('name', 'هيلو كيتي'),
                'price' => 25.00,
                'description' => 'زجاجة مياه آمنة وجميلة بتصميم هيلو كيتي، سعة 500 مل',
                'is_sized' => false,
            ],
            [
                'name' => 'طقم أدوات طعام ديزني',
                'category' => $categories->firstWhere('name', 'أدوات الطعام'),
                'brand' => $brands->firstWhere('name', 'ديزني'),
                'price' => 35.00,
                'description' => 'طقم كامل من الأطباق والأكواب الآمنة بشخصيات ديزني',
                'is_sized' => false,
            ],
            [
                'name' => 'مجموعة ربطات شعر ملونة',
                'category' => $categories->firstWhere('name', 'إكسسوارات الشعر'),
                'brand' => $brands->firstWhere('name', 'ديزني'),
                'price' => 20.00,
                'description' => 'مجموعة من ربطات الشعر الملونة والجميلة مع شخصيات كرتونية',
                'is_sized' => false,
            ],
            [
                'name' => 'وسادة نوم ناعمة للأطفال',
                'category' => $categories->firstWhere('name', 'مستلزمات النوم'),
                'brand' => $brands->firstWhere('name', 'ديزني'),
                'price' => 40.00,
                'description' => 'وسادة ناعمة ومريحة بتصميم جميل مناسبة لنوم الأطفال',
                'is_sized' => false,
            ],
            [
                'name' => 'منشفة استحمام ملونة',
                'category' => $categories->firstWhere('name', 'مستلزمات الاستحمام'),
                'brand' => $brands->firstWhere('name', 'ديزني'),
                'price' => 30.00,
                'description' => 'منشفة استحمام ناعمة وماصة بألوان زاهية وتصاميم محببة للأطفال',
                'is_sized' => false,
            ],
        ];
        
        // Combine all products
        $allProductsData = array_merge($toysProducts, $shoesProducts, $accessoriesProducts);
        
        foreach ($allProductsData as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'original_price' => $productData['price'] * 1.2, // Original price 20% higher
                'sku' => 'MO-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                'quantity' => rand(50, 200),
                'category_id' => $productData['category']->id,
                'brand_id' => $productData['brand']->id,
                'is_active' => true,
                'status' => 'in_stock',
                'meta_title' => $productData['name'],
                'meta_description' => Str::limit($productData['description'], 155),
                'is_sized' => $productData['is_sized'],
                'is_deleted' => false,
            ]);
            
            $products->push($product);
        }
        
        $this->command->info("✅ تم إنشاء {$products->count()} منتج");
        return $products;
    }
    
    private function createProductImages($products)
    {
        $this->command->info('🖼️ إنشاء صور المنتجات...');
        
        $imageCount = 0;
        
        // Available sample images
        $sampleImages = [
            '/images/talking-doll-1.jpg',
            '/images/rc-car-1.jpg',
            '/images/rc-car-2.jpg',
            '/images/blocks-1.jpg',
            '/images/placeholder-1.svg',
            '/images/placeholder-2.svg',
            '/images/placeholder-3.svg',
            '/images/placeholder-4.svg',
            '/images/baby.png',
            '/images/pngegg.png',
        ];
        
        foreach ($products as $product) {
            $numImages = rand(2, 4); // 2-4 images per product
            
            for ($i = 1; $i <= $numImages; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $sampleImages[array_rand($sampleImages)],
                    'is_primary' => $i === 1,
                    'is_deleted' => false,
                ]);
                $imageCount++;
            }
        }
        
        $this->command->info("✅ تم إنشاء {$imageCount} صورة منتج");
    }
    
    private function createProductSizes($products)
    {
        $this->command->info('📏 إنشاء أحجام المنتجات...');
        
        $sizeCount = 0;
        
        foreach ($products as $product) {
            if (!$product->is_sized) continue;
            
            // Define sizes based on category
            $sizes = [];
            
            if ($product->category->parent_id == Category::where('name', 'أحذية')->first()->id) {
                // Shoe sizes
                $sizes = [
                    ['size' => '28', 'size_type' => 'أحذية أطفال', 'stock' => rand(10, 30)],
                    ['size' => '30', 'size_type' => 'أحذية أطفال', 'stock' => rand(15, 35)],
                    ['size' => '32', 'size_type' => 'أحذية أطفال', 'stock' => rand(12, 25)],
                    ['size' => '34', 'size_type' => 'أحذية أطفال', 'stock' => rand(8, 20)],
                    ['size' => '36', 'size_type' => 'أحذية أطفال', 'stock' => rand(10, 28)],
                ];
            } else {
                // General toy sizes
                $sizes = [
                    ['size' => 'صغير', 'size_type' => 'عام', 'stock' => rand(20, 40)],
                    ['size' => 'متوسط', 'size_type' => 'عام', 'stock' => rand(25, 45)],
                    ['size' => 'كبير', 'size_type' => 'عام', 'stock' => rand(15, 35)],
                ];
            }
            
            foreach ($sizes as $sizeData) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $sizeData['size'],
                    'size_type' => $sizeData['size_type'],
                    'description' => null,
                    'stock_quantity' => $sizeData['stock'],
                    'additional_price' => 0.00,
                    'is_available' => true,
                    'is_popular' => rand(0, 1) == 1,
                    'is_deleted' => false,
                ]);
                $sizeCount++;
            }
        }
        
        $this->command->info("✅ تم إنشاء {$sizeCount} حجم منتج");
    }
    
    private function createProductReviews($products, $users)
    {
        $this->command->info('⭐ إنشاء تقييمات المنتجات...');
        
        $reviewCount = 0;
        
        // Arabic review comments
        $reviewComments = [
            'منتج رائع جداً، أطفالي يحبونه كثيراً',
            'جودة ممتازة وسعر مناسب',
            'وصل في الوقت المحدد والتغليف ممتاز',
            'ابنتي سعيدة جداً بهذا المنتج',
            'مناسب للعمر المذكور وآمن للأطفال',
            'ألوان زاهية وجميلة',
            'قيمة ممتازة مقابل السعر',
            'مقاوم ومتين، يتحمل اللعب الكثير',
            'تصميم جميل وعملي',
            'أنصح بشرائه للأطفال',
            'منتج تعليمي رائع',
            'مريح جداً في الاستخدام',
            'حجم مناسب للأطفال',
            'ابني يلعب به يومياً',
            'سهل التنظيف والصيانة',
        ];
        
        // Create reviews for random products (safe bounds)
        $productsCount = $products->count();
        if ($productsCount > 0) {
            $minReviewed = min(12, $productsCount);
            $maxReviewed = min(18, $productsCount);
            $reviewPick = rand($minReviewed, $maxReviewed);
            $reviewedProducts = $products->shuffle()->take($reviewPick);

            foreach ($reviewedProducts as $product) {
            $numReviews = rand(2, 8); // 2-8 reviews per product
            $reviewedUsers = $users->random(min($numReviews, $users->count()));
            
            foreach ($reviewedUsers as $user) {
                ProductReview::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'rating' => rand(3, 5), // Rating between 3-5 stars
                    'comment' => $reviewComments[array_rand($reviewComments)],
                    'is_approved' => rand(0, 1) == 1, // Random approval status
                    'is_deleted' => false,
                ]);
                $reviewCount++;
            }
            }
        }
        
        $this->command->info("✅ تم إنشاء {$reviewCount} تقييم");
    }
    
    private function applyDiscountsToProducts($products, $discounts)
    {
        $this->command->info('🎯 تطبيق الخصومات على المنتجات...');
        
        $discountCount = 0;
        
        // Apply discounts to random products (safe bounds)
        $productsCount = $products->count();
        $discountsCount = $discounts->count();
        if ($productsCount > 0 && $discountsCount > 0) {
            $minDiscounted = min(8, $productsCount);
            $maxDiscounted = min(15, $productsCount);
            $discountPick = rand($minDiscounted, $maxDiscounted);
            $discountedProducts = $products->shuffle()->take($discountPick);

            foreach ($discountedProducts as $product) {
                $randomDiscount = $discounts->random();

                DiscountProduct::create([
                    'product_id' => $product->id,
                    'discount_id' => $randomDiscount->id,
                    'is_deleted' => false,
                ]);

                $discountCount++;
            }
        }
        
        $this->command->info("✅ تم تطبيق {$discountCount} خصم على المنتجات");
    }
    
    private function printSummary()
    {
        $this->command->info('');
        $this->command->info('📊 ملخص البيانات المنشأة:');
        $this->command->info('- المستخدمين: ' . User::count());
        $this->command->info('- التصنيفات: ' . Category::count());
        $this->command->info('- العلامات التجارية: ' . Brand::count());
        $this->command->info('- المنتجات: ' . Product::count());
        $this->command->info('- صور المنتجات: ' . ProductImage::count());
        $this->command->info('- أحجام المنتجات: ' . ProductSize::count());
        $this->command->info('- التقييمات: ' . ProductReview::count());
        $this->command->info('- الخصومات: ' . Discount::count());
        $this->command->info('- المنتجات المخفضة: ' . DiscountProduct::count());
        $this->command->info('');
        $this->command->info('🎉 متجر ملاك جاهز للعمل!');
    }
}