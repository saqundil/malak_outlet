<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->boot();

echo "=== Checking Products in Database ===\n";

$products = \App\Models\Product::select('id', 'name', 'slug')->take(10)->get();

if ($products->count() > 0) {
    echo "Found " . $products->count() . " products:\n\n";
    foreach ($products as $product) {
        echo "ID: {$product->id} | Slug: {$product->slug} | Name: {$product->name}\n";
        echo "URL by ID: /products/{$product->id}\n";
        echo "URL by Slug: /products/{$product->slug}\n";
        echo "---\n";
    }
} else {
    echo "No products found in database.\n";
}

echo "\n=== Testing Product ID 12 ===\n";
$product12 = \App\Models\Product::find(12);
if ($product12) {
    echo "Product ID 12 exists:\n";
    echo "Name: {$product12->name}\n";
    echo "Slug: {$product12->slug}\n";
    echo "Status: {$product12->status}\n";
} else {
    echo "Product ID 12 not found.\n";
}
