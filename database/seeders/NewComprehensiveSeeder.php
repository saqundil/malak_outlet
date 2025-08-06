<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\ProductReview;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Favorite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class NewComprehensiveSeeder extends Seeder
{
    public function run()
    {
        // Clear all existing data
        $this->command->info('مسح البيانات الموجودة...');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear tables in correct order to avoid foreign key constraints
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('favorites')->truncate();
        DB::table('product_reviews')->truncate();
        DB::table('product_sizes')->truncate();
        DB::table('product_images')->truncate();
        DB::table('products')->truncate();
        DB::table('brands')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->where('id', '!=', 1)->delete(); // Keep admin user
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('تم مسح البيانات بنجاح!');

        // Create Users
        $this->createUsers();
        
        // Create Main Categories
        $this->createMainCategories();
        
        // Create Brands
        $this->createBrands();
        
        // Create Products
        $this->createProducts();
        
        // Create Product Images
        $this->createProductImages();
        
        // Create Product Sizes (for shoes)
        $this->createProductSizes();
        
        // Create Reviews
        $this->createReviews();
        
        // Create Orders
        $this->createOrders();
        
        // Create Favorites
        $this->createFavorites();

        $this->command->info('تم إنشاء جميع البيانات بنجاح!');
    }

    private function createUsers()
    {
        $this->command->info('إنشاء المستخدمين...');
        
        // Admin user (if not exists)
        User::firstOrCreate([
            'email' => 'admin@malakoutlet.com'
        ], [
            'name' => 'مدير الموقع',
            'password' => Hash::make('password'),
        ]);

        // Regular users
        $users = [
            ['name' => 'أحمد محمد', 'email' => 'ahmed@example.com'],
            ['name' => 'فاطمة علي', 'email' => 'fatima@example.com'],
            ['name' => 'محمد عبدالله', 'email' => 'mohammed@example.com'],
            ['name' => 'نورا أحمد', 'email' => 'nora@example.com'],
            ['name' => 'خالد سعد', 'email' => 'khalid@example.com'],
            ['name' => 'عائشة محمود', 'email' => 'aisha@example.com'],
            ['name' => 'عمر حسن', 'email' => 'omar@example.com'],
            ['name' => 'زينب يوسف', 'email' => 'zainab@example.com'],
            ['name' => 'سعد عبدالرحمن', 'email' => 'saad@example.com'],
            ['name' => 'مريم إبراهيم', 'email' => 'mariam@example.com'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate([
                'email' => $userData['email']
            ], [
                'name' => $userData['name'],
                'password' => Hash::make('password'),
            ]);
        }
    }

    private function createMainCategories()
    {
        $this->command->info('إنشاء الفئات الرئيسية...');
        
        $mainCategories = [
            [
                'name' => 'ألعاب',
                'slug' => 'toys',
                'description' => 'مجموعة متنوعة من الألعاب التعليمية والترفيهية للأطفال من جميع الأعمار',
                'image' => 'toys-category.jpg',
                'subcategories' => [
                    ['name' => 'ألعاب تعليمية', 'slug' => 'educational-toys', 'description' => 'ألعاب تساعد في تنمية مهارات الأطفال التعليمية'],
                    ['name' => 'ألعاب البناء', 'slug' => 'building-toys', 'description' => 'مكعبات البناء وألعاب التركيب لتنمية الإبداع'],
                    ['name' => 'الدمى والعرائس', 'slug' => 'dolls', 'description' => 'مجموعة متنوعة من الدمى والعرائس'],
                    ['name' => 'السيارات والمركبات', 'slug' => 'toy-cars', 'description' => 'سيارات لعبة ومركبات متنوعة'],
                    ['name' => 'ألعاب إلكترونية', 'slug' => 'electronic-toys', 'description' => 'ألعاب تفاعلية وإلكترونية حديثة'],
                ]
            ],
            [
                'name' => 'أحذية',
                'slug' => 'shoes',
                'description' => 'أحذية عصرية ومريحة للأطفال والكبار بأحجام وتصاميم متنوعة',
                'image' => 'shoes-category.jpg',
                'subcategories' => [
                    ['name' => 'أحذية رياضية', 'slug' => 'sports-shoes', 'description' => 'أحذية رياضية مريحة لجميع الأنشطة'],
                    ['name' => 'أحذية كاجوال', 'slug' => 'casual-shoes', 'description' => 'أحذية يومية أنيقة ومريحة'],
                    ['name' => 'أحذية رسمية', 'slug' => 'formal-shoes', 'description' => 'أحذية أنيقة للمناسبات الرسمية'],
                    ['name' => 'أحذية أطفال', 'slug' => 'kids-shoes', 'description' => 'أحذية مخصصة للأطفال بتصاميم جذابة'],
                    ['name' => 'صنادل', 'slug' => 'sandals', 'description' => 'صنادل مريحة لفصل الصيف'],
                ]
            ],
            [
                'name' => 'مستلزمات أطفال',
                'slug' => 'kids-accessories',
                'description' => 'جميع احتياجات ومستلزمات الأطفال من ملابس وإكسسوارات وأدوات',
                'image' => 'kids-accessories-category.jpg',
                'subcategories' => [
                    ['name' => 'ملابس أطفال', 'slug' => 'kids-clothing', 'description' => 'ملابس عصرية ومريحة للأطفال'],
                    ['name' => 'حقائب مدرسية', 'slug' => 'school-bags', 'description' => 'حقائب مدرسية عملية وجذابة'],
                    ['name' => 'أدوات مدرسية', 'slug' => 'school-supplies', 'description' => 'جميع الأدوات المدرسية اللازمة'],
                    ['name' => 'إكسسوارات أطفال', 'slug' => 'kids-accessories-items', 'description' => 'إكسسوارات متنوعة للأطفال'],
                    ['name' => 'عربات أطفال', 'slug' => 'strollers', 'description' => 'عربات أطفال آمنة ومريحة'],
                ]
            ]
        ];

        foreach ($mainCategories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'description' => $categoryData['description'],
                'image' => $categoryData['image'],
                'is_active' => true,
                'parent_id' => null,
                'is_deleted' => false,
                'edit_by' => 1,
            ]);

            // Create subcategories
            foreach ($categoryData['subcategories'] as $subCategoryData) {
                Category::create([
                    'name' => $subCategoryData['name'],
                    'slug' => $subCategoryData['slug'],
                    'description' => $subCategoryData['description'],
                    'image' => $subCategoryData['slug'] . '.jpg',
                    'is_active' => true,
                    'parent_id' => $category->id,
                    'is_deleted' => false,
                    'edit_by' => 1,
                ]);
            }
        }
    }

    private function createBrands()
    {
        $this->command->info('إنشاء العلامات التجارية...');
        
        $brands = [
            // Toy brands
            ['name' => 'LEGO', 'slug' => 'lego'],
            ['name' => 'Mattel', 'slug' => 'mattel'],
            ['name' => 'Fisher-Price', 'slug' => 'fisher-price'],
            ['name' => 'Hasbro', 'slug' => 'hasbro'],
            ['name' => 'Barbie', 'slug' => 'barbie'],
            
            // Shoe brands
            ['name' => 'Nike', 'slug' => 'nike'],
            ['name' => 'Adidas', 'slug' => 'adidas'],
            ['name' => 'Puma', 'slug' => 'puma'],
            ['name' => 'Converse', 'slug' => 'converse'],
            ['name' => 'Vans', 'slug' => 'vans'],
            
            // Kids accessories brands
            ['name' => 'Disney', 'slug' => 'disney'],
            ['name' => 'Marvel', 'slug' => 'marvel'],
            ['name' => 'Hello Kitty', 'slug' => 'hello-kitty'],
            ['name' => 'Frozen', 'slug' => 'frozen'],
            ['name' => 'Cars', 'slug' => 'cars'],
        ];

        foreach ($brands as $brandData) {
            Brand::create([
                'name' => $brandData['name'],
                'slug' => $brandData['slug'],
                'image' => $brandData['slug'] . '-logo.png',
                'is_active' => true,
                'is_deleted' => false,
                'edit_by' => 1,
            ]);
        }
    }

    private function createProducts()
    {
        $this->command->info('إنشاء المنتجات...');
        
        $this->createToyProducts();
        $this->createShoeProducts();
        $this->createKidsAccessoriesProducts();
    }

    private function createToyProducts()
    {
        $toys = [
            // Educational Toys
            [
                'name' => 'لعبة الأرقام التعليمية',
                'slug' => 'educational-numbers-toy',
                'description' => 'لعبة تفاعلية لتعليم الأطفال الأرقام والعد بطريقة ممتعة. مناسبة للأطفال من سن 3-6 سنوات.',
                'price' => 89.99,
                'original_price' => 120.00,
                'sku' => 'EDU-NUM-001',
                'quantity' => 50,
                'category' => 'educational-toys',
                'brand' => 'fisher-price',
            ],
            [
                'name' => 'بازل الحروف العربية',
                'slug' => 'arabic-alphabet-puzzle',
                'description' => 'بازل خشبي لتعليم الحروف العربية مع الأصوات. مصنوع من الخشب الطبيعي الآمن.',
                'price' => 65.50,
                'original_price' => 85.00,
                'sku' => 'EDU-ARA-002',
                'quantity' => 30,
                'category' => 'educational-toys',
                'brand' => 'fisher-price',
            ],
            
            // Building Toys
            [
                'name' => 'مجموعة لیجو المدينة الكبيرة',
                'slug' => 'lego-city-big-set',
                'description' => 'مجموعة لیجو ضخمة لبناء مدينة كاملة مع السيارات والمباني. تحتوي على 1200 قطعة.',
                'price' => 299.99,
                'original_price' => 399.99,
                'sku' => 'LEGO-CITY-001',
                'quantity' => 15,
                'category' => 'building-toys',
                'brand' => 'lego',
            ],
            [
                'name' => 'مكعبات البناء الملونة',
                'slug' => 'colorful-building-blocks',
                'description' => 'مجموعة من 200 مكعب ملون لتنمية الخيال والإبداع لدى الأطفال.',
                'price' => 75.00,
                'original_price' => 95.00,
                'sku' => 'BUILD-COL-003',
                'quantity' => 40,
                'category' => 'building-toys',
                'brand' => 'lego',
            ],
            
            // Dolls
            [
                'name' => 'دمية باربي الأميرة',
                'slug' => 'barbie-princess-doll',
                'description' => 'دمية باربي جميلة بفستان أميرة فاخر مع الإكسسوارات.',
                'price' => 125.00,
                'original_price' => 150.00,
                'sku' => 'BARBIE-PRIN-004',
                'quantity' => 25,
                'category' => 'dolls',
                'brand' => 'barbie',
            ],
            [
                'name' => 'مجموعة شخصيات الأكشن',
                'slug' => 'action-figures-set',
                'description' => 'مجموعة من 5 شخصيات أكشن متحركة مستوحاة من الأفلام الشهيرة.',
                'price' => 89.99,
                'original_price' => 110.00,
                'sku' => 'ACTION-SET-005',
                'quantity' => 20,
                'category' => 'dolls',
                'brand' => 'hasbro',
            ],
            
            // Toy Cars
            [
                'name' => 'مجموعة سيارات السباق',
                'slug' => 'racing-cars-set',
                'description' => 'مجموعة من 10 سيارات سباق متنوعة مع مضمار سباق.',
                'price' => 145.00,
                'original_price' => 180.00,
                'sku' => 'CAR-RACE-006',
                'quantity' => 35,
                'category' => 'toy-cars',
                'brand' => 'mattel',
            ],
            [
                'name' => 'شاحنة الإطفاء الكبيرة',
                'slug' => 'big-fire-truck',
                'description' => 'شاحنة إطفاء كبيرة مع سلم قابل للامتداد وأصوات حقيقية.',
                'price' => 199.99,
                'original_price' => 250.00,
                'sku' => 'FIRE-TRUCK-007',
                'quantity' => 12,
                'category' => 'toy-cars',
                'brand' => 'mattel',
            ],
            
            // Electronic Toys
            [
                'name' => 'روبوت تعليمي ذكي',
                'slug' => 'smart-educational-robot',
                'description' => 'روبوت تفاعلي يعلم البرمجة البسيطة للأطفال.',
                'price' => 299.99,
                'original_price' => 399.99,
                'sku' => 'ELEC-ROBOT-010',
                'quantity' => 10,
                'category' => 'electronic-toys',
                'brand' => 'fisher-price',
            ],
            [
                'name' => 'تابلت الأطفال التعليمي',
                'slug' => 'kids-educational-tablet',
                'description' => 'تابلت مخصص للأطفال مع ألعاب تعليمية وبرامج تفاعلية.',
                'price' => 189.99,
                'original_price' => 249.99,
                'sku' => 'ELEC-TABLET-011',
                'quantity' => 15,
                'category' => 'electronic-toys',
                'brand' => 'fisher-price',
            ],
        ];

        foreach ($toys as $toyData) {
            $this->createProduct($toyData);
        }
    }

    private function createShoeProducts()
    {
        $shoes = [
            // Sports Shoes
            [
                'name' => 'حذاء نايكي الرياضي للأطفال',
                'slug' => 'nike-kids-sports-shoes',
                'description' => 'حذاء رياضي مريح للأطفال مع تقنية امتصاص الصدمات.',
                'price' => 199.99,
                'original_price' => 250.00,
                'sku' => 'NIKE-KIDS-001',
                'quantity' => 30,
                'category' => 'sports-shoes',
                'brand' => 'nike',
                'is_sized' => true,
            ],
            [
                'name' => 'حذاء أديداس الرياضي',
                'slug' => 'adidas-sports-shoes',
                'description' => 'حذاء رياضي عالي الجودة بتصميم عصري وألوان جذابة.',
                'price' => 229.99,
                'original_price' => 280.00,
                'sku' => 'ADIDAS-SPORT-001',
                'quantity' => 25,
                'category' => 'sports-shoes',
                'brand' => 'adidas',
                'is_sized' => true,
            ],
            
            // Casual Shoes
            [
                'name' => 'حذاء كونفيرس الكلاسيكي',
                'slug' => 'converse-classic-shoes',
                'description' => 'حذاء كونفيرس الكلاسيكي بتصميم عالي وألوان متنوعة.',
                'price' => 159.99,
                'original_price' => 190.00,
                'sku' => 'CONV-CLASSIC-001',
                'quantity' => 40,
                'category' => 'casual-shoes',
                'brand' => 'converse',
                'is_sized' => true,
            ],
            [
                'name' => 'حذاء فانز العصري',
                'slug' => 'vans-trendy-shoes',
                'description' => 'حذاء فانز مريح بتصميم عصري مناسب للاستخدام اليومي.',
                'price' => 179.99,
                'original_price' => 220.00,
                'sku' => 'VANS-TREND-001',
                'quantity' => 35,
                'category' => 'casual-shoes',
                'brand' => 'vans',
                'is_sized' => true,
            ],
            
            // Formal Shoes
            [
                'name' => 'حذاء رسمي كلاسيكي',
                'slug' => 'classic-formal-shoes',
                'description' => 'حذاء رسمي أنيق مصنوع من الجلد الطبيعي للمناسبات الخاصة.',
                'price' => 249.99,
                'original_price' => 300.00,
                'sku' => 'FORMAL-CLASS-001',
                'quantity' => 20,
                'category' => 'formal-shoes',
                'brand' => 'nike',
                'is_sized' => true,
            ],
            
            // Kids Shoes
            [
                'name' => 'حذاء أطفال ملون',
                'slug' => 'colorful-kids-shoes',
                'description' => 'حذاء أطفال بألوان زاهية وتصميم جذاب مع إضاءة LED.',
                'price' => 89.99,
                'original_price' => 120.00,
                'sku' => 'KIDS-COLOR-001',
                'quantity' => 50,
                'category' => 'kids-shoes',
                'brand' => 'disney',
                'is_sized' => true,
            ],
            [
                'name' => 'حذاء أطفال سبايدرمان',
                'slug' => 'spiderman-kids-shoes',
                'description' => 'حذاء أطفال بتصميم سبايدرمان المحبوب مع أضواء وأصوات.',
                'price' => 99.99,
                'original_price' => 130.00,
                'sku' => 'SPIDER-KIDS-001',
                'quantity' => 45,
                'category' => 'kids-shoes',
                'brand' => 'marvel',
                'is_sized' => true,
            ],
            
            // Sandals
            [
                'name' => 'صندل صيفي مريح',
                'slug' => 'comfortable-summer-sandals',
                'description' => 'صندل صيفي مريح ومناسب للشاطئ والأنشطة الخارجية.',
                'price' => 69.99,
                'original_price' => 90.00,
                'sku' => 'SANDAL-SUMMER-001',
                'quantity' => 60,
                'category' => 'sandals',
                'brand' => 'adidas',
                'is_sized' => true,
            ],
        ];

        foreach ($shoes as $shoeData) {
            $this->createProduct($shoeData);
        }
    }

    private function createKidsAccessoriesProducts()
    {
        $accessories = [
            // Kids Clothing
            [
                'name' => 'قميص أطفال بتصميم ديزني',
                'slug' => 'disney-kids-tshirt',
                'description' => 'قميص أطفال مريح بتصميم شخصيات ديزني المحبوبة.',
                'price' => 45.99,
                'original_price' => 60.00,
                'sku' => 'DISNEY-SHIRT-001',
                'quantity' => 80,
                'category' => 'kids-clothing',
                'brand' => 'disney',
            ],
            [
                'name' => 'فستان أطفال أنيق',
                'slug' => 'elegant-kids-dress',
                'description' => 'فستان أطفال أنيق ومريح للمناسبات الخاصة.',
                'price' => 89.99,
                'original_price' => 110.00,
                'sku' => 'KIDS-DRESS-001',
                'quantity' => 40,
                'category' => 'kids-clothing',
                'brand' => 'frozen',
            ],
            
            // School Bags
            [
                'name' => 'حقيبة مدرسية سبايدرمان',
                'slug' => 'spiderman-school-bag',
                'description' => 'حقيبة مدرسية عملية بتصميم سبايدرمان مع جيوب متعددة.',
                'price' => 119.99,
                'original_price' => 150.00,
                'sku' => 'SPIDER-BAG-001',
                'quantity' => 35,
                'category' => 'school-bags',
                'brand' => 'marvel',
            ],
            [
                'name' => 'حقيبة مدرسية للبنات',
                'slug' => 'girls-school-bag',
                'description' => 'حقيبة مدرسية جميلة للبنات بألوان وردية وتصميم أنيق.',
                'price' => 99.99,
                'original_price' => 130.00,
                'sku' => 'GIRLS-BAG-001',
                'quantity' => 45,
                'category' => 'school-bags',
                'brand' => 'hello-kitty',
            ],
            
            // School Supplies
            [
                'name' => 'مجموعة أدوات مدرسية كاملة',
                'slug' => 'complete-school-supplies',
                'description' => 'مجموعة شاملة من الأدوات المدرسية: أقلام، مساطر، ألوان.',
                'price' => 59.99,
                'original_price' => 80.00,
                'sku' => 'SCHOOL-SUP-001',
                'quantity' => 70,
                'category' => 'school-supplies',
                'brand' => 'disney',
            ],
            [
                'name' => 'علبة ألوان للأطفال',
                'slug' => 'kids-coloring-set',
                'description' => 'علبة ألوان شاملة مع أقلام تلوين وألوان مائية.',
                'price' => 39.99,
                'original_price' => 55.00,
                'sku' => 'COLOR-SET-001',
                'quantity' => 90,
                'category' => 'school-supplies',
                'brand' => 'cars',
            ],
            
            // Kids Accessories
            [
                'name' => 'ساعة أطفال ذكية',
                'slug' => 'smart-kids-watch',
                'description' => 'ساعة ذكية للأطفال مع ألعاب وأنشطة تعليمية.',
                'price' => 149.99,
                'original_price' => 200.00,
                'sku' => 'SMART-WATCH-001',
                'quantity' => 25,
                'category' => 'kids-accessories-items',
                'brand' => 'disney',
            ],
            [
                'name' => 'قبعة أطفال عصرية',
                'slug' => 'trendy-kids-hat',
                'description' => 'قبعة أطفال عصرية مع حماية من أشعة الشمس.',
                'price' => 29.99,
                'original_price' => 40.00,
                'sku' => 'KIDS-HAT-001',
                'quantity' => 100,
                'category' => 'kids-accessories-items',
                'brand' => 'cars',
            ],
            
            // Strollers
            [
                'name' => 'عربة أطفال فاخرة',
                'slug' => 'luxury-baby-stroller',
                'description' => 'عربة أطفال فاخرة قابلة للطي مع ميزات أمان متقدمة.',
                'price' => 599.99,
                'original_price' => 750.00,
                'sku' => 'STROLLER-LUX-001',
                'quantity' => 10,
                'category' => 'strollers',
                'brand' => 'disney',
            ],
            [
                'name' => 'عربة أطفال خفيفة',
                'slug' => 'lightweight-stroller',
                'description' => 'عربة أطفال خفيفة الوزن ومريحة للاستخدام اليومي.',
                'price' => 299.99,
                'original_price' => 400.00,
                'sku' => 'STROLLER-LIGHT-001',
                'quantity' => 15,
                'category' => 'strollers',
                'brand' => 'hello-kitty',
            ],
        ];

        foreach ($accessories as $accessoryData) {
            $this->createProduct($accessoryData);
        }
    }

    private function createProduct($productData)
    {
        $category = Category::where('slug', $productData['category'])->first();
        $brand = Brand::where('slug', $productData['brand'])->first();

        if (!$category || !$brand) {
            return;
        }

        Product::create([
            'name' => $productData['name'],
            'slug' => $productData['slug'],
            'description' => $productData['description'],
            'price' => $productData['price'],
            'original_price' => $productData['original_price'],
            'sku' => $productData['sku'],
            'quantity' => $productData['quantity'],
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'is_active' => true,
            'status' => 'in_stock',
            'meta_title' => $productData['name'],
            'meta_description' => $productData['description'],
            'is_sized' => $productData['is_sized'] ?? false,
            'is_deleted' => false,
            'edit_by' => 1,
        ]);
    }

    private function createProductImages()
    {
        $this->command->info('إنشاء صور المنتجات...');
        
        $products = Product::all();
        
        foreach ($products as $product) {
            for ($i = 1; $i <= 3; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'products/' . $product->slug . '-' . $i . '.jpg',
                    'is_primary' => $i === 1,
                    'is_deleted' => false,
                    'edit_by' => 1,
                ]);
            }
        }
    }

    private function createProductSizes()
    {
        $this->command->info('إنشاء مقاسات المنتجات...');
        
        $sizedProducts = Product::where('is_sized', true)->get();
        $shoeSizes = ['35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
        
        foreach ($sizedProducts as $product) {
            foreach ($shoeSizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'stock_quantity' => rand(5, 20),
                    'is_available' => true,
                    'is_deleted' => false,
                    'edit_by' => 1,
                ]);
            }
        }
    }

    private function createReviews()
    {
        $this->command->info('إنشاء التقييمات...');
        
        $products = Product::all();
        $users = User::where('id', '!=', 1)->get(); // Exclude admin user
        
        $reviews = [
            'منتج رائع وجودة ممتازة، أنصح بشرائه',
            'المنتج وصل في الوقت المحدد وحسب الوصف',
            'جودة عالية وسعر مناسب، راض جداً عن الشراء',
            'منتج جميل وعملي، الأطفال يحبونه كثيراً',
            'تعامل ممتاز وخدمة رائعة، شكراً لكم',
            'المنتج أفضل من المتوقع، سأشتري مرة أخرى',
            'جودة التصنيع ممتازة والمواد آمنة للأطفال',
            'سعر مناسب ومنتج عالي الجودة'
        ];

        foreach ($products->take(15) as $product) {
            for ($i = 0; $i < rand(1, 4); $i++) {
                if ($users->count() > 0) {
                    ProductReview::create([
                        'product_id' => $product->id,
                        'user_id' => $users->random()->id,
                        'rating' => rand(4, 5),
                        'comment' => $reviews[array_rand($reviews)],
                        'is_approved' => true,
                        'is_deleted' => false,
                        'edit_by' => 1,
                    ]);
                }
            }
        }
    }

    private function createOrders()
    {
        $this->command->info('إنشاء الطلبات...');
        
        $users = User::where('id', '!=', 1)->get(); // Exclude admin user
        $products = Product::all();

        foreach ($users->take(5) as $user) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                $subtotal = 0;
                $orderProducts = $products->random(rand(1, 4));
                
                foreach ($orderProducts as $product) {
                    $subtotal += $product->price * rand(1, 2);
                }
                
                $shippingCost = 30.00;
                $totalAmount = $subtotal + $shippingCost;

                $order = Order::create([
                    'order_number' => 'ORD-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'status' => ['pending', 'confirmed', 'shipped', 'delivered'][rand(0, 3)],
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'total_amount' => $totalAmount,
                    'shipping_address' => 'الرياض، حي النرجس، شارع الأمير محمد بن عبدالعزيز',
                    'phone' => '05' . rand(10000000, 99999999),
                    'notes' => 'ملاحظات خاصة بالطلب',
                ]);

                foreach ($orderProducts as $product) {
                    $quantity = rand(1, 2);
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'total' => $product->price * $quantity,
                    ]);
                }
            }
        }
    }

    private function createFavorites()
    {
        $this->command->info('إنشاء المفضلة...');
        
        $users = User::where('id', '!=', 1)->get(); // Exclude admin user
        $products = Product::all();

        foreach ($users as $user) {
            $favoriteProducts = $products->random(rand(3, 8));
            
            foreach ($favoriteProducts as $product) {
                Favorite::firstOrCreate([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
