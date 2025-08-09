

<?php $__env->startSection('title', 'لوحة التحكم الرئيسية'); ?>
<?php $__env->startSection('page-title', 'لوحة التحكم'); ?>
<?php $__env->startSection('page-description', 'نظرة عامة شاملة على نشاط المتجر والإحصائيات'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Quick Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Products -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">إجمالي المنتجات</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($stats['total_products'])); ?></p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-arrow-up"></i> 
                        +<?php echo e($stats['active_products'] ?? 0); ?> نشط
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-blue-100 rounded-xl">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <a href="<?php echo e(route('admin.products.index')); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    إدارة المنتجات
                </a>
                <a href="<?php echo e(route('admin.products.create')); ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-xs">
                    إضافة منتج
                </a>
            </div>
        </div>
        
        <!-- Total Orders -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">إجمالي الطلبات</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($stats['total_orders'])); ?></p>
                    <p class="text-xs text-orange-600 mt-1">
                        <i class="fas fa-clock"></i> 
                        <?php echo e($stats['pending_orders'] ?? 0); ?> في الانتظار
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-green-100 rounded-xl">
                    <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    إدارة الطلبات
                </a>
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-md text-xs">
                    جديد
                </span>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">إجمالي المبيعات</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($stats['total_revenue'] ?? 0)); ?> ر.س</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-chart-line"></i> 
                        هذا الشهر
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-yellow-100 rounded-xl">
                    <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: <?php echo e(min(100, ($stats['total_revenue'] ?? 0) / 1000)); ?>%"></div>
                </div>
            </div>
        </div>
        
        <!-- Total Categories -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">الفئات والعلامات</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_categories'] + $stats['total_brands']); ?></p>
                    <p class="text-xs text-purple-600 mt-1">
                        <?php echo e($stats['total_categories']); ?> فئة، <?php echo e($stats['total_brands']); ?> علامة
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-purple-100 rounded-xl">
                    <i class="fas fa-tags text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    إدارة الفئات
                </a>
                <a href="<?php echo e(route('admin.brands.index')); ?>" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    العلامات
                </a>
            </div>
        </div>
    </div>

    <!-- Second Row Stats - Discounts -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Discounts -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">إجمالي الخصومات</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($stats['total_discounts'] ?? 0)); ?></p>
                    <p class="text-xs text-red-600 mt-1">
                        <i class="fas fa-percentage"></i> 
                        <?php echo e($stats['active_discounts'] ?? 0); ?> نشط
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-xl">
                    <i class="fas fa-percentage text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <a href="<?php echo e(route('admin.discounts.index')); ?>" class="text-red-600 hover:text-red-800 text-sm font-medium">
                    إدارة الخصومات
                </a>
                <a href="<?php echo e(route('admin.discounts.create')); ?>" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs">
                    إضافة خصم
                </a>
            </div>
        </div>
        
        <!-- Discounted Products -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">منتجات بخصم</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($discountedProducts->count() ?? 0); ?></p>
                    <p class="text-xs text-orange-600 mt-1">
                        <i class="fas fa-tag"></i> 
                        لها خصومات نشطة
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-orange-100 rounded-xl">
                    <i class="fas fa-tags text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="<?php echo e(route('admin.products.index')); ?>?has_discount=yes" class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                    عرض المنتجات المخفضة
                </a>
            </div>
        </div>
        
        <!-- Low Stock Alert -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">منتجات منخفضة المخزون</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['low_stock_products'] ?? 0); ?></p>
                    <p class="text-xs text-red-600 mt-1">
                        <i class="fas fa-exclamation-triangle"></i> 
                        تحتاج إعادة تموين
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-xl">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="<?php echo e(route('admin.products.index')); ?>?stock_status=low_stock" class="text-red-600 hover:text-red-800 text-sm font-medium">
                    عرض المنتجات
                </a>
            </div>
        </div>
        
        <!-- Total Customers -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">إجمالي العملاء</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e(number_format($stats['total_customers'] ?? 0)); ?></p>
                    <p class="text-xs text-indigo-600 mt-1">
                        <i class="fas fa-users"></i> 
                        عضو نشط
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-indigo-100 rounded-xl">
                    <i class="fas fa-users text-indigo-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="<?php echo e(route('admin.users.index')); ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    إدارة العملاء
                </a>
            </div>
        </div>
    </div>

    <!-- Management Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Product Management Section -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">إدارة المنتجات</h3>
                <a href="<?php echo e(route('admin.products.create')); ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus ml-2"></i> إضافة منتج جديد
                </a>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-box text-blue-500 ml-3"></i>
                        <span class="font-medium">المنتجات النشطة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-blue-600"><?php echo e($stats['active_products'] ?? 0); ?></span>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-eye-slash text-gray-500 ml-3"></i>
                        <span class="font-medium">المنتجات غير النشطة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-gray-600"><?php echo e($stats['inactive_products'] ?? 0); ?></span>
                        <a href="<?php echo e(route('admin.products.index')); ?>?status=inactive" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-500 ml-3"></i>
                        <span class="font-medium">المنتجات المميزة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-yellow-600"><?php echo e($stats['featured_products'] ?? 0); ?></span>
                        <a href="<?php echo e(route('admin.products.index')); ?>?featured=1" class="text-yellow-500 hover:text-yellow-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Management Section -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">إدارة الطلبات</h3>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-list ml-2"></i> عرض جميع الطلبات
                </a>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-orange-500 ml-3"></i>
                        <span class="font-medium">طلبات في الانتظار</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-orange-600"><?php echo e($stats['pending_orders'] ?? 0); ?></span>
                        <a href="<?php echo e(route('admin.orders.index')); ?>?status=pending" class="text-orange-500 hover:text-orange-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-truck text-blue-500 ml-3"></i>
                        <span class="font-medium">طلبات قيد التوصيل</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-blue-600"><?php echo e($stats['shipping_orders'] ?? 0); ?></span>
                        <a href="<?php echo e(route('admin.orders.index')); ?>?status=shipping" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 ml-3"></i>
                        <span class="font-medium">طلبات مكتملة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-green-600"><?php echo e($stats['completed_orders'] ?? 0); ?></span>
                        <a href="<?php echo e(route('admin.orders.index')); ?>?status=completed" class="text-green-500 hover:text-green-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discount Management Section -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">إدارة الخصومات</h3>
                <a href="<?php echo e(route('admin.discounts.create')); ?>" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus ml-2"></i> إضافة خصم
                </a>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-percentage text-red-500 ml-3"></i>
                        <span class="font-medium">خصومات نشطة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-red-600"><?php echo e($stats['active_discounts'] ?? 0); ?></span>
                        <a href="<?php echo e(route('admin.discounts.index')); ?>?status=active" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-tags text-orange-500 ml-3"></i>
                        <span class="font-medium">منتجات مخفضة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-orange-600"><?php echo e($discountedProducts->count() ?? 0); ?></span>
                        <a href="<?php echo e(route('admin.products.index')); ?>?has_discount=yes" class="text-orange-500 hover:text-orange-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <?php if($recentDiscounts->count() > 0): ?>
                <div class="p-4 bg-red-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-red-900">أحدث خصم</span>
                        <a href="<?php echo e(route('admin.discounts.show', $recentDiscounts->first())); ?>" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    <p class="text-sm text-red-700"><?php echo e($recentDiscounts->first()->name); ?></p>
                    <p class="text-xs text-red-600">
                        <?php if($recentDiscounts->first()->type == 'percentage'): ?>
                            <?php echo e($recentDiscounts->first()->value); ?>%
                        <?php else: ?>
                            <?php echo e(number_format($recentDiscounts->first()->value, 2)); ?> د.أ
                        <?php endif; ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Categories and Brands Management -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Categories Management -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">إدارة الفئات</h3>
                <a href="<?php echo e(route('admin.categories.create')); ?>" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus ml-2"></i> إضافة فئة
                </a>
            </div>
            
            <div class="space-y-3">
                <?php if($recentCategories->count() > 0): ?>
                    <?php $__currentLoopData = $recentCategories->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <?php if($category->image): ?>
                                <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>" class="w-10 h-10 rounded-lg object-cover ml-3">
                            <?php else: ?>
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center ml-3">
                                    <i class="fas fa-folder text-purple-500"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <p class="font-medium text-gray-900"><?php echo e($category->name); ?></p>
                                <p class="text-sm text-gray-500"><?php echo e($category->products_count ?? 0); ?> منتج</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 rounded-full text-xs <?php echo e($category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e($category->is_active ? 'نشط' : 'غير نشط'); ?>

                            </span>
                            <a href="<?php echo e(route('admin.categories.show', $category)); ?>" class="text-purple-500 hover:text-purple-700">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-folder-open text-4xl mb-4"></i>
                        <p>لا توجد فئات حالياً</p>
                        <a href="<?php echo e(route('admin.categories.create')); ?>" class="text-purple-500 hover:text-purple-700 mt-2 inline-block">
                            إضافة أول فئة
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if($recentCategories->count() > 5): ?>
                <div class="text-center pt-4">
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-purple-500 hover:text-purple-700 font-medium">
                        عرض جميع الفئات (<?php echo e($stats['total_categories']); ?>)
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Brands Management -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">إدارة العلامات التجارية</h3>
                <a href="<?php echo e(route('admin.brands.create')); ?>" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus ml-2"></i> إضافة علامة
                </a>
            </div>
            
            <div class="space-y-3">
                <?php if($recentBrands->count() > 0): ?>
                    <?php $__currentLoopData = $recentBrands->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <?php if($brand->logo): ?>
                                <img src="<?php echo e(asset('storage/' . $brand->logo)); ?>" alt="<?php echo e($brand->name); ?>" class="w-10 h-10 rounded-lg object-cover ml-3">
                            <?php else: ?>
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center ml-3">
                                    <i class="fas fa-tag text-indigo-500"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <p class="font-medium text-gray-900"><?php echo e($brand->name); ?></p>
                                <p class="text-sm text-gray-500"><?php echo e($brand->products_count ?? 0); ?> منتج</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 rounded-full text-xs <?php echo e($brand->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e($brand->is_active ? 'نشط' : 'غير نشط'); ?>

                            </span>
                            <a href="<?php echo e(route('admin.brands.show', $brand)); ?>" class="text-indigo-500 hover:text-indigo-700">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-tags text-4xl mb-4"></i>
                        <p>لا توجد علامات تجارية حالياً</p>
                        <a href="<?php echo e(route('admin.brands.create')); ?>" class="text-indigo-500 hover:text-indigo-700 mt-2 inline-block">
                            إضافة أول علامة تجارية
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if($recentBrands->count() > 5): ?>
                <div class="text-center pt-4">
                    <a href="<?php echo e(route('admin.brands.index')); ?>" class="text-indigo-500 hover:text-indigo-700 font-medium">
                        عرض جميع العلامات (<?php echo e($stats['total_brands']); ?>)
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Quick Links -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">أحدث الطلبات</h3>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-blue-500 hover:text-blue-700 font-medium">
                    عرض الكل
                </a>
            </div>
            
            <?php if($recentOrders->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $recentOrders->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center ml-4">
                                <i class="fas fa-receipt text-blue-500"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">طلب #<?php echo e($order->order_number); ?></p>
                                <p class="text-sm text-gray-500"><?php echo e($order->user->name ?? 'زائر'); ?></p>
                                <p class="text-xs text-gray-400"><?php echo e($order->created_at->diffForHumans()); ?></p>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-gray-900"><?php echo e(number_format($order->total)); ?> ر.س</p>
                            <span class="px-2 py-1 rounded-full text-xs
                                <?php echo e($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                <?php echo e($order->status == 'processing' ? 'bg-blue-100 text-blue-800' : ''); ?>

                                <?php echo e($order->status == 'shipped' ? 'bg-purple-100 text-purple-800' : ''); ?>

                                <?php echo e($order->status == 'delivered' ? 'bg-green-100 text-green-800' : ''); ?>

                                <?php echo e($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : ''); ?>">
                                <?php echo e($order->status == 'pending' ? 'في الانتظار' :
                                    ($order->status == 'processing' ? 'قيد المعالجة' :
                                    ($order->status == 'shipped' ? 'تم الشحن' :
                                    ($order->status == 'delivered' ? 'تم التوصيل' :
                                    ($order->status == 'cancelled' ? 'ملغي' : $order->status))))); ?>

                            </span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <p>لا توجد طلبات حالياً</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-bold text-gray-900 mb-6">إجراءات سريعة</h3>
            
            <div class="space-y-4">
                <a href="<?php echo e(route('admin.products.create')); ?>" class="flex items-center justify-between p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-plus-circle text-blue-500 ml-3"></i>
                        <span class="font-medium text-blue-900">إضافة منتج جديد</span>
                    </div>
                    <i class="fas fa-arrow-left text-blue-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="<?php echo e(route('admin.categories.create')); ?>" class="flex items-center justify-between p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-folder-plus text-purple-500 ml-3"></i>
                        <span class="font-medium text-purple-900">إضافة فئة جديدة</span>
                    </div>
                    <i class="fas fa-arrow-left text-purple-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="<?php echo e(route('admin.brands.create')); ?>" class="flex items-center justify-between p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-tag text-indigo-500 ml-3"></i>
                        <span class="font-medium text-indigo-900">إضافة علامة تجارية</span>
                    </div>
                    <i class="fas fa-arrow-left text-indigo-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="<?php echo e(route('admin.discounts.create')); ?>" class="flex items-center justify-between p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-percentage text-red-500 ml-3"></i>
                        <span class="font-medium text-red-900">إضافة خصم جديد</span>
                    </div>
                    <i class="fas fa-arrow-left text-red-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="flex items-center justify-between p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-list-alt text-green-500 ml-3"></i>
                        <span class="font-medium text-green-900">مراجعة الطلبات</span>
                    </div>
                    <i class="fas fa-arrow-left text-green-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="<?php echo e(route('home')); ?>" target="_blank" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-external-link-alt text-gray-500 ml-3"></i>
                        <span class="font-medium text-gray-900">زيارة الموقع</span>
                    </div>
                    <i class="fas fa-arrow-left text-gray-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card:hover {
        transform: translateY(-2px);
    }
    
    .group:hover .group-hover\:translate-x-1 {
        transform: translateX(-0.25rem);
    }
</style>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>