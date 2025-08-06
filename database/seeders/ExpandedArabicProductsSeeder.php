<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ExpandedArabicProductsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedMoreProducts();
        $this->seedProductImages();
        $this->seedFavorites();
        $this->seedProductAttributes();
        $this->seedAttributeValues();
    }

    private function seedMoreProducts(): void
    {
        $products = [
            // المزيد من الملابس الرجالية
            [
                'name' => 'قميص كتان بيج صيفي',
                'slug' => 'beige-linen-summer-shirt',
                'description' => 'قميص كتان بيج خفيف ومريح، مثالي للأجواء الصيفية الحارة.',
                'price' => 95.00,
                'original_price' => 120.00,
                'sku' => 'SHIRT-002',
                'quantity' => 40,
                'category_id' => 6,
                'brand_id' => 3,
            ],
            [
                'name' => 'تي شيرت رياضي أسود',
                'slug' => 'black-athletic-tshirt',
                'description' => 'تي شيرت رياضي أسود من قماش يمتص العرق، مناسب للتمارين الرياضية.',
                'price' => 75.00,
                'original_price' => 95.00,
                'sku' => 'TSHIRT-001',
                'quantity' => 60,
                'category_id' => 6,
                'brand_id' => 1,
            ],
            [
                'name' => 'بنطلون كحلي رسمي',
                'slug' => 'navy-formal-pants',
                'description' => 'بنطلون كحلي رسمي أنيق، مناسب للعمل والمناسبات الرسمية.',
                'price' => 150.00,
                'original_price' => 180.00,
                'sku' => 'PANTS-001',
                'quantity' => 35,
                'category_id' => 7,
                'brand_id' => 3,
            ],
            [
                'name' => 'بلوفر صوف رمادي',
                'slug' => 'gray-wool-sweater',
                'description' => 'بلوفر صوف رمادي دافئ وأنيق، مثالي للطقس البارد.',
                'price' => 200.00,
                'original_price' => 250.00,
                'sku' => 'SWEATER-001',
                'quantity' => 30,
                'category_id' => 6,
                'brand_id' => 4,
            ],
            
            // المزيد من الملابس النسائية
            [
                'name' => 'عباءة سوداء مطرزة',
                'slug' => 'black-embroidered-abaya',
                'description' => 'عباءة سوداء أنيقة مطرزة بخيوط ذهبية، مناسبة للمناسبات الخاصة.',
                'price' => 320.00,
                'original_price' => 400.00,
                'sku' => 'ABAYA-001',
                'quantity' => 25,
                'category_id' => 9,
                'brand_id' => 9,
            ],
            [
                'name' => 'كارديجان وردي ناعم',
                'slug' => 'soft-pink-cardigan',
                'description' => 'كارديجان وردي ناعم ومريح، مثالي للطقس المعتدل.',
                'price' => 140.00,
                'original_price' => 170.00,
                'sku' => 'CARDIGAN-001',
                'quantity' => 45,
                'category_id' => 10,
                'brand_id' => 4,
            ],
            [
                'name' => 'فستان زفاف أبيض',
                'slug' => 'white-wedding-dress',
                'description' => 'فستان زفاف أبيض فاخر بتطريز رائع، مناسب لأهم يوم في حياتك.',
                'price' => 1200.00,
                'original_price' => 1500.00,
                'sku' => 'WEDDING-001',
                'quantity' => 8,
                'category_id' => 9,
                'brand_id' => 6,
            ],
            [
                'name' => 'بنطلون جينز نسائي',
                'slug' => 'womens-jeans',
                'description' => 'بنطلون جينز نسائي عالي الجودة، مريح وعصري.',
                'price' => 165.00,
                'original_price' => 200.00,
                'sku' => 'WJEANS-001',
                'quantity' => 50,
                'category_id' => 10,
                'brand_id' => 3,
            ],
            [
                'name' => 'تنورة طويلة منقوشة',
                'slug' => 'long-patterned-skirt',
                'description' => 'تنورة طويلة بنقوش جميلة، مناسبة للإطلالات المحتشمة والأنيقة.',
                'price' => 110.00,
                'original_price' => 140.00,
                'sku' => 'LSKIRT-001',
                'quantity' => 35,
                'category_id' => 11,
                'brand_id' => 10,
            ],
            
            // المزيد من الأحذية
            [
                'name' => 'بوط جلدي بني',
                'slug' => 'brown-leather-boots',
                'description' => 'بوط جلدي بني عالي الجودة، مناسب للشتاء والإطلالات الكاجوال.',
                'price' => 280.00,
                'original_price' => 350.00,
                'sku' => 'BOOT-001',
                'quantity' => 20,
                'category_id' => 12,
                'brand_id' => 5,
            ],
            [
                'name' => 'حذاء رسمي أسود',
                'slug' => 'black-formal-shoes',
                'description' => 'حذاء رسمي أسود كلاسيكي، مناسب للعمل والمناسبات الرسمية.',
                'price' => 250.00,
                'original_price' => 300.00,
                'sku' => 'FORMAL-001',
                'quantity' => 30,
                'category_id' => 12,
                'brand_id' => 7,
            ],
            [
                'name' => 'صندل نسائي مريح',
                'slug' => 'comfortable-womens-sandals',
                'description' => 'صندل نسائي مريح للاستخدام اليومي، بتصميم عصري وأنيق.',
                'price' => 120.00,
                'original_price' => 150.00,
                'sku' => 'WSANDAL-001',
                'quantity' => 40,
                'category_id' => 13,
                'brand_id' => 4,
            ],
            [
                'name' => 'حذاء رياضي نسائي وردي',
                'slug' => 'pink-womens-sneakers',
                'description' => 'حذاء رياضي نسائي وردي مريح، مناسب للتمارين والمشي.',
                'price' => 180.00,
                'original_price' => 220.00,
                'sku' => 'WSNEAKER-001',
                'quantity' => 35,
                'category_id' => 13,
                'brand_id' => 2,
            ],
            
            // إكسسوارات
            [
                'name' => 'ساعة يد ذهبية',
                'slug' => 'gold-wrist-watch',
                'description' => 'ساعة يد ذهبية فاخرة، مناسبة للرجال والنساء.',
                'price' => 450.00,
                'original_price' => 550.00,
                'sku' => 'WATCH-001',
                'quantity' => 15,
                'category_id' => 4,
                'brand_id' => 7,
            ],
            [
                'name' => 'حزام جلدي بني',
                'slug' => 'brown-leather-belt',
                'description' => 'حزام جلدي بني كلاسيكي، مناسب للاستخدام اليومي والرسمي.',
                'price' => 85.00,
                'original_price' => 110.00,
                'sku' => 'BELT-001',
                'quantity' => 50,
                'category_id' => 4,
                'brand_id' => 3,
            ],
            [
                'name' => 'نظارة شمسية سوداء',
                'slug' => 'black-sunglasses',
                'description' => 'نظارة شمسية سوداء عصرية، تحمي من أشعة الشمس الضارة.',
                'price' => 120.00,
                'original_price' => 150.00,
                'sku' => 'SUNGLASS-001',
                'quantity' => 40,
                'category_id' => 4,
                'brand_id' => 7,
            ],
            
            // حقائب
            [
                'name' => 'حقيبة يد نسائية جلدية',
                'slug' => 'womens-leather-handbag',
                'description' => 'حقيبة يد نسائية جلدية أنيقة، مناسبة للاستخدام اليومي.',
                'price' => 200.00,
                'original_price' => 250.00,
                'sku' => 'HANDBAG-001',
                'quantity' => 25,
                'category_id' => 5,
                'brand_id' => 8,
            ],
            [
                'name' => 'حقيبة ظهر رياضية',
                'slug' => 'sports-backpack',
                'description' => 'حقيبة ظهر رياضية متينة، مناسبة للرياضة والسفر.',
                'price' => 150.00,
                'original_price' => 180.00,
                'sku' => 'BACKPACK-001',
                'quantity' => 30,
                'category_id' => 5,
                'brand_id' => 1,
            ],
            [
                'name' => 'حقيبة سفر كبيرة',
                'slug' => 'large-travel-bag',
                'description' => 'حقيبة سفر كبيرة ومتينة، مثالية للرحلات الطويلة.',
                'price' => 280.00,
                'original_price' => 350.00,
                'sku' => 'TRAVEL-001',
                'quantity' => 20,
                'category_id' => 5,
                'brand_id' => 5,
            ],
        ];

        $productId = 9; // البدء من المنتج رقم 9
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
                'status' => 'in_stock',
                'meta_title' => $product['name'] . ' - ملاك أوتلت',
                'meta_description' => 'اشتري ' . $product['name'] . ' من ملاك أوتلت بأفضل الأسعار',
                'is_sized' => in_array($product['category_id'], [6, 7, 8, 9, 10, 11, 12, 13]), // الملابس والأحذية لها أحجام
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $productId++;
        }
    }

    private function seedProductImages(): void
    {
        // إضافة صور للمنتجات
        $productImages = [];
        
        // Get the actual number of products from the database
        $productCount = DB::table('products')->count();
        
        for ($productId = 1; $productId <= $productCount; $productId++) {
            // صورة رئيسية
            $productImages[] = [
                'product_id' => $productId,
                'image_path' => "products/product_{$productId}_main.jpg",
                'is_primary' => true,
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            
            // صور إضافية
            for ($i = 2; $i <= 4; $i++) {
                $productImages[] = [
                    'product_id' => $productId,
                    'image_path' => "products/product_{$productId}_image_{$i}.jpg",
                    'is_primary' => false,
                    'is_deleted' => false,
                    'edit_by' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        foreach ($productImages as $image) {
            DB::table('product_images')->insert($image);
        }
    }

    private function seedFavorites(): void
    {
        // إضافة منتجات مفضلة للمستخدمين
        // Only reference products that actually exist
        $productCount = DB::table('products')->count();
        $userCount = DB::table('users')->count();
        
        $favorites = [
            ['user_id' => 1, 'product_id' => 1],
            ['user_id' => 1, 'product_id' => 3],
            ['user_id' => 1, 'product_id' => min(7, $productCount)],
            ['user_id' => 2, 'product_id' => 4],
            ['user_id' => 2, 'product_id' => 5],
            ['user_id' => 2, 'product_id' => min(8, $productCount)],
            ['user_id' => 3, 'product_id' => 2],
            ['user_id' => 3, 'product_id' => 6],
            ['user_id' => 4, 'product_id' => 4],
            ['user_id' => min(5, $userCount), 'product_id' => min(9, $productCount)],
        ];

        foreach ($favorites as $favorite) {
            // Only insert if both user and product exist
            if ($favorite['user_id'] <= $userCount && $favorite['product_id'] <= $productCount) {
                DB::table('favorites')->insert([
                    'user_id' => $favorite['user_id'],
                    'product_id' => $favorite['product_id'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }

    private function seedProductAttributes(): void
    {
        // First, create the attribute types
        $attributeTypes = [
            [
                'name' => 'نوع القماش',
                'input_type' => 'select',
            ],
            [
                'name' => 'طريقة الغسيل',
                'input_type' => 'text',
            ],
            [
                'name' => 'المرونة',
                'input_type' => 'text',
            ],
            [
                'name' => 'المادة',
                'input_type' => 'text',
            ],
            [
                'name' => 'العزل الحراري',
                'input_type' => 'text',
            ],
            [
                'name' => 'المناسبة',
                'input_type' => 'text',
            ],
            [
                'name' => 'نوع النعل',
                'input_type' => 'text',
            ],
            [
                'name' => 'التهوية',
                'input_type' => 'text',
            ],
            [
                'name' => 'ارتفاع الكعب',
                'input_type' => 'text',
            ],
        ];

        foreach ($attributeTypes as $attributeType) {
            DB::table('product_attributes')->insert([
                'name' => $attributeType['name'],
                'input_type' => $attributeType['input_type'],
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function seedAttributeValues(): void
    {
        // Get the attribute IDs first
        $attributes = DB::table('product_attributes')->get();
        
        $attributeMap = [];
        foreach ($attributes as $attribute) {
            $attributeMap[$attribute->name] = $attribute->id;
        }

        $attributeValues = [
            // نوع القماش values
            [
                'product_attribute_id' => $attributeMap['نوع القماش'] ?? 1,
                'value' => 'قطن 100%',
            ],
            [
                'product_attribute_id' => $attributeMap['نوع القماش'] ?? 1,
                'value' => 'جينز قطني',
            ],
            [
                'product_attribute_id' => $attributeMap['نوع القماش'] ?? 1,
                'value' => 'حرير طبيعي',
            ],
            [
                'product_attribute_id' => $attributeMap['طريقة الغسيل'] ?? 2,
                'value' => 'غسيل في الغسالة على حرارة 30 درجة',
            ],
            [
                'product_attribute_id' => $attributeMap['المرونة'] ?? 3,
                'value' => 'قماش مرن',
            ],
            [
                'product_attribute_id' => $attributeMap['المادة'] ?? 4,
                'value' => 'بوليستر مقاوم للماء',
            ],
            [
                'product_attribute_id' => $attributeMap['المادة'] ?? 4,
                'value' => 'جلد طبيعي',
            ],
            [
                'product_attribute_id' => $attributeMap['العزل الحراري'] ?? 5,
                'value' => 'حشو صناعي دافئ',
            ],
            [
                'product_attribute_id' => $attributeMap['المناسبة'] ?? 6,
                'value' => 'السهرات والحفلات',
            ],
            [
                'product_attribute_id' => $attributeMap['نوع النعل'] ?? 7,
                'value' => 'مطاط متين',
            ],
            [
                'product_attribute_id' => $attributeMap['التهوية'] ?? 8,
                'value' => 'قماش قابل للتنفس',
            ],
            [
                'product_attribute_id' => $attributeMap['ارتفاع الكعب'] ?? 9,
                'value' => '8 سم',
            ],
        ];

        foreach ($attributeValues as $value) {
            DB::table('attribute_values')->insert([
                'product_attribute_id' => $value['product_attribute_id'],
                'value' => $value['value'],
                'is_deleted' => false,
                'edit_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
