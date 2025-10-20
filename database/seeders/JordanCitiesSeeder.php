<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JordanCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name_ar' => 'عمان',
                'name_en' => 'Amman',
                'delivery_cost' => 3.00,
                'delivery_days' => 1,
                'notes' => 'العاصمة - توصيل سريع خلال 24 ساعة'
            ],
            [
                'name_ar' => 'الزرقاء',
                'name_en' => 'Zarqa',
                'delivery_cost' => 4.00,
                'delivery_days' => 1,
                'notes' => 'توصيل خلال 24-48 ساعة'
            ],
            [
                'name_ar' => 'إربد',
                'name_en' => 'Irbid',
                'delivery_cost' => 5.00,
                'delivery_days' => 2,
                'notes' => 'الشمال - توصيل خلال 2-3 أيام'
            ],
            [
                'name_ar' => 'عجلون',
                'name_en' => 'Ajloun',
                'delivery_cost' => 6.00,
                'delivery_days' => 2,
                'notes' => 'منطقة جبلية - توصيل خلال 2-3 أيام'
            ],
            [
                'name_ar' => 'جرش',
                'name_en' => 'Jerash',
                'delivery_cost' => 5.50,
                'delivery_days' => 2,
                'notes' => 'توصيل خلال 2-3 أيام'
            ],
            [
                'name_ar' => 'المفرق',
                'name_en' => 'Mafraq',
                'delivery_cost' => 6.00,
                'delivery_days' => 2,
                'notes' => 'الشمال الشرقي - توصيل خلال 2-3 أيام'
            ],
            [
                'name_ar' => 'البلقاء',
                'name_en' => 'Balqa',
                'delivery_cost' => 4.50,
                'delivery_days' => 1,
                'notes' => 'السلط ومنطقة البلقاء'
            ],
            [
                'name_ar' => 'مادبا',
                'name_en' => 'Madaba',
                'delivery_cost' => 5.00,
                'delivery_days' => 2,
                'notes' => 'جنوب عمان - توصيل خلال 2 أيام'
            ],
            [
                'name_ar' => 'الكرك',
                'name_en' => 'Karak',
                'delivery_cost' => 7.00,
                'delivery_days' => 3,
                'notes' => 'الجنوب - توصيل خلال 3 أيام'
            ],
            [
                'name_ar' => 'الطفيلة',
                'name_en' => 'Tafilah',
                'delivery_cost' => 8.00,
                'delivery_days' => 3,
                'notes' => 'الجنوب - منطقة جبلية'
            ],
            [
                'name_ar' => 'معان',
                'name_en' => 'Ma\'an',
                'delivery_cost' => 9.00,
                'delivery_days' => 4,
                'notes' => 'الجنوب - توصيل خلال 4 أيام'
            ],
            [
                'name_ar' => 'العقبة',
                'name_en' => 'Aqaba',
                'delivery_cost' => 10.00,
                'delivery_days' => 4,
                'notes' => 'أقصى الجنوب - المنطقة الاقتصادية الخاصة'
            ]
        ];

        foreach ($cities as $city) {
            $city['is_active'] = true;
            $city['created_at'] = now();
            $city['updated_at'] = now();
        }

        DB::table('jordan_cities')->insert($cities);
    }
}
