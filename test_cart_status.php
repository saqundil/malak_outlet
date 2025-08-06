<?php
// Quick test to verify cart contents
require_once 'vendor/autoload.php';

// Set up Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\CartController;

echo "=== Cart Status Check ===\n\n";

// Create controller instance
$controller = new CartController();

// Test cart count
try {
    $response = $controller->getCount();
    $data = json_decode($response->getContent(), true);
    echo "Cart Count: " . $data['count'] . "\n\n";
} catch (Exception $e) {
    echo "Error getting cart count: " . $e->getMessage() . "\n\n";
}

// Test cart view
try {
    $response = $controller->index();
    echo "Cart page loaded successfully!\n";
    echo "Cart view type: " . get_class($response) . "\n\n";
} catch (Exception $e) {
    echo "Error loading cart: " . $e->getMessage() . "\n\n";
}

echo "=== Test Complete ===\n";
