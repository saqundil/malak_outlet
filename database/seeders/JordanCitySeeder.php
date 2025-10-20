<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JordanCity;

class JordanCitySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $cities = [
            [
                'name_ar' => 'عمان',
                'name_en' => 'Amman',
                'delivery_cost' => 2.00,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'العاصمة - توصيل سريع'
            ],
            [
                'name_ar' => 'الزرقاء',
                'name_en' => 'Zarqa',
                'delivery_cost' => 3.00,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'توصيل يومي'
            ],
            [
                'name_ar' => 'إربد',
                'name_en' => 'Irbid',
                'delivery_cost' => 4.00,
                'delivery_days' => 2,
                'is_active' => true,
                'notes' => 'الشمال'
            ],
            [
                'name_ar' => 'السلط',
                'name_en' => 'Salt',
                'delivery_cost' => 3.50,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'البلقاء'
            ],
            [
                'name_ar' => 'الكرك',
                'name_en' => 'Karak',
                'delivery_cost' => 5.00,
                'delivery_days' => 2,
                'is_active' => true,
                'notes' => 'الجنوب'
            ],
            [
                'name_ar' => 'معان',
                'name_en' => 'Maan',
                'delivery_cost' => 6.00,
                'delivery_days' => 3,
                'is_active' => true,
                'notes' => 'الجنوب - بعيد'
            ],
            [
                'name_ar' => 'العقبة',
                'name_en' => 'Aqaba',
                'delivery_cost' => 7.00,
                'delivery_days' => 3,
                'is_active' => true,
                'notes' => 'المدينة الساحلية'
            ],
            [
                'name_ar' => 'الطفيلة',
                'name_en' => 'Tafilah',
                'delivery_cost' => 5.50,
                'delivery_days' => 2,
                'is_active' => true,
                'notes' => 'الجنوب'
            ],
            [
                'name_ar' => 'جرش',
                'name_en' => 'Jerash',
                'delivery_cost' => 4.50,
                'delivery_days' => 2,
                'is_active' => true,
                'notes' => 'الشمال - المدينة الأثرية'
            ],
            [
                'name_ar' => 'عجلون',
                'name_en' => 'Ajloun',
                'delivery_cost' => 4.50,
                'delivery_days' => 2,
                'is_active' => true,
                'notes' => 'الشمال'
            ],
            [
                'name_ar' => 'المفرق',
                'name_en' => 'Mafraq',
                'delivery_cost' => 4.00,
                'delivery_days' => 2,
                'is_active' => true,
                'notes' => 'الشمال الشرقي'
            ],
            [
                'name_ar' => 'مادبا',
                'name_en' => 'Madaba',
                'delivery_cost' => 3.50,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'مدينة الفسيفساء'
            ],
            // Additional areas within Amman
            [
                'name_ar' => 'عمان - وسط البلد',
                'name_en' => 'Amman Downtown',
                'delivery_cost' => 2.00,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'وسط عمان'
            ],
            [
                'name_ar' => 'عمان - عبدون',
                'name_en' => 'Amman Abdoun',
                'delivery_cost' => 2.00,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'منطقة عبدون'
            ],
            [
                'name_ar' => 'عمان - الجبيهة',
                'name_en' => 'Amman Jubeiha',
                'delivery_cost' => 2.50,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'منطقة الجبيهة'
            ],
            [
                'name_ar' => 'عمان - الشميساني',
                'name_en' => 'Amman Shmeisani',
                'delivery_cost' => 2.00,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'منطقة الشميساني'
            ],
            [
                'name_ar' => 'عمان - دير غبار',
                'name_en' => 'Amman Deir Ghbar',
                'delivery_cost' => 2.50,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'منطقة دير غبار'
            ],
            [
                'name_ar' => 'عمان - صويلح',
                'name_en' => 'Amman Sweileh',
                'delivery_cost' => 2.50,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'منطقة صويلح'
            ],
            [
                'name_ar' => 'عمان - الجامعة الأردنية',
                'name_en' => 'Amman University Area',
                'delivery_cost' => 2.50,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'منطقة الجامعة الأردنية'
            ],
            [
                'name_ar' => 'عمان - طبربور',
                'name_en' => 'Amman Tabarbour',
                'delivery_cost' => 2.50,
                'delivery_days' => 1,
                'is_active' => true,
                'notes' => 'منطقة طبربور'
            ]
        ];

        foreach ($cities as $city) {
            JordanCity::create($city);
        }
    }
}