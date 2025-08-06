<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

$product = Product::where('slug', 'لعبة-الأرقام-التعليمية')->first();

if($product) {
    echo "Product: " . $product->name . "\n";
    echo "Stock Quantity: " . $product->stock_quantity . "\n";
    echo "Quantity: " . $product->quantity . "\n";
    echo "Status: " . $product->status . "\n";
    echo "Is Active: " . ($product->is_active ? 'Yes' : 'No') . "\n";
} else {
    echo "Product not found\n";
}
