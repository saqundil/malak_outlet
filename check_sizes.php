<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "جميع المنتجات التي تحتوي على أحجام:\n";

$products = \App\Models\Product::with('sizes')->whereHas('sizes')->get();

foreach ($products as $product) {
    echo "\n" . $product->name . ":\n";
    foreach ($product->sizes as $size) {
        echo "  - الحجم: {$size->size} | المخزون: {$size->stock_quantity} | السعر الإضافي: +{$size->additional_price} د.أ\n";
    }
}

echo "\nإجمالي المنتجات مع أحجام: " . $products->count() . "\n";
echo "إجمالي الأحجام: " . \App\Models\ProductSize::count() . "\n";
