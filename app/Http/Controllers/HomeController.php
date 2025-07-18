<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products (temporarily remove is_active filter for debugging)
        $featuredProducts = Product::where('is_featured', true)
            ->with(['category', 'brand', 'images', 'sizes'])
            ->limit(8)
            ->get();

        // If no featured products, get any products
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with(['category', 'brand', 'images', 'sizes'])
                ->limit(8)
                ->get();
        }

        // Get active categories
        $categories = Category::limit(8)->get();

        // Get latest products (New Arrivals)
        $latestProducts = Product::with(['category', 'brand', 'images', 'sizes'])
            ->latest()
            ->limit(10)
            ->get();

        // Get popular/best selling products
        $popularProducts = Product::with(['category', 'brand', 'images', 'sizes'])
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(8)
            ->get();

        // If no popular products based on orders, get random products
        if ($popularProducts->isEmpty()) {
            $popularProducts = Product::with(['category', 'brand', 'images', 'sizes'])
                ->inRandomOrder()
                ->limit(8)
                ->get();
        }

        // Get sale products
        $saleProducts = Product::whereNotNull('sale_price')
            ->where('sale_price', '<', DB::raw('price'))
            ->with(['category', 'brand', 'images', 'sizes'])
            ->limit(8)
            ->get();

        // If no sale products, create some mock sale data
        if ($saleProducts->isEmpty()) {
            $saleProducts = Product::with(['category', 'brand', 'images', 'sizes'])
                ->limit(8)
                ->get()
                ->map(function ($product) {
                    // Create a mock sale price that's 20-50% off
                    $discountPercentage = rand(20, 50) / 100;
                    $product->sale_price = $product->price * (1 - $discountPercentage);
                    return $product;
                });
        }

        // Get user's wishlist product IDs if authenticated
        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Favorite::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        return view('home', compact(
            'featuredProducts', 
            'categories', 
            'latestProducts', 
            'popularProducts',
            'saleProducts', 
            'wishlistProductIds'
        ));
    }
}
