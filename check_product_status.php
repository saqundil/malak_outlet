<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== فحص حالة المنتجات ===\n\n";

$products = Product::take(10)->get(['name', 'status', 'quantity', 'is_active']);

foreach($products as $product) {
    echo "المنتج: {$product->name}\n";
    echo "  - الحالة: {$product->status}\n";
    echo "  - الكمية: {$product->quantity}\n";
    echo "  - نشط: " . ($product->is_active ? 'نعم' : 'لا') . "\n";
    echo "  - متوفر: " . (($product->status == 'in_stock' && $product->quantity > 0) ? 'نعم' : 'لا') . "\n";
    echo "---\n";
}

echo "\nإحصائيات:\n";
echo "- إجمالي المنتجات: " . Product::count() . "\n";
echo "- المنتجات النشطة: " . Product::where('is_active', true)->count() . "\n";
echo "- المنتجات المتوفرة: " . Product::where('status', 'in_stock')->where('quantity', '>', 0)->count() . "\n";
echo "- المنتجات غير المحذوفة: " . Product::where('is_deleted', false)->count() . "\n";
