<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class HierarchicalCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing categories first (optional)
        // Category::truncate();

        // Main Categories with their subcategories
        $categories = [
            [
                'name' => 'ألعاب تعليمية',
                'slug' => 'educational-toys',
                'description' => 'ألعاب تساعد في تطوير مهارات الطفل التعليمية',
                'image' => 'categories/educational-toys.jpg',
                'children' => [
                    [
                        'name' => 'ألعاب الرياضيات',
                        'slug' => 'math-toys',
                        'description' => 'ألعاب لتعلم الأرقام والحساب',
                        'image' => 'categories/math-toys.jpg',
                    ],
                    [
                        'name' => 'ألعاب اللغة',
                        'slug' => 'language-toys',
                        'description' => 'ألعاب لتعلم الحروف والكلمات',
                        'image' => 'categories/language-toys.jpg',
                    ],
                    [
                        'name' => 'ألعاب العلوم',
                        'slug' => 'science-toys',
                        'description' => 'ألعاب التجارب العلمية والاستكشاف',
                        'image' => 'categories/science-toys.jpg',
                    ]
                ]
            ],
            [
                'name' => 'ليغو ومكعبات البناء',
                'slug' => 'lego-building-blocks',
                'description' => 'جميع أنواع مكعبات البناء وألعاب التركيب',
                'image' => 'categories/lego-building.jpg',
                'children' => [
                    [
                        'name' => 'ليغو كلاسيك',
                        'slug' => 'lego-classic',
                        'description' => 'مجموعات ليغو الكلاسيكية',
                        'image' => 'categories/lego-classic.jpg',
                    ],
                    [
                        'name' => 'ليغو تكنيك',
                        'slug' => 'lego-technic',
                        'description' => 'مجموعات ليغو التقنية المتقدمة',
                        'image' => 'categories/lego-technic.jpg',
                    ],
                    [
                        'name' => 'ليغو المدينة',
                        'slug' => 'lego-city',
                        'description' => 'مجموعات ليغو المدينة والمباني',
                        'image' => 'categories/lego-city.jpg',
                    ],
                    [
                        'name' => 'ليغو الأصدقاء',
                        'slug' => 'lego-friends',
                        'description' => 'مجموعات ليغو الأصدقاء للبنات',
                        'image' => 'categories/lego-friends.jpg',
                    ]
                ]
            ],
            [
                'name' => 'ألعاب الأطفال',
                'slug' => 'baby-toys',
                'description' => 'ألعاب مخصصة للأطفال الصغار',
                'image' => 'categories/baby-toys.jpg',
                'children' => [
                    [
                        'name' => 'ألعاب الرضع (0-6 أشهر)',
                        'slug' => 'infant-toys-0-6',
                        'description' => 'ألعاب آمنة للرضع من 0 إلى 6 أشهر',
                        'image' => 'categories/infant-toys.jpg',
                    ],
                    [
                        'name' => 'ألعاب الحبو (6-12 شهر)',
                        'slug' => 'crawling-toys-6-12',
                        'description' => 'ألعاب تشجع على الحبو والحركة',
                        'image' => 'categories/crawling-toys.jpg',
                    ],
                    [
                        'name' => 'ألعاب المشي (1-2 سنة)',
                        'slug' => 'walking-toys-1-2',
                        'description' => 'ألعاب تساعد على تعلم المشي',
                        'image' => 'categories/walking-toys.jpg',
                    ]
                ]
            ],
            [
                'name' => 'ألعاب إلكترونية',
                'slug' => 'electronic-toys',
                'description' => 'ألعاب تفاعلية وإلكترونية',
                'image' => 'categories/electronic-toys.jpg',
                'children' => [
                    [
                        'name' => 'ألعاب الروبوت',
                        'slug' => 'robot-toys',
                        'description' => 'ألعاب الروبوت والآلات التفاعلية',
                        'image' => 'categories/robot-toys.jpg',
                    ],
                    [
                        'name' => 'ألعاب التحكم عن بعد',
                        'slug' => 'remote-control-toys',
                        'description' => 'سيارات وطائرات التحكم عن بعد',
                        'image' => 'categories/rc-toys.jpg',
                    ],
                    [
                        'name' => 'ألعاب تعليمية إلكترونية',
                        'slug' => 'electronic-learning-toys',
                        'description' => 'أجهزة تعليمية إلكترونية تفاعلية',
                        'image' => 'categories/electronic-learning.jpg',
                    ]
                ]
            ],
            [
                'name' => 'ألعاب الأولاد',
                'slug' => 'boys-toys',
                'description' => 'ألعاب مخصصة للأولاد',
                'image' => 'categories/boys-toys.jpg',
                'children' => [
                    [
                        'name' => 'سيارات وشاحنات',
                        'slug' => 'cars-trucks',
                        'description' => 'مجموعة متنوعة من السيارات والشاحنات',
                        'image' => 'categories/cars-trucks.jpg',
                    ],
                    [
                        'name' => 'أسلحة الألعاب',
                        'slug' => 'toy-weapons',
                        'description' => 'أسلحة آمنة للعب والتسلية',
                        'image' => 'categories/toy-weapons.jpg',
                    ],
                    [
                        'name' => 'ألعاب الرياضة',
                        'slug' => 'sports-toys',
                        'description' => 'ألعاب رياضية وأنشطة خارجية',
                        'image' => 'categories/sports-toys.jpg',
                    ]
                ]
            ],
            [
                'name' => 'ألعاب البنات',
                'slug' => 'girls-toys',
                'description' => 'ألعاب مخصصة للبنات',
                'image' => 'categories/girls-toys.jpg',
                'children' => [
                    [
                        'name' => 'دمى وعرائس',
                        'slug' => 'dolls',
                        'description' => 'مجموعة متنوعة من الدمى والعرائس',
                        'image' => 'categories/dolls.jpg',
                    ],
                    [
                        'name' => 'ألعاب الطبخ',
                        'slug' => 'cooking-toys',
                        'description' => 'مطابخ الألعاب وأدوات الطبخ',
                        'image' => 'categories/cooking-toys.jpg',
                    ],
                    [
                        'name' => 'ألعاب التجميل',
                        'slug' => 'beauty-toys',
                        'description' => 'أدوات التجميل والعناية الآمنة للأطفال',
                        'image' => 'categories/beauty-toys.jpg',
                    ]
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            // Create main category
            $mainCategory = Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
                'description' => $categoryData['description'],
                'image' => $categoryData['image'],
                'is_active' => true,
                'parent_id' => null
            ]);

            // Create subcategories if they exist
            if (isset($categoryData['children'])) {
                foreach ($categoryData['children'] as $childData) {
                    Category::create([
                        'name' => $childData['name'],
                        'slug' => $childData['slug'],
                        'description' => $childData['description'],
                        'image' => $childData['image'],
                        'is_active' => true,
                        'parent_id' => $mainCategory->id
                    ]);
                }
            }
        }

        $this->command->info('تم إنشاء الفئات الهرمية بنجاح!');
        $this->command->info('تم إنشاء ' . Category::main()->count() . ' فئة رئيسية');
        $this->command->info('تم إنشاء ' . Category::subcategories()->count() . ' فئة فرعية');
    }
}
