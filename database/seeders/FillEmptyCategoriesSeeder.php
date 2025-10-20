<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;

class FillEmptyCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔍 فحص التصنيفات الفارغة...');
        
        // Get all subcategories (those with parent_id)
        $subcategories = Category::whereNotNull('parent_id')->withCount('products')->get();
        $brands = Brand::all();
        $products = collect();
        
        $this->command->info("📊 تم العثور على {$subcategories->count()} تصنيف فرعي");
        
        // Products data for each subcategory
        $categoryProducts = $this->getCategoryProducts();
        
        foreach ($subcategories as $subcategory) {
            $this->command->info("🔧 فحص تصنيف: {$subcategory->name} (المنتجات الحالية: {$subcategory->products_count})");
            
            // If category has less than 2 products, add more
            if ($subcategory->products_count < 2) {
                $productsToAdd = 3 - $subcategory->products_count; // Add products to reach 3 per category
                
                if (isset($categoryProducts[$subcategory->name])) {
                    $productData = $categoryProducts[$subcategory->name];
                    
                    for ($i = 0; $i < min($productsToAdd, count($productData)); $i++) {
                        $product = $this->createProduct($subcategory, $productData[$i], $brands->random());
                        $products->push($product);
                        $this->createProductImages($product);
                        
                        // Add sizes for shoes and some toys
                        if ($this->needsSizes($subcategory)) {
                            $this->createProductSizes($product, $subcategory);
                        }
                    }
                    
                    $this->command->info("✅ تم إضافة {$productsToAdd} منتجات لتصنيف: {$subcategory->name}");
                }
            }
        }
        
        $this->command->info("🎉 تم الانتهاء! إجمالي المنتجات المضافة: {$products->count()}");
    }
    
    private function getCategoryProducts()
    {
        return [
            // ألعاب تعليمية
            'ألعاب تعليمية' => [
                [
                    'name' => 'لوحة تعليم الحروف العربية المغناطيسية',
                    'price' => 45.00,
                    'description' => 'لوحة تعليمية تفاعلية لتعلم الحروف العربية والكلمات الأولى بطريقة ممتعة',
                ],
                [
                    'name' => 'مكعبات الأرقام والعمليات الحسابية',
                    'price' => 38.00,
                    'description' => 'مكعبات ملونة لتعليم الأرقام والجمع والطرح للأطفال',
                ],
                [
                    'name' => 'لعبة الذاكرة والألوان التفاعلية',
                    'price' => 52.00,
                    'description' => 'لعبة إلكترونية لتنمية الذاكرة والتركيز عند الأطفال',
                ],
            ],
            
            // ألعاب إلكترونية
            'ألعاب إلكترونية' => [
                [
                    'name' => 'جهاز تابلت الأطفال التعليمي',
                    'price' => 95.00,
                    'description' => 'تابلت خاص بالأطفال مع ألعاب تعليمية وقصص تفاعلية',
                ],
                [
                    'name' => 'روبوت ذكي قابل للبرمجة',
                    'price' => 125.00,
                    'description' => 'روبوت تعليمي يمكن برمجته لأداء حركات ومهام مختلفة',
                ],
                [
                    'name' => 'كاميرا أطفال رقمية',
                    'price' => 75.00,
                    'description' => 'كاميرا مصممة خصيصاً للأطفال مع ألعاب وفلاتر ممتعة',
                ],
            ],
            
            // ألعاب البناء
            'ألعاب البناء' => [
                [
                    'name' => 'مجموعة ليجو المدينة الكبيرة',
                    'price' => 120.00,
                    'description' => 'مجموعة كبيرة من قطع ليجو لبناء مدينة كاملة بالتفاصيل',
                ],
                [
                    'name' => 'مكعبات البناء المغناطيسية',
                    'price' => 68.00,
                    'description' => 'مكعبات مغناطيسية آمنة لبناء أشكال ثلاثية الأبعاد',
                ],
                [
                    'name' => 'مجموعة بناء القلعة الخشبية',
                    'price' => 85.00,
                    'description' => 'قطع خشبية طبيعية لبناء قلعة جميلة ومفصلة',
                ],
            ],
            
            // دمى وعرائس
            'دمى وعرائس' => [
                [
                    'name' => 'دمية أميرة ديزني الناطقة',
                    'price' => 65.00,
                    'description' => 'دمية أميرة جميلة تتحدث وتغني أغاني ديزني المحبوبة',
                ],
                [
                    'name' => 'بيت العرائس المصغر مع أثاث',
                    'price' => 95.00,
                    'description' => 'بيت عرائس كامل مع غرف مؤثثة وإكسسوارات متنوعة',
                ],
                [
                    'name' => 'دمية الطفلة التفاعلية',
                    'price' => 78.00,
                    'description' => 'دمية تتفاعل مع الطفل وتحتاج للعناية والاهتمام',
                ],
            ],
            
            // ألعاب خارجية
            'ألعاب خارجية' => [
                [
                    'name' => 'دراجة أطفال ثلاثية العجلات',
                    'price' => 145.00,
                    'description' => 'دراجة آمنة ومريحة للأطفال مع مقبض للوالدين',
                ],
                [
                    'name' => 'مجموعة كرات رياضية متنوعة',
                    'price' => 55.00,
                    'description' => 'مجموعة من الكرات الرياضية المختلفة للعب في الخارج',
                ],
                [
                    'name' => 'نطاطة هوائية صغيرة للأطفال',
                    'price' => 125.00,
                    'description' => 'نطاطة آمنة ومسلية للاستخدام في الحديقة أو المنزل',
                ],
            ],
            
            // ألعاب الطاولة
            'ألعاب الطاولة' => [
                [
                    'name' => 'لعبة مونوبولي النسخة العربية',
                    'price' => 48.00,
                    'description' => 'لعبة مونوبولي الكلاسيكية بأسماء عربية ومحلية',
                ],
                [
                    'name' => 'مجموعة ألعاب الورق التعليمية',
                    'price' => 25.00,
                    'description' => 'ألعاب ورق متنوعة لتعليم الأطفال والتسلية',
                ],
                [
                    'name' => 'لعبة الشطرنج للمبتدئين',
                    'price' => 42.00,
                    'description' => 'شطرنج تعليمي مع دليل للتعلم والممارسة',
                ],
            ],
            
            // أحذية رياضية
            'أحذية رياضية' => [
                [
                    'name' => 'حذاء رياضي للجري - أزرق',
                    'price' => 85.00,
                    'description' => 'حذاء رياضي خفيف ومريح مناسب للجري والأنشطة الرياضية',
                ],
                [
                    'name' => 'حذاء كرة القدم للأطفال',
                    'price' => 92.00,
                    'description' => 'حذاء كرة قدم مع مسامير مطاطية آمنة للأطفال',
                ],
                [
                    'name' => 'حذاء رياضي متعدد الألوان',
                    'price' => 78.00,
                    'description' => 'حذاء رياضي بألوان زاهية وتصميم عصري للأطفال',
                ],
            ],
            
            // أحذية مدرسية
            'أحذية مدرسية' => [
                [
                    'name' => 'حذاء مدرسي جلدي أسود كلاسيكي',
                    'price' => 68.00,
                    'description' => 'حذاء رسمي أسود من الجلد الطبيعي مناسب للمدرسة',
                ],
                [
                    'name' => 'حذاء مدرسي بنات أبيض',
                    'price' => 62.00,
                    'description' => 'حذاء أبيض أنيق ومريح للبنات في المدرسة',
                ],
                [
                    'name' => 'حذاء مدرسي بشريط لاصق',
                    'price' => 58.00,
                    'description' => 'حذاء مدرسي عملي بشريط لاصق سهل الاستخدام',
                ],
            ],
            
            // صنادل صيفية
            'صنادل صيفية' => [
                [
                    'name' => 'صندل بحر مقاوم للماء',
                    'price' => 45.00,
                    'description' => 'صندل مطاطي مقاوم للماء مثالي للشاطئ والسباحة',
                ],
                [
                    'name' => 'صندل صيفي بزخارف ملونة',
                    'price' => 38.00,
                    'description' => 'صندل مفتوح بتصاميم مرحة وألوان زاهية للصيف',
                ],
                [
                    'name' => 'صندل رياضي للأنشطة الخارجية',
                    'price' => 52.00,
                    'description' => 'صندل قوي ومريح للأنشطة الخارجية والمغامرات',
                ],
            ],
            
            // أحذية شتوية
            'أحذية شتوية' => [
                [
                    'name' => 'بوت شتوي مبطن بالفراء',
                    'price' => 95.00,
                    'description' => 'حذاء شتوي دافئ مبطن بالفراء الطبيعي',
                ],
                [
                    'name' => 'حذاء مطر ملون للأطفال',
                    'price' => 42.00,
                    'description' => 'حذاء مطاطي مقاوم للماء بألوان مرحة',
                ],
                [
                    'name' => 'بوت جلدي للطقس البارد',
                    'price' => 88.00,
                    'description' => 'بوت من الجلد الطبيعي مناسب للطقس البارد والرطب',
                ],
            ],
            
            // أحذية منزلية
            'أحذية منزلية' => [
                [
                    'name' => 'شبشب منزلي بشخصيات كرتونية',
                    'price' => 28.00,
                    'description' => 'شبشب مريح ودافئ مع شخصيات كرتونية محبوبة',
                ],
                [
                    'name' => 'حذاء منزلي مبطن ناعم',
                    'price' => 35.00,
                    'description' => 'حذاء منزلي مبطن بمادة ناعمة ومريحة للقدم',
                ],
                [
                    'name' => 'شبشب قطني طبيعي للأطفال',
                    'price' => 24.00,
                    'description' => 'شبشب من القطن الطبيعي صحي ومريح للاستخدام المنزلي',
                ],
            ],
            
            // أحذية المناسبات
            'أحذية المناسبات' => [
                [
                    'name' => 'حذاء أنيق للمناسبات الخاصة',
                    'price' => 75.00,
                    'description' => 'حذاء رسمي أنيق مناسب للحفلات والمناسبات المهمة',
                ],
                [
                    'name' => 'حذاء بنات لامع للحفلات',
                    'price' => 68.00,
                    'description' => 'حذاء لامع وجميل للبنات مناسب للحفلات والمناسبات',
                ],
                [
                    'name' => 'حذاء كلاسيكي للمناسبات الرسمية',
                    'price' => 82.00,
                    'description' => 'حذاء كلاسيكي أنيق للمناسبات الرسمية والخاصة',
                ],
            ],
            
            // حقائب مدرسية
            'حقائب مدرسية' => [
                [
                    'name' => 'حقيبة مدرسية بعجلات ديزني',
                    'price' => 78.00,
                    'description' => 'حقيبة مدرسية عملية بعجلات مع شخصيات ديزني المحبوبة',
                ],
                [
                    'name' => 'حقيبة ظهر مدرسية مقاومة للماء',
                    'price' => 65.00,
                    'description' => 'حقيبة ظهر قوية ومقاومة للماء مع جيوب متعددة',
                ],
                [
                    'name' => 'حقيبة مدرسية بتصميم رياضي',
                    'price' => 58.00,
                    'description' => 'حقيبة مدرسية أنيقة بتصميم رياضي عصري',
                ],
            ],
            
            // زجاجات مياه
            'زجاجات مياه' => [
                [
                    'name' => 'زجاجة مياه حرارية للأطفال',
                    'price' => 32.00,
                    'description' => 'زجاجة حرارية تحافظ على برودة الماء لساعات طويلة',
                ],
                [
                    'name' => 'زجاجة مياه بلاستيكية آمنة',
                    'price' => 18.00,
                    'description' => 'زجاجة من البلاستيك الآمن خالي من المواد الضارة',
                ],
                [
                    'name' => 'زجاجة مياه مع قشة مدمجة',
                    'price' => 24.00,
                    'description' => 'زجاجة عملية مع قشة مدمجة سهلة الاستخدام للأطفال',
                ],
            ],
            
            // أدوات الطعام
            'أدوات الطعام' => [
                [
                    'name' => 'طقم أطباق الأطفال المضاد للكسر',
                    'price' => 42.00,
                    'description' => 'طقم كامل من الأطباق والأكواب المضادة للكسر',
                ],
                [
                    'name' => 'أدوات طعام آمنة للأطفال',
                    'price' => 28.00,
                    'description' => 'ملعقة وشوكة وسكين آمنة مصممة خصيصاً للأطفال',
                ],
                [
                    'name' => 'طبق طعام بأقسام ملونة',
                    'price' => 22.00,
                    'description' => 'طبق مقسم إلى أجزاء ملونة لتنظيم الطعام',
                ],
            ],
            
            // إكسسوارات الشعر
            'إكسسوارات الشعر' => [
                [
                    'name' => 'مجموعة ربطات شعر مع إكسسوارات',
                    'price' => 35.00,
                    'description' => 'مجموعة كاملة من ربطات الشعر والدبابيس والعقد',
                ],
                [
                    'name' => 'عقدة شعر بشخصيات محبوبة',
                    'price' => 18.00,
                    'description' => 'عقد شعر جميلة بأشكال وشخصيات كرتونية',
                ],
                [
                    'name' => 'تاج أميرة للبنات',
                    'price' => 45.00,
                    'description' => 'تاج جميل ولامع يجعل الطفلة تشعر وكأنها أميرة',
                ],
            ],
            
            // مستلزمات النوم
            'مستلزمات النوم' => [
                [
                    'name' => 'وسادة أطفال بشكل حيوان',
                    'price' => 38.00,
                    'description' => 'وسادة ناعمة ومريحة على شكل حيوان محبوب',
                ],
                [
                    'name' => 'غطاء سرير أطفال ملون',
                    'price' => 55.00,
                    'description' => 'غطاء سرير ناعم بألوان زاهية ورسومات جميلة',
                ],
                [
                    'name' => 'لحاف أطفال قطني',
                    'price' => 48.00,
                    'description' => 'لحاف من القطن الطبيعي دافئ ومريح للأطفال',
                ],
            ],
            
            // مستلزمات الاستحمام
            'مستلزمات الاستحمام' => [
                [
                    'name' => 'مجموعة لعب الحمام المطاطية',
                    'price' => 32.00,
                    'description' => 'مجموعة ألعاب مطاطية آمنة ومسلية لوقت الاستحمام',
                ],
                [
                    'name' => 'منشفة أطفال بقبعة',
                    'price' => 28.00,
                    'description' => 'منشفة ناعمة مع قبعة لتجفيف الطفل بطريقة مرحة',
                ],
                [
                    'name' => 'شامبو أطفال لطيف وآمن',
                    'price' => 24.00,
                    'description' => 'شامبو خاص بالأطفال خالي من المواد الكيماوية الضارة',
                ],
            ],
        ];
    }
    
    private function createProduct($category, $productData, $brand)
    {
        // Make slug unique by adding timestamp and random number
        $baseSlug = Str::slug($productData['name']);
        $uniqueSlug = $baseSlug . '-' . time() . '-' . rand(1000, 9999);
        
        return Product::create([
            'name' => $productData['name'],
            'slug' => $uniqueSlug,
            'description' => $productData['description'],
            'price' => $productData['price'],
            'original_price' => $productData['price'] * 1.15, // Original price 15% higher
            'sku' => 'MO-' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
            'quantity' => rand(25, 150),
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'is_active' => true,
            'status' => 'in_stock',
            'meta_title' => $productData['name'],
            'meta_description' => Str::limit($productData['description'], 155),
            'is_sized' => $this->needsSizes($category),
            'is_deleted' => false,
        ]);
    }
    
    private function createProductImages($product)
    {
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
        
        $numImages = rand(2, 3); // 2-3 images per product
        
        for ($i = 1; $i <= $numImages; $i++) {
            \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $sampleImages[array_rand($sampleImages)],
                'is_primary' => $i === 1,
                'is_deleted' => false,
            ]);
        }
    }
    
    private function createProductSizes($product, $category)
    {
        $sizes = [];
        
        // Check if it's a shoes category
        if (in_array($category->name, ['أحذية رياضية', 'أحذية مدرسية', 'صنادل صيفية', 'أحذية شتوية', 'أحذية منزلية', 'أحذية المناسبات'])) {
            // Shoe sizes
            $sizes = [
                ['size' => '28', 'size_type' => 'أحذية أطفال', 'stock' => rand(5, 15)],
                ['size' => '30', 'size_type' => 'أحذية أطفال', 'stock' => rand(8, 20)],
                ['size' => '32', 'size_type' => 'أحذية أطفال', 'stock' => rand(6, 18)],
                ['size' => '34', 'size_type' => 'أحذية أطفال', 'stock' => rand(4, 12)],
                ['size' => '36', 'size_type' => 'أحذية أطفال', 'stock' => rand(5, 15)],
            ];
        } else {
            // General sizes for other products
            $sizes = [
                ['size' => 'صغير', 'size_type' => 'عام', 'stock' => rand(10, 25)],
                ['size' => 'متوسط', 'size_type' => 'عام', 'stock' => rand(15, 30)],
                ['size' => 'كبير', 'size_type' => 'عام', 'stock' => rand(8, 20)],
            ];
        }
        
        foreach ($sizes as $sizeData) {
            \App\Models\ProductSize::create([
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
        }
    }
    
    private function needsSizes($category)
    {
        // Categories that need sizes
        $sizedCategories = [
            'أحذية رياضية', 'أحذية مدرسية', 'صنادل صيفية', 
            'أحذية شتوية', 'أحذية منزلية', 'أحذية المناسبات',
            'حقائب مدرسية', 'ألعاب خارجية'
        ];
        
        return in_array($category->name, $sizedCategories);
    }
}
