<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class DashboardService
{
    /**
     * Get comprehensive dashboard data
     */
    public function getDashboardData(): array
    {
        return [
            'stats' => $this->getStatistics(),
            'recentOrders' => $this->getRecentOrders(5),
            'recentCategories' => $this->getRecentCategories(10),
            'recentBrands' => $this->getRecentBrands(10),
            'monthlyRevenue' => $this->getMonthlyRevenue(),
            'topProducts' => $this->getTopProducts(5),
            'lowStockProducts' => $this->getLowStockProducts(10, 10),
            'recentActivity' => $this->getRecentActivity(10),
        ];
    }

    /**
     * Get comprehensive dashboard statistics
     */
    public function getStatistics(): array
    {
        return [
            'total_products' => $this->getTotalProducts(),
            'active_products' => $this->getActiveProducts(),
            'inactive_products' => $this->getInactiveProducts(),
            'featured_products' => $this->getFeaturedProducts(),
            'total_orders' => $this->getTotalOrders(),
            'pending_orders' => $this->getPendingOrders(),
            'shipping_orders' => $this->getShippingOrders(),
            'completed_orders' => $this->getCompletedOrders(),
            'total_customers' => $this->getTotalCustomers(),
            'total_revenue' => $this->getTotalRevenue(),
            'total_categories' => $this->getTotalCategories(),
            'total_brands' => $this->getTotalBrands(),
            'low_stock_products' => $this->getLowStockCount(),
        ];
    }

    /**
     * Get recent orders with user and items
     */
    public function getRecentOrders(int $limit = 5): Collection
    {
        return Order::with(['user', 'items.product'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent categories with product count
     */
    public function getRecentCategories(int $limit = 10): Collection
    {
        return Category::withCount('products')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent brands with product count
     */
    public function getRecentBrands(int $limit = 10): Collection
    {
        return Brand::withCount('products')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get monthly revenue data for charts
     */
    public function getMonthlyRevenue(int $months = 12): Collection
    {
        return Order::where('status', 'delivered')
            ->where('created_at', '>=', Carbon::now()->subMonths($months))
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    }

    /**
     * Get top selling products
     */
    public function getTopProducts(int $limit = 5): Collection
    {
        return Product::withCount(['orderItems'])
            ->orderBy('order_items_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get low stock products
     */
    public function getLowStockProducts(int $threshold = 10, int $limit = 10): Collection
    {
        return Product::lowStock($threshold)
            ->orderBy('stock_quantity', 'asc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent activity feed
     */
    public function getRecentActivity(int $limit = 10): Collection
    {
        $activities = collect();

        // Recent products
        $recentProducts = Product::latest()->limit($limit / 2)->get();
        foreach ($recentProducts as $product) {
            $activities->push((object) [
                'type' => 'product_added',
                'title' => 'تم إضافة منتج جديد',
                'description' => $product->name,
                'created_at' => $product->created_at,
                'icon' => 'fas fa-plus-circle',
                'color' => 'text-green-600'
            ]);
        }

        // Recent orders
        $recentOrders = Order::latest()->limit($limit / 2)->get();
        foreach ($recentOrders as $order) {
            $activities->push((object) [
                'type' => 'order_placed',
                'title' => 'طلب جديد',
                'description' => "طلب رقم #{$order->id} بقيمة {$order->total_amount} د.أ",
                'created_at' => $order->created_at,
                'icon' => 'fas fa-shopping-cart',
                'color' => 'text-blue-600'
            ]);
        }

        return $activities->sortByDesc('created_at')->take($limit);
    }

    // Private helper methods for statistics
    private function getTotalProducts(): int
    {
        return Product::count();
    }

    private function getActiveProducts(): int
    {
        return Product::active()->count();
    }

    private function getInactiveProducts(): int
    {
        return Product::where('is_active', false)->count();
    }

    private function getFeaturedProducts(): int
    {
        return Product::featured()->count();
    }

    private function getTotalOrders(): int
    {
        return Order::count();
    }

    private function getPendingOrders(): int
    {
        return Order::where('status', 'pending')->count();
    }

    private function getShippingOrders(): int
    {
        return Order::whereIn('status', ['processing', 'shipped'])->count();
    }

    private function getCompletedOrders(): int
    {
        return Order::where('status', 'delivered')->count();
    }

    private function getTotalCustomers(): int
    {
        return User::where('is_admin', false)->count();
    }

    private function getTotalRevenue(): float
    {
        return (float) Order::where('status', 'delivered')->sum('total_amount');
    }

    private function getTotalCategories(): int
    {
        return Category::count();
    }

    private function getTotalBrands(): int
    {
        return Brand::count();
    }

    private function getLowStockCount(int $threshold = 10): int
    {
        return Product::lowStock($threshold)->count();
    }
}
