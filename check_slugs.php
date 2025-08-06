<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "First 5 products with their slugs:\n";
$products = Product::take(5)->get(['name', 'slug', 'quantity']);

foreach($products as $product) {
    echo "- Name: " . $product->name . "\n";
    echo "  Slug: " . $product->slug . "\n";
    echo "  Quantity: " . $product->quantity . "\n";
    echo "  Stock Quantity: " . $product->stock_quantity . "\n\n";
}
