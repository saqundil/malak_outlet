<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING PRODUCT CONTROLLER SHOW METHOD ===\n";

try {
    $controller = new \App\Http\Controllers\ProductController();
    
    // Create a mock request
    $request = \Illuminate\Http\Request::create('/products/lego-city-big-set', 'GET');
    $app->instance('request', $request);
    
    echo "Attempting to call show method with slug: 'lego-city-big-set'\n";
    
    $result = $controller->show('lego-city-big-set');
    echo "SUCCESS: Product page loaded successfully!\n";
    
} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    echo "ERROR: Product not found - " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
