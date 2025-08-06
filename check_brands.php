<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Brand;
use App\Models\Product;

echo "=== BRANDS ===\n";
$brands = Brand::all(['id', 'name', 'is_active']);
foreach ($brands as $brand) {
    echo "ID: {$brand->id}, Name: {$brand->name}, Active: " . ($brand->is_active ? 'Yes' : 'No') . "\n";
}

echo "\n=== PRODUCTS WITH BRANDS ===\n";
$products = Product::with('brand')->whereNotNull('brand_id')->get(['id', 'name', 'brand_id']);
foreach ($products as $product) {
    echo "Product: {$product->name}, Brand: " . ($product->brand ? $product->brand->name : 'None') . "\n";
}

echo "\n=== ACTIVE BRANDS WITH PRODUCT COUNTS ===\n";
$activeBrands = Brand::active()->withCount('products')->get();
foreach ($activeBrands as $brand) {
    echo "Brand: {$brand->name}, Products: {$brand->products_count}\n";
}
