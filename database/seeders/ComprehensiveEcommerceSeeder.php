<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\AttributeValue;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Discount;
use App\Models\User;
use Illuminate\Support\Str;

class ComprehensiveEcommerceSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'ملابس نسائية', 'slug' => 'womens-clothing', 'description' => 'مجموعة متنوعة من الملابس النسائية العصرية'],
            ['name' => 'ملابس رجالية', 'slug' => 'mens-clothing', 'description' => 'ملابس رجالية أنيقة ومريحة'],
            ['name' => 'ملابس أطفال', 'slug' => 'kids-clothing', 'description' => 'ملابس أطفال ملونة ومريحة'],
            ['name' => 'أحذية', 'slug' => 'shoes', 'description' => 'أحذية متنوعة للجميع'],
            ['name' => 'إكسسوارات', 'slug' => 'accessories', 'description' => 'إكسسوارات وحقائب متنوعة'],
            ['name' => 'إلكترونيات', 'slug' => 'electronics', 'description' => 'أجهزة إلكترونية حديثة'],
            ['name' => 'منتجات المنزل', 'slug' => 'home-products', 'description' => 'منتجات منزلية وديكور'],
            ['name' => 'رياضة ولياقة', 'slug' => 'sports-fitness', 'description' => 'معدات رياضية ولياقة بدنية'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create Brands
        $brands = [
            ['name' => 'نايك', 'slug' => 'nike'],
            ['name' => 'أديداس', 'slug' => 'adidas'],
            ['name' => 'زارا', 'slug' => 'zara'],
            ['name' => 'H&M', 'slug' => 'hm'],
            ['name' => 'سامسونغ', 'slug' => 'samsung'],
            ['name' => 'آبل', 'slug' => 'apple'],
            ['name' => 'ايكيا', 'slug' => 'ikea'],
            ['name' => 'العلامة المحلية', 'slug' => 'local-brand'],
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }

        // Create Product Attributes
        $attributes = [
            ['name' => 'اللون', 'input_type' => 'select'],
            ['name' => 'المقاس', 'input_type' => 'select'],
            ['name' => 'نوع القماش', 'input_type' => 'select'],
            ['name' => 'المادة', 'input_type' => 'select'],
            ['name' => 'الوزن', 'input_type' => 'text'],
            ['name' => 'الأبعاد', 'input_type' => 'text'],
            ['name' => 'السعة', 'input_type' => 'select'],
            ['name' => 'النوع', 'input_type' => 'select'],
            ['name' => 'الماركة الفرعية', 'input_type' => 'text'],
            ['name' => 'بلد الصنع', 'input_type' => 'select'],
            ['name' => 'فترة الضمان', 'input_type' => 'select'],
            ['name' => 'العمر المناسب', 'input_type' => 'select'],
        ];

        foreach ($attributes as $attributeData) {
            ProductAttribute::create($attributeData);
        }

        // Create Products with comprehensive data
        $products = [
            // Women's Clothing
            [
                'name' => 'فستان صيفي أنيق',
                'description' => 'فستان صيفي خفيف ومريح مصنوع من القطن الطبيعي، مثالي للمناسبات اليومية والخروجات الصيفية',
                'price' => 89.99,
                'sale_price' => 69.99,
                'category_id' => 1,
                'brand_id' => 3,
                'quantity' => 25,
                'sku' => 'WD-001',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'بلوزة نسائية كلاسيكية',
                'description' => 'بلوزة نسائية أنيقة مناسبة للعمل والمناسبات الرسمية، مصنوعة من خامات عالية الجودة',
                'price' => 59.99,
                'sale_price' => 45.99,
                'category_id' => 1,
                'brand_id' => 4,
                'quantity' => 30,
                'sku' => 'WB-001',
                'is_active' => true,
            ],
            
            // Men's Clothing
            [
                'name' => 'قميص رجالي قطني',
                'description' => 'قميص رجالي كلاسيكي مصنوع من القطن المضغوط، مريح ومناسب للاستخدام اليومي والمناسبات',
                'price' => 75.00,
                'sale_price' => 60.00,
                'category_id' => 2,
                'brand_id' => 8,
                'quantity' => 40,
                'sku' => 'MS-001',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'بنطلون جينز رجالي',
                'description' => 'بنطلون جينز عصري بقصة مريحة، مصنوع من الدنيم عالي الجودة مع تفاصيل عملية',
                'price' => 120.00,
                'sale_price' => 95.00,
                'category_id' => 2,
                'brand_id' => 3,
                'quantity' => 20,
                'sku' => 'MJ-001',
                'is_active' => true,
            ],
            
            // Kids Clothing
            [
                'name' => 'قميص أطفال بتصميم كارتوني',
                'description' => 'قميص أطفال ملون بتصميمات كارتونية محبوبة، مصنوع من القطن الناعم المناسب للبشرة الحساسة',
                'price' => 35.00,
                'sale_price' => 25.00,
                'category_id' => 3,
                'brand_id' => 8,
                'quantity' => 50,
                'sku' => 'KS-001',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'فستان أطفال أميرات',
                'description' => 'فستان أطفال جميل بتصميم الأميرات، مثالي للحفلات والمناسبات الخاصة',
                'price' => 65.00,
                'sale_price' => 50.00,
                'category_id' => 3,
                'brand_id' => 4,
                'quantity' => 15,
                'sku' => 'KD-001',
                'is_active' => true,
            ],
            
            // Shoes
            [
                'name' => 'حذاء رياضي للجري',
                'description' => 'حذاء رياضي متطور مصمم خصيصاً للجري والأنشطة الرياضية، بتقنيات امتصاص الصدمات',
                'price' => 189.99,
                'sale_price' => 149.99,
                'category_id' => 4,
                'brand_id' => 1,
                'quantity' => 35,
                'sku' => 'NS-001',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'صندل نسائي صيفي',
                'description' => 'صندل نسائي أنيق ومريح للصيف، بتصميم عصري وخامات طبيعية',
                'price' => 79.99,
                'sale_price' => 65.99,
                'category_id' => 4,
                'brand_id' => 8,
                'quantity' => 25,
                'sku' => 'WS-001',
                'is_active' => true,
            ],
            
            // Accessories
            [
                'name' => 'حقيبة يد نسائية جلدية',
                'description' => 'حقيبة يد أنيقة مصنوعة من الجلد الطبيعي، بتصميم عملي ومساحة تخزين واسعة',
                'price' => 159.99,
                'sale_price' => 129.99,
                'category_id' => 5,
                'brand_id' => 8,
                'quantity' => 18,
                'sku' => 'WH-001',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'ساعة يد ذكية',
                'description' => 'ساعة يد ذكية بمميزات متقدمة لتتبع اللياقة البدنية والإشعارات الذكية',
                'price' => 299.99,
                'sale_price' => 249.99,
                'category_id' => 5,
                'brand_id' => 6,
                'quantity' => 12,
                'sku' => 'SW-001',
                'is_active' => true,
            ],
            
            // Electronics
            [
                'name' => 'سماعات لاسلكية عالية الجودة',
                'description' => 'سماعات لاسلكية بتقنية إلغاء الضوضاء وجودة صوت استثنائية، مثالية للموسيقى والمكالمات',
                'price' => 199.99,
                'sale_price' => 159.99,
                'category_id' => 6,
                'brand_id' => 6,
                'quantity' => 20,
                'sku' => 'WH-002',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'شاحن محمول سريع',
                'description' => 'شاحن محمول بسعة عالية وتقنية الشحن السريع، مناسب لجميع الأجهزة الذكية',
                'price' => 89.99,
                'sale_price' => 69.99,
                'category_id' => 6,
                'brand_id' => 5,
                'quantity' => 30,
                'sku' => 'PB-001',
                'is_active' => true,
            ],
            
            // Home Products
            [
                'name' => 'وسادة مريحة للنوم',
                'description' => 'وسادة طبية مريحة تدعم الرقبة والرأس، مصنوعة من الإسفنج الذكي',
                'price' => 79.99,
                'sale_price' => 59.99,
                'category_id' => 7,
                'brand_id' => 7,
                'quantity' => 25,
                'sku' => 'HP-001',
                'is_active' => true,
            ],
            [
                'name' => 'مجموعة أدوات مطبخ',
                'description' => 'مجموعة شاملة من أدوات المطبخ المصنوعة من الستانلس ستيل عالي الجودة',
                'price' => 149.99,
                'sale_price' => 119.99,
                'category_id' => 7,
                'brand_id' => 7,
                'quantity' => 15,
                'sku' => 'KS-002',
                'is_active' => true,
                'is_featured' => true,
            ],
            
            // Sports & Fitness
            [
                'name' => 'مجموعة أوزان منزلية',
                'description' => 'مجموعة أوزان متدرجة للتمارين المنزلية، مع حامل منظم وتصميم مدمج',
                'price' => 299.99,
                'sale_price' => 229.99,
                'category_id' => 8,
                'brand_id' => 8,
                'quantity' => 10,
                'sku' => 'WS-002',
                'is_active' => true,
            ],
            [
                'name' => 'حصيرة يوغا مضادة للانزلاق',
                'description' => 'حصيرة يوغا عالية الجودة بسطح مضاد للانزلاق، مثالية لتمارين اليوغا واللياقة',
                'price' => 59.99,
                'sale_price' => 45.99,
                'category_id' => 8,
                'brand_id' => 1,
                'quantity' => 30,
                'sku' => 'YM-001',
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $productData) {
            $productData['slug'] = Str::slug($productData['name']);
            $product = Product::create($productData);

            // Add attribute values for each product
            $this->addAttributeValues($product);
            
            // Add product images
            $this->addProductImages($product);
            
            // Add product sizes for clothing items
            if (in_array($product->category_id, [1, 2, 3])) {
                $this->addProductSizes($product);
            }
        }

        // Create Discounts
        $discounts = [
            [
                'name' => 'خصم الصيف الكبير',
                'description' => 'خصم 25% على جميع الملابس الصيفية',
                'discount_type' => 'percentage',
                'discount_value' => 25,
                'starts_at' => now(),
                'ends_at' => now()->addDays(30),
                'is_active' => true,
            ],
            [
                'name' => 'خصم المنتجات الإلكترونية',
                'description' => 'خصم 50 دينار على الإلكترونيات',
                'discount_type' => 'fixed',
                'discount_value' => 50,
                'starts_at' => now(),
                'ends_at' => now()->addDays(15),
                'is_active' => true,
            ],
            [
                'name' => 'خصم نهاية الأسبوع',
                'description' => 'خصم 15% على جميع المنتجات',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'starts_at' => now(),
                'ends_at' => now()->addDays(7),
                'is_active' => true,
            ],
        ];

        foreach ($discounts as $discountData) {
            $discount = Discount::create($discountData);
            
            // Attach discounts to some products
            $products = Product::inRandomOrder()->limit(rand(3, 6))->get();
            $discount->products()->attach($products->pluck('id'));
        }
    }

    private function addAttributeValues($product)
    {
        $colorAttribute = ProductAttribute::where('name', 'اللون')->first();
        $sizeAttribute = ProductAttribute::where('name', 'المقاس')->first();
        $materialAttribute = ProductAttribute::where('name', 'نوع القماش')->first();
        
        // Colors based on product type
        $colors = ['أحمر', 'أزرق', 'أخضر', 'أسود', 'أبيض', 'رمادي', 'بني', 'وردي', 'أصفر', 'بنفسجي'];
        $selectedColors = array_slice($colors, 0, rand(2, 4));
        
        foreach ($selectedColors as $color) {
            AttributeValue::create([
                'product_id' => $product->id,
                'product_attribute_id' => $colorAttribute->id,
                'value' => $color,
            ]);
        }
        
        // Sizes for clothing
        if (in_array($product->category_id, [1, 2, 3])) {
            $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
            $selectedSizes = array_slice($sizes, rand(1, 2), rand(3, 5));
            
            foreach ($selectedSizes as $size) {
                AttributeValue::create([
                    'product_id' => $product->id,
                    'product_attribute_id' => $sizeAttribute->id,
                    'value' => $size,
                ]);
            }
            
            // Material for clothing
            $materials = ['قطن', 'بوليستر', 'حرير', 'كتان', 'صوف'];
            AttributeValue::create([
                'product_id' => $product->id,
                'product_attribute_id' => $materialAttribute->id,
                'value' => $materials[array_rand($materials)],
            ]);
        }
    }
    
    private function addProductImages($product)
    {
        // Add 2-4 sample images per product
        $imageCount = rand(2, 4);
        for ($i = 0; $i < $imageCount; $i++) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => "products/sample-{$product->id}-{$i}.jpg",
                'is_primary' => $i === 0,
            ]);
        }
    }
    
    private function addProductSizes($product)
    {
        $sizes = ['S', 'M', 'L', 'XL'];
        foreach ($sizes as $size) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $size,
                'stock_quantity' => rand(5, 15),
            ]);
        }
    }
}
