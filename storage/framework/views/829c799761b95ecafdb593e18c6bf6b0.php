

<?php $__env->startSection('title', 'نظرة عامة على قواعد البيانات'); ?>
<?php $__env->startSection('page-title', 'إدارة قواعد البيانات'); ?>
<?php $__env->startSection('page-description', 'نظرة شاملة على جميع جداول قاعدة البيانات وإحصائياتها'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .table-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .table-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-color: #cbd5e0;
    }
    .table-header {
        background: linear-gradient(135deg, var(--header-color-1), var(--header-color-2));
        color: white;
        padding: 20px;
        text-align: center;
    }
    .table-icon {
        background: rgba(255, 255, 255, 0.2);
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 20px;
    }
    .stat-grid {
        padding: 24px;
    }
    .stat-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: all 0.2s ease;
    }
    .stat-item:hover {
        background: #e2e8f0;
        transform: scale(1.02);
    }
    .action-buttons {
        display: flex;
        gap: 8px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
    }
    .action-btn {
        flex: 1;
        padding: 8px 12px;
        border-radius: 8px;
        text-align: center;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
    }
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }
    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        color: white;
        text-decoration: none;
    }
    .summary-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        margin-bottom: 32px;
    }
    .summary-number {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 8px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Summary Card -->
    <div class="summary-card">
        <div class="summary-number"><?php echo e($stats['total_products'] + 
            $stats['total_orders'] + 
            $stats['total_customers'] + 
            $stats['total_categories'] + 
            $stats['total_brands'] + 
            $stats['total_discounts'] + 
            $stats['total_reviews'] + 
            $stats['total_favorites']); ?></div>
        <h2 class="text-2xl font-bold mb-2">إجمالي السجلات في قاعدة البيانات</h2>
        <p class="opacity-90">جميع البيانات المخزنة عبر <?php echo e(16); ?> جدول رئيسي</p>
    </div>

    <!-- Core Tables Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Products Table -->
        <div class="table-card" style="--header-color-1: #3b82f6; --header-color-2: #1e40af;">
            <div class="table-header">
                <div class="table-icon">
                    <i class="fas fa-box"></i>
                </div>
                <h3 class="text-lg font-bold">جدول المنتجات</h3>
                <p class="text-sm opacity-90">Products</p>
            </div>
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="font-medium">إجمالي المنتجات</span>
                    <span class="text-xl font-bold text-blue-600"><?php echo e(number_format($stats['total_products'])); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">منتجات نشطة</span>
                    <span class="font-bold text-green-600"><?php echo e($stats['active_products']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">منتجات مميزة</span>
                    <span class="font-bold text-yellow-600"><?php echo e($stats['featured_products']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">مخزون منخفض</span>
                    <span class="font-bold text-red-600"><?php echo e($stats['low_stock_products']); ?></span>
                </div>
                <div class="action-buttons">
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="action-btn btn-primary">عرض الكل</a>
                    <a href="<?php echo e(route('admin.products.create')); ?>" class="action-btn btn-success">إضافة جديد</a>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="table-card" style="--header-color-1: #10b981; --header-color-2: #059669;">
            <div class="table-header">
                <div class="table-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3 class="text-lg font-bold">جدول الطلبات</h3>
                <p class="text-sm opacity-90">Orders</p>
            </div>
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="font-medium">إجمالي الطلبات</span>
                    <span class="text-xl font-bold text-green-600"><?php echo e(number_format($stats['total_orders'])); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">طلبات معلقة</span>
                    <span class="font-bold text-orange-600"><?php echo e($stats['pending_orders']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">طلبات مكتملة</span>
                    <span class="font-bold text-blue-600"><?php echo e($stats['completed_orders']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">إجمالي المبيعات</span>
                    <span class="font-bold text-green-600"><?php echo e(number_format($stats['total_revenue'], 2)); ?> د.أ</span>
                </div>
                <div class="action-buttons">
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="action-btn btn-primary">عرض الكل</a>
                    <a href="<?php echo e(route('admin.orders.index')); ?>?status=pending" class="action-btn btn-secondary">المعلقة</a>
                </div>
            </div>
        </div>

        <!-- Users/Customers Table -->
        <div class="table-card" style="--header-color-1: #8b5cf6; --header-color-2: #7c3aed;">
            <div class="table-header">
                <div class="table-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="text-lg font-bold">جدول المستخدمين</h3>
                <p class="text-sm opacity-90">Users</p>
            </div>
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="font-medium">إجمالي العملاء</span>
                    <span class="text-xl font-bold text-purple-600"><?php echo e(number_format($stats['total_customers'])); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">المفضلة</span>
                    <span class="font-bold text-pink-600"><?php echo e($stats['total_favorites']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">المراجعات</span>
                    <span class="font-bold text-yellow-600"><?php echo e($stats['total_reviews']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">مراجعات موافقة</span>
                    <span class="font-bold text-green-600"><?php echo e($stats['approved_reviews']); ?></span>
                </div>
                <div class="action-buttons">
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="action-btn btn-primary">عرض العملاء</a>
                    <a href="<?php echo e(route('admin.reviews.index')); ?>" class="action-btn btn-secondary">المراجعات</a>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="table-card" style="--header-color-1: #f59e0b; --header-color-2: #d97706;">
            <div class="table-header">
                <div class="table-icon">
                    <i class="fas fa-folder"></i>
                </div>
                <h3 class="text-lg font-bold">جدول الفئات</h3>
                <p class="text-sm opacity-90">Categories</p>
            </div>
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="font-medium">إجمالي الفئات</span>
                    <span class="text-xl font-bold text-orange-600"><?php echo e(number_format($stats['total_categories'])); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">فئات رئيسية</span>
                    <span class="font-bold text-blue-600"><?php echo e($recentCategories->where('parent_id', null)->count()); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">فئات فرعية</span>
                    <span class="font-bold text-purple-600"><?php echo e($recentCategories->where('parent_id', '!=', null)->count()); ?></span>
                </div>
                <div class="action-buttons">
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="action-btn btn-primary">عرض الكل</a>
                    <a href="<?php echo e(route('admin.categories.create')); ?>" class="action-btn btn-success">إضافة جديد</a>
                </div>
            </div>
        </div>

        <!-- Brands Table -->
        <div class="table-card" style="--header-color-1: #ef4444; --header-color-2: #dc2626;">
            <div class="table-header">
                <div class="table-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h3 class="text-lg font-bold">جدول العلامات التجارية</h3>
                <p class="text-sm opacity-90">Brands</p>
            </div>
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="font-medium">إجمالي العلامات</span>
                    <span class="text-xl font-bold text-red-600"><?php echo e(number_format($stats['total_brands'])); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">علامات نشطة</span>
                    <span class="font-bold text-green-600"><?php echo e($recentBrands->where('is_active', true)->count()); ?></span>
                </div>
                <div class="action-buttons">
                    <a href="<?php echo e(route('admin.brands.index')); ?>" class="action-btn btn-primary">عرض الكل</a>
                    <a href="<?php echo e(route('admin.brands.create')); ?>" class="action-btn btn-success">إضافة جديد</a>
                </div>
            </div>
        </div>

        <!-- Discounts Table -->
        <div class="table-card" style="--header-color-1: #ec4899; --header-color-2: #be185d;">
            <div class="table-header">
                <div class="table-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <h3 class="text-lg font-bold">جدول الخصومات</h3>
                <p class="text-sm opacity-90">Discounts</p>
            </div>
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="font-medium">إجمالي الخصومات</span>
                    <span class="text-xl font-bold text-pink-600"><?php echo e(number_format($stats['total_discounts'])); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">خصومات نشطة</span>
                    <span class="font-bold text-green-600"><?php echo e($stats['active_discounts']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="text-sm text-gray-600">منتجات مخفضة</span>
                    <span class="font-bold text-orange-600"><?php echo e($stats['total_discount_products']); ?></span>
                </div>
                <div class="action-buttons">
                    <a href="<?php echo e(route('admin.discounts.index')); ?>" class="action-btn btn-primary">عرض الكل</a>
                    <a href="<?php echo e(route('admin.discounts.create')); ?>" class="action-btn btn-success">إضافة جديد</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Secondary Tables Grid -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">جداول البيانات الفرعية والمساعدة</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Product Images -->
            <div class="table-card" style="--header-color-1: #06b6d4; --header-color-2: #0891b2;">
                <div class="table-header">
                    <div class="table-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <h3 class="text-sm font-bold">صور المنتجات</h3>
                </div>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="text-sm font-medium">إجمالي الصور</span>
                        <span class="text-lg font-bold text-cyan-600"><?php echo e($stats['total_product_images']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Product Sizes -->
            <div class="table-card" style="--header-color-1: #84cc16; --header-color-2: #65a30d;">
                <div class="table-header">
                    <div class="table-icon">
                        <i class="fas fa-ruler"></i>
                    </div>
                    <h3 class="text-sm font-bold">مقاسات المنتجات</h3>
                </div>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="text-sm font-medium">إجمالي المقاسات</span>
                        <span class="text-lg font-bold text-lime-600"><?php echo e($stats['total_product_sizes']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="table-card" style="--header-color-1: #a855f7; --header-color-2: #9333ea;">
                <div class="table-header">
                    <div class="table-icon">
                        <i class="fas fa-list-ol"></i>
                    </div>
                    <h3 class="text-sm font-bold">عناصر الطلبات</h3>
                </div>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="text-sm font-medium">إجمالي العناصر</span>
                        <span class="text-lg font-bold text-violet-600"><?php echo e($stats['total_order_items']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Jordan Cities -->
            <div class="table-card" style="--header-color-1: #059669; --header-color-2: #047857;">
                <div class="table-header">
                    <div class="table-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="text-sm font-bold">المدن الأردنية</h3>
                </div>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="text-sm font-medium">إجمالي المدن</span>
                        <span class="text-lg font-bold text-emerald-600"><?php echo e($stats['total_jordan_cities']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Product Attributes -->
            <div class="table-card" style="--header-color-1: #f97316; --header-color-2: #ea580c;">
                <div class="table-header">
                    <div class="table-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <h3 class="text-sm font-bold">خصائص المنتجات</h3>
                </div>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="text-sm font-medium">إجمالي الخصائص</span>
                        <span class="text-lg font-bold text-orange-600"><?php echo e($stats['total_product_attributes']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Attribute Values -->
            <div class="table-card" style="--header-color-1: #0d9488; --header-color-2: #0f766e;">
                <div class="table-header">
                    <div class="table-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h3 class="text-sm font-bold">قيم الخصائص</h3>
                </div>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="text-sm font-medium">إجمالي القيم</span>
                        <span class="text-lg font-bold text-teal-600"><?php echo e($stats['total_attribute_values']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Favorites -->
            <div class="table-card" style="--header-color-1: #e11d48; --header-color-2: #be123c;">
                <div class="table-header">
                    <div class="table-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="text-sm font-bold">المفضلة</h3>
                </div>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="text-sm font-medium">إجمالي المفضلة</span>
                        <span class="text-lg font-bold text-rose-600"><?php echo e($stats['total_favorites']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Product Reviews -->
            <div class="table-card" style="--header-color-1: #eab308; --header-color-2: #ca8a04;">
                <div class="table-header">
                    <div class="table-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="text-sm font-bold">مراجعات المنتجات</h3>
                </div>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="text-sm font-medium">إجمالي المراجعات</span>
                        <span class="text-lg font-bold text-yellow-600"><?php echo e($stats['total_reviews']); ?></span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="mt-12 bg-gray-50 rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">إجراءات سريعة لإدارة قاعدة البيانات</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="<?php echo e(route('admin.products.create')); ?>" class="action-btn btn-primary">
                <i class="fas fa-plus mr-2"></i>إضافة منتج جديد
            </a>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="action-btn btn-secondary">
                <i class="fas fa-folder-plus mr-2"></i>إضافة فئة جديدة
            </a>
            <a href="<?php echo e(route('admin.brands.create')); ?>" class="action-btn btn-success">
                <i class="fas fa-tag mr-2"></i>إضافة علامة تجارية
            </a>
            <a href="<?php echo e(route('admin.discounts.create')); ?>" class="action-btn btn-primary">
                <i class="fas fa-percentage mr-2"></i>إضافة خصم جديد
            </a>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/dashboard_tables.blade.php ENDPATH**/ ?>