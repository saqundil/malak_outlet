

<?php $__env->startSection('title', 'إدارة العلامات التجارية'); ?>
<?php $__env->startSection('page-title', 'إدارة العلامات التجارية'); ?>
<?php $__env->startSection('page-description', 'عرض وإدارة جميع العلامات التجارية في المتجر'); ?>

<?php $__env->startSection('content'); ?>
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="fas fa-tags text-blue-600 text-xl"></i>
            </div>
            <div class="mr-4">
                <h3 class="text-2xl font-bold text-gray-900"><?php echo e($brands->total()); ?></h3>
                <p class="text-gray-600">إجمالي العلامات التجارية</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="mr-4">
                <h3 class="text-2xl font-bold text-gray-900"><?php echo e($brands->where('is_active', true)->count()); ?></h3>
                <p class="text-gray-600">علامات نشطة</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 bg-orange-100 rounded-lg">
                <i class="fas fa-pause-circle text-orange-600 text-xl"></i>
            </div>
            <div class="mr-4">
                <h3 class="text-2xl font-bold text-gray-900"><?php echo e($brands->where('is_active', false)->count()); ?></h3>
                <p class="text-gray-600">علامات غير نشطة</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg">
                <i class="fas fa-cube text-purple-600 text-xl"></i>
            </div>
            <div class="mr-4">
                <h3 class="text-2xl font-bold text-gray-900"><?php echo e($brands->sum(function($brand) { return $brand->products->count(); })); ?></h3>
                <p class="text-gray-600">إجمالي المنتجات</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Actions -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <!-- Search and Filters -->
        <form method="GET" class="flex flex-col lg:flex-row gap-4 flex-1">
            <div class="flex-1">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                       placeholder="البحث في العلامات التجارية..."
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            </div>
            
            <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                <option value="">جميع الحالات</option>
                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>نشط</option>
                <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>غير نشط</option>
            </select>
            
            <select name="sort" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>ترتيب بالاسم</option>
                <option value="created_at" <?php echo e(request('sort') == 'created_at' ? 'selected' : ''); ?>>ترتيب بتاريخ الإنشاء</option>
                <option value="products_count" <?php echo e(request('sort') == 'products_count' ? 'selected' : ''); ?>>ترتيب بعدد المنتجات</option>
            </select>
            
            <button type="submit" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-search ml-2"></i>
                بحث
            </button>
        </form>
        
        <!-- Actions -->
        <div class="flex gap-2">
            <a href="<?php echo e(route('admin.brands.create')); ?>" 
               class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors">
                <i class="fas fa-plus ml-2"></i>
                إضافة علامة تجارية
            </a>
            
            <button type="button" onclick="exportBrands()" 
                    class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                <i class="fas fa-download ml-2"></i>
                تصدير
            </button>
        </div>
    </div>
</div>

<!-- Brands Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <form id="bulk-form" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="action" id="bulk-action">
        
        <!-- Table Header with Bulk Actions -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                        <span class="mr-2 text-sm text-gray-600">تحديد الكل</span>
                    </label>
                    <span id="selected-count" class="text-sm text-gray-600 hidden">0 عنصر محدد</span>
                </div>
                
                <div id="bulk-actions" class="flex gap-2 hidden">
                    <button type="button" onclick="bulkAction('activate')" 
                            class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 transition-colors">
                        <i class="fas fa-check ml-1"></i>
                        تفعيل
                    </button>
                    <button type="button" onclick="bulkAction('deactivate')" 
                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 transition-colors">
                        <i class="fas fa-pause ml-1"></i>
                        إلغاء تفعيل
                    </button>
                    <button type="button" onclick="bulkAction('delete')" 
                            class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-600 transition-colors">
                        <i class="fas fa-trash ml-1"></i>
                        حذف
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الشعار
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            اسم العلامة التجارية
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            عدد المنتجات
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الحالة
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            تاريخ الإنشاء
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            الإجراءات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="selected_brands[]" value="<?php echo e($brand->id); ?>" 
                                       class="brand-checkbox rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($brand->logo): ?>
                                    <img src="<?php echo e($brand->logo); ?>" alt="<?php echo e($brand->name); ?>" 
                                         class="w-12 h-12 object-contain rounded-lg border border-gray-200">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-lg"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($brand->name); ?></div>
                                <?php if($brand->description): ?>
                                    <div class="text-sm text-gray-500"><?php echo e(Str::limit($brand->description, 50)); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <?php echo e($brand->products->count()); ?> منتج
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($brand->is_active): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle ml-1"></i>
                                        نشط
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle ml-1"></i>
                                        غير نشط
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($brand->created_at->format('d/m/Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="<?php echo e(route('admin.brands.show', $brand)); ?>" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.brands.edit', $brand)); ?>" 
                                       class="text-orange-600 hover:text-orange-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" onclick="deleteBrand(<?php echo e($brand->id); ?>)" 
                                            class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-tags text-4xl mb-4"></i>
                                    <p>لا توجد علامات تجارية</p>
                                    <a href="<?php echo e(route('admin.brands.create')); ?>" 
                                       class="text-orange-500 hover:text-orange-700 mt-2 inline-block">
                                        إضافة علامة تجارية جديدة
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </form>
    
    <!-- Pagination -->
    <?php if($brands->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($brands->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Select all functionality
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.brand-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });
    
    // Individual checkbox functionality
    document.querySelectorAll('.brand-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
    
    function updateBulkActions() {
        const checkboxes = document.querySelectorAll('.brand-checkbox');
        const checked = document.querySelectorAll('.brand-checkbox:checked');
        const selectAll = document.getElementById('select-all');
        const selectedCount = document.getElementById('selected-count');
        const bulkActions = document.getElementById('bulk-actions');
        
        // Update select all checkbox
        if (checked.length === 0) {
            selectAll.indeterminate = false;
            selectAll.checked = false;
        } else if (checked.length === checkboxes.length) {
            selectAll.indeterminate = false;
            selectAll.checked = true;
        } else {
            selectAll.indeterminate = true;
        }
        
        // Show/hide bulk actions
        if (checked.length > 0) {
            selectedCount.textContent = `${checked.length} عنصر محدد`;
            selectedCount.classList.remove('hidden');
            bulkActions.classList.remove('hidden');
        } else {
            selectedCount.classList.add('hidden');
            bulkActions.classList.add('hidden');
        }
    }
    
    function bulkAction(action) {
        const checked = document.querySelectorAll('.brand-checkbox:checked');
        if (checked.length === 0) {
            alert('يرجى تحديد عنصر واحد على الأقل');
            return;
        }
        
        let message = '';
        switch(action) {
            case 'activate':
                message = `هل أنت متأكد من تفعيل ${checked.length} علامة تجارية؟`;
                break;
            case 'deactivate':
                message = `هل أنت متأكد من إلغاء تفعيل ${checked.length} علامة تجارية؟`;
                break;
            case 'delete':
                message = `هل أنت متأكد من حذف ${checked.length} علامة تجارية؟ هذا الإجراء لا يمكن التراجع عنه.`;
                break;
        }
        
        if (confirm(message)) {
            document.getElementById('bulk-action').value = action;
            document.getElementById('bulk-form').action = '<?php echo e(route("admin.brands.bulk")); ?>';
            document.getElementById('bulk-form').submit();
        }
    }
    
    function deleteBrand(id) {
        if (confirm('هل أنت متأكد من حذف هذه العلامة التجارية؟')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/brands/${id}`;
            form.innerHTML = `
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function exportBrands() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'excel');
        window.location.href = '<?php echo e(route("admin.brands.index")); ?>?' + params.toString();
    }
</script>
<?php $__env->stopPush(); ?>





<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/brands/index.blade.php ENDPATH**/ ?>