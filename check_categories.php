<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

echo "=== CATEGORY HIERARCHY ===\n\n";

// Get all main categories (parent_id = null)
$mainCategories = Category::whereNull('parent_id')->with('children')->orderBy('name')->get();

foreach ($mainCategories as $mainCategory) {
    echo "📁 MAIN: {$mainCategory->name} (ID: {$mainCategory->id})\n";
    
    if ($mainCategory->children->count() > 0) {
        foreach ($mainCategory->children as $subCategory) {
            echo "   └── SUB: {$subCategory->name} (ID: {$subCategory->id})\n";
        }
    }
    echo "\n";
}

echo "=== ALL CATEGORIES FLAT ===\n";
$allCategories = Category::with('parent')->orderBy('parent_id')->orderBy('name')->get();
foreach ($allCategories as $category) {
    $parentName = $category->parent ? $category->parent->name : 'ROOT';
    echo "ID: {$category->id}, Name: {$category->name}, Parent: {$parentName}\n";
}
