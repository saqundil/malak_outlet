<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by order ID or customer name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics for the current filters
        $stats = [
            'total_orders' => $query->count(),
            'total_revenue' => $query->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product.images']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update([
            'status' => $request->status,
            'status_updated_at' => now()
        ]);

        // Log status change
        $order->statusChanges()->create([
            'from_status' => $order->getOriginal('status'),
            'to_status' => $request->status,
            'changed_by' => auth()->id(),
            'notes' => $request->notes
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function destroy(Order $order)
    {
        // Only allow deletion of cancelled orders
        if ($order->status !== 'cancelled') {
            return redirect()->back()->with('error', 'لا يمكن حذف الطلب إلا إذا كان ملغياً');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }

    public function bulkAction(Request $request)
    {
        $action = $request->action;
        $orderIds = $request->order_ids;

        if (!$orderIds || !is_array($orderIds)) {
            return response()->json(['error' => 'يرجى اختيار طلبات للعملية'], 400);
        }

        switch ($action) {
            case 'mark_processing':
                Order::whereIn('id', $orderIds)->update([
                    'status' => 'processing',
                    'status_updated_at' => now()
                ]);
                return response()->json(['message' => 'تم تحديث حالة الطلبات إلى قيد المعالجة']);
            
            case 'mark_shipped':
                Order::whereIn('id', $orderIds)->update([
                    'status' => 'shipped',
                    'status_updated_at' => now()
                ]);
                return response()->json(['message' => 'تم تحديث حالة الطلبات إلى تم الشحن']);
            
            case 'mark_delivered':
                Order::whereIn('id', $orderIds)->update([
                    'status' => 'delivered',
                    'status_updated_at' => now()
                ]);
                return response()->json(['message' => 'تم تحديث حالة الطلبات إلى تم التسليم']);
            
            default:
                return response()->json(['error' => 'عملية غير صحيحة'], 400);
        }
    }

    public function generateReport(Request $request)
    {
        $dateFrom = $request->date_from ?? Carbon::now()->startOfMonth();
        $dateTo = $request->date_to ?? Carbon::now()->endOfMonth();

        $orders = Order::with(['user', 'items.product'])
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->get();

        $report = [
            'period' => [
                'from' => $dateFrom,
                'to' => $dateTo
            ],
            'summary' => [
                'total_orders' => $orders->count(),
                'total_revenue' => $orders->sum('total_amount'),
                'average_order_value' => $orders->count() > 0 ? $orders->sum('total_amount') / $orders->count() : 0,
                'status_breakdown' => $orders->groupBy('status')->map->count(),
            ],
            'top_products' => $orders->flatMap->items
                ->groupBy('product_id')
                ->map(function ($items) {
                    return [
                        'product' => $items->first()->product,
                        'quantity_sold' => $items->sum('quantity'),
                        'revenue' => $items->sum('total')
                    ];
                })
                ->sortByDesc('quantity_sold')
                ->take(10)
                ->values(),
            'daily_sales' => $orders->groupBy(function ($order) {
                return $order->created_at->format('Y-m-d');
            })->map(function ($dayOrders) {
                return [
                    'orders_count' => $dayOrders->count(),
                    'revenue' => $dayOrders->sum('total_amount')
                ];
            })
        ];

        return view('admin.orders.report', compact('report'));
    }
}
