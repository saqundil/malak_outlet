<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;

class TestController extends Controller
{
    public function index()
    {
        $tests = [];
        
        try {
            // Test product count
            $productCount = Product::count();
            $tests['products'] = "✅ Products: {$productCount}";
        } catch (\Exception $e) {
            $tests['products'] = "❌ Products error: " . $e->getMessage();
        }
        
        try {
            // Test categories
            $categoryCount = Category::count();
            $tests['categories'] = "✅ Categories: {$categoryCount}";
        } catch (\Exception $e) {
            $tests['categories'] = "❌ Categories error: " . $e->getMessage();
        }
        
        try {
            // Test brands
            $brandCount = Brand::count();
            $tests['brands'] = "✅ Brands: {$brandCount}";
        } catch (\Exception $e) {
            $tests['brands'] = "❌ Brands error: " . $e->getMessage();
        }
        
        try {
            // Test product images
            $imageCount = ProductImage::count();
            $tests['images'] = "✅ Product Images: {$imageCount}";
        } catch (\Exception $e) {
            $tests['images'] = "❌ Product Images error: " . $e->getMessage();
        }
        
        try {
            // Test featured products
            $featuredCount = Product::where('is_featured', true)->count();
            $tests['featured'] = "✅ Featured Products: {$featuredCount}";
        } catch (\Exception $e) {
            $tests['featured'] = "❌ Featured Products error: " . $e->getMessage();
        }
        
        try {
            // Test products with images
            $productsWithImages = Product::has('images')->count();
            $tests['products_with_images'] = "✅ Products with Images: {$productsWithImages}";
        } catch (\Exception $e) {
            $tests['products_with_images'] = "❌ Products with Images error: " . $e->getMessage();
        }
        
        return response()->json($tests);
    }
}
