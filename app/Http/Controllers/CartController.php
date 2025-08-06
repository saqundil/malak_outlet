<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCartFromCookie();
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            foreach ($cart as $cartKey => $cartItem) {
                // Handle old format (backwards compatibility)
                if (is_numeric($cartItem)) {
                    $productId = $cartKey;
                    $quantity = $cartItem;
                    $sizeId = null;
                } else {
                    // New format with size support
                    $productId = $cartItem['product_id'];
                    $quantity = $cartItem['quantity'];
                    $sizeId = $cartItem['size_id'] ?? null;
                }

                $product = Product::find($productId);
                if (!$product) continue;

                $price = $product->sale_price ?? $product->price;
                $size = null;
                
                // Add size price if applicable
                if ($sizeId) {
                    $size = $product->sizes()->find($sizeId);
                    if ($size) {
                        $price += $size->additional_price;
                    }
                }
                
                $subtotal = $price * $quantity;
                
                $cartItems[] = [
                    'cart_key' => $cartKey,
                    'product' => $product,
                    'size' => $size,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal
                ];
                
                $total += $subtotal;
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $productIdentifier)
    {
        // Try to find product by ID first, then by slug
        $product = null;
        if (is_numeric($productIdentifier)) {
            $product = Product::find($productIdentifier);
        }
        
        if (!$product) {
            $product = Product::where('slug', $productIdentifier)->first();
        }
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود'
            ], 404);
        }
        $quantity = $request->input('quantity', 1);
        $sizeId = $request->input('size_id');

        $cart = $this->getCartFromCookie();
        
        // Create unique cart key including size
        $cartKey = $product->id;
        if ($sizeId) {
            $cartKey = $product->id . '_size_' . $sizeId;
        }
        
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'size_id' => $sizeId
            ];
        }

        $this->saveCartToCookie($cart);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المنتج إلى السلة',
            'cart_count' => $this->getCartCount($cart)
        ]);
    }

    public function update(Request $request, $productId)
    {
        $quantity = $request->input('quantity', 1);
        $cartKey = $request->input('cart_key', $productId);
        
        if ($quantity <= 0) {
            return $this->remove($cartKey);
        }

        $cart = $this->getCartFromCookie();
        
        if (isset($cart[$cartKey])) {
            if (is_numeric($cart[$cartKey])) {
                // Old format
                $cart[$cartKey] = $quantity;
            } else {
                // New format
                $cart[$cartKey]['quantity'] = $quantity;
            }
            $this->saveCartToCookie($cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث السلة',
            'cart_count' => $this->getCartCount($cart)
        ]);
    }

    public function remove($cartKey)
    {
        $cart = $this->getCartFromCookie();
        
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            $this->saveCartToCookie($cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المنتج من السلة',
            'cart_count' => $this->getCartCount($cart)
        ]);
    }

    public function clear()
    {
        Cookie::queue(Cookie::forget('cart'));
        
        return response()->json([
            'success' => true,
            'message' => 'تم مسح السلة',
            'cart_count' => 0
        ]);
    }

    public function getCount()
    {
        $cart = $this->getCartFromCookie();
        return response()->json(['count' => $this->getCartCount($cart)]);
    }

    private function getCartFromCookie()
    {
        $cart = Cookie::get('cart');
        return $cart ? json_decode($cart, true) : [];
    }

    private function saveCartToCookie($cart)
    {
        Cookie::queue('cart', json_encode($cart), 60 * 24 * 30); // 30 days
    }

    private function getCartCount($cart)
    {
        $count = 0;
        foreach ($cart as $cartItem) {
            if (is_numeric($cartItem)) {
                // Old format
                $count += $cartItem;
            } else {
                // New format
                $count += $cartItem['quantity'] ?? 0;
            }
        }
        return $count;
    }
}
