

<?php $__env->startSection('title', 'إدارة المدن الأردنية'); ?>
<?php $__env->startSection('page-title', 'إدارة المدن الأردنية'); ?>
<?php $__env->startSection('page-description', 'إدارة المدن وتكاليف التوصيل في المملكة الأردنية الهاشمية'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .city-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
    }
    .city-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border-color: #cbd5e0;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-active {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    .status-inactive {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    .stats-card {
        background: linear-gradient(135deg, var(--bg-color-1), var(--bg-color-2));
        color: white;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
    }
    .search-box {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .search-box:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .action-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
    }
    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }
    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: white;
        text-decoration: none;
    }
    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stats-card" style="--bg-color-1: #3b82f6; --bg-color-2: #1e40af;">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-map-marker-alt text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2"><?php echo e(number_format($stats['total_cities'])); ?></h3>
            <p class="text-sm opacity-90">إجمالي المدن</p>
        </div>

        <div class="stats-card" style="--bg-color-1: #10b981; --bg-color-2: #059669;">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2"><?php echo e(number_format($stats['active_cities'])); ?></h3>
            <p class="text-sm opacity-90">مدن نشطة</p>
        </div>

        <div class="stats-card" style="--bg-color-1: #f59e0b; --bg-color-2: #d97706;">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-shopping-cart text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2"><?php echo e(number_format($stats['total_orders'])); ?></h3>
            <p class="text-sm opacity-90">إجمالي الطلبات</p>
        </div>

        <div class="stats-card" style="--bg-color-1: #8b5cf6; --bg-color-2: #7c3aed;">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-truck text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2"><?php echo e(number_format($stats['total_delivery_revenue'], 2)); ?></h3>
            <p class="text-sm opacity-90">إيرادات التوصيل (د.أ)</p>
        </div>
    </div>

    <!-- Search and Actions -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <h2 class="text-xl font-bold text-gray-900">قائمة المدن الأردنية</h2>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('admin.cities.create')); ?>" class="action-btn btn-success">
                    <i class="fas fa-plus"></i>
                    إضافة مدينة جديدة
                </a>
            </div>
        </div>

        <!-- Search and Filter Form -->
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div>
                <input type="text" 
                       name="search" 
                       value="<?php echo e(request('search')); ?>"
                       placeholder="البحث في المدن..."
                       class="search-box w-full px-4 py-3">
            </div>
            
            <div>
                <select name="status" class="search-box w-full px-4 py-3">
                    <option value="">جميع الحالات</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>نشط</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>غير نشط</option>
                </select>
            </div>

            <div>
                <select name="sort_by" class="search-box w-full px-4 py-3">
                    <option value="name" <?php echo e(request('sort_by') === 'name' ? 'selected' : ''); ?>>الاسم</option>
                    <option value="delivery_cost" <?php echo e(request('sort_by') === 'delivery_cost' ? 'selected' : ''); ?>>تكلفة التوصيل</option>
                    <option value="delivery_days" <?php echo e(request('sort_by') === 'delivery_days' ? 'selected' : ''); ?>>أيام التوصيل</option>
                    <option value="created_at" <?php echo e(request('sort_by') === 'created_at' ? 'selected' : ''); ?>>تاريخ الإضافة</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="action-btn btn-primary flex-1">
                    <i class="fas fa-search"></i>
                    بحث
                </button>
                <a href="<?php echo e(route('admin.cities.index')); ?>" class="action-btn btn-warning">
                    <i class="fas fa-refresh"></i>
                </a>
            </div>
        </form>

        <!-- Cities Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="px-6 py-4 text-right text-sm font-medium uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded">
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-medium uppercase tracking-wider">
                            المدينة
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-medium uppercase tracking-wider">
                            تكلفة التوصيل
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-medium uppercase tracking-wider">
                            أيام التوصيل
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-medium uppercase tracking-wider">
                            عدد الطلبات
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-medium uppercase tracking-wider">
                            الحالة
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-medium uppercase tracking-wider">
                            الإجراءات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="city-checkbox rounded" value="<?php echo e($city->id); ?>">
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center ml-3">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($city->display_name); ?></div>
                                    <?php if($city->name_en): ?>
                                        <div class="text-sm text-gray-500"><?php echo e($city->name_en); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-green-600"><?php echo e($city->formatted_delivery_cost); ?></div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <?php echo e($city->delivery_days); ?> <?php echo e($city->delivery_days == 1 ? 'يوم' : 'أيام'); ?>

                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <?php echo e(number_format($city->orders_count)); ?>

                                <?php if($city->orders_count > 0): ?>
                                    <a href="<?php echo e(route('admin.cities.orders', $city)); ?>" class="text-blue-500 hover:text-blue-700 mr-2">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="status-badge <?php echo e($city->is_active ? 'status-active' : 'status-inactive'); ?>">
                                <?php echo e($city->is_active ? 'نشط' : 'غير نشط'); ?>

                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.cities.show', $city)); ?>" class="action-btn btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.cities.edit', $city)); ?>" class="action-btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="toggleStatus(<?php echo e($city->id); ?>)" 
                                        class="action-btn <?php echo e($city->is_active ? 'btn-danger' : 'btn-success'); ?>">
                                    <i class="fas fa-<?php echo e($city->is_active ? 'ban' : 'check'); ?>"></i>
                                </button>
                                <?php if($city->orders_count == 0): ?>
                                <button onclick="deleteCity(<?php echo e($city->id); ?>)" class="action-btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-map-marker-alt text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium">لا توجد مدن</p>
                                <p class="text-sm">قم بإضافة مدينة جديدة للبدء</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($cities->hasPages()): ?>
            <div class="mt-6 flex justify-center">
                <?php echo e($cities->appends(request()->query())->links()); ?>

            </div>
        <?php endif; ?>

        <!-- Bulk Actions -->
        <div id="bulk-actions" class="mt-6 p-4 bg-gray-50 rounded-lg hidden">
            <div class="flex items-center justify-between">
                <span id="selected-count" class="text-sm text-gray-600">0 مدينة محددة</span>
                <div class="flex gap-2">
                    <button onclick="bulkAction('activate')" class="action-btn btn-success">
                        <i class="fas fa-check"></i>
                        تفعيل
                    </button>
                    <button onclick="bulkAction('deactivate')" class="action-btn btn-warning">
                        <i class="fas fa-ban"></i>
                        إلغاء تفعيل
                    </button>
                    <button onclick="bulkAction('delete')" class="action-btn btn-danger">
                        <i class="fas fa-trash"></i>
                        حذف
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Select all functionality
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.city-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    // Individual checkbox functionality
    document.querySelectorAll('.city-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const selected = document.querySelectorAll('.city-checkbox:checked');
        const bulkActions = document.getElementById('bulk-actions');
        const selectedCount = document.getElementById('selected-count');
        
        if (selected.length > 0) {
            bulkActions.classList.remove('hidden');
            selectedCount.textContent = `${selected.length} مدينة محددة`;
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    // Toggle city status
    function toggleStatus(cityId) {
        if (confirm('هل أنت متأكد من تغيير حالة المدينة؟')) {
            fetch(`/admin/cities/${cityId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(data.message || 'حدث خطأ', 'error');
                }
            })
            .catch(error => {
                showNotification('حدث خطأ في الاتصال', 'error');
            });
        }
    }

    // Delete city
    function deleteCity(cityId) {
        if (confirm('هل أنت متأكد من حذف هذه المدينة؟ لا يمكن التراجع عن هذا الإجراء.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/cities/${cityId}`;
            form.innerHTML = `
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Bulk actions
    function bulkAction(action) {
        const selected = Array.from(document.querySelectorAll('.city-checkbox:checked')).map(cb => cb.value);
        
        if (selected.length === 0) {
            showNotification('يرجى تحديد مدينة واحدة على الأقل', 'error');
            return;
        }

        const actionText = {
            'activate': 'تفعيل',
            'deactivate': 'إلغاء تفعيل',
            'delete': 'حذف'
        };

        if (confirm(`هل أنت متأكد من ${actionText[action]} المدن المحددة؟`)) {
            fetch('/admin/cities/bulk-action', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: action,
                    cities: selected
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(data.message || 'حدث خطأ', 'error');
                }
            })
            .catch(error => {
                showNotification('حدث خطأ في الاتصال', 'error');
            });
        }
    }

    // Notification function
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
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/cities/index.blade.php ENDPATH**/ ?>