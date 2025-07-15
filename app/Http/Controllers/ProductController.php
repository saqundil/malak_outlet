<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images']);
        
        // Get all categories and brands for filter options
        $categories = Category::get();
        $brands = Brand::get();
        
        // Apply filters
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        
        if ($request->filled('min_price')) {
            $query->where(function($q) use ($request) {
                $q->where('sale_price', '>=', $request->min_price)
                  ->orWhere(function($q2) use ($request) {
                      $q2->whereNull('sale_price')
                         ->where('price', '>=', $request->min_price);
                  });
            });
        }
        
        if ($request->filled('max_price')) {
            $query->where(function($q) use ($request) {
                $q->where('sale_price', '<=', $request->max_price)
                  ->orWhere(function($q2) use ($request) {
                      $q2->whereNull('sale_price')
                         ->where('price', '<=', $request->max_price);
                  });
            });
        }
        
        if ($request->filled('age')) {
            $query->where('suitable_age', 'like', '%' . $request->age . '%');
        }
        
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }
        
        if ($request->filled('in_stock')) {
            $query->where('stock', true)->where('stock_quantity', '>', 0);
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        switch ($sortBy) {
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->paginate(12)->appends($request->all());
        
        // Get user's wishlist product IDs if authenticated
        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Favorite::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }
        
        return view('products.index', compact('products', 'categories', 'brands', 'wishlistProductIds'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'brand', 'images', 'approvedReviews'])->findOrFail($id);
        $relatedProducts = Product::with(['category', 'brand', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();
        
        // Check if current product is in user's wishlist
        $isInWishlist = false;
        if (Auth::check()) {
            $isInWishlist = Favorite::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
        }
        
        // Get wishlist status for related products
        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Favorite::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }
            
        return view('products.show', compact('product', 'relatedProducts', 'isInWishlist', 'wishlistProductIds'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::with(['category', 'brand', 'images'])
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhereHas('category', function($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  })
                  ->orWhereHas('brand', function($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
            })
            ->paginate(12);
            
        return view('products.search', compact('products', 'query'));
    }

    public function searchSuggestions(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query || strlen($query) < 1) {
            return response()->json([
                'success' => false,
                'suggestions' => []
            ]);
        }

        $suggestions = Product::with(['category', 'brand', 'images'])
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "{$query}%")  // Starts with query (highest priority)
                  ->orWhere('name', 'like', "%{$query}%") // Contains query
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhereHas('category', function($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  })
                  ->orWhereHas('brand', function($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
            })
            ->orderByRaw("CASE 
                WHEN name LIKE '{$query}%' THEN 1 
                WHEN name LIKE '%{$query}%' THEN 2 
                ELSE 3 
            END")
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions
        ]);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::with(['category', 'brand', 'images'])
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->paginate(12);
            
        return view('products.category', compact('products', 'category'));
    }
}
