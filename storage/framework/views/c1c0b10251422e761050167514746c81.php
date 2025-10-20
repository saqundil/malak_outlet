

<?php $__env->startSection('title', 'لوحة التحكم الشاملة'); ?>
<?php $__env->startSection('page-title', 'لوحة التحكم الشاملة'); ?>
<?php $__env->startSection('page-description', 'نظرة شاملة على جميع بيانات المتجر والإحصائيات التفصيلية'); ?>

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css" rel="stylesheet">
<style>
    .dashboard-card {
        transition: all 0.3s ease;
        border-radius: 16px;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
    }
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-color: #cbd5e0;
    }
    .stat-icon {
        background: linear-gradient(135deg, var(--icon-color-1), var(--icon-color-2));
        color: white;
        border-radius: 12px;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .stat-number {
        font-size: 2.25rem;
        font-weight: 800;
        line-height: 1;
        color: #1a202c;
    }
    .progress-bar {
        height: 8px;
        border-radius: 4px;
        background-color: #e2e8f0;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 1s ease-in-out;
        background: linear-gradient(90deg, var(--progress-color-1), var(--progress-color-2));
    }
    .quick-action {
        transition: all 0.2s ease;
        border-radius: 12px;
        padding: 16px;
        background: linear-gradient(135deg, var(--action-color-1), var(--action-color-2));
        color: white;
        text-decoration: none;
        display: block;
    }
    .quick-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        color: white;
        text-decoration: none;
    }
    .table-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        text-align: center;
        font-weight: bold;
        font-size: 18px;
    }
    .table-content {
        padding: 20px;
    }
    .mini-stat {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }
    .mini-stat:hover {
        background: #e2e8f0;
        transform: scale(1.02);
    }
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    .realtime-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    .activity-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        background: #fafafa;
        transition: all 0.2s ease;
    }
    .activity-item:hover {
        background: #f0f0f0;
        transform: translateX(4px);
    }
    .section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 16px 24px;
        margin: -24px -24px 24px -24px;
        border-radius: 16px 16px 0 0;
        font-weight: bold;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: between;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Real-time Status Header -->
    <div class="dashboard-card p-6 border-r-4 border-green-500">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="realtime-dot"></div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">النظام متصل ونشط</h3>
                    <p class="text-sm text-gray-600">آخر تحديث: <span id="last-update">الآن</span></p>
                </div>
            </div>
            <button onclick="refreshAllData()" class="quick-action text-sm" style="--action-color-1: #3b82f6; --action-color-2: #1d4ed8;">
                <i class="fas fa-sync-alt mr-2"></i>تحديث جميع البيانات
            </button>
        </div>
    </div>

    <!-- Main Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Products Stats -->
        <div class="dashboard-card p-6" style="--icon-color-1: #3b82f6; --icon-color-2: #1e40af;">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="text-left">
                    <p class="text-sm font-medium text-gray-600">إجمالي المنتجات</p>
                    <p class="stat-number"><?php echo e(number_format($stats['total_products'])); ?></p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">نشط</span>
                    <span class="font-bold text-green-600"><?php echo e($stats['active_products']); ?></span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="--progress-color-1: #10b981; --progress-color-2: #059669; width: <?php echo e($stats['total_products'] > 0 ? ($stats['active_products'] / $stats['total_products']) * 100 : 0); ?>%;"></div>
                </div>
            </div>
        </div>

        <!-- Orders Stats -->
        <div class="dashboard-card p-6" style="--icon-color-1: #10b981; --icon-color-2: #059669;">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="text-left">
                    <p class="text-sm font-medium text-gray-600">إجمالي الطلبات</p>
                    <p class="stat-number"><?php echo e(number_format($stats['total_orders'])); ?></p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">معلق</span>
                    <span class="font-bold text-orange-600"><?php echo e($stats['pending_orders']); ?></span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="--progress-color-1: #f59e0b; --progress-color-2: #d97706; width: <?php echo e($stats['total_orders'] > 0 ? ($stats['pending_orders'] / $stats['total_orders']) * 100 : 0); ?>%;"></div>
                </div>
            </div>
        </div>

        <!-- Revenue Stats -->
        <div class="dashboard-card p-6" style="--icon-color-1: #f59e0b; --icon-color-2: #d97706;">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="text-left">
                    <p class="text-sm font-medium text-gray-600">إجمالي المبيعات</p>
                    <p class="stat-number"><?php echo e(number_format($stats['total_revenue'], 2)); ?></p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">متوسط الطلب</span>
                    <span class="font-bold text-blue-600"><?php echo e(number_format($stats['average_order_value'], 2)); ?> د.أ</span>
                </div>
            </div>
        </div>

        <!-- Customers Stats -->
        <div class="dashboard-card p-6" style="--icon-color-1: #8b5cf6; --icon-color-2: #7c3aed;">
            <div class="flex items-center justify-between mb-4">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text-left">
                    <p class="text-sm font-medium text-gray-600">إجمالي العملاء</p>
                    <p class="stat-number"><?php echo e(number_format($stats['total_customers'])); ?></p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">المفضلة</span>
                    <span class="font-bold text-pink-600"><?php echo e($stats['total_favorites']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Comprehensive Table Management Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Product Management Tables -->
        <div class="table-card">
            <div class="table-header">
                <i class="fas fa-box mr-2"></i>
                إدارة المنتجات والفئات
            </div>
            <div class="table-content space-y-3">
                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-box text-blue-500 ml-3 text-lg"></i>
                        <span class="font-medium">المنتجات</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-blue-600"><?php echo e($stats['total_products']); ?></span>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-folder text-purple-500 ml-3 text-lg"></i>
                        <span class="font-medium">الفئات</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-purple-600"><?php echo e($stats['total_categories']); ?></span>
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-purple-500 hover:text-purple-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-tags text-indigo-500 ml-3 text-lg"></i>
                        <span class="font-medium">العلامات التجارية</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-indigo-600"><?php echo e($stats['total_brands']); ?></span>
                        <a href="<?php echo e(route('admin.brands.index')); ?>" class="text-indigo-500 hover:text-indigo-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-images text-green-500 ml-3 text-lg"></i>
                        <span class="font-medium">صور المنتجات</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-green-600"><?php echo e($stats['total_product_images']); ?></span>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="text-green-500 hover:text-green-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-ruler text-orange-500 ml-3 text-lg"></i>
                        <span class="font-medium">مقاسات المنتجات</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-orange-600"><?php echo e($stats['total_product_sizes']); ?></span>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="text-orange-500 hover:text-orange-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-list text-teal-500 ml-3 text-lg"></i>
                        <span class="font-medium">خصائص المنتجات</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-teal-600"><?php echo e($stats['total_product_attributes']); ?></span>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="text-teal-500 hover:text-teal-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders and Sales Management -->
        <div class="table-card">
            <div class="table-header">
                <i class="fas fa-shopping-cart mr-2"></i>
                إدارة الطلبات والمبيعات
            </div>
            <div class="table-content space-y-3">
                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-shopping-cart text-green-500 ml-3 text-lg"></i>
                        <span class="font-medium">جميع الطلبات</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-green-600"><?php echo e($stats['total_orders']); ?></span>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-green-500 hover:text-green-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-orange-500 ml-3 text-lg"></i>
                        <span class="font-medium">طلبات معلقة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-orange-600"><?php echo e($stats['pending_orders']); ?></span>
                        <a href="<?php echo e(route('admin.orders.index')); ?>?status=pending" class="text-orange-500 hover:text-orange-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-blue-500 ml-3 text-lg"></i>
                        <span class="font-medium">طلبات مكتملة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-blue-600"><?php echo e($stats['completed_orders']); ?></span>
                        <a href="<?php echo e(route('admin.orders.index')); ?>?status=completed" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-list-ol text-purple-500 ml-3 text-lg"></i>
                        <span class="font-medium">عناصر الطلبات</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-purple-600"><?php echo e($stats['total_order_items']); ?></span>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-purple-500 hover:text-purple-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-indigo-500 ml-3 text-lg"></i>
                        <span class="font-medium">المدن الأردنية</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-indigo-600"><?php echo e($stats['total_jordan_cities']); ?></span>
                        <span class="text-indigo-500">
                            <i class="fas fa-info-circle"></i>
                        </span>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-dollar-sign text-yellow-500 ml-3 text-lg"></i>
                        <span class="font-medium">متوسط قيمة الطلب</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-lg font-bold text-yellow-600"><?php echo e(number_format($stats['average_order_value'], 2)); ?></span>
                        <span class="text-yellow-500 text-sm">د.أ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Engagement and Reviews -->
        <div class="table-card">
            <div class="table-header">
                <i class="fas fa-users mr-2"></i>
                تفاعل العملاء والتقييمات
            </div>
            <div class="table-content space-y-3">
                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-users text-purple-500 ml-3 text-lg"></i>
                        <span class="font-medium">إجمالي العملاء</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-purple-600"><?php echo e($stats['total_customers']); ?></span>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="text-purple-500 hover:text-purple-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-500 ml-3 text-lg"></i>
                        <span class="font-medium">المراجعات</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-yellow-600"><?php echo e($stats['total_reviews']); ?></span>
                        <a href="<?php echo e(route('admin.reviews.index')); ?>" class="text-yellow-500 hover:text-yellow-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-check text-green-500 ml-3 text-lg"></i>
                        <span class="font-medium">مراجعات موافق عليها</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-green-600"><?php echo e($stats['approved_reviews']); ?></span>
                        <a href="<?php echo e(route('admin.reviews.index')); ?>?status=approved" class="text-green-500 hover:text-green-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-heart text-pink-500 ml-3 text-lg"></i>
                        <span class="font-medium">المفضلة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-pink-600"><?php echo e($stats['total_favorites']); ?></span>
                        <span class="text-pink-500">
                            <i class="fas fa-info-circle"></i>
                        </span>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-percentage text-red-500 ml-3 text-lg"></i>
                        <span class="font-medium">الخصومات</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-red-600"><?php echo e($stats['total_discounts']); ?></span>
                        <a href="<?php echo e(route('admin.discounts.index')); ?>" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="mini-stat">
                    <div class="flex items-center">
                        <i class="fas fa-tag text-orange-500 ml-3 text-lg"></i>
                        <span class="font-medium">منتجات مخفضة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xl font-bold text-orange-600"><?php echo e($stats['total_discount_products']); ?></span>
                        <a href="<?php echo e(route('admin.products.index')); ?>?has_discount=1" class="text-orange-500 hover:text-orange-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Sales Trends Chart -->
        <div class="dashboard-card p-6">
            <div class="section-header">
                <i class="fas fa-chart-line mr-2"></i>
                اتجاهات المبيعات (7 أيام)
                <div class="mr-auto flex items-center">
                    <div class="realtime-dot mr-2"></div>
                    <span class="text-sm">تحديث مباشر</span>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="dashboard-card p-6">
            <div class="section-header">
                <i class="fas fa-chart-pie mr-2"></i>
                توزيع حالات الطلبات
                <button onclick="refreshCharts()" class="mr-auto text-white hover:text-gray-200">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
            <div class="chart-container">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="<?php echo e(route('admin.products.create')); ?>" class="quick-action" style="--action-color-1: #3b82f6; --action-color-2: #1e40af;">
            <div class="flex items-center justify-between">
                <div>
                    <i class="fas fa-plus-circle text-2xl mb-2"></i>
                    <p class="font-bold">إضافة منتج جديد</p>
                    <p class="text-sm opacity-90">إضافة منتج إلى المتجر</p>
                </div>
                <i class="fas fa-arrow-left text-xl"></i>
            </div>
        </a>

        <a href="<?php echo e(route('admin.orders.index')); ?>" class="quick-action" style="--action-color-1: #10b981; --action-color-2: #059669;">
            <div class="flex items-center justify-between">
                <div>
                    <i class="fas fa-shopping-cart text-2xl mb-2"></i>
                    <p class="font-bold">إدارة الطلبات</p>
                    <p class="text-sm opacity-90">متابعة الطلبات الجديدة</p>
                </div>
                <i class="fas fa-arrow-left text-xl"></i>
            </div>
        </a>

        <a href="<?php echo e(route('admin.discounts.create')); ?>" class="quick-action" style="--action-color-1: #ef4444; --action-color-2: #dc2626;">
            <div class="flex items-center justify-between">
                <div>
                    <i class="fas fa-percentage text-2xl mb-2"></i>
                    <p class="font-bold">إضافة خصم</p>
                    <p class="text-sm opacity-90">إنشاء عروض وخصومات</p>
                </div>
                <i class="fas fa-arrow-left text-xl"></i>
            </div>
        </a>

        <a href="<?php echo e(route('admin.users.index')); ?>" class="quick-action" style="--action-color-1: #8b5cf6; --action-color-2: #7c3aed;">
            <div class="flex items-center justify-between">
                <div>
                    <i class="fas fa-users text-2xl mb-2"></i>
                    <p class="font-bold">إدارة العملاء</p>
                    <p class="text-sm opacity-90">عرض بيانات العملاء</p>
                </div>
                <i class="fas fa-arrow-left text-xl"></i>
            </div>
        </a>
    </div>

    <!-- Recent Activity Feed -->
    <div class="dashboard-card p-6">
        <div class="section-header">
            <i class="fas fa-clock mr-2"></i>
            آخر النشاطات
            <button onclick="refreshActivity()" class="mr-auto text-white hover:text-gray-200">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Orders -->
            <div>
                <h4 class="font-bold text-gray-900 mb-4">أحدث الطلبات</h4>
                <?php if($recentOrders->count() > 0): ?>
                    <?php $__currentLoopData = $recentOrders->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="activity-item">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center ml-3">
                            <i class="fas fa-shopping-cart text-green-500"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">طلب #<?php echo e($order->id); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($order->user->name ?? 'زائر'); ?> - <?php echo e(number_format($order->total_amount)); ?> د.أ</p>
                            <p class="text-xs text-gray-400"><?php echo e($order->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-4">لا توجد طلبات حديثة</p>
                <?php endif; ?>
            </div>

            <!-- Recent Reviews -->
            <div>
                <h4 class="font-bold text-gray-900 mb-4">أحدث المراجعات</h4>
                <?php if(isset($recentReviews) && $recentReviews->count() > 0): ?>
                    <?php $__currentLoopData = $recentReviews->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="activity-item">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center ml-3">
                            <i class="fas fa-star text-yellow-500"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900"><?php echo e($review->product->name ?? 'منتج محذوف'); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($review->user->name ?? 'زائر'); ?> - <?php echo e($review->rating); ?>/5</p>
                            <p class="text-xs text-gray-400"><?php echo e($review->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-4">لا توجد مراجعات حديثة</p>
                <?php endif; ?>
            </div>

            <!-- Recent Products -->
            <div>
                <h4 class="font-bold text-gray-900 mb-4">أحدث المنتجات</h4>
                <?php if($topProducts->count() > 0): ?>
                    <?php $__currentLoopData = $topProducts->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="activity-item">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center ml-3">
                            <i class="fas fa-box text-blue-500"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900"><?php echo e($product->name); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e(number_format($product->price)); ?> د.أ</p>
                            <p class="text-xs text-gray-400"><?php echo e($product->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-4">لا توجد منتجات حديثة</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script id="dashboard-data" type="application/json">
{
    "salesTrends": <?php echo json_encode($salesTrends); ?>,
    "orderStatusDistribution": <?php echo json_encode($orderStatusDistribution); ?>,
    "stats": <?php echo json_encode($stats); ?>

}
</script>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    let salesChart, ordersChart;
    let dashboardData;

    document.addEventListener('DOMContentLoaded', function() {
        dashboardData = JSON.parse(document.getElementById('dashboard-data').textContent);
        initCharts();
        startRealTimeUpdates();
    });

    function initCharts() {
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: dashboardData.salesTrends.map(item => 
                    new Date(item.date).toLocaleDateString('ar-SA', {month: 'short', day: 'numeric'})
                ),
                datasets: [{
                    label: 'المبيعات (د.أ)',
                    data: dashboardData.salesTrends.map(item => parseFloat(item.total_sales) || 0),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });

        // Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        ordersChart = new Chart(ordersCtx, {
            type: 'doughnut',
            data: {
                labels: dashboardData.orderStatusDistribution.map(item => {
                    const statusMap = {
                        'pending': 'في الانتظار',
                        'processing': 'قيد المعالجة',
                        'shipped': 'تم الشحن',
                        'delivered': 'تم التوصيل',
                        'cancelled': 'ملغي'
                    };
                    return statusMap[item.status] || item.status;
                }),
                datasets: [{
                    data: dashboardData.orderStatusDistribution.map(item => item.count),
                    backgroundColor: ['#fcd34d', '#60a5fa', '#a78bfa', '#10b981', '#f87171'],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } }
                }
            }
        });
    }

    function startRealTimeUpdates() {
        setInterval(function() {
            document.getElementById('last-update').textContent = new Date().toLocaleTimeString('ar-SA');
        }, 30000);
    }

    function refreshAllData() {
        const button = event.target.closest('button');
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>جاري التحديث...';
        button.disabled = true;
        
        // Simulate refresh
        setTimeout(() => {
            button.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>تحديث جميع البيانات';
            button.disabled = false;
            showNotification('تم تحديث جميع البيانات بنجاح', 'success');
        }, 2000);
    }

    function refreshCharts() {
        // Chart refresh logic here
    }

    function refreshActivity() {
        // Activity refresh logic here
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        } transform translate-x-full transition-transform duration-300`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        setTimeout(() => notification.classList.remove('translate-x-full'), 100);
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => document.body.removeChild(notification), 300);
        }, 3000);
    }
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/dashboard_enhanced.blade.php ENDPATH**/ ?>