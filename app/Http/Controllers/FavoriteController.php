<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $favorites = [];
        
        if (Auth::check()) {
            $favorites = Favorite::where('user_id', Auth::id())
                ->with(['product.brand', 'product.images'])
                ->get();
        }
        
        return view('wishlist', compact('favorites'));
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'product_id' => 'sometimes|exists:products,id'
        ]);

        $productId = $productId ?? $request->product_id;

        // Find product by ID or slug
        if (is_numeric($productId)) {
            $product = Product::find($productId);
        } else {
            $product = Product::where('slug', $productId)->first();
        }

        // Check if product exists
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        // Use the actual product ID for the favorite record
        $actualProductId = $product->id;

        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $actualProductId
        ]);

        $wasRecentlyCreated = $favorite->wasRecentlyCreated;
        
        // Get updated wishlist count
        $wishlistCount = Favorite::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => $wasRecentlyCreated ? 'تم إضافة المنتج لقائمة الأمنيات' : 'المنتج موجود بالفعل في قائمة الأمنيات',
            'added' => $wasRecentlyCreated,
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function destroy($productId)
    {
        // Find product by ID or slug
        if (is_numeric($productId)) {
            $product = Product::find($productId);
        } else {
            $product = Product::where('slug', $productId)->first();
        }

        // Check if product exists
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        // Use the actual product ID for the favorite record
        $actualProductId = $product->id;

        $deleted = Favorite::where('user_id', Auth::id())
            ->where('product_id', $actualProductId)
            ->delete();
            
        // Get updated wishlist count
        $wishlistCount = Favorite::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => $deleted ? 'تم حذف المنتج من قائمة الأمنيات' : 'المنتج غير موجود في قائمة الأمنيات',
            'removed' => $deleted > 0,
            'wishlist_count' => $wishlistCount
        ]);
    }
}
