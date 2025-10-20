<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Discount;
use App\Models\DiscountProduct;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CompleteMalakDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting Malak Outlet Complete Data Seeding...');

        // Clear existing data
        $this->clearExistingData();

        // Create categories with subcategories
        $categories = $this->createCategories();
        
        // Create brands
        $brands = $this->createBrands();
        
        // Create discounts
        $discounts = $this->createDiscounts();
        
        // Create products for each category
        $products = $this->createProducts($categories, $brands);
        
        // Create product images
        $this->createProductImages($products);
        
        // Create product sizes
        $this->createProductSizes($products);
        
        // Apply discounts to random products
        echo "🎯 Applying discounts to products...\n";
        $products = Product::inRandomOrder()->take(5)->get();
        $discounts = Discount::all();
        
        foreach($products as $product) {
            $randomDiscount = $discounts->random();
            DiscountProduct::create([
                'product_id' => $product->id,
                'discount_id' => $randomDiscount->id,
                'is_deleted' => false,
                'edit_by' => null,
            ]);
        }

        $this->command->info('✅ Malak Outlet Complete Data Seeding Completed Successfully!');
        $this->showSummary();
    }

    private function clearExistingData()
    {
        $this->command->info('🗑️  Clearing existing data...');
        
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear data in proper order
        DiscountProduct::truncate();
        ProductSize::truncate();
        ProductImage::truncate();
        
        // Clear favorites table if exists
        if (\Schema::hasTable('favorites')) {
            \DB::table('favorites')->delete();
        }
        
        Product::truncate();
        Discount::truncate();
        Brand::truncate();
        Category::truncate();
        
        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function createCategories()
    {
        $this->command->info('📂 Creating categories...');

        $mainCategories = [
            'العاب' => [
                'slug' => 'toys',
                'description' => 'مجموعة متنوعة من الألعاب المسلية والتعليمية للأطفال من جميع الأعمار',
                'subcategories' => [
                    'ألعاب تعليمية' => 'Educational toys that help children learn while having fun',
                    'ألعاب إلكترونية' => 'Electronic games and gadgets for modern entertainment',
                    'ألعاب بناء' => 'Building blocks, LEGO, and construction toys',
                    'دمى وعرائس' => 'Dolls, action figures, and character toys',
                    'ألعاب خارجية' => 'Outdoor toys for active play and sports',
                ]
            ],
            'أحذية' => [
                'slug' => 'shoes',
                'description' => 'أحذية عصرية وأنيقة للأطفال بأحجام وألوان متنوعة',
                'subcategories' => [
                    'أحذية رياضية' => 'Sports shoes and sneakers for active children',
                    'أحذية مدرسية' => 'Formal school shoes for daily wear',
                    'صنادل صيفية' => 'Summer sandals and beach footwear',
                    'أحذية شتوية' => 'Winter boots and warm footwear',
                    'أحذية منزلية' => 'House slippers and comfortable indoor shoes',
                ]
            ],
            'مستلزمات أطفال' => [
                'slug' => 'kids-accessories',
                'description' => 'كل ما يحتاجه طفلك من مستلزمات وإكسسوارات يومية',
                'subcategories' => [
                    'حقائب مدرسية' => 'School bags, backpacks, and lunch boxes',
                    'مستلزمات النوم' => 'Bedding, pillows, and sleep accessories',
                    'أدوات الطعام' => 'Plates, cups, utensils for kids',
                    'إكسسوارات الشعر' => 'Hair accessories, clips, and bands',
                    'مستلزمات الاستحمام' => 'Bath toys, towels, and hygiene products',
                ]
            ]
        ];

        $categories = collect();

        foreach ($mainCategories as $mainCatName => $mainCatData) {
            // Create main category
            $mainCategory = Category::create([
                'name' => $mainCatName,
                'slug' => $mainCatData['slug'],
                'description' => $mainCatData['description'],
                'parent_id' => null,
                'is_active' => true,
                'is_deleted' => false,
            ]);

            $categories->push($mainCategory);

            // Create subcategories
            foreach ($mainCatData['subcategories'] as $subCatName => $subCatDesc) {
                $subCategory = Category::create([
                    'name' => $subCatName,
                    'slug' => Str::slug($subCatName),
                    'description' => $subCatDesc,
                    'parent_id' => $mainCategory->id,
                    'is_active' => true,
                    'is_deleted' => false,
                ]);

                $categories->push($subCategory);
            }
        }

        $this->command->info("✅ Created {$categories->count()} categories");
        return $categories;
    }

    private function createBrands()
    {
        $this->command->info('🏷️  Creating brands...');

        $brandData = [
            'نايكي' => ['Nike', 'العلامة التجارية الرياضية الرائدة عالمياً'],
            'أديداس' => ['Adidas', 'علامة تجارية المانية مشهورة بالمنتجات الرياضية'],
            'ليجو' => ['LEGO', 'أشهر علامة تجارية في ألعاب البناء'],
            'باربي' => ['Barbie', 'العلامة التجارية الأشهر في عالم الدمى'],
            'فيشر برايس' => ['Fisher-Price', 'ألعاب تعليمية وترفيهية للأطفال'],
            'ماتيل' => ['Mattel', 'شركة ألعاب أمريكية رائدة'],
            'هاسبرو' => ['Hasbro', 'ألعاب وترفيه للأطفال من جميع الأعمار'],
            'كونفيرس' => ['Converse', 'أحذية كلاسيكية عصرية'],
            'سكيتشرز' => ['Skechers', 'أحذية مريحة وأنيقة'],
            'بوما' => ['Puma', 'علامة تجارية رياضية عالمية'],
        ];

        $brands = collect();

        foreach ($brandData as $arabicName => $data) {
            $brand = Brand::create([
                'name' => $arabicName,
                'slug' => Str::slug($data[0]),
                'is_active' => true,
                'is_deleted' => false,
            ]);

            $brands->push($brand);
        }

        $this->command->info("✅ Created {$brands->count()} brands");
        return $brands;
    }

    private function createDiscounts()
    {
        $this->command->info('💰 Creating discounts...');

        $discounts = collect([
            Discount::create([
                'name' => 'خصم الصيف الكبير',
                'description' => 'خصم صيفي على جميع المنتجات',
                'discount_type' => 'percentage',
                'discount_value' => 25.00,
                'starts_at' => now()->subDays(10),
                'ends_at' => now()->addDays(30),
                'is_active' => true,
            ]),
            Discount::create([
                'name' => 'خصم العودة للمدارس',
                'description' => 'خصم خاص على مستلزمات المدرسة',
                'discount_type' => 'percentage',
                'discount_value' => 15.00,
                'starts_at' => now()->subDays(5),
                'ends_at' => now()->addDays(45),
                'is_active' => true,
            ]),
            Discount::create([
                'name' => 'خصم ثابت للألعاب',
                'description' => 'خصم ثابت 20 ريال على الألعاب',
                'discount_type' => 'fixed',
                'discount_value' => 20.00,
                'starts_at' => now(),
                'ends_at' => now()->addDays(60),
                'is_active' => true,
            ]),
        ]);

        $this->command->info("✅ Created {$discounts->count()} discounts");
        return $discounts;
    }

    private function createProducts($categories, $brands)
    {
        $this->command->info('🛍️  Creating products...');

        $products = collect();

        // Products data organized by category
        $productsByCategory = [
            'العاب' => [
                'ألعاب تعليمية' => [
                    'لعبة تعلم الحروف والأرقام' => ['educational-letters-numbers', 'لعبة تفاعلية لتعلم الحروف والأرقام باللغة العربية والإنجليزية', 89.99],
                    'مكعبات بناء تعليمية' => ['educational-building-blocks', 'مكعبات ملونة لتطوير مهارات البناء والإبداع', 65.50],
                    'لوح رسم مغناطيسي' => ['magnetic-drawing-board', 'لوح رسم مغناطيسي محمول للرسم والكتابة', 45.00],
                ],
                'ألعاب إلكترونية' => [
                    'جهاز ألعاب محمول للأطفال' => ['kids-handheld-console', 'جهاز ألعاب محمول مع 200 لعبة متنوعة', 159.99],
                    'ساعة ذكية للأطفال' => ['kids-smart-watch', 'ساعة ذكية بألعاب وكاميرا للأطفال', 199.00],
                ],
                'دمى وعرائس' => [
                    'دمية باربي كلاسيكية' => ['classic-barbie-doll', 'دمية باربي الأصلية مع إكسسوارات متنوعة', 79.99],
                    'شخصيات سوبرمان' => ['superman-action-figures', 'مجموعة شخصيات سوبرمان المتحركة', 95.50],
                ],
            ],
            'أحذية' => [
                'أحذية رياضية' => [
                    'حذاء رياضي نايكي للأطفال' => ['nike-kids-sneakers', 'حذاء رياضي مريح وأنيق للأطفال', 159.99],
                    'حذاء أديداس كلاسيكي' => ['adidas-classic-shoes', 'حذاء أديداس كلاسيكي بتصميم عصري', 149.00],
                ],
                'أحذية مدرسية' => [
                    'حذاء مدرسي أسود' => ['black-school-shoes', 'حذاء مدرسي رسمي أسود اللون', 89.99],
                    'حذاء مدرسي بني' => ['brown-school-shoes', 'حذاء مدرسي أنيق بني اللون', 85.50],
                ],
                'صنادل صيفية' => [
                    'صندل صيفي ملون' => ['colorful-summer-sandals', 'صندل صيفي مريح بألوان زاهية', 45.99],
                    'صندل شاطئي للأطفال' => ['kids-beach-sandals', 'صندل مقاوم للماء للشاطئ', 39.99],
                ],
            ],
            'مستلزمات أطفال' => [
                'حقائب مدرسية' => [
                    'حقيبة مدرسية بعجلات' => ['wheeled-school-bag', 'حقيبة مدرسية عملية بعجلات', 129.99],
                    'حقيبة ظهر ملونة' => ['colorful-backpack', 'حقيبة ظهر بتصميم جذاب وألوان زاهية', 69.99],
                ],
                'أدوات الطعام' => [
                    'طقم أطباق الأطفال' => ['kids-dinnerware-set', 'طقم أطباق آمن وملون للأطفال', 55.50],
                    'كوب تدريب للأطفال' => ['kids-training-cup', 'كوب تدريب مانع للانسكاب', 25.99],
                ],
                'مستلزمات النوم' => [
                    'وسادة أطفال مريحة' => ['comfortable-kids-pillow', 'وسادة ناعمة ومريحة للأطفال', 45.00],
                    'بطانية أطفال قطنية' => ['cotton-kids-blanket', 'بطانية قطنية ناعمة بتصاميم الأطفال', 65.99],
                ],
            ],
        ];

        foreach ($productsByCategory as $mainCatName => $subcategories) {
            foreach ($subcategories as $subCatName => $productList) {
                $category = $categories->firstWhere('name', $subCatName);
                if (!$category) continue;

                foreach ($productList as $productName => $productData) {
                    $product = Product::create([
                        'name' => $productName,
                        'slug' => $productData[0],
                        'description' => $productData[1],
                        'price' => $productData[2],
                        'sale_price' => rand(0, 1) ? round($productData[2] * 0.85, 2) : null,
                        'category_id' => $category->id,
                        'brand_id' => $brands->random()->id,
                        'sku' => 'MLK-' . strtoupper(Str::random(6)),
                        'quantity' => rand(10, 100),
                        'status' => 'in_stock',
                        'is_active' => true,
                        'is_featured' => rand(0, 1) == 1,
                        'is_deleted' => false,
                        'meta_title' => $productName . ' - Malak Outlet',
                        'meta_description' => $productData[1],
                    ]);

                    $products->push($product);
                }
            }
        }

        $this->command->info("✅ Created {$products->count()} products");
        return $products;
    }

    private function createProductImages($products)
    {
        $this->command->info('🖼️  Creating product images...');

        $imageCount = 0;
        foreach ($products as $product) {
            // Create 2-4 images per product
            $numImages = rand(2, 4);
            
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
            
            for ($i = 1; $i <= $numImages; $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $sampleImages[rand(0, count($sampleImages) - 1)],
                    'is_primary' => $i === 1,
                    'is_deleted' => false,
                ]);
                $imageCount++;
            }
        }

        $this->command->info("✅ Created {$imageCount} product images");
    }

    private function createProductSizes($products)
    {
        $this->command->info('📏 Creating product sizes...');

        $sizeCount = 0;
        
        // Size mappings by category
        $sizesByCategory = [
            'أحذية رياضية' => ['35', '36', '37', '38', '39', '40', '41', '42'],
            'أحذية مدرسية' => ['34', '35', '36', '37', '38', '39', '40'],
            'صنادل صيفية' => ['32', '33', '34', '35', '36', '37', '38'],
            'أحذية شتوية' => ['35', '36', '37', '38', '39', '40', '41'],
            'أحذية منزلية' => ['30', '32', '34', '36', '38', '40'],
            'حقائب مدرسية' => ['صغير', 'متوسط', 'كبير'],
            'أدوات الطعام' => ['صغير', 'متوسط'],
            'مستلزمات النوم' => ['50x70', '60x80', '70x90'],
            'إكسسوارات الشعر' => ['صغير', 'متوسط', 'كبير'],
        ];

        foreach ($products as $product) {
            $categoryName = $product->category->name;
            $sizes = $sizesByCategory[$categoryName] ?? ['صغير', 'متوسط', 'كبير'];
            
            // Select 2-4 random sizes for each product
            $productSizes = collect($sizes)->random(min(rand(2, 4), count($sizes)));
            
            foreach ($productSizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'size_type' => 'standard',
                    'description' => "مقاس {$size}",
                    'stock_quantity' => rand(5, 30),
                    'additional_price' => 0,
                    'is_available' => true,
                    'is_popular' => rand(0, 1) == 1,
                    'is_deleted' => false,
                ]);
                $sizeCount++;
            }
        }

        $this->command->info("✅ Created {$sizeCount} product sizes");
    }

    private function applyDiscountsToProducts($products, $discounts)
    {
        $this->command->info('🎯 Applying discounts to products...');

        $discountCount = 0;
        
        // Apply discounts to random products (about 30% of products)
        $productsToDiscount = $products->random(ceil($products->count() * 0.3));
        
        foreach ($productsToDiscount as $product) {
            $discount = $discounts->random();
            
            DiscountProduct::create([
                'product_id' => $product->id,
                'discount_id' => $discount->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $discountCount++;
        }

        $this->command->info("✅ Applied {$discountCount} discounts to products");
    }

    private function showSummary()
    {
        $this->command->info('📊 Database Summary:');
        $this->command->info('- Categories: ' . Category::count());
        $this->command->info('- Brands: ' . Brand::count());
        $this->command->info('- Products: ' . Product::count());
        $this->command->info('- Product Images: ' . ProductImage::count());
        $this->command->info('- Product Sizes: ' . ProductSize::count());
        $this->command->info('- Discounts: ' . Discount::count());
        $this->command->info('- Discount Applications: ' . DiscountProduct::count());
        $this->command->info('🎉 Malak Outlet is ready to go!');
    }
}
