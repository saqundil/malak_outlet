<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JordanCity;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class CitiesController extends Controller
{
    /**
     * Display a listing of the Jordanian cities.
     */
    public function index(Request $request): View
    {
        $query = JordanCity::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->active();
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sort
        $sortBy = $request->get('sort_by', 'name_ar');
        $sortDir = $request->get('sort_dir', 'asc');
        
        if (in_array($sortBy, ['name_ar', 'name_en', 'delivery_cost', 'delivery_days', 'created_at'])) {
            $query->orderBy($sortBy, $sortDir);
        }

        $cities = $query->withCount('orders')->paginate(15);

        // Statistics
        $stats = [
            'total_cities' => JordanCity::count(),
            'active_cities' => JordanCity::active()->count(),
            'total_orders' => Order::whereNotNull('jordan_city_id')->count(),
            'total_delivery_revenue' => Order::whereNotNull('jordan_city_id')->sum('shipping_cost'),
        ];

        return view('admin.cities.index', compact('cities', 'stats'));
    }

    /**
     * Show the form for creating a new city.
     */
    public function create(): View
    {
        return view('admin.cities.create');
    }

    /**
     * Store a newly created city in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jordan_cities,name_ar',
            'name_en' => 'required|string|max:255|unique:jordan_cities,name_en',
            'delivery_cost' => 'required|numeric|min:0|max:999.99',
            'delivery_days' => 'required|integer|min:1|max:30',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم المدينة مطلوب',
            'name.unique' => 'اسم المدينة موجود مسبقاً',
            'name_en.required' => 'الاسم الإنجليزي مطلوب',
            'name_en.unique' => 'الاسم الإنجليزي موجود مسبقاً',
            'delivery_cost.required' => 'تكلفة التوصيل مطلوبة',
            'delivery_cost.numeric' => 'تكلفة التوصيل يجب أن تكون رقماً',
            'delivery_days.required' => 'أيام التوصيل مطلوبة',
            'delivery_days.integer' => 'أيام التوصيل يجب أن تكون رقماً صحيحاً',
        ]);

        JordanCity::create([
            'name_ar' => $request->name,
            'name_en' => $request->name_en,
            'delivery_cost' => $request->delivery_cost,
            'delivery_days' => $request->delivery_days,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.cities.index')
            ->with('success', 'تم إضافة المدينة بنجاح');
    }

    /**
     * Display the specified city.
     */
    public function show(JordanCity $city): View
    {
        $city->load(['orders' => function($query) {
            $query->latest()->limit(10);
        }]);

        $stats = [
            'total_orders' => $city->orders()->count(),
            'pending_orders' => $city->orders()->where('status', 'pending')->count(),
            'completed_orders' => $city->orders()->where('status', 'delivered')->count(),
            'total_revenue' => $city->orders()->where('status', 'delivered')->sum('total_amount'),
            'delivery_revenue' => $city->orders()->sum('shipping_cost'),
        ];

        return view('admin.cities.show', compact('city', 'stats'));
    }

    /**
     * Show the form for editing the specified city.
     */
    public function edit(JordanCity $city): View
    {
        return view('admin.cities.edit', compact('city'));
    }

    /**
     * Update the specified city in storage.
     */
    public function update(Request $request, JordanCity $city): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jordan_cities,name_ar,' . $city->id,
            'name_en' => 'nullable|string|max:255|unique:jordan_cities,name_en,' . $city->id,
            'delivery_cost' => 'required|numeric|min:0|max:999.99',
            'delivery_days' => 'required|integer|min:1|max:30',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم المدينة مطلوب',
            'name.unique' => 'اسم المدينة موجود مسبقاً',
            'name_en.unique' => 'الاسم الإنجليزي موجود مسبقاً',
            'delivery_cost.required' => 'تكلفة التوصيل مطلوبة',
            'delivery_cost.numeric' => 'تكلفة التوصيل يجب أن تكون رقماً',
            'delivery_days.required' => 'أيام التوصيل مطلوبة',
            'delivery_days.integer' => 'أيام التوصيل يجب أن تكون رقماً صحيحاً',
        ]);

        $city->update([
            'name_ar' => $request->name,
            'name_en' => $request->name_en,
            'delivery_cost' => $request->delivery_cost,
            'delivery_days' => $request->delivery_days,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.cities.index')
            ->with('success', 'تم تحديث المدينة بنجاح');
    }

    /**
     * Remove the specified city from storage.
     */
    public function destroy(JordanCity $city): RedirectResponse
    {
        // Check if city has orders
        if ($city->orders()->count() > 0) {
            return redirect()->route('admin.cities.index')
                ->with('error', 'لا يمكن حذف المدينة لأنها مرتبطة بطلبات');
        }

        $city->delete();

        return redirect()->route('admin.cities.index')
            ->with('success', 'تم حذف المدينة بنجاح');
    }

    /**
     * Toggle city status
     */
    public function toggleStatus(JordanCity $city): JsonResponse
    {
        $city->update(['is_active' => !$city->is_active]);

        return response()->json([
            'success' => true,
            'status' => $city->is_active,
            'message' => $city->is_active ? 'تم تفعيل المدينة' : 'تم إلغاء تفعيل المدينة'
        ]);
    }

    /**
     * Bulk actions for cities
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'cities' => 'required|array',
            'cities.*' => 'exists:jordan_cities,id'
        ]);

        $cities = JordanCity::whereIn('id', $request->cities);
        $count = $cities->count();

        switch ($request->action) {
            case 'activate':
                $cities->update(['is_active' => true]);
                $message = "تم تفعيل {$count} مدينة بنجاح";
                break;

            case 'deactivate':
                $cities->update(['is_active' => false]);
                $message = "تم إلغاء تفعيل {$count} مدينة بنجاح";
                break;

            case 'delete':
                // Check if any city has orders
                $citiesWithOrders = $cities->whereHas('orders')->count();
                if ($citiesWithOrders > 0) {
                    return response()->json([
                        'success' => false,
                        'message' => "لا يمكن حذف {$citiesWithOrders} مدينة لأنها مرتبطة بطلبات"
                    ]);
                }
                
                $cities->delete();
                $message = "تم حذف {$count} مدينة بنجاح";
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Show orders for a specific city
     */
    public function orders(JordanCity $city, Request $request): View
    {
        $query = $city->orders()->with(['user']);

        // Apply filters
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->get('order_number') . '%');
        }

        if ($request->filled('customer_name')) {
            $customerName = $request->get('customer_name');
            $query->whereHas('user', function($q) use ($customerName) {
                $q->where('name', 'like', '%' . $customerName . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->get('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->get('to_date'));
        }

        $orders = $query->latest()->paginate(20);

        // Calculate statistics
        $totalRevenue = $city->orders()->where('status', 'delivered')->sum('total_amount');
        $deliveryRevenue = $city->orders()->sum('shipping_cost');
        $avgOrderValue = $city->orders()->count() > 0 ? 
            $city->orders()->sum('total_amount') / $city->orders()->count() : 0;

        return view('admin.cities.orders', compact('city', 'orders', 'totalRevenue', 'deliveryRevenue', 'avgOrderValue'));
    }
}