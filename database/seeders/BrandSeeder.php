<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Category;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $electronicsCategory = Category::where('slug', 'electronics')->first();
        $clothingCategory = Category::where('slug', 'clothing')->first();
        $sportsCategory = Category::where('slug', 'sports-fitness')->first();
        $homeCategory = Category::where('slug', 'home-garden')->first();
        $automotiveCategory = Category::where('slug', 'automotive')->first();

        $brands = [
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'description' => 'South Korean multinational electronics company',
                'category_id' => $electronicsCategory ? $electronicsCategory->id : null,
            ],
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'description' => 'American technology company',
                'category_id' => $electronicsCategory ? $electronicsCategory->id : null,
            ],
            [
                'name' => 'Nike',
                'slug' => 'nike',
                'description' => 'American athletic footwear and apparel corporation',
                'category_id' => $clothingCategory ? $clothingCategory->id : null,
            ],
            [
                'name' => 'Adidas',
                'slug' => 'adidas',
                'description' => 'German multinational corporation that designs and manufactures shoes',
                'category_id' => $clothingCategory ? $clothingCategory->id : null,
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'description' => 'Japanese multinational conglomerate corporation',
                'category_id' => $electronicsCategory ? $electronicsCategory->id : null,
            ],
            [
                'name' => 'LG',
                'slug' => 'lg',
                'description' => 'South Korean multinational electronics company',
                'category_id' => $electronicsCategory ? $electronicsCategory->id : null,
            ],
            [
                'name' => 'Zara',
                'slug' => 'zara',
                'description' => 'Spanish clothing retailer',
                'category_id' => $clothingCategory ? $clothingCategory->id : null,
            ],
            [
                'name' => 'H&M',
                'slug' => 'hm',
                'description' => 'Swedish multinational clothing-retail company',
                'category_id' => $clothingCategory ? $clothingCategory->id : null,
            ],
            [
                'name' => 'IKEA',
                'slug' => 'ikea',
                'description' => 'Swedish furniture retailer',
                'category_id' => $homeCategory ? $homeCategory->id : null,
            ],
            [
                'name' => 'Toyota',
                'slug' => 'toyota',
                'description' => 'Japanese automotive manufacturer',
                'category_id' => $automotiveCategory ? $automotiveCategory->id : null,
            ],
            [
                'name' => 'Converse',
                'slug' => 'converse',
                'description' => 'American shoe company known for Chuck Taylor All Star sneakers',
                'category_id' => $clothingCategory ? $clothingCategory->id : null,
            ],
            [
                'name' => 'Puma',
                'slug' => 'puma',
                'description' => 'German multinational corporation that designs athletic shoes',
                'category_id' => $sportsCategory ? $sportsCategory->id : null,
            ],
            [
                'name' => 'Under Armour',
                'slug' => 'under-armour',
                'description' => 'American sports equipment company',
                'category_id' => $sportsCategory ? $sportsCategory->id : null,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['slug' => $brand['slug']], 
                $brand
            );
        }
    }
}
