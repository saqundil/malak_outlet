<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('product_sizes');
    echo "Product Sizes Table Columns:\n";
    print_r($columns);
    
    if (!empty($columns)) {
        echo "\nChecking if table has required columns:\n";
        $required = ['id', 'product_id', 'size', 'size_type', 'stock_quantity', 'additional_price', 'is_available'];
        foreach ($required as $col) {
            echo "- $col: " . (in_array($col, $columns) ? "✓ EXISTS" : "✗ MISSING") . "\n";
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
