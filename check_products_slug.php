<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHECKING LEGO PRODUCT STATUS ===\n";
$legoProduct = \App\Models\Product::where('slug', 'lego-city-big-set')->first();
if($legoProduct) {
    echo "ID: {$legoProduct->id}\n";
    echo "Name: {$legoProduct->name}\n";
    echo "Slug: {$legoProduct->slug}\n";
    echo "is_active: " . ($legoProduct->is_active ? 'true' : 'false') . "\n";
    echo "is_deleted: " . ($legoProduct->is_deleted ? 'true' : 'false') . "\n";
    echo "status: {$legoProduct->status}\n";
    
    echo "\n=== TESTING ACTIVE SCOPE ===\n";
    $activeLegoProduct = \App\Models\Product::where('slug', 'lego-city-big-set')->active()->first();
    if($activeLegoProduct) {
        echo "Product found with active scope!\n";
    } else {
        echo "Product NOT found with active scope - this is the issue!\n";
    }
} else {
    echo "Product with slug 'lego-city-big-set' NOT FOUND\n";
}
