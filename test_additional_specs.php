<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

echo "=== Testing additional_specs field ===\n\n";

// Get a sample product
$product = Product::first();

if (!$product) {
    echo "No products found in database.\n";
    exit;
}

echo "Product: {$product->name}\n";
echo "Additional Specs Type: " . gettype($product->additional_specs) . "\n";
echo "Additional Specs Content:\n";

if ($product->additional_specs && is_array($product->additional_specs)) {
    foreach ($product->additional_specs as $key => $value) {
        echo "  - {$key}: {$value}\n";
    }
} else {
    echo "  No additional specs found\n";
}

echo "\n=== How to add more additional_specs ===\n";
echo "You can add more specifications like this:\n\n";

// Example of adding more specs
$newSpecs = [
    'لون المنتج' => 'أزرق وأبيض',
    'نوع التشغيل' => 'يدوي',
    'مستوى الصوت' => 'هادئ',
    'سهولة التجميع' => '15 دقيقة'
];

echo "Example additional specs to add:\n";
foreach ($newSpecs as $key => $value) {
    echo "  '{$key}' => '{$value}'\n";
}

echo "\n=== Usage in Blade Template ===\n";
echo "The additional_specs are automatically displayed in the product specs tab.\n";
echo "They render as a dynamic grid of specification pairs.\n";

echo "\n=== Database Structure ===\n";
echo "Field: additional_specs\n";
echo "Type: JSON\n";
echo "Laravel Cast: 'array'\n";
echo "Purpose: Store flexible, dynamic product specifications\n";

?>
