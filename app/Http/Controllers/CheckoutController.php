<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = $this->getCartFromCookie();
        
        if (empty($cart)) {
            return redirect()->route('cart')
                ->with('error', 'السلة فارغة. يرجى إضافة منتجات قبل إتمام الطلب.');
        }

        $cartItems = [];
        $subtotal = 0;

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

            $product = Product::with(['images', 'brand'])->find($productId);
            
            if ($product) {
                $size = null;
                if ($sizeId) {
                    $size = ProductSize::find($sizeId);
                }

                $price = $product->sale_price ?? $product->price;
                if ($size) {
                    $price += $size->additional_price ?? 0;
                }

                $itemTotal = $price * $quantity;

                $cartItem = [
                    'key' => $cartKey,
                    'product' => $product,
                    'size' => $size,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $itemTotal
                ];

                $cartItems[] = $cartItem;
                $subtotal += $itemTotal;
            }
        }

        // Calculate additional costs
        $shippingCost = 30.00; // Fixed shipping cost
        $taxRate = 0.16; // 16% VAT (Jordan rate)
        $taxAmount = $subtotal * $taxRate;
        $total = $subtotal + $shippingCost + $taxAmount;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'taxAmount', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card',
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = $this->getCartFromCookie();
        
        if (empty($cart)) {
            return redirect()->route('cart')
                ->with('error', 'السلة فارغة. يرجى إضافة منتجات قبل إتمام الطلب.');
        }

        try {
            $order = DB::transaction(function () use ($request, $cart) {
                $subtotal = 0;
                $orderItems = [];

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

                    $product = Product::findOrFail($productId);
                    
                    // Check if product is still available
                    if (!$product->is_active || $product->is_deleted) {
                        throw new \Exception("المنتج {$product->name} غير متاح حالياً");
                    }

                    $size = null;
                    if ($sizeId) {
                        $size = ProductSize::findOrFail($sizeId);
                        if (!$size->is_available || $size->stock_quantity < $quantity) {
                            throw new \Exception("المقاس المطلوب للمنتج {$product->name} غير متاح بالكمية المطلوبة");
                        }
                    }

                    $price = $product->sale_price ?? $product->price;
                    if ($size) {
                        $price += $size->additional_price ?? 0;
                    }

                    $totalPrice = $price * $quantity;
                    $subtotal += $totalPrice;
                    
                    $orderItems[] = [
                        'product_id' => $product->id,
                        'product_size_id' => $sizeId,
                        'product_name' => $product->name,
                        'product_size_name' => $size ? $size->size : null,
                        'product_price' => $price,
                        'quantity' => $quantity,
                        'total_price' => $totalPrice,
                    ];
                }

                // Calculate additional costs
                $shippingCost = 30.00;
                $taxRate = 0.16;
                $taxAmount = $subtotal * $taxRate;
                $totalAmount = $subtotal + $shippingCost + $taxAmount;

                // Create order
                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'user_id' => Auth::id(),
                    'status' => 'pending',
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'tax_amount' => $taxAmount,
                    'total_amount' => $totalAmount,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending',
                    'shipping_address' => $request->shipping_address,
                    'phone' => $request->phone,
                    'notes' => $request->notes,
                ]);

                // Create order items
                foreach ($orderItems as $item) {
                    $order->items()->create($item);
                }

                // Update stock for sized products
                foreach ($cart as $item) {
                    if (isset($item['size_id'])) {
                        $size = ProductSize::find($item['size_id']);
                        if ($size) {
                            $size->decrement('stock_quantity', $item['quantity']);
                        }
                    }
                }

                return $order;
            });

            // Clear cart after successful order
            Cookie::queue(Cookie::forget('cart'));

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'تم إنشاء الطلب بنجاح!');        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إنشاء الطلب: ' . $e->getMessage());
        }
    }

    private function getCartFromCookie()
    {
        $cart = Cookie::get('cart');
        return $cart ? json_decode($cart, true) : [];
    }

    public function success($orderNumber)
    {
        $order = Auth::user()->orders()
            ->where('order_number', $orderNumber)
            ->with('items.product')
            ->first();
            
        if (!$order) {
            return redirect()->route('home')
                ->with('error', 'الطلب غير موجود');
        }
        
        return view('checkout.success', compact('order'));
    }
}
