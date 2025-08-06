<?php
// Test the updated CartController add method with the slug
require_once 'vendor/autoload.php';

// Set up Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;

// Create a mock request with the slug
$request = new Request();
$request->merge([
    'quantity' => 1,
    'size' => null,
    'color' => null
]);

// Create controller instance
$controller = new CartController();

try {
    // Test with the slug that was causing issues
    $response = $controller->add($request, 'lego-city-big-set');
    echo "Response status: " . $response->getStatusCode() . "\n";
    echo "Response content: " . $response->getContent() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Type: " . get_class($e) . "\n";
}
