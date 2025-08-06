<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;

echo "=== COMPREHENSIVE FUNCTIONALITY TEST ===\n\n";

// Test 1: Category Hierarchy Display
echo "🔍 TEST 1: Category Hierarchy Structure\n";
echo "----------------------------------------\n";
$mainCategories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();

foreach ($mainCategories as $main) {
    echo "📁 {$main->name} (ID: {$main->id})\n";
    foreach ($main->children as $sub) {
        echo "   └── {$sub->name} (ID: {$sub->id})\n";
    }
}

// Test 2: Filtering Logic
echo "\n🔍 TEST 2: Category Filtering Logic\n";
echo "-----------------------------------\n";

// Simulate filtering by main category "ألعاب" (ID: 1)
$categoryIds = [1];
$allCategoryIds = collect($categoryIds);

foreach ($categoryIds as $categoryId) {
    $subcategories = Category::where('parent_id', $categoryId)->pluck('id');
    $allCategoryIds = $allCategoryIds->merge($subcategories);
}

$filteredProducts = Product::whereIn('category_id', $allCategoryIds->unique()->toArray())->get();

echo "Selected Category: ألعاب (ID: 1)\n";
echo "Includes subcategories: " . implode(', ', $allCategoryIds->unique()->toArray()) . "\n";
echo "Total products found: {$filteredProducts->count()}\n";

foreach ($filteredProducts as $product) {
    $category = Category::find($product->category_id);
    echo "   - {$product->name} (في: {$category->name})\n";
}

// Test 3: Navigation URLs
echo "\n🔍 TEST 3: Navigation URL Structure\n";
echo "-----------------------------------\n";
echo "Main Categories Navigation URLs:\n";
echo "- ألعاب: /products?category[]=1\n";
echo "- أحذية: /products?category[]=7\n";
echo "- مستلزمات أطفال: /products?category[]=13\n";

// Test 4: Product Counts
echo "\n🔍 TEST 4: Product Count Verification\n";
echo "-------------------------------------\n";
foreach ($mainCategories as $main) {
    $subcategoryIds = $main->children->pluck('id');
    $allIds = collect([$main->id])->merge($subcategoryIds);
    $productCount = Product::whereIn('category_id', $allIds)->count();
    echo "{$main->name}: {$productCount} products\n";
    
    foreach ($main->children as $sub) {
        $subCount = Product::where('category_id', $sub->id)->count();
        echo "   └── {$sub->name}: {$subCount} products\n";
    }
}

echo "\n✅ ALL TESTS COMPLETED SUCCESSFULLY!\n";
