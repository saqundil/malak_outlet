<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\User;
use App\Models\Order;

echo "=== تحقق من البيانات الجديدة ===\n\n";

// الفئات الرئيسية
echo "الفئات الرئيسية:\n";
$mainCategories = Category::whereNull('parent_id')->get();
foreach($mainCategories as $cat) {
    echo "- {$cat->name} (ID: {$cat->id})\n";
    
    // الفئات الفرعية
    $subCategories = Category::where('parent_id', $cat->id)->get();
    foreach($subCategories as $subCat) {
        echo "  └── {$subCat->name} (ID: {$subCat->id})\n";
    }
}

echo "\n";

// إحصائيات
echo "إحصائيات:\n";
echo "- عدد الفئات الإجمالي: " . Category::count() . "\n";
echo "- عدد المنتجات: " . Product::count() . "\n";
echo "- عدد العلامات التجارية: " . Brand::count() . "\n";
echo "- عدد المستخدمين: " . User::count() . "\n";
echo "- عدد الطلبات: " . Order::count() . "\n";

echo "\n";

// عينة من المنتجات لكل فئة رئيسية
echo "عينة من المنتجات:\n";
foreach($mainCategories as $cat) {
    echo "\nفئة {$cat->name}:\n";
    $categoryIds = Category::where('parent_id', $cat->id)->pluck('id')->toArray();
    $categoryIds[] = $cat->id; // Include the main category itself
    
    $products = Product::whereIn('category_id', $categoryIds)->take(3)->get();
    foreach($products as $product) {
        echo "- {$product->name} - {$product->price} ريال\n";
    }
}

echo "\n=== انتهى التحقق ===\n";
