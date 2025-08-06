<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    private const CART_COOKIE_NAME = 'shopping_cart';
    private const CART_COOKIE_DURATION = 60 * 24 * 30; // 30 days in minutes

    /**
     * Display the cart page
     */
    public function index(): View
    {
        $cart = $this->getCart();
        $cartItems = $this->getCartForCheckout();
        
        $total = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request, $productIdentifier): JsonResponse
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

        $cart = $this->getCart();
        $quantity = (int) $request->input('quantity', 1);
        $size = $request->input('size');
        $color = $request->input('color');

        // Create unique key for cart item (considering variants)
        $cartKey = $this->generateCartKey($product->id, $size, $color);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'size' => $size,
                'color' => $color,
                'added_at' => now()->toISOString()
            ];
        }

        $this->saveCart($cart);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المنتج إلى السلة بنجاح',
            'cart_count' => $this->getCartCount(),
            'product_name' => $product->name
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $productId): JsonResponse
    {
        $cart = $this->getCart();
        $quantity = (int) $request->input('quantity', 1);
        $size = $request->input('size');
        $color = $request->input('color');
        
        $cartKey = $this->generateCartKey($productId, $size, $color);
        
        if (isset($cart[$cartKey])) {
            if ($quantity > 0) {
                $cart[$cartKey]['quantity'] = $quantity;
            } else {
                unset($cart[$cartKey]);
            }
            
            $this->saveCart($cart);
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الكمية بنجاح',
                'cart_count' => $this->getCartCount()
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'المنتج غير موجود في السلة'
        ], 404);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request, $productId): JsonResponse
    {
        $cart = $this->getCart();
        $size = $request->input('size');
        $color = $request->input('color');
        
        $cartKey = $this->generateCartKey($productId, $size, $color);
        
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            $this->saveCart($cart);
            
            return response()->json([
                'success' => true,
                'message' => 'تم حذف المنتج من السلة',
                'cart_count' => $this->getCartCount()
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'المنتج غير موجود في السلة'
        ], 404);
    }

    /**
     * Clear entire cart
     */
    public function clear(): JsonResponse
    {
        $this->saveCart([]);
        
        return response()->json([
            'success' => true,
            'message' => 'تم تفريغ السلة بنجاح'
        ]);
    }

    /**
     * Get cart count
     */
    public function getCount(): JsonResponse
    {
        return response()->json([
            'count' => $this->getCartCount()
        ]);
    }

    /**
     * Get cart items count and total
     */
    public function count(): JsonResponse
    {
        $cart = $this->getCart();
        $count = 0;
        $total = 0;
        
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $count += $item['quantity'];
                $total += $product->price * $item['quantity'];
            }
        }
        
        return response()->json([
            'count' => $count,
            'total' => number_format($total, 2)
        ]);
    }

    /**
     * Get cart from cookies
     */
    private function getCart(): array
    {
        $cartData = request()->cookie(self::CART_COOKIE_NAME);
        
        if (!$cartData) {
            return [];
        }
        
        return json_decode($cartData, true) ?: [];
    }

    /**
     * Save cart to cookies
     */
    private function saveCart(array $cart): void
    {
        $cartJson = json_encode($cart);
        
        cookie()->queue(
            self::CART_COOKIE_NAME,
            $cartJson,
            self::CART_COOKIE_DURATION,
            '/',
            null,
            false,
            false
        );
    }

    /**
     * Get total cart items count
     */
    private function getCartCount(): int
    {
        $cart = $this->getCart();
        
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Generate unique cart key for item variants
     */
    private function generateCartKey($productId, $size = null, $color = null): string
    {
        $key = (string) $productId;
        
        if ($size) {
            $key .= '_size_' . $size;
        }
        
        if ($color) {
            $key .= '_color_' . $color;
        }
        
        return $key;
    }

    /**
     * Get cart items formatted for checkout
     */
    public function getCartForCheckout(): array
    {
        $cart = $this->getCart();
        $cartItems = [];
        
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $cartItems[] = [
                    'product_id' => $item['product_id'],
                    'product' => $product,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'] ?? null,
                    'color' => $item['color'] ?? null,
                    'total' => $product->price * $item['quantity'],
                    'image' => $product->images->first()?->image_path ?? '/images/placeholder.jpg'
                ];
            }
        }
        
        return $cartItems;
    }

    /**
     * Clear cart after successful order
     */
    public function clearAfterOrder(): void
    {
        $this->saveCart([]);
    }
}
