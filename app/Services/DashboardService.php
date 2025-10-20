<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Discount;
use App\Models\ProductReview;
use App\Models\Favorite;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\ProductAttribute;
use App\Models\AttributeValue;
use App\Models\JordanCity;
use App\Models\OrderItem;
use App\Models\DiscountProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class DashboardService
{
    /**
     * Get comprehensive dashboard data with caching
     */
    public function getDashboardData(): array
    {
        return Cache::remember('dashboard_data', 300, function () {
            return [
                'stats' => $this->getStatistics(),
                'recentOrders' => $this->getRecentOrders(5),
                'recentCategories' => $this->getRecentCategories(10),
                'recentBrands' => $this->getRecentBrands(10),
                'recentDiscounts' => $this->getRecentDiscounts(5),
                'monthlyRevenue' => $this->getMonthlyRevenue(),
                'topProducts' => $this->getTopProducts(5),
                'discountedProducts' => $this->getDiscountedProducts(5),
                'lowStockProducts' => $this->getLowStockProducts(10, 10),
                'recentActivity' => $this->getRecentActivity(10),
                'salesTrends' => $this->getSalesTrends(),
                'orderStatusDistribution' => $this->getOrderStatusDistribution(),
                'topCategories' => $this->getTopCategories(5),
                'recentReviews' => $this->getRecentReviews(5),
                'recentFavorites' => $this->getRecentFavorites(5),
                'popularSizes' => $this->getPopularSizes(5),
                'recentProductImages' => $this->getRecentProductImages(5),
                'recentAttributes' => $this->getRecentAttributes(5),
            ];
        });
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
            'total_discounts' => $this->getTotalDiscounts(),
            'active_discounts' => $this->getActiveDiscounts(),
            'low_stock_products' => $this->getLowStockCount(),
            // New statistics for all tables
            'total_reviews' => $this->getTotalReviews(),
            'approved_reviews' => $this->getApprovedReviews(),
            'pending_reviews' => $this->getPendingReviews(),
            'total_favorites' => $this->getTotalFavorites(),
            'total_product_images' => $this->getTotalProductImages(),
            'total_product_sizes' => $this->getTotalProductSizes(),
            'total_product_attributes' => $this->getTotalProductAttributes(),
            'total_attribute_values' => $this->getTotalAttributeValues(),
            'total_jordan_cities' => $this->getTotalJordanCities(),
            'total_order_items' => $this->getTotalOrderItems(),
            'total_discount_products' => $this->getTotalDiscountProducts(),
            'average_order_value' => $this->getAverageOrderValue(),
            'popular_cities' => $this->getPopularCities(),
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
            ->orderBy('quantity', 'asc')
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
        $recentProducts = Product::latest()->limit($limit / 3)->get();
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
        $recentOrders = Order::latest()->limit($limit / 3)->get();
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

        // Recent discounts
        $recentDiscounts = Discount::where('is_deleted', false)->latest()->limit($limit / 3)->get();
        foreach ($recentDiscounts as $discount) {
            $activities->push((object) [
                'type' => 'discount_added',
                'title' => 'تم إضافة خصم جديد',
                'description' => $discount->name,
                'created_at' => $discount->created_at,
                'icon' => 'fas fa-percentage',
                'color' => 'text-purple-600'
            ]);
        }

        return $activities->sortByDesc('created_at')->take($limit);
    }

    /**
     * Get recent discounts with product/category counts
     */
    public function getRecentDiscounts(int $limit = 5): Collection
    {
        return Discount::with(['products', 'categories'])
            ->where('is_deleted', false)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get products with active discounts
     */
    public function getDiscountedProducts(int $limit = 5): Collection
    {
        return Product::with(['discounts' => function($query) {
                $query->where('discounts.is_active', true)
                      ->where('discounts.is_deleted', false);
            }])
            ->whereHas('discounts', function($query) {
                $query->where('discounts.is_active', true)
                      ->where('discounts.is_deleted', false);
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
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

    private function getTotalDiscounts(): int
    {
        return Discount::where('is_deleted', false)->count();
    }

    private function getActiveDiscounts(): int
    {
        return Discount::where('is_active', true)
                      ->where('is_deleted', false)
                      ->count();
    }

    private function getLowStockCount(int $threshold = 10): int
    {
        return Product::lowStock($threshold)->count();
    }

    // New methods for additional statistics
    private function getTotalReviews(): int
    {
        return ProductReview::count();
    }

    private function getApprovedReviews(): int
    {
        return ProductReview::where('is_approved', true)->count();
    }

    private function getPendingReviews(): int
    {
        return ProductReview::where('is_approved', false)->count();
    }

    private function getTotalFavorites(): int
    {
        return Favorite::count();
    }

    private function getTotalProductImages(): int
    {
        return ProductImage::count();
    }

    private function getTotalProductSizes(): int
    {
        return ProductSize::count();
    }

    private function getTotalProductAttributes(): int
    {
        return ProductAttribute::count();
    }

    private function getTotalAttributeValues(): int
    {
        return AttributeValue::count();
    }

    private function getTotalJordanCities(): int
    {
        return JordanCity::count();
    }

    private function getTotalOrderItems(): int
    {
        return OrderItem::count();
    }

    private function getTotalDiscountProducts(): int
    {
        return DiscountProduct::count();
    }

    private function getAverageOrderValue(): float
    {
        return (float) Order::where('status', 'delivered')->avg('total_amount') ?? 0;
    }

    private function getPopularCities(): Collection
    {
        return Order::select('city_name', DB::raw('count(*) as orders_count'))
            ->whereNotNull('city_name')
            ->groupBy('city_name')
            ->orderBy('orders_count', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Get recent reviews with product and user info
     */
    public function getRecentReviews(int $limit = 5): Collection
    {
        return ProductReview::with(['product', 'user'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent favorites with product and user info
     */
    public function getRecentFavorites(int $limit = 5): Collection
    {
        return Favorite::with(['product', 'user'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get popular product sizes
     */
    public function getPopularSizes(int $limit = 5): Collection
    {
        return ProductSize::select('size', DB::raw('SUM(stock_quantity) as total_stock'))
            ->where('is_available', true)
            ->where('is_deleted', false)
            ->groupBy('size')
            ->orderBy('total_stock', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent product images
     */
    public function getRecentProductImages(int $limit = 5): Collection
    {
        return ProductImage::with('product')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent product attributes
     */
    public function getRecentAttributes(int $limit = 5): Collection
    {
        return ProductAttribute::with(['product'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get sales trends for the last 7 days
     */
    public function getSalesTrends(): Collection
    {
        return Order::where('status', 'delivered')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * Get order status distribution for pie chart
     */
    public function getOrderStatusDistribution(): Collection
    {
        return Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
    }

    /**
     * Get top categories by product count
     */
    public function getTopCategories(int $limit = 5): Collection
    {
        return Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Clear dashboard cache
     */
    public function clearCache(): void
    {
        Cache::forget('dashboard_data');
        Cache::forget('dashboard_stats');
    }

    /**
     * Get real-time stats for AJAX updates
     */
    public function getRealtimeStats(): array
    {
        return Cache::remember('dashboard_stats', 60, function () {
            return [
                'total_orders_today' => Order::whereDate('created_at', Carbon::today())->count(),
                'revenue_today' => Order::where('status', 'delivered')
                    ->whereDate('created_at', Carbon::today())
                    ->sum('total_amount'),
                'new_customers_today' => User::where('is_admin', false)
                    ->whereDate('created_at', Carbon::today())
                    ->count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
            ];
        });
    }
}
