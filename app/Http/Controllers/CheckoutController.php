<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\JordanCity;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Require authentication for checkout
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
        $totalOriginal = 0;

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

                $price = $product->final_price;
                $originalPrice = $product->price;
                
                if ($size) {
                    $price += $size->additional_price ?? 0;
                    $originalPrice += $size->additional_price ?? 0;
                }

                $itemTotal = $price * $quantity;
                $originalItemTotal = $originalPrice * $quantity;

                $cartItem = [
                    'key' => $cartKey,
                    'product' => $product,
                    'size' => $size,
                    'quantity' => $quantity,
                    'price' => $price,
                    'original_price' => $originalPrice,
                    'total' => $itemTotal
                ];

                $cartItems[] = $cartItem;
                $subtotal += $itemTotal;
                $totalOriginal += $originalItemTotal;
            }
        }

        // Get Jordan cities for delivery
        $cities = JordanCity::active()->orderBy('delivery_cost')->get();
        
        // Calculate totals (delivery cost will be calculated on frontend)
        $total = $subtotal;
        $totalSavings = $totalOriginal - $total;

        return view('checkout.index', compact('cartItems', 'subtotal', 'total', 'totalOriginal', 'totalSavings', 'cities'));
    }

    public function store(Request $request)
    {
        // Debug logging
        Log::info('Checkout store method called', [
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        $request->validate([
            'payment_method' => 'required|in:cash,card',
            'shipping_address' => 'required|string|max:500',
            'jordan_city_id' => 'required|exists:jordan_cities,id',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ], [
            'payment_method.required' => 'يرجى اختيار طريقة الدفع',
            'shipping_address.required' => 'عنوان الشحن مطلوب',
            'jordan_city_id.required' => 'يرجى اختيار المدينة',
            'jordan_city_id.exists' => 'المدينة المختارة غير صحيحة',
            'phone.required' => 'رقم الهاتف مطلوب',
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

                    $price = $product->final_price;
                    if ($size) {
                        $price += $size->additional_price ?? 0;
                    }

                    $totalPrice = $price * $quantity;
                    $subtotal += $totalPrice;
                    
                    $orderItems[] = [
                        'product_id' => $product->id,
                        'price' => $price,
                        'quantity' => $quantity,
                        'size' => $size ? $size->size : null,
                        'total' => $totalPrice,
                    ];
                }

                // Get selected city and calculate delivery cost
                $selectedCity = JordanCity::findOrFail($request->jordan_city_id);
                $shippingCost = $selectedCity->delivery_cost;
                $totalAmount = $subtotal + $shippingCost;

                // Create order
                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'user_id' => Auth::id(),
                    'customer_name' => Auth::user()->name,
                    'customer_email' => Auth::user()->email,
                    'status' => 'pending',
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'tax_amount' => 0.00,
                    'total_amount' => $totalAmount,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending',
                    'shipping_address' => $request->shipping_address,
                    'jordan_city_id' => $selectedCity->id,
                    'city_name' => $selectedCity->name_ar,
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
                ->with('success', 'تم إنشاء الطلب بنجاح!');
                
        } catch (\Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            
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
        // Find order for authenticated user only
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with(['items.product.images'])
            ->first();
            
        if (!$order) {
            return redirect()->route('home')
                ->with('error', 'الطلب غير موجود');
        }
        
        return view('checkout.success', compact('order'));
    }
}
