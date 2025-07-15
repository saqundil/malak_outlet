<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Category;

class CategoryBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $categories = [
            'electronics' => Category::where('slug', 'electronics')->first(),
            'clothing' => Category::where('slug', 'clothing')->first(),
            'sports-fitness' => Category::where('slug', 'sports-fitness')->first(),
            'home-garden' => Category::where('slug', 'home-garden')->first(),
            'automotive' => Category::where('slug', 'automotive')->first(),
            'beauty-health' => Category::where('slug', 'beauty-health')->first(),
            'toys-games' => Category::where('slug', 'toys-games')->first(),
        ];

        // Electronics brands
        $electronicsBrands = [
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'description' => 'South Korean multinational electronics company - smartphones, TVs, appliances',
                'category_id' => $categories['electronics']?->id,
            ],
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'description' => 'American technology company - iPhone, iPad, MacBook, Apple Watch',
                'category_id' => $categories['electronics']?->id,
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'description' => 'Japanese electronics corporation - PlayStation, cameras, headphones',
                'category_id' => $categories['electronics']?->id,
            ],
            [
                'name' => 'LG',
                'slug' => 'lg',
                'description' => 'South Korean electronics company - TVs, refrigerators, washing machines',
                'category_id' => $categories['electronics']?->id,
            ],
            [
                'name' => 'Dell',
                'slug' => 'dell',
                'description' => 'American computer technology company - laptops, desktops, servers',
                'category_id' => $categories['electronics']?->id,
            ],
            [
                'name' => 'HP',
                'slug' => 'hp',
                'description' => 'American multinational IT company - printers, laptops, desktops',
                'category_id' => $categories['electronics']?->id,
            ],
        ];

        // Clothing & Fashion brands
        $clothingBrands = [
            [
                'name' => 'Nike',
                'slug' => 'nike',
                'description' => 'American athletic footwear and apparel corporation',
                'category_id' => $categories['clothing']?->id,
            ],
            [
                'name' => 'Adidas',
                'slug' => 'adidas',
                'description' => 'German multinational corporation - athletic shoes and clothing',
                'category_id' => $categories['clothing']?->id,
            ],
            [
                'name' => 'Zara',
                'slug' => 'zara',
                'description' => 'Spanish fast fashion clothing retailer',
                'category_id' => $categories['clothing']?->id,
            ],
            [
                'name' => 'H&M',
                'slug' => 'hm',
                'description' => 'Swedish multinational clothing retail company',
                'category_id' => $categories['clothing']?->id,
            ],
            [
                'name' => 'Converse',
                'slug' => 'converse',
                'description' => 'American shoe company known for Chuck Taylor All Star sneakers',
                'category_id' => $categories['clothing']?->id,
            ],
            [
                'name' => 'Levis',
                'slug' => 'levis',
                'description' => 'American clothing company known for denim jeans',
                'category_id' => $categories['clothing']?->id,
            ],
        ];

        // Sports & Fitness brands
        $sportsBrands = [
            [
                'name' => 'Puma',
                'slug' => 'puma',
                'description' => 'German multinational corporation - athletic shoes and sportswear',
                'category_id' => $categories['sports-fitness']?->id,
            ],
            [
                'name' => 'Under Armour',
                'slug' => 'under-armour',
                'description' => 'American sports equipment and athletic clothing company',
                'category_id' => $categories['sports-fitness']?->id,
            ],
            [
                'name' => 'Reebok',
                'slug' => 'reebok',
                'description' => 'American fitness and athletic footwear company',
                'category_id' => $categories['sports-fitness']?->id,
            ],
            [
                'name' => 'Wilson',
                'slug' => 'wilson',
                'description' => 'American sports equipment manufacturer - tennis, basketball, football',
                'category_id' => $categories['sports-fitness']?->id,
            ],
        ];

        // Home & Garden brands
        $homeBrands = [
            [
                'name' => 'IKEA',
                'slug' => 'ikea',
                'description' => 'Swedish furniture retailer - home furnishing and accessories',
                'category_id' => $categories['home-garden']?->id,
            ],
            [
                'name' => 'Ashley Furniture',
                'slug' => 'ashley-furniture',
                'description' => 'American furniture store chain',
                'category_id' => $categories['home-garden']?->id,
            ],
            [
                'name' => 'Black & Decker',
                'slug' => 'black-decker',
                'description' => 'American manufacturer of power tools and home improvement products',
                'category_id' => $categories['home-garden']?->id,
            ],
        ];

        // Automotive brands
        $automotiveBrands = [
            [
                'name' => 'Toyota',
                'slug' => 'toyota',
                'description' => 'Japanese automotive manufacturer',
                'category_id' => $categories['automotive']?->id,
            ],
            [
                'name' => 'Honda',
                'slug' => 'honda',
                'description' => 'Japanese automotive and motorcycle manufacturer',
                'category_id' => $categories['automotive']?->id,
            ],
            [
                'name' => 'Ford',
                'slug' => 'ford',
                'description' => 'American multinational automobile manufacturer',
                'category_id' => $categories['automotive']?->id,
            ],
        ];

        // Beauty & Health brands
        $beautyBrands = [
            [
                'name' => 'LOreal',
                'slug' => 'loreal',
                'description' => 'French cosmetics and beauty company',
                'category_id' => $categories['beauty-health']?->id,
            ],
            [
                'name' => 'Maybelline',
                'slug' => 'maybelline',
                'description' => 'American cosmetics brand',
                'category_id' => $categories['beauty-health']?->id,
            ],
            [
                'name' => 'Johnson & Johnson',
                'slug' => 'johnson-johnson',
                'description' => 'American healthcare and consumer goods company',
                'category_id' => $categories['beauty-health']?->id,
            ],
        ];

        // Toys & Games brands
        $toysBrands = [
            [
                'name' => 'LEGO',
                'slug' => 'lego',
                'description' => 'Danish toy production company known for plastic construction toys',
                'category_id' => $categories['toys-games']?->id,
            ],
            [
                'name' => 'Mattel',
                'slug' => 'mattel',
                'description' => 'American toy manufacturing company - Barbie, Hot Wheels',
                'category_id' => $categories['toys-games']?->id,
            ],
            [
                'name' => 'Hasbro',
                'slug' => 'hasbro',
                'description' => 'American toy and board game company - Transformers, Monopoly',
                'category_id' => $categories['toys-games']?->id,
            ],
        ];

        // Combine all brands
        $allBrands = array_merge(
            $electronicsBrands,
            $clothingBrands,
            $sportsBrands,
            $homeBrands,
            $automotiveBrands,
            $beautyBrands,
            $toysBrands
        );

        // Create or update brands
        foreach ($allBrands as $brand) {
            Brand::updateOrCreate(
                ['slug' => $brand['slug']], 
                $brand
            );
        }

        echo "Created/Updated " . count($allBrands) . " brands across " . count($categories) . " categories.\n";
    }
}
