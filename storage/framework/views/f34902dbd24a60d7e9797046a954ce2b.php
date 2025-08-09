<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo $__env->yieldContent('title', 'لوحة التحكم'); ?> - Malak Outlet Admin</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        /* Minimal fallback styles only */
        body {
            direction: rtl;
        }
        
        .gap-6 {
            gap: 1.5rem;
        }
        
        .p-6 {
            padding: 1.5rem;
        }
        
        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .text-gray-900 {
            color: #111827;
        }
        
        .text-gray-600 {
            color: #4b5563;
        }
        
        .mt-4 {
            margin-top: 1rem;
        }
        
        .flex-1 {
            flex: 1;
        }
        
        .overflow-auto {
            overflow: auto;
        }
    </style>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-white shadow-lg w-64 flex-shrink-0">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-orange-500">
                <h1 class="text-white text-xl font-bold">Malak Outlet</h1>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-4 space-y-1">
                    <!-- Dashboard -->
                    <a href="<?php echo e(route('admin.dashboard')); ?>" 
                       class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-chart-bar ml-3"></i>
                        <span>لوحة التحكم</span>
                    </a>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Products Management -->
                    <div class="space-y-1">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">إدارة المنتجات</p>
                        
                        <a href="<?php echo e(route('admin.products.index')); ?>" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
                            <i class="fas fa-box ml-3"></i>
                            <span>جميع المنتجات</span>
                            <?php if(isset($stats['total_products']) && $stats['total_products'] > 0): ?>
                                <span class="mr-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full"><?php echo e($stats['total_products']); ?></span>
                            <?php endif; ?>
                        </a>
                        
                        <a href="<?php echo e(route('admin.products.create')); ?>" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors <?php echo e(request()->routeIs('admin.products.create') ? 'active' : ''); ?>">
                            <i class="fas fa-plus-circle ml-3"></i>
                            <span>إضافة منتج</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.categories.index')); ?>" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                            <i class="fas fa-folder ml-3"></i>
                            <span>الفئات</span>
                            <?php if(isset($stats['total_categories']) && $stats['total_categories'] > 0): ?>
                                <span class="mr-auto bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full"><?php echo e($stats['total_categories']); ?></span>
                            <?php endif; ?>
                        </a>
                        
                        <a href="<?php echo e(route('admin.brands.index')); ?>" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors <?php echo e(request()->routeIs('admin.brands.*') ? 'active' : ''); ?>">
                            <i class="fas fa-tags ml-3"></i>
                            <span>العلامات التجارية</span>
                            <?php if(isset($stats['total_brands']) && $stats['total_brands'] > 0): ?>
                                <span class="mr-auto bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full"><?php echo e($stats['total_brands']); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Discounts Management -->
                    <div class="space-y-1">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">إدارة الخصومات</p>
                        
                        <a href="<?php echo e(route('admin.discounts.index')); ?>" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors <?php echo e(request()->routeIs('admin.discounts.*') ? 'active' : ''); ?>">
                            <i class="fas fa-percentage ml-3"></i>
                            <span>جميع الخصومات</span>
                            <?php if(isset($stats['total_discounts']) && $stats['total_discounts'] > 0): ?>
                                <span class="mr-auto bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full"><?php echo e($stats['total_discounts']); ?></span>
                            <?php endif; ?>
                        </a>
                        
                        <a href="<?php echo e(route('admin.discounts.create')); ?>" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors <?php echo e(request()->routeIs('admin.discounts.create') ? 'active' : ''); ?>">
                            <i class="fas fa-plus-circle ml-3"></i>
                            <span>إضافة خصم</span>
                        </a>
                        
                        <?php if(isset($stats['active_discounts']) && $stats['active_discounts'] > 0): ?>
                        <a href="<?php echo e(route('admin.discounts.index')); ?>?status=active" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-check-circle ml-3"></i>
                            <span>خصومات نشطة</span>
                            <span class="mr-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full"><?php echo e($stats['active_discounts']); ?></span>
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Orders Management -->
                    <div class="space-y-1">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">إدارة الطلبات</p>
                        
                        <a href="<?php echo e(route('admin.orders.index')); ?>" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
                            <i class="fas fa-shopping-cart ml-3"></i>
                            <span>جميع الطلبات</span>
                            <?php if(isset($stats['total_orders']) && $stats['total_orders'] > 0): ?>
                                <span class="mr-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full"><?php echo e($stats['total_orders']); ?></span>
                            <?php endif; ?>
                        </a>
                        
                        <?php if(isset($stats['pending_orders']) && $stats['pending_orders'] > 0): ?>
                        <a href="<?php echo e(route('admin.orders.index')); ?>?status=pending" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-clock ml-3"></i>
                            <span>طلبات في الانتظار</span>
                            <span class="mr-auto bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full"><?php echo e($stats['pending_orders']); ?></span>
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- User Management -->
                    <div class="space-y-1">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">إدارة المستخدمين</p>
                        
                        <a href="<?php echo e(route('admin.users.index')); ?>" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                            <i class="fas fa-users ml-3"></i>
                            <span>العملاء</span>
                        </a>
                        
                        <a href="<?php echo e(route('admin.reviews.index')); ?>" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors <?php echo e(request()->routeIs('admin.reviews.*') ? 'active' : ''); ?>">
                            <i class="fas fa-star ml-3"></i>
                            <span>المراجعات</span>
                        </a>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Quick Actions -->
                    <div class="space-y-1">
                        <a href="<?php echo e(route('home')); ?>" target="_blank"
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-external-link-alt ml-3"></i>
                            <span>زيارة الموقع</span>
                        </a>
                        
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                            <?php echo csrf_field(); ?>
                            <button type="submit" 
                                    class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors w-full text-right hover:bg-red-50 hover:text-red-700">
                                <i class="fas fa-sign-out-alt ml-3"></i>
                                <span>تسجيل الخروج</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900"><?php echo $__env->yieldContent('page-title', 'لوحة التحكم'); ?></h1>
                            <p class="text-gray-600"><?php echo $__env->yieldContent('page-description', 'مرحباً بك في لوحة التحكم'); ?></p>
                        </div>
                        
                        <div class="flex items-center space-x-4 space-x-reverse">
                            <div class="text-sm text-gray-600">
                                مرحباً، <?php echo e(auth()->user()->name); ?>

                            </div>
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold">
                                <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <!-- Alerts -->
                    <?php if(session('success')): ?>
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle ml-2"></i>
                                <?php echo e(session('success')); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(session('error')): ?>
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-times-circle ml-2"></i>
                                <?php echo e(session('error')); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($errors->any()): ?>
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-triangle ml-2"></i>
                                يرجى تصحيح الأخطاء التالية:
                            </div>
                            <ul class="list-disc list-inside space-y-1">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // CSRF Token setup for AJAX
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Global admin functionality
        function confirmDelete(message = 'هل أنت متأكد من الحذف؟') {
            return confirm(message);
        }
        
        function showNotification(type, message) {
            // Simple notification system
            const notification = document.createElement('div');
            notification.className = `fixed top-4 left-4 z-50 px-6 py-3 rounded-lg text-white font-medium ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
        
        // Bulk actions
        function toggleAllCheckboxes(masterCheckbox) {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = masterCheckbox.checked;
            });
            updateBulkActionButtons();
        }
        
        function updateBulkActionButtons() {
            const selectedItems = document.querySelectorAll('input[name="selected_items[]"]:checked');
            const bulkActionButtons = document.querySelector('.bulk-actions');
            
            if (bulkActionButtons) {
                bulkActionButtons.style.display = selectedItems.length > 0 ? 'block' : 'none';
            }
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Update bulk action buttons on page load
            updateBulkActionButtons();
            
            // Add event listeners to checkboxes
            document.querySelectorAll('input[name="selected_items[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActionButtons);
            });
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>




<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/layout.blade.php ENDPATH**/ ?>