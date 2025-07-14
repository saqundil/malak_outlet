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

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المنتج لقائمة الأمنيات'
        ]);
    }

    public function destroy(Product $product)
    {
        Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المنتج من قائمة الأمنيات'
        ]);
    }
}
