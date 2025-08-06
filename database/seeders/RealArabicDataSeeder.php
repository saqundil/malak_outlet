<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RealArabicDataSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Categories (الفئات)
        $this->seedCategories();
        
        // Seed Brands (العلامات التجارية)
        $this->seedBrands();
        
        // Seed Users (المستخدمين)
        $this->seedUsers();
        
        // Seed Products (المنتجات)
        $this->seedProducts();
        
        // Seed Product Sizes (أحجام المنتجات)
        $this->seedProductSizes();
        
        // Seed Product Reviews (تقييمات المنتجات)
        $this->seedProductReviews();
        
        // Seed Orders (الطلبات)
        $this->seedOrders();
        
        // Seed Order Items (عناصر الطلبات)
        $this->seedOrderItems();
    }

    private function seedCategories(): void
    {
        $categories = [
            [
                'name' => 'ملابس رجالية',
                'slug' => 'mens-clothing',
                'description' => 'مجموعة متنوعة من الملابس الرجالية العصرية والأنيقة',
                'is_active' => true,
                'parent_id' => null,
                'image' => 'mens-clothing.jpg',
            ],
            [
                'name' => 'ملابس نسائية',
                'slug' => 'womens-clothing',
                'description' => 'أحدث صيحات الموضة النسائية والملابس العصرية',
                'is_active' => true,
                'parent_id' => null,
                'image' => 'womens-clothing.jpg',
            ],
            [
                'name' => 'أحذية',
                'slug' => 'shoes',
                'description' => 'مجموعة واسعة من الأحذية للرجال والنساء',
                'is_active' => true,
                'parent_id' => null,
                'image' => 'shoes.jpg',
            ],
            [
                'name' => 'إكسسوارات',
                'slug' => 'accessories',
                'description' => 'إكسسوارات متنوعة لإكمال إطلالتك',
                'is_active' => true,
                'parent_id' => null,
                'image' => 'accessories.jpg',
            ],
            [
                'name' => 'حقائب',
                'slug' => 'bags',
                'description' => 'حقائب عملية وأنيقة للاستخدام اليومي',
                'is_active' => true,
                'parent_id' => null,
                'image' => 'bags.jpg',
            ],
        ];

        // إضافة فئات فرعية
        $subCategories = [
            // فئات فرعية للملابس الرجالية
            [
                'name' => 'قمصان رجالية',
                'slug' => 'mens-shirts',
                'description' => 'قمصان رجالية كلاسيكية وعصرية',
                'parent_id' => 1,
                'image' => 'mens-shirts.jpg',
            ],
            [
                'name' => 'بناطيل رجالية',
                'slug' => 'mens-pants',
                'description' => 'بناطيل رجالية مريحة وأنيقة',
                'parent_id' => 1,
                'image' => 'mens-pants.jpg',
            ],
            [
                'name' => 'جاكيتات رجالية',
                'slug' => 'mens-jackets',
                'description' => 'جاكيتات رجالية للطقس البارد',
                'parent_id' => 1,
                'image' => 'mens-jackets.jpg',
            ],
            // فئات فرعية للملابس النسائية
            [
                'name' => 'فساتين',
                'slug' => 'dresses',
                'description' => 'فساتين أنيقة لجميع المناسبات',
                'parent_id' => 2,
                'image' => 'dresses.jpg',
            ],
            [
                'name' => 'بلوزات نسائية',
                'slug' => 'womens-blouses',
                'description' => 'بلوزات نسائية عصرية وأنيقة',
                'parent_id' => 2,
                'image' => 'womens-blouses.jpg',
            ],
            [
                'name' => 'تنانير',
                'slug' => 'skirts',
                'description' => 'تنانير بتصاميم متنوعة وعصرية',
                'parent_id' => 2,
                'image' => 'skirts.jpg',
            ],
            // فئات فرعية للأحذية
            [
                'name' => 'أحذية رجالية',
                'slug' => 'mens-shoes',
                'description' => 'أحذية رجالية كلاسيكية ورياضية',
                'parent_id' => 3,
                'image' => 'mens-shoes.jpg',
            ],
            [
                'name' => 'أحذية نسائية',
                'slug' => 'womens-shoes',
                'description' => 'أحذية نسائية بكعب عالي ومنخفض',
                'parent_id' => 3,
                'image' => 'womens-shoes.jpg',
            ],
        ];

        // إدراج الفئات الرئيسية
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'is_active' => $category['is_active'],
                'parent_id' => $category['parent_id'],
                'image' => $category['image'],
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // إدراج الفئات الفرعية
        foreach ($subCategories as $subCategory) {
            DB::table('categories')->insert([
                'name' => $subCategory['name'],
                'slug' => $subCategory['slug'],
                'description' => $subCategory['description'],
                'is_active' => true,
                'parent_id' => $subCategory['parent_id'],
                'image' => $subCategory['image'],
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function seedBrands(): void
    {
        $brands = [
            [
                'name' => 'أديداس',
                'slug' => 'adidas',
                'image' => 'adidas-logo.jpg',
            ],
            [
                'name' => 'نايكي',
                'slug' => 'nike',
                'image' => 'nike-logo.jpg',
            ],
            [
                'name' => 'زارا',
                'slug' => 'zara',
                'image' => 'zara-logo.jpg',
            ],
            [
                'name' => 'إتش آند إم',
                'slug' => 'h-and-m',
                'image' => 'hm-logo.jpg',
            ],
            [
                'name' => 'بوما',
                'slug' => 'puma',
                'image' => 'puma-logo.jpg',
            ],
            [
                'name' => 'فيرساتشي',
                'slug' => 'versace',
                'image' => 'versace-logo.jpg',
            ],
            [
                'name' => 'غوتشي',
                'slug' => 'gucci',
                'image' => 'gucci-logo.jpg',
            ],
            [
                'name' => 'شانيل',
                'slug' => 'chanel',
                'image' => 'chanel-logo.jpg',
            ],
            [
                'name' => 'الماس العربي',
                'slug' => 'almas-alarabi',
                'image' => 'almas-logo.jpg',
            ],
            [
                'name' => 'أناقة شرقية',
                'slug' => 'anaqa-sharqiya',
                'image' => 'anaqa-logo.jpg',
            ],
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand['name'],
                'slug' => $brand['slug'],
                'image' => $brand['image'],
                'is_active' => true,
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function seedUsers(): void
    {
        $users = [
            [
                'name' => 'أحمد محمد علي',
                'email' => 'ahmed.mohamed@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'فاطمة عبدالله',
                'email' => 'fatima.abdullah@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'محمد حسن',
                'email' => 'mohamed.hassan@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'عائشة سالم',
                'email' => 'aisha.salem@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'عبدالرحمن أحمد',
                'email' => 'abdulrahman.ahmed@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'مريم يوسف',
                'email' => 'mariam.youssef@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'خالد عبدالعزيز',
                'email' => 'khalid.abdulaziz@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'نورا إبراهيم',
                'email' => 'nora.ibrahim@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'سعد المالكي',
                'email' => 'saad.almalki@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'هند الزهراني',
                'email' => 'hind.alzahrani@example.com',
                'password' => bcrypt('password123'),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function seedProducts(): void
    {
        $products = [
            // ملابس رجالية
            [
                'name' => 'قميص قطني أبيض كلاسيكي',
                'slug' => 'classic-white-cotton-shirt',
                'description' => 'قميص قطني أبيض كلاسيكي مناسب للعمل والمناسبات الرسمية. مصنوع من قطن عالي الجودة.',
                'price' => 120.00,
                'original_price' => 150.00,
                'sku' => 'SHIRT-001',
                'quantity' => 50,
                'category_id' => 6, // قمصان رجالية
                'brand_id' => 3, // زارا
                'status' => 'in_stock',
                'is_sized' => true,
                'meta_title' => 'قميص قطني أبيض كلاسيكي - ملاك أوتلت',
                'meta_description' => 'اشتري أفضل قميص قطني أبيض كلاسيكي من ملاك أوتلت بأفضل الأسعار',
            ],
            [
                'name' => 'بنطلون جينز أزرق غامق',
                'slug' => 'dark-blue-jeans',
                'description' => 'بنطلون جينز أزرق غامق عالي الجودة، مريح ومناسب للاستخدام اليومي.',
                'price' => 180.00,
                'original_price' => 220.00,
                'sku' => 'JEANS-001',
                'quantity' => 30,
                'category_id' => 7, // بناطيل رجالية
                'brand_id' => 4, // إتش آند إم
                'status' => 'in_stock',
                'is_sized' => true,
                'meta_title' => 'بنطلون جينز أزرق غامق - ملاك أوتلت',
                'meta_description' => 'بنطلون جينز عالي الجودة بسعر مميز من ملاك أوتلت',
            ],
            [
                'name' => 'جاكيت شتوي أسود',
                'slug' => 'black-winter-jacket',
                'description' => 'جاكيت شتوي أسود دافئ ومقاوم للماء، مثالي للطقس البارد.',
                'price' => 350.00,
                'original_price' => 450.00,
                'sku' => 'JACKET-001',
                'quantity' => 25,
                'category_id' => 8, // جاكيتات رجالية
                'brand_id' => 1, // أديداس
                'status' => 'in_stock',
                'is_sized' => true,
                'meta_title' => 'جاكيت شتوي أسود - ملاك أوتلت',
                'meta_description' => 'جاكيت شتوي عالي الجودة يحميك من البرد',
            ],
            // ملابس نسائية
            [
                'name' => 'فستان سهرة أحمر',
                'slug' => 'red-evening-dress',
                'description' => 'فستان سهرة أحمر أنيق مناسب للمناسبات الخاصة والحفلات.',
                'price' => 280.00,
                'original_price' => 350.00,
                'sku' => 'DRESS-001',
                'quantity' => 20,
                'category_id' => 9, // فساتين
                'brand_id' => 6, // فيرساتشي
                'status' => 'in_stock',
                'is_sized' => true,
                'meta_title' => 'فستان سهرة أحمر أنيق - ملاك أوتلت',
                'meta_description' => 'فستان سهرة راقي ومميز لإطلالة ساحرة',
            ],
            [
                'name' => 'بلوزة حريرية زرقاء',
                'slug' => 'blue-silk-blouse',
                'description' => 'بلوزة حريرية زرقاء ناعمة وأنيقة، مناسبة للعمل والمناسبات.',
                'price' => 160.00,
                'original_price' => 200.00,
                'sku' => 'BLOUSE-001',
                'quantity' => 35,
                'category_id' => 10, // بلوزات نسائية
                'brand_id' => 8, // شانيل
                'status' => 'in_stock',
                'is_sized' => true,
                'meta_title' => 'بلوزة حريرية زرقاء - ملاك أوتلت',
                'meta_description' => 'بلوزة حريرية فاخرة بجودة عالية',
            ],
            [
                'name' => 'تنورة قصيرة سوداء',
                'slug' => 'black-short-skirt',
                'description' => 'تنورة قصيرة سوداء عصرية وأنيقة، مناسبة للإطلالات اليومية.',
                'price' => 95.00,
                'original_price' => 120.00,
                'sku' => 'SKIRT-001',
                'quantity' => 40,
                'category_id' => 11, // تنانير
                'brand_id' => 3, // زارا
                'status' => 'in_stock',
                'is_sized' => true,
                'meta_title' => 'تنورة قصيرة سوداء - ملاك أوتلت',
                'meta_description' => 'تنورة عصرية وأنيقة بأفضل الأسعار',
            ],
            // أحذية
            [
                'name' => 'حذاء رياضي أبيض',
                'slug' => 'white-sneakers',
                'description' => 'حذاء رياضي أبيض مريح ومناسب للرياضة والاستخدام اليومي.',
                'price' => 220.00,
                'original_price' => 280.00,
                'sku' => 'SHOE-001',
                'quantity' => 45,
                'category_id' => 12, // أحذية رجالية
                'brand_id' => 2, // نايكي
                'status' => 'in_stock',
                'is_sized' => true,
                'meta_title' => 'حذاء رياضي أبيض - ملاك أوتلت',
                'meta_description' => 'حذاء رياضي مريح وعصري من نايكي',
            ],
            [
                'name' => 'صندل نسائي بكعب عالي',
                'slug' => 'womens-high-heel-sandals',
                'description' => 'صندل نسائي أنيق بكعب عالي، مثالي للمناسبات الخاصة.',
                'price' => 190.00,
                'original_price' => 240.00,
                'sku' => 'SANDAL-001',
                'quantity' => 25,
                'category_id' => 13, // أحذية نسائية
                'brand_id' => 7, // غوتشي
                'status' => 'in_stock',
                'is_sized' => true,
                'meta_title' => 'صندل نسائي بكعب عالي - ملاك أوتلت',
                'meta_description' => 'صندل نسائي فاخر وأنيق من غوتشي',
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
                'price' => $product['price'],
                'original_price' => $product['original_price'],
                'sku' => $product['sku'],
                'quantity' => $product['quantity'],
                'category_id' => $product['category_id'],
                'brand_id' => $product['brand_id'],
                'is_active' => true,
                'status' => $product['status'],
                'meta_title' => $product['meta_title'],
                'meta_description' => $product['meta_description'],
                'is_sized' => $product['is_sized'],
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function seedProductSizes(): void
    {
        // أحجام الملابس
        $clothingSizes = [
            ['size' => 'XS', 'size_type' => 'ملابس', 'description' => 'صغير جداً'],
            ['size' => 'S', 'size_type' => 'ملابس', 'description' => 'صغير'],
            ['size' => 'M', 'size_type' => 'ملابس', 'description' => 'متوسط'],
            ['size' => 'L', 'size_type' => 'ملابس', 'description' => 'كبير'],
            ['size' => 'XL', 'size_type' => 'ملابس', 'description' => 'كبير جداً'],
            ['size' => 'XXL', 'size_type' => 'ملابس', 'description' => 'كبير جداً جداً'],
        ];

        // أحجام الأحذية
        $shoeSizes = [
            ['size' => '38', 'size_type' => 'أحذية', 'description' => ''],
            ['size' => '39', 'size_type' => 'أحذية', 'description' => ''],
            ['size' => '40', 'size_type' => 'أحذية', 'description' => ''],
            ['size' => '41', 'size_type' => 'أحذية', 'description' => ''],
            ['size' => '42', 'size_type' => 'أحذية', 'description' => ''],
            ['size' => '43', 'size_type' => 'أحذية', 'description' => ''],
            ['size' => '44', 'size_type' => 'أحذية', 'description' => ''],
            ['size' => '45', 'size_type' => 'أحذية', 'description' => ''],
        ];

        // إضافة أحجام للمنتجات (المنتجات 1-6 ملابس، المنتجات 7-8 أحذية)
        for ($productId = 1; $productId <= 6; $productId++) {
            foreach ($clothingSizes as $size) {
                DB::table('product_sizes')->insert([
                    'product_id' => $productId,
                    'size' => $size['size'],
                    'size_type' => $size['size_type'],
                    'description' => $size['description'],
                    'stock_quantity' => rand(5, 20),
                    'additional_price' => 0.00,
                    'is_available' => true,
                    'is_popular' => in_array($size['size'], ['S', 'M', 'L']),
                    'is_deleted' => false,
                    'edit_by' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        // إضافة أحجام الأحذية للمنتجات 7-8
        for ($productId = 7; $productId <= 8; $productId++) {
            foreach ($shoeSizes as $size) {
                DB::table('product_sizes')->insert([
                    'product_id' => $productId,
                    'size' => $size['size'],
                    'size_type' => $size['size_type'],
                    'description' => $size['description'],
                    'stock_quantity' => rand(3, 15),
                    'additional_price' => 0.00,
                    'is_available' => true,
                    'is_popular' => in_array($size['size'], ['40', '41', '42']),
                    'is_deleted' => false,
                    'edit_by' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }

    private function seedProductReviews(): void
    {
        $reviews = [
            [
                'product_id' => 1,
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'منتج ممتاز! جودة القماش رائعة والمقاس مضبوط تماماً. أنصح بالشراء.',
            ],
            [
                'product_id' => 1,
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'قميص جميل ومريح، لكن الشحن استغرق وقت أطول من المتوقع.',
            ],
            [
                'product_id' => 2,
                'user_id' => 3,
                'rating' => 5,
                'comment' => 'بنطلون جينز رائع! المقاس مثالي والجودة عالية جداً.',
            ],
            [
                'product_id' => 2,
                'user_id' => 4,
                'rating' => 4,
                'comment' => 'منتج جيد بشكل عام، اللون أجمل من الصور.',
            ],
            [
                'product_id' => 3,
                'user_id' => 5,
                'rating' => 5,
                'comment' => 'جاكيت دافئ جداً ومقاوم للماء كما هو مذكور. ممتاز للشتاء.',
            ],
            [
                'product_id' => 4,
                'user_id' => 6,
                'rating' => 5,
                'comment' => 'فستان رائع وأنيق! حصلت على إعجاب الجميع في الحفلة.',
            ],
            [
                'product_id' => 4,
                'user_id' => 7,
                'rating' => 4,
                'comment' => 'فستان جميل لكن المقاس كان أكبر قليلاً مما توقعت.',
            ],
            [
                'product_id' => 5,
                'user_id' => 8,
                'rating' => 5,
                'comment' => 'بلوزة حريرية فاخرة وناعمة جداً. تستحق السعر المدفوع.',
            ],
            [
                'product_id' => 6,
                'user_id' => 9,
                'rating' => 4,
                'comment' => 'تنورة أنيقة ومناسبة للعمل. جودة جيدة.',
            ],
            [
                'product_id' => 7,
                'user_id' => 10,
                'rating' => 5,
                'comment' => 'أفضل حذاء رياضي اشتريته! مريح جداً ومناسب للجري.',
            ],
            [
                'product_id' => 7,
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'حذاء ممتاز وسعر معقول. التوصيل كان سريع.',
            ],
            [
                'product_id' => 8,
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'صندل جميل وأنيق، لكن الكعب عالي قليلاً بالنسبة لي.',
            ],
        ];

        foreach ($reviews as $review) {
            DB::table('product_reviews')->insert([
                'product_id' => $review['product_id'],
                'user_id' => $review['user_id'],
                'rating' => $review['rating'],
                'comment' => $review['comment'],
                'is_approved' => true,
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }

    private function seedOrders(): void
    {
        $orders = [
            [
                'order_number' => 'ORD-2025-001',
                'user_id' => 1,
                'status' => 'delivered',
                'subtotal' => 300.00,
                'shipping_cost' => 25.00,
                'total_amount' => 325.00,
                'shipping_address' => 'الرياض، حي النخيل، شارع الأمير سلطان، رقم 123',
                'phone' => '+966501234567',
                'notes' => 'يرجى التوصيل بعد المغرب',
                'shipped_at' => Carbon::now()->subDays(5),
                'delivered_at' => Carbon::now()->subDays(3),
            ],
            [
                'order_number' => 'ORD-2025-002',
                'user_id' => 2,
                'status' => 'shipped',
                'subtotal' => 180.00,
                'shipping_cost' => 20.00,
                'total_amount' => 200.00,
                'shipping_address' => 'جدة، حي الزهراء، شارع التحلية، رقم 456',
                'phone' => '+966507654321',
                'notes' => null,
                'shipped_at' => Carbon::now()->subDays(2),
                'delivered_at' => null,
            ],
            [
                'order_number' => 'ORD-2025-003',
                'user_id' => 3,
                'status' => 'pending',
                'subtotal' => 450.00,
                'shipping_cost' => 30.00,
                'total_amount' => 480.00,
                'shipping_address' => 'الدمام، حي الفيصلية، شارع الملك فهد، رقم 789',
                'phone' => '+966512345678',
                'notes' => 'طلب عاجل',
                'shipped_at' => null,
                'delivered_at' => null,
            ],
            [
                'order_number' => 'ORD-2025-004',
                'user_id' => 4,
                'status' => 'delivered',
                'subtotal' => 280.00,
                'shipping_cost' => 25.00,
                'total_amount' => 305.00,
                'shipping_address' => 'مكة المكرمة، حي العزيزية، شارع إبراهيم الجفالي، رقم 321',
                'phone' => '+966598765432',
                'notes' => null,
                'shipped_at' => Carbon::now()->subDays(7),
                'delivered_at' => Carbon::now()->subDays(5),
            ],
            [
                'order_number' => 'ORD-2025-005',
                'user_id' => 5,
                'status' => 'cancelled',
                'subtotal' => 160.00,
                'shipping_cost' => 20.00,
                'total_amount' => 180.00,
                'shipping_address' => 'المدينة المنورة، حي قربان، شارع سيد الشهداء، رقم 654',
                'phone' => '+966534567890',
                'notes' => null,
                'shipped_at' => null,
                'delivered_at' => null,
                'cancelled_at' => Carbon::now()->subDays(1),
                'cancellation_reason' => 'طلب العميل إلغاء الطلب',
            ],
        ];

        foreach ($orders as $order) {
            DB::table('orders')->insert([
                'order_number' => $order['order_number'],
                'user_id' => $order['user_id'],
                'status' => $order['status'],
                'subtotal' => $order['subtotal'],
                'shipping_cost' => $order['shipping_cost'],
                'total_amount' => $order['total_amount'],
                'shipping_address' => $order['shipping_address'],
                'phone' => $order['phone'],
                'notes' => $order['notes'],
                'shipped_at' => $order['shipped_at'],
                'delivered_at' => $order['delivered_at'],
                'cancelled_at' => $order['cancelled_at'] ?? null,
                'cancellation_reason' => $order['cancellation_reason'] ?? null,
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now()->subDays(rand(1, 10)),
                'updated_at' => Carbon::now()->subDays(rand(1, 5)),
            ]);
        }
    }

    private function seedOrderItems(): void
    {
        $orderItems = [
            // Order 1 items
            ['order_id' => 1, 'product_id' => 1, 'quantity' => 2, 'price' => 120.00, 'size' => 'L'],
            ['order_id' => 1, 'product_id' => 6, 'quantity' => 1, 'price' => 95.00, 'size' => 'M'],
            
            // Order 2 items
            ['order_id' => 2, 'product_id' => 2, 'quantity' => 1, 'price' => 180.00, 'size' => '42'],
            
            // Order 3 items
            ['order_id' => 3, 'product_id' => 3, 'quantity' => 1, 'price' => 350.00, 'size' => 'XL'],
            ['order_id' => 3, 'product_id' => 4, 'quantity' => 1, 'price' => 280.00, 'size' => 'M'],
            
            // Order 4 items
            ['order_id' => 4, 'product_id' => 4, 'quantity' => 1, 'price' => 280.00, 'size' => 'S'],
            
            // Order 5 items (cancelled)
            ['order_id' => 5, 'product_id' => 5, 'quantity' => 1, 'price' => 160.00, 'size' => 'L'],
        ];

        foreach ($orderItems as $item) {
            $total = $item['price'] * $item['quantity'];
            DB::table('order_items')->insert([
                'order_id' => $item['order_id'],
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'size' => $item['size'],
                'total' => $total,
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
