<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Support\Str;

class ToysSeeder extends Seeder
{
    public function run()
    {
        // Create toy-specific categories
        $toyCategories = [
            [
                'name' => 'ألعاب تعليمية',
                'slug' => 'educational-toys',
                'description' => 'ألعاب تساعد في تنمية مهارات الأطفال التعليمية والذهنية',
                'image' => 'educational-toys.jpg'
            ],
            [
                'name' => 'ألعاب البناء',
                'slug' => 'building-toys',
                'description' => 'مكعبات البناء وألعاب التركيب لتنمية الإبداع',
                'image' => 'building-toys.jpg'
            ],
            [
                'name' => 'الدمى والعرائس',
                'slug' => 'dolls-figurines',
                'description' => 'مجموعة متنوعة من الدمى والعرائس الجميلة',
                'image' => 'dolls.jpg'
            ],
            [
                'name' => 'السيارات والمركبات',
                'slug' => 'cars-vehicles',
                'description' => 'سيارات لعبة ومركبات متنوعة للأطفال',
                'image' => 'toy-cars.jpg'
            ],
            [
                'name' => 'ألعاب رياضية',
                'slug' => 'sports-toys',
                'description' => 'ألعاب رياضية لتنمية النشاط البدني',
                'image' => 'sports-toys.jpg'
            ],
            [
                'name' => 'ألعاب إلكترونية',
                'slug' => 'electronic-toys',
                'description' => 'ألعاب تفاعلية وإلكترونية حديثة',
                'image' => 'electronic-toys.jpg'
            ]
        ];

        foreach ($toyCategories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'image' => $categoryData['image'],
                    'is_active' => true,
                    'parent_id' => null,
                    'is_deleted' => false,
                    'edit_by' => 1
                ]
            );
        }

        // Create toy brands
        $toyBrands = [
            [
                'name' => 'LEGO',
                'slug' => 'lego',
                'image' => 'lego-logo.png'
            ],
            [
                'name' => 'Mattel',
                'slug' => 'mattel',
                'image' => 'mattel-logo.png'
            ],
            [
                'name' => 'Fisher-Price',
                'slug' => 'fisher-price',
                'image' => 'fisher-price-logo.png'
            ],
            [
                'name' => 'Hasbro',
                'slug' => 'hasbro',
                'image' => 'hasbro-logo.png'
            ],
            [
                'name' => 'Hot Wheels',
                'slug' => 'hot-wheels',
                'image' => 'hot-wheels-logo.png'
            ],
            [
                'name' => 'Barbie',
                'slug' => 'barbie',
                'image' => 'barbie-logo.png'
            ]
        ];

        foreach ($toyBrands as $brandData) {
            Brand::firstOrCreate(
                ['slug' => $brandData['slug']],
                [
                    'name' => $brandData['name'],
                    'image' => $brandData['image'],
                    'is_active' => true,
                    'is_deleted' => false,
                    'edit_by' => 1
                ]
            );
        }

        // Create toy products
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
                'meta_title' => 'لعبة الأرقام التعليمية - Fisher Price',
                'meta_description' => 'لعبة تعليمية ممتعة لتعلم الأرقام للأطفال'
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
                'meta_title' => 'بازل الحروف العربية الخشبي',
                'meta_description' => 'بازل تعليمي للحروف العربية مصنوع من الخشب الطبيعي'
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
                'meta_title' => 'مجموعة لیجو المدينة الكبيرة - 1200 قطعة',
                'meta_description' => 'مجموعة لیجو شاملة لبناء مدينة كاملة'
            ],
            [
                'name' => 'مكعبات البناء الملونة',
                'slug' => 'colorful-building-blocks',
                'description' => 'مجموعة من 200 مكعب ملون لتنمية الخيال والإبداع لدى الأطفال. آمنة ومصنوعة من البلاستيك عالي الجودة.',
                'price' => 75.00,
                'original_price' => 95.00,
                'sku' => 'BUILD-COL-003',
                'quantity' => 40,
                'category' => 'building-toys',
                'brand' => 'lego',
                'meta_title' => 'مكعبات البناء الملونة - 200 قطعة',
                'meta_description' => 'مكعبات بناء ملونة آمنة للأطفال'
            ],

            // Dolls & Figurines
            [
                'name' => 'دمية باربي الأميرة',
                'slug' => 'barbie-princess-doll',
                'description' => 'دمية باربي جميلة بفستان أميرة فاخر مع الإكسسوارات. مثالية للعب التخيلي.',
                'price' => 125.00,
                'original_price' => 150.00,
                'sku' => 'BARBIE-PRIN-004',
                'quantity' => 25,
                'category' => 'dolls-figurines',
                'brand' => 'barbie',
                'meta_title' => 'دمية باربي الأميرة مع الإكسسوارات',
                'meta_description' => 'دمية باربي أميرة بفستان فاخر وإكسسوارات'
            ],
            [
                'name' => 'مجموعة شخصيات الأكشن',
                'slug' => 'action-figures-set',
                'description' => 'مجموعة من 5 شخصيات أكشن متحركة مستوحاة من الأفلام الشهيرة. قابلة للتحريك بالكامل.',
                'price' => 89.99,
                'original_price' => 110.00,
                'sku' => 'ACTION-SET-005',
                'quantity' => 20,
                'category' => 'dolls-figurines',
                'brand' => 'hasbro',
                'meta_title' => 'مجموعة شخصيات الأكشن المتحركة',
                'meta_description' => 'شخصيات أكشن متحركة مستوحاة من الأفلام'
            ],

            // Cars & Vehicles
            [
                'name' => 'مجموعة سيارات هوت ويلز',
                'slug' => 'hot-wheels-car-set',
                'description' => 'مجموعة من 20 سيارة هوت ويلز متنوعة مع مضمار سباق. تشمل سيارات رياضية وسيارات سباق.',
                'price' => 145.00,
                'original_price' => 180.00,
                'sku' => 'HW-CAR-SET-006',
                'quantity' => 35,
                'category' => 'cars-vehicles',
                'brand' => 'hot-wheels',
                'meta_title' => 'مجموعة سيارات هوت ويلز مع مضمار',
                'meta_description' => '20 سيارة هوت ويلز مع مضمار سباق'
            ],
            [
                'name' => 'شاحنة الإطفاء الكبيرة',
                'slug' => 'big-fire-truck',
                'description' => 'شاحنة إطفاء كبيرة مع سلم قابل للامتداد وأصوات حقيقية. مثالية للعب التمثيلي.',
                'price' => 199.99,
                'original_price' => 250.00,
                'sku' => 'FIRE-TRUCK-007',
                'quantity' => 12,
                'category' => 'cars-vehicles',
                'brand' => 'mattel',
                'meta_title' => 'شاحنة الإطفاء الكبيرة مع الأصوات',
                'meta_description' => 'شاحنة إطفاء تفاعلية مع سلم وأصوات'
            ],

            // Sports Toys
            [
                'name' => 'مجموعة كرة القدم للأطفال',
                'slug' => 'kids-football-set',
                'description' => 'مجموعة كاملة لكرة القدم تشمل كرة، مرمى صغير، وأقماع تدريب. مناسبة للحديقة والبيت.',
                'price' => 85.00,
                'original_price' => 110.00,
                'sku' => 'SPORT-FOOT-008',
                'quantity' => 28,
                'category' => 'sports-toys',
                'brand' => 'fisher-price',
                'meta_title' => 'مجموعة كرة القدم للأطفال الكاملة',
                'meta_description' => 'مجموعة كرة قدم مع مرمى وأقماع للأطفال'
            ],
            [
                'name' => 'طقم كرة السلة المحمول',
                'slug' => 'portable-basketball-set',
                'description' => 'طقم كرة سلة قابل للتعديل في الارتفاع مع كرة. مثالي للعب في الداخل والخارج.',
                'price' => 120.00,
                'original_price' => 155.00,
                'sku' => 'SPORT-BASKET-009',
                'quantity' => 18,
                'category' => 'sports-toys',
                'brand' => 'mattel',
                'meta_title' => 'طقم كرة السلة القابل للتعديل',
                'meta_description' => 'طقم كرة سلة محمول قابل لتعديل الارتفاع'
            ],

            // Electronic Toys
            [
                'name' => 'روبوت تعليمي ذكي',
                'slug' => 'smart-educational-robot',
                'description' => 'روبوت تفاعلي يعلم البرمجة البسيطة للأطفال. يتحرك ويتكلم ويضيء بألوان مختلفة.',
                'price' => 299.99,
                'original_price' => 399.99,
                'sku' => 'ELEC-ROBOT-010',
                'quantity' => 10,
                'category' => 'electronic-toys',
                'brand' => 'fisher-price',
                'meta_title' => 'روبوت تعليمي ذكي للبرمجة',
                'meta_description' => 'روبوت تفاعلي لتعليم البرمجة للأطفال'
            ],
            [
                'name' => 'تابلت الأطفال التعليمي',
                'slug' => 'kids-educational-tablet',
                'description' => 'تابلت مخصص للأطفال مع ألعاب تعليمية وبرامج تفاعلية. شاشة آمنة ومقاومة للكسر.',
                'price' => 189.99,
                'original_price' => 249.99,
                'sku' => 'ELEC-TABLET-011',
                'quantity' => 15,
                'category' => 'electronic-toys',
                'brand' => 'fisher-price',
                'meta_title' => 'تابلت الأطفال التعليمي التفاعلي',
                'meta_description' => 'تابلت آمن للأطفال مع برامج تعليمية'
            ],

            // Additional Toys
            [
                'name' => 'بيت الدمى المفصل',
                'slug' => 'detailed-dollhouse',
                'description' => 'بيت دمى من ثلاث طوابق مع أثاث كامل وإضاءة LED. مصنوع من الخشب عالي الجودة.',
                'price' => 349.99,
                'original_price' => 450.00,
                'sku' => 'DOLL-HOUSE-012',
                'quantity' => 8,
                'category' => 'dolls-figurines',
                'brand' => 'mattel',
                'meta_title' => 'بيت الدمى المفصل مع الإضاءة',
                'meta_description' => 'بيت دمى خشبي من ثلاث طوابق مع أثاث'
            ],
            [
                'name' => 'قطار الألعاب الكهربائي',
                'slug' => 'electric-toy-train',
                'description' => 'قطار كهربائي مع قضبان دائرية وأصوات واقعية. يشمل محطة ونفق وجسر.',
                'price' => 199.99,
                'original_price' => 259.99,
                'sku' => 'ELEC-TRAIN-013',
                'quantity' => 12,
                'category' => 'electronic-toys',
                'brand' => 'mattel',
                'meta_title' => 'قطار الألعاب الكهربائي مع القضبان',
                'meta_description' => 'قطار كهربائي بأصوات واقعية مع محطة'
            ],
            [
                'name' => 'مطبخ الأطفال التفاعلي',
                'slug' => 'interactive-kids-kitchen',
                'description' => 'مطبخ لعبة كامل مع أصوات الطبخ الحقيقية وإضاءة. يشمل جميع أدوات الطبخ والطعام.',
                'price' => 249.99,
                'original_price' => 320.00,
                'sku' => 'PLAY-KITCHEN-014',
                'quantity' => 10,
                'category' => 'electronic-toys',
                'brand' => 'fisher-price',
                'meta_title' => 'مطبخ الأطفال التفاعلي مع الأصوات',
                'meta_description' => 'مطبخ لعبة تفاعلي مع أصوات وإضاءة'
            ],
            [
                'name' => 'مجموعة ألعاب الرمل الشاطئية',
                'slug' => 'beach-sand-toys-set',
                'description' => 'مجموعة كاملة لألعاب الرمل تشمل دلاء، مجارف، وقوالب متنوعة. مثالية للشاطئ والحديقة.',
                'price' => 45.00,
                'original_price' => 60.00,
                'sku' => 'SAND-TOY-015',
                'quantity' => 45,
                'category' => 'sports-toys',
                'brand' => 'mattel',
                'meta_title' => 'مجموعة ألعاب الرمل الشاطئية الكاملة',
                'meta_description' => 'ألعاب رمل شاطئية مع دلاء ومجارف'
            ]
        ];

        foreach ($toys as $toyData) {
            $category = Category::where('slug', $toyData['category'])->first();
            $brand = Brand::where('slug', $toyData['brand'])->first();

            if (!$category || !$brand) {
                continue;
            }

            $product = Product::firstOrCreate(
                ['slug' => $toyData['slug']],
                [
                    'name' => $toyData['name'],
                    'description' => $toyData['description'],
                    'price' => $toyData['price'],
                    'original_price' => $toyData['original_price'],
                    'sku' => $toyData['sku'],
                    'quantity' => $toyData['quantity'],
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'is_active' => true,
                    'status' => 'in_stock',
                    'meta_title' => $toyData['meta_title'],
                    'meta_description' => $toyData['meta_description'],
                    'is_sized' => false,
                    'is_deleted' => false,
                    'edit_by' => 1
                ]
            );

            // Add product images
            $images = [
                $toyData['slug'] . '-1.jpg',
                $toyData['slug'] . '-2.jpg',
                $toyData['slug'] . '-3.jpg'
            ];

            foreach ($images as $index => $imageName) {
                ProductImage::firstOrCreate([
                    'product_id' => $product->id,
                    'image_path' => 'products/' . $imageName,
                    'is_primary' => $index === 0,
                    'is_deleted' => false,
                    'edit_by' => 1
                ]);
            }

            // Add some reviews for toys
            if (rand(1, 3) === 1) { // Add reviews to 1/3 of products
                $users = User::all();
                if ($users->count() > 0) {
                    for ($i = 0; $i < rand(1, 3); $i++) {
                        $user = $users->random();
                        ProductReview::firstOrCreate([
                            'product_id' => $product->id,
                            'user_id' => $user->id,
                            'rating' => rand(4, 5),
                            'comment' => $this->getToyReview(),
                            'is_approved' => true,
                            'is_deleted' => false,
                            'edit_by' => 1
                        ]);
                    }
                }
            }
        }

        echo "تم إنشاء " . count($toys) . " منتج لعبة بنجاح!\n";
        echo "تم إنشاء " . count($toyCategories) . " فئة ألعاب\n";
        echo "تم إنشاء " . count($toyBrands) . " علامة تجارية للألعاب\n";
    }

    private function getToyReview()
    {
        $reviews = [
            'لعبة رائعة وممتعة للأطفال، جودة عالية ومناسبة للعمر',
            'أطفالي يحبون هذه اللعبة كثيراً، تنمي خيالهم وإبداعهم',
            'قيمة ممتازة مقابل السعر، مصنوعة بجودة عالية وآمنة',
            'لعبة تعليمية رائعة، ساعدت طفلي في تعلم أشياء جديدة',
            'سهلة الاستخدام ومسلية، أنصح بها بشدة للأطفال',
            'جودة التصنيع ممتازة واللعبة متينة جداً',
            'أطفالي يلعبون بها يومياً ولا يملون منها',
            'لعبة آمنة ومناسبة للأطفال، تستحق الشراء'
        ];

        return $reviews[array_rand($reviews)];
    }
}
