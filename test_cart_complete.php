<?php
// Test adding product to cart and viewing cart
require_once 'vendor/autoload.php';

// Set up Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;

// Clear any existing cart first
setcookie('shopping_cart', '', time() - 3600, '/');

echo "=== Testing Cart Functionality ===\n\n";

// Create controller instance
$controller = new CartController();

// Test 1: Add product using slug
echo "1. Adding product 'lego-city-big-set' to cart...\n";
$request = new Request();
$request->merge(['quantity' => 2]);

try {
    $response = $controller->add($request, 'lego-city-big-set');
    echo "Status: " . $response->getStatusCode() . "\n";
    $data = json_decode($response->getContent(), true);
    echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
    echo "Message: " . $data['message'] . "\n";
    echo "Product: " . $data['product_name'] . "\n\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n\n";
}

// Test 2: View cart
echo "2. Viewing cart contents...\n";
try {
    $response = $controller->index();
    echo "Cart view loaded successfully\n\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n\n";
}

// Test 3: Get cart count
echo "3. Getting cart count...\n";
try {
    $response = $controller->count();
    $data = json_decode($response->getContent(), true);
    echo "Cart count: " . $data['count'] . "\n";
    echo "Total amount: " . $data['total'] . " ر.س\n\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n\n";
}

echo "=== Test Complete ===\n";
