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

        // Check if product exists
        if (!Product::find($productId)) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $productId
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
        // Check if product exists
        if (!Product::find($productId)) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }

        $deleted = Favorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
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
