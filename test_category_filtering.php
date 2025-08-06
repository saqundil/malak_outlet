<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;

echo "=== CATEGORY FILTERING TEST ===\n\n";

// Test main categories with their subcategories
$mainCategories = Category::whereNull('parent_id')->get();

foreach ($mainCategories as $mainCategory) {
    echo "📁 MAIN CATEGORY: {$mainCategory->name} (ID: {$mainCategory->id})\n";
    
    // Direct products in main category
    $directProducts = Product::where('category_id', $mainCategory->id)->count();
    echo "   Direct products: {$directProducts}\n";
    
    // Products in subcategories
    $subcategoryIds = $mainCategory->children->pluck('id');
    $subcategoryProducts = Product::whereIn('category_id', $subcategoryIds)->count();
    echo "   Subcategory products: {$subcategoryProducts}\n";
    
    // Total products (including subcategories)
    $allCategoryIds = collect([$mainCategory->id])->merge($subcategoryIds);
    $totalProducts = Product::whereIn('category_id', $allCategoryIds)->count();
    echo "   TOTAL products: {$totalProducts}\n";
    
    // List subcategories
    if ($subcategoryIds->count() > 0) {
        echo "   Subcategories:\n";
        foreach ($mainCategory->children as $sub) {
            $subProducts = Product::where('category_id', $sub->id)->count();
            echo "      └── {$sub->name} ({$subProducts} products)\n";
        }
    }
    echo "\n";
}
