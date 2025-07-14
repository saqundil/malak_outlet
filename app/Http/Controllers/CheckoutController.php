<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
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
        // Get cart items from cookie
        $cart = json_decode(request()->cookie('cart', '[]'), true);
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get();

            foreach ($products as $product) {
                $quantity = $cart[$product->id];
                $price = $product->sale_price ?? $product->price;
                $subtotal = $price * $quantity;
                
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal
                ];
                
                $total += $subtotal;
            }
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card',
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get cart items from cookie
        $cart = json_decode($request->cookie('cart', '[]'), true);
        
        if (empty($cart)) {
            return redirect()->route('cart')
                ->with('error', 'السلة فارغة. يرجى إضافة منتجات قبل إتمام الطلب.');
        }

        try {
            DB::transaction(function () use ($request, $cart) {
                // Get products and calculate totals
                $productIds = array_keys($cart);
                $products = Product::whereIn('id', $productIds)->get();
                
                $subtotal = 0;
                $orderItems = [];

                foreach ($products as $product) {
                    $quantity = $cart[$product->id];
                    $price = $product->sale_price ?? $product->price;
                    $totalPrice = $price * $quantity;
                    
                    $subtotal += $totalPrice;
                    
                    $orderItems[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $price,
                        'quantity' => $quantity,
                        'total_price' => $totalPrice,
                    ];
                }

                // Calculate additional costs
                $shippingCost = 30.00; // Fixed shipping cost
                $taxRate = 0.15; // 15% VAT
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
                    'payment_method' => $request->payment_method === 'cash' ? 'cod' : 'card',
                    'payment_status' => 'pending',
                    'shipping_address' => $request->shipping_address,
                    'phone' => $request->phone,
                    'notes' => $request->notes,
                ]);

                // Create order items
                foreach ($orderItems as $item) {
                    $order->items()->create($item);
                }

                // Store order number in session for success page
                session(['last_order_number' => $order->order_number]);
            });

            // Clear cart and redirect to success
            return redirect()->route('checkout.success')
                ->cookie('cart', json_encode([]), 60 * 24 * 30)
                ->with('success', 'تم إنشاء طلبك بنجاح!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إنشاء الطلب. يرجى المحاولة مرة أخرى.')
                ->withInput();
        }
    }

    public function success()
    {
        $orderNumber = session('last_order_number');
        $order = null;
        
        if ($orderNumber) {
            $order = Auth::user()->orders()
                ->with('items.product')
                ->where('order_number', $orderNumber)
                ->first();
        }
        
        return view('checkout.success', compact('order'));
    }
}
