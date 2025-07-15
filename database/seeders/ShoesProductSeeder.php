<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ShoesProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category and brand IDs
        $clothingCategory = Category::where('slug', 'clothing')->first();
        $sportsCategory = Category::where('slug', 'sports-fitness')->first();
        
        $nikeBrand = Brand::where('name', 'Nike')->first();
        $adidasBrand = Brand::where('name', 'Adidas')->first();
        $converseBrand = Brand::where('name', 'Converse')->first();
        
        $shoes = [
            // Nike Shoes
            [
                'name' => 'Nike Air Force 1 \'07',
                'slug' => 'nike-air-force-1-07',
                'description' => 'Classic basketball shoe with premium leather upper and Air-Sole unit. Available in white, black, and multiple colorways.',
                'price' => 90.00,
                'sale_price' => 75.00,
                'sku' => 'NIK-AF1-001',
                'stock_quantity' => 85,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => $nikeBrand ? $nikeBrand->id : 3,
                'is_featured' => true,
                'is_active' => true,
                'weight' => '0.8kg',
                'materials' => 'Leather upper, rubber sole',
                'country_of_origin' => 'Vietnam',
                'warranty_period' => '6 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Nike React Infinity Run Flyknit 3',
                'slug' => 'nike-react-infinity-run-flyknit-3',
                'description' => 'Revolutionary running shoe designed to help reduce injury. Features Nike React foam and Flyknit upper.',
                'price' => 160.00,
                'sale_price' => 140.00,
                'sku' => 'NIK-RIR3-001',
                'stock_quantity' => 60,
                'category_id' => $sportsCategory ? $sportsCategory->id : 4,
                'brand_id' => $nikeBrand ? $nikeBrand->id : 3,
                'is_featured' => true,
                'is_active' => true,
                'weight' => '0.7kg',
                'materials' => 'Flyknit upper, React foam midsole',
                'country_of_origin' => 'China',
                'warranty_period' => '1 year',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Nike Dunk Low Retro',
                'slug' => 'nike-dunk-low-retro',
                'description' => 'Iconic basketball shoe returns with classic two-tone colorways and vintage appeal.',
                'price' => 100.00,
                'sale_price' => null,
                'sku' => 'NIK-DLR-001',
                'stock_quantity' => 45,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => $nikeBrand ? $nikeBrand->id : 3,
                'is_featured' => false,
                'is_active' => true,
                'weight' => '0.75kg',
                'materials' => 'Leather and synthetic upper',
                'country_of_origin' => 'Indonesia',
                'warranty_period' => '6 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Nike Blazer Mid \'77 Vintage',
                'slug' => 'nike-blazer-mid-77-vintage',
                'description' => 'Classic basketball shoe with vintage styling and modern comfort. Perfect for casual wear.',
                'price' => 85.00,
                'sale_price' => 70.00,
                'sku' => 'NIK-BM77-001',
                'stock_quantity' => 70,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => $nikeBrand ? $nikeBrand->id : 3,
                'is_featured' => false,
                'is_active' => true,
                'weight' => '0.8kg',
                'materials' => 'Leather upper, rubber sole',
                'country_of_origin' => 'Indonesia',
                'warranty_period' => '6 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],

            // Adidas Shoes
            [
                'name' => 'Adidas Stan Smith',
                'slug' => 'adidas-stan-smith',
                'description' => 'Legendary tennis shoe with clean white leather design and green accents. A timeless classic.',
                'price' => 80.00,
                'sale_price' => 65.00,
                'sku' => 'ADI-SS-001',
                'stock_quantity' => 95,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => $adidasBrand ? $adidasBrand->id : 4,
                'is_featured' => true,
                'is_active' => true,
                'weight' => '0.7kg',
                'materials' => 'Leather upper, rubber sole',
                'country_of_origin' => 'Vietnam',
                'warranty_period' => '6 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Adidas Ultraboost 23',
                'slug' => 'adidas-ultraboost-23',
                'description' => 'Premium running shoe with Boost technology for endless energy return. Perfect for long-distance running.',
                'price' => 190.00,
                'sale_price' => 170.00,
                'sku' => 'ADI-UB23-001',
                'stock_quantity' => 50,
                'category_id' => $sportsCategory ? $sportsCategory->id : 4,
                'brand_id' => $adidasBrand ? $adidasBrand->id : 4,
                'is_featured' => true,
                'is_active' => true,
                'weight' => '0.65kg',
                'materials' => 'Primeknit upper, Boost midsole',
                'country_of_origin' => 'Germany',
                'warranty_period' => '1 year',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Adidas Gazelle',
                'slug' => 'adidas-gazelle',
                'description' => 'Vintage-inspired sneaker with suede upper and iconic three stripes. Perfect for everyday wear.',
                'price' => 75.00,
                'sale_price' => null,
                'sku' => 'ADI-GAZ-001',
                'stock_quantity' => 80,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => $adidasBrand ? $adidasBrand->id : 4,
                'is_featured' => false,
                'is_active' => true,
                'weight' => '0.6kg',
                'materials' => 'Suede upper, rubber sole',
                'country_of_origin' => 'Vietnam',
                'warranty_period' => '6 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Adidas NMD_R1',
                'slug' => 'adidas-nmd-r1',
                'description' => 'Modern street-style sneaker with Boost technology and distinctive design elements.',
                'price' => 130.00,
                'sale_price' => 110.00,
                'sku' => 'ADI-NMD-001',
                'stock_quantity' => 65,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => $adidasBrand ? $adidasBrand->id : 4,
                'is_featured' => false,
                'is_active' => true,
                'weight' => '0.7kg',
                'materials' => 'Textile upper, Boost midsole',
                'country_of_origin' => 'China',
                'warranty_period' => '6 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],

            // Converse Shoes
            [
                'name' => 'Converse Chuck Taylor All Star Classic',
                'slug' => 'converse-chuck-taylor-all-star-classic',
                'description' => 'Iconic canvas sneaker that has been a cultural staple for decades. Available in multiple colors.',
                'price' => 55.00,
                'sale_price' => 45.00,
                'sku' => 'CON-CT-001',
                'stock_quantity' => 120,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => $converseBrand ? $converseBrand->id : null,
                'is_featured' => true,
                'is_active' => true,
                'weight' => '0.5kg',
                'materials' => 'Canvas upper, rubber sole',
                'country_of_origin' => 'Vietnam',
                'warranty_period' => '3 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Converse Chuck 70 High Top',
                'slug' => 'converse-chuck-70-high-top',
                'description' => 'Premium version of the classic Chuck with enhanced comfort and vintage details.',
                'price' => 75.00,
                'sale_price' => null,
                'sku' => 'CON-C70-001',
                'stock_quantity' => 85,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => $converseBrand ? $converseBrand->id : null,
                'is_featured' => false,
                'is_active' => true,
                'weight' => '0.6kg',
                'materials' => 'Canvas upper, premium rubber sole',
                'country_of_origin' => 'Vietnam',
                'warranty_period' => '6 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],

            // Generic/Other Brand Shoes
            [
                'name' => 'Classic White Leather Sneakers',
                'slug' => 'classic-white-leather-sneakers',
                'description' => 'Clean and minimalist white leather sneakers perfect for any casual outfit. Unisex design.',
                'price' => 60.00,
                'sale_price' => 50.00,
                'sku' => 'GEN-WLS-001',
                'stock_quantity' => 100,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => null,
                'is_featured' => false,
                'is_active' => true,
                'weight' => '0.7kg',
                'materials' => 'Genuine leather upper, rubber sole',
                'country_of_origin' => 'Turkey',
                'warranty_period' => '3 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Running Shoes - Performance Series',
                'slug' => 'running-shoes-performance-series',
                'description' => 'Lightweight running shoes with breathable mesh upper and cushioned sole for optimal performance.',
                'price' => 85.00,
                'sale_price' => 70.00,
                'sku' => 'GEN-RSP-001',
                'stock_quantity' => 75,
                'category_id' => $sportsCategory ? $sportsCategory->id : 4,
                'brand_id' => null,
                'is_featured' => false,
                'is_active' => true,
                'weight' => '0.6kg',
                'materials' => 'Mesh upper, EVA midsole',
                'country_of_origin' => 'China',
                'warranty_period' => '6 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Canvas High-Top Sneakers',
                'slug' => 'canvas-high-top-sneakers',
                'description' => 'Retro-style canvas high-top sneakers in various colors. Perfect for street style and casual wear.',
                'price' => 45.00,
                'sale_price' => 35.00,
                'sku' => 'GEN-CHS-001',
                'stock_quantity' => 110,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => null,
                'is_featured' => false,
                'is_active' => true,
                'weight' => '0.5kg',
                'materials' => 'Canvas upper, rubber sole',
                'country_of_origin' => 'Bangladesh',
                'warranty_period' => '3 months',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Formal Black Dress Shoes',
                'slug' => 'formal-black-dress-shoes',
                'description' => 'Classic black leather dress shoes for formal occasions. Perfect for business and formal events.',
                'price' => 120.00,
                'sale_price' => 100.00,
                'sku' => 'GEN-FDS-001',
                'stock_quantity' => 40,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => null,
                'is_featured' => false,
                'is_active' => true,
                'weight' => '1.0kg',
                'materials' => 'Genuine leather upper and sole',
                'country_of_origin' => 'Italy',
                'warranty_period' => '1 year',
                'dimensions' => 'Available in sizes 36-46 EU'
            ],
            [
                'name' => 'Women\'s Ballet Flats',
                'slug' => 'womens-ballet-flats',
                'description' => 'Comfortable and elegant ballet flats for women. Available in multiple colors and patterns.',
                'price' => 35.00,
                'sale_price' => 28.00,
                'sku' => 'GEN-WBF-001',
                'stock_quantity' => 90,
                'category_id' => $clothingCategory ? $clothingCategory->id : 2,
                'brand_id' => null,
                'is_featured' => false,
                'is_active' => true,
                'weight' => '0.4kg',
                'materials' => 'Synthetic leather upper, rubber sole',
                'country_of_origin' => 'China',
                'warranty_period' => '3 months',
                'dimensions' => 'Available in sizes 36-42 EU'
            ],
            [
                'name' => 'Hiking Boots - Adventure Series',
                'slug' => 'hiking-boots-adventure-series',
                'description' => 'Durable hiking boots with waterproof technology and excellent grip for outdoor adventures.',
                'price' => 140.00,
                'sale_price' => 120.00,
                'sku' => 'GEN-HBA-001',
                'stock_quantity' => 35,
                'category_id' => $sportsCategory ? $sportsCategory->id : 4,
                'brand_id' => null,
                'is_featured' => true,
                'is_active' => true,
                'weight' => '1.2kg',
                'materials' => 'Waterproof leather, Vibram sole',
                'country_of_origin' => 'Portugal',
                'warranty_period' => '2 years',
                'dimensions' => 'Available in sizes 36-46 EU'
            ]
        ];

        foreach ($shoes as $shoe) {
            Product::create($shoe);
        }
    }
}
