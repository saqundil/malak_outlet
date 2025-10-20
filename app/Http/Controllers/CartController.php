<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCartFromCookie();
        $cartItems = [];
        $total = 0;
        $totalOriginal = 0;
        $totalSavings = 0;

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

                // Use the final_price attribute which includes discount calculations
                $price = $product->final_price;
                $originalPrice = $product->price;
                $size = null;
                
                // Add size price if applicable
                if ($sizeId) {
                    $size = $product->sizes()->find($sizeId);
                    if ($size) {
                        $price += $size->additional_price;
                        $originalPrice += $size->additional_price;
                    }
                }
                
                $subtotal = $price * $quantity;
                $originalSubtotal = $originalPrice * $quantity;
                
                $cartItems[] = [
                    'cart_key' => $cartKey,
                    'product' => $product,
                    'size' => $size,
                    'quantity' => $quantity,
                    'price' => $price,
                    'original_price' => $originalPrice,
                    'subtotal' => $subtotal,
                    'original_subtotal' => $originalSubtotal
                ];
                
                $total += $subtotal;
                $totalOriginal += $originalSubtotal;
            }
        }

        $totalSavings = $totalOriginal - $total;

        return view('cart.index', compact('cartItems', 'total', 'totalOriginal', 'totalSavings'));
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

        // Validate product availability
        if (!$product->is_active || $product->is_deleted) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير متاح حالياً'
            ], 400);
        }

        // Validate size availability if size is selected
        if ($sizeId) {
            $size = ProductSize::find($sizeId);
            if (!$size) {
                return response()->json([
                    'success' => false,
                    'message' => 'المقاس المختار غير موجود'
                ], 400);
            }

            if (!$size->is_available) {
                return response()->json([
                    'success' => false,
                    'message' => 'المقاس المختار غير متاح حالياً'
                ], 400);
            }

            if ($size->stock_quantity < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "المقاس المختار متاح بكمية أقل. الكمية المتاحة: {$size->stock_quantity}"
                ], 400);
            }
        } else {
            // Check general product stock for non-sized products
            if ($product->quantity < $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "المنتج متاح بكمية أقل. الكمية المتاحة: {$product->quantity}"
                ], 400);
            }
        }

        $cart = $this->getCartFromCookie();
        
        // Create unique cart key including size
        $cartKey = $product->id;
        if ($sizeId) {
            $cartKey = $product->id . '_size_' . $sizeId;
        }

        // Check existing quantity in cart to validate total availability
        $existingQuantity = 0;
        if (isset($cart[$cartKey])) {
            $existingQuantity = is_numeric($cart[$cartKey]) ? $cart[$cartKey] : $cart[$cartKey]['quantity'];
        }
        
        $totalRequestedQuantity = $existingQuantity + $quantity;
        
        // Re-validate with existing cart quantity
        if ($sizeId) {
            $size = ProductSize::find($sizeId);
            if ($size->stock_quantity < $totalRequestedQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => "إجمالي الكمية المطلوبة ({$totalRequestedQuantity}) تتجاوز المتاح ({$size->stock_quantity}). في السلة حالياً: {$existingQuantity}"
                ], 400);
            }
        } else {
            if ($product->quantity < $totalRequestedQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => "إجمالي الكمية المطلوبة ({$totalRequestedQuantity}) تتجاوز المتاح ({$product->quantity}). في السلة حالياً: {$existingQuantity}"
                ], 400);
            }
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
        // Handle both JSON and form data
        if ($request->isJson()) {
            $data = $request->json()->all();
            $quantity = $data['quantity'] ?? 1;
            $cartKey = $data['cart_key'] ?? $productId;
        } else {
            $quantity = $request->input('quantity', 1);
            $cartKey = $request->input('cart_key', $productId);
        }
        
        if ($quantity <= 0) {
            return $this->remove($request, $cartKey);
        }

        $cart = $this->getCartFromCookie();
        
        if (isset($cart[$cartKey])) {
            // Get cart item details for validation
            $cartItem = $cart[$cartKey];
            $productId = is_numeric($cartItem) ? $cartKey : $cartItem['product_id'];
            $sizeId = is_numeric($cartItem) ? null : ($cartItem['size_id'] ?? null);
            
            // Find product and validate availability
            $product = Product::find($productId);
            if (!$product || !$product->is_active || $product->is_deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير متاح حالياً'
                ], 400);
            }
            
            // Validate size availability if applicable
            if ($sizeId) {
                $size = ProductSize::find($sizeId);
                if (!$size || !$size->is_available) {
                    return response()->json([
                        'success' => false,
                        'message' => 'المقاس المختار غير متاح حالياً'
                    ], 400);
                }
                
                if ($size->stock_quantity < $quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "الكمية المطلوبة ({$quantity}) تتجاوز المتاح ({$size->stock_quantity})"
                    ], 400);
                }
            } else {
                // Check general product stock
                if ($product->quantity < $quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "الكمية المطلوبة ({$quantity}) تتجاوز المتاح ({$product->quantity})"
                    ], 400);
                }
            }
            
            // Update cart item
            if (is_numeric($cart[$cartKey])) {
                // Old format
                $cart[$cartKey] = $quantity;
            } else {
                // New format
                $cart[$cartKey]['quantity'] = $quantity;
            }
            $this->saveCartToCookie($cart);
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث السلة',
                'cart_count' => $this->getCartCount($cart)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'المنتج غير موجود في السلة'
        ], 404);
    }

    public function remove(Request $request, $cartKey)
    {
        $cart = $this->getCartFromCookie();
        
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            $this->saveCartToCookie($cart);
            
            return response()->json([
                'success' => true,
                'message' => 'تم حذف المنتج من السلة',
                'cart_count' => $this->getCartCount($cart)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'المنتج غير موجود في السلة'
        ], 404);
    }

    public function clear()
    {
        try {
            Cookie::queue(Cookie::forget('cart'));
            
            return response()->json([
                'success' => true,
                'message' => 'تم مسح السلة',
                'cart_count' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء مسح السلة'
            ], 500);
        }
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
