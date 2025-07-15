<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products (temporarily remove is_active filter for debugging)
        $featuredProducts = Product::where('is_featured', true)
            ->with(['category', 'brand', 'images'])
            ->limit(8)
            ->get();

        // If no featured products, get any products
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with(['category', 'brand', 'images'])
                ->limit(8)
                ->get();
        }

        // Get active categories
        $categories = Category::limit(8)->get();

        // Get latest products
        $latestProducts = Product::with(['category', 'brand', 'images'])
            ->latest()
            ->limit(4)
            ->get();

        // Get sale products
        $saleProducts = Product::whereNotNull('sale_price')
            ->with(['category', 'brand', 'images'])
            ->limit(4)
            ->get();

        // Get user's wishlist product IDs if authenticated
        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Favorite::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        return view('home', compact('featuredProducts', 'categories', 'latestProducts', 'saleProducts', 'wishlistProductIds'));
    }
}
