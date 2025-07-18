<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class SimplifiedBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            // Electronics & Technology
            ['name' => 'سامسونج', 'image' => 'brands/samsung.jpg'],
            ['name' => 'آبل', 'image' => 'brands/apple.jpg'],
            ['name' => 'سوني', 'image' => 'brands/sony.jpg'],
            ['name' => 'هواوي', 'image' => 'brands/huawei.jpg'],
            ['name' => 'شاومي', 'image' => 'brands/xiaomi.jpg'],
            ['name' => 'إل جي', 'image' => 'brands/lg.jpg'],
            
            // Toys & Games
            ['name' => 'ليجو', 'image' => 'brands/lego.jpg'],
            ['name' => 'فيشر برايس', 'image' => 'brands/fisher-price.jpg'],
            ['name' => 'ماتيل', 'image' => 'brands/mattel.jpg'],
            ['name' => 'هاسبرو', 'image' => 'brands/hasbro.jpg'],
            ['name' => 'بلايموبيل', 'image' => 'brands/playmobil.jpg'],
            
            // Clothing & Fashion
            ['name' => 'نايكي', 'image' => 'brands/nike.jpg'],
            ['name' => 'أديداس', 'image' => 'brands/adidas.jpg'],
            ['name' => 'بوما', 'image' => 'brands/puma.jpg'],
            ['name' => 'زارا', 'image' => 'brands/zara.jpg'],
            ['name' => 'إتش آند إم', 'image' => 'brands/hm.jpg'],
            
            // Sports & Fitness
            ['name' => 'ريبوك', 'image' => 'brands/reebok.jpg'],
            ['name' => 'أندر آرمور', 'image' => 'brands/under-armour.jpg'],
            ['name' => 'نيو بالانس', 'image' => 'brands/new-balance.jpg'],
            
            // Home & Garden
            ['name' => 'إيكيا', 'image' => 'brands/ikea.jpg'],
            ['name' => 'هوم سنتر', 'image' => 'brands/home-center.jpg'],
            
            // Beauty & Health
            ['name' => 'لوريال', 'image' => 'brands/loreal.jpg'],
            ['name' => 'نيفيا', 'image' => 'brands/nivea.jpg'],
            ['name' => 'جونسون آند جونسون', 'image' => 'brands/johnson-johnson.jpg'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        $this->command->info('تم إنشاء ' . count($brands) . ' علامة تجارية بنجاح!');
    }
}
