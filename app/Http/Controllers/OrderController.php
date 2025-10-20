<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()->orders()
            ->with(['items.product.images'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('orders.index', compact('orders'));
    }

    public function show($orderNumber)
    {
        try {
            $order = Auth::user()->orders()
                ->with(['items.product.images'])
                ->where('order_number', $orderNumber)
                ->firstOrFail();
                
            // If it's an AJAX request, return JSON
            if (request()->expectsJson()) {
                return response()->json($order);
            }
                
            return view('orders.show', compact('order'));
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'error' => 'Order not found',
                    'message' => $e->getMessage()
                ], 404);
            }
            
            abort(404, 'Order not found');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required|in:cod,card',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            // Calculate totals
            $subtotal = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $quantity = $item['quantity'];
                $totalPrice = $product->price * $quantity;
                
                $subtotal += $totalPrice;
                
                $orderItems[] = [
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'size' => null, // Add size logic if needed
                    'total' => $totalPrice,
                ];
            }

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
        });

        return redirect()->route('orders.index')
            ->with('success', 'تم إنشاء الطلب بنجاح');
    }

    public function cancel(Request $request, $orderNumber)
    {
        $order = Auth::user()->orders()->where('order_number', $orderNumber)->firstOrFail();
        
        if (!$order->canBeCancelled()) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن إلغاء هذا الطلب'
            ]);
        }

        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->reason
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إلغاء الطلب بنجاح'
        ]);
    }

    public function update(Request $request, $orderNumber)
    {
        $order = Auth::user()->orders()->where('order_number', $orderNumber)->firstOrFail();
        
        if (!$order->canBeEdited()) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن تعديل هذا الطلب'
            ]);
        }

        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $order->update([
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الطلب بنجاح'
        ]);
    }

    public function track($orderNumber)
    {
        $order = Auth::user()->orders()->where('order_number', $orderNumber)->firstOrFail();
        
        return response()->json([
            'order_number' => $order->order_number,
            'status' => $order->status,
            'status_arabic' => $order->status_arabic,
            'shipped_at' => $order->shipped_at,
            'delivered_at' => $order->delivered_at,
        ]);
    }

    public function downloadInvoice($orderNumber)
    {
        try {
            $order = Auth::user()->orders()
                ->with(['items.product', 'user'])
                ->where('order_number', $orderNumber)
                ->firstOrFail();

            // Generate PDF
            $pdf = Pdf::loadView('orders.invoice', compact('order'));
            
            // Set paper size and orientation
            $pdf->setPaper('A4', 'portrait');
            
            // Return PDF download
            return $pdf->download('invoice-' . $order->order_number . '.pdf');
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Invoice generation failed: ' . $e->getMessage());
            
            // Return a user-friendly error
            return back()->with('error', 'حدث خطأ في إنشاء الفاتورة. يرجى المحاولة مرة أخرى.');
        }
    }

    public function reorder($orderNumber)
    {
        $order = Auth::user()->orders()
            ->with('items.product')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Add items back to cart (assuming you have a cart system)
        // For now, we'll just return success
        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المنتجات إلى السلة بنجاح',
            'items' => $order->items
        ]);
    }

    /**
     * Display detailed items and pricing breakdown for a specific order
     */
    public function itemsDetails($orderNumber)
    {
        $order = Auth::user()->orders()
            ->with(['items.product.images', 'items.product.category', 'user'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Calculate detailed pricing breakdown
        $subtotal = $order->items->sum('total');
        $itemsCount = $order->items->sum('quantity');
        
        // Get tax rate and shipping cost from order or calculate
        $taxRate = 0.14; // 14% tax rate (adjust based on your needs)
        $taxAmount = $order->tax_amount ?? ($subtotal * $taxRate);
        $shippingCost = $order->shipping_cost ?? 15.00; // Default shipping cost
        
        $pricingBreakdown = [
            'subtotal' => $subtotal,
            'items_count' => $itemsCount,
            'tax_rate' => $taxRate * 100,
            'tax_amount' => $taxAmount,
            'shipping_cost' => $shippingCost,
            'total' => $subtotal + $taxAmount + $shippingCost
        ];

        return view('orders.items', compact('order', 'pricingBreakdown'));
    }
}
