<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Category;

class TestCategoryBrandRelationship extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "=== Category-Brand Relationship Test ===\n\n";

        $categories = Category::with('brands')->get();

        foreach ($categories as $category) {
            echo "📂 {$category->name} ({$category->brands->count()} brands)\n";
            foreach ($category->brands as $brand) {
                echo "   ├── {$brand->name}\n";
            }
            echo "\n";
        }

        echo "=== Brand-Category Relationship Test ===\n\n";

        $brands = Brand::with('category')->get()->groupBy('category.name');
        
        foreach ($brands as $categoryName => $categoryBrands) {
            echo "📂 {$categoryName}\n";
            foreach ($categoryBrands as $brand) {
                echo "   ├── {$brand->name}\n";
            }
            echo "\n";
        }

        echo "=== Summary ===\n";
        echo "Total Categories: " . Category::count() . "\n";
        echo "Total Brands: " . Brand::count() . "\n";
        echo "Brands with Category: " . Brand::whereNotNull('category_id')->count() . "\n";
    }
}
