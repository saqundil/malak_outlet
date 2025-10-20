

<?php $__env->startSection('title', 'إدارة الفئات'); ?>
<?php $__env->startSection('page-title', 'إدارة الفئات'); ?>
<?php $__env->startSection('page-description', 'عرض وإدارة فئات المنتجات'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">الفئات (<?php echo e($categories->total()); ?>)</h2>
            <p class="text-gray-600 mt-1">إدارة فئات المنتجات وتصنيفاتها</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="<?php echo e(route('admin.categories.create')); ?>" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium flex items-center">
                <i class="fas fa-plus"></i>
                <span class="mr-2">إضافة فئة جديدة</span>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">إجمالي الفئات</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_categories'] ?? 0); ?></p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-tags text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">فئات نشطة</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['active_categories'] ?? 0); ?></p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">فئات رئيسية</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['parent_categories'] ?? 0); ?></p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-sitemap text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">إجمالي المنتجات</p>
                    <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_products'] ?? 0); ?></p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <i class="fas fa-box text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-filter text-blue-500"></i>
                <span class="mr-3">البحث والتصفية</span>
            </h3>
            <p class="text-sm text-gray-600 mt-1">استخدم الخيارات التالية للبحث وتصفية الفئات</p>
        </div>
        
        <form method="GET" action="<?php echo e(route('admin.categories.index')); ?>" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-search text-gray-500"></i>
                    <span class="mr-2">البحث</span>
                </label>
                <div class="relative">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                           placeholder="البحث في الفئات..." 
                           class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-toggle-on text-gray-500"></i>
                    <span class="mr-2">الحالة</span>
                </label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-right bg-white" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot;><path d=&quot;M6 9l6 6 6-6&quot;/></svg>'); background-repeat: no-repeat; background-position: left 12px center; background-size: 16px; padding-left: 40px; appearance: none;">
                    <option value="">جميع الحالات</option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>نشط</option>
                    <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>غير نشط</option>
                </select>
            </div>

            <!-- Parent Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sitemap text-gray-500"></i>
                    <span class="mr-2">نوع الفئة</span>
                </label>
                <select name="parent" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-right bg-white" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot;><path d=&quot;M6 9l6 6 6-6&quot;/></svg>'); background-repeat: no-repeat; background-position: left 12px center; background-size: 16px; padding-left: 40px; appearance: none;">
                    <option value="">جميع الأنواع</option>
                    <option value="main" <?php echo e(request('parent') == 'main' ? 'selected' : ''); ?>>فئات رئيسية</option>
                    <option value="sub" <?php echo e(request('parent') == 'sub' ? 'selected' : ''); ?>>فئات فرعية</option>
                </select>
            </div>

            <!-- Sort Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sort text-gray-500"></i>
                    <span class="mr-2">ترتيب حسب</span>
                </label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-right bg-white" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 24 24&quot; fill=&quot;none&quot; stroke=&quot;currentColor&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot;><path d=&quot;M6 9l6 6 6-6&quot;/></svg>'); background-repeat: no-repeat; background-position: left 12px center; background-size: 16px; padding-left: 40px; appearance: none;">
                    <option value="created_at_desc" <?php echo e(request('sort') == 'created_at_desc' ? 'selected' : ''); ?>>الأحدث</option>
                    <option value="created_at_asc" <?php echo e(request('sort') == 'created_at_asc' ? 'selected' : ''); ?>>الأقدم</option>
                    <option value="name_asc" <?php echo e(request('sort') == 'name_asc' ? 'selected' : ''); ?>>الاسم (أ-ي)</option>
                    <option value="name_desc" <?php echo e(request('sort') == 'name_desc' ? 'selected' : ''); ?>>الاسم (ي-أ)</option>
                    <option value="products_count_desc" <?php echo e(request('sort') == 'products_count_desc' ? 'selected' : ''); ?>>الأكثر منتجات</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="lg:col-span-4 flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center">
                    <i class="fas fa-search"></i>
                    <span class="mr-2">بحث</span>
                </button>
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center">
                    <i class="fas fa-undo"></i>
                    <span class="mr-2">إعادة تعيين</span>
                </a>
                <?php if(request()->hasAny(['search', 'status', 'parent', 'sort'])): ?>
                    <div class="flex items-center text-sm text-gray-600 bg-blue-50 px-3 py-2 rounded-lg border border-blue-200">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        <span class="mr-2">يتم عرض النتائج المفلترة</span>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Categories Grid/Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <?php if($categories->count() > 0): ?>
            <!-- Bulk Actions Bar -->
            <div id="bulkActionsBar" class="hidden bg-blue-50 border-b border-blue-200 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-blue-700 font-medium">
                            <span id="selectedCount">0</span> فئة محددة
                        </span>
                        <div class="flex gap-2">
                            <button onclick="bulkActivate()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                                تفعيل
                            </button>
                            <button onclick="bulkDeactivate()" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">
                                إلغاء تفعيل
                            </button>
                            <button onclick="bulkDelete()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                                حذف
                            </button>
                        </div>
                    </div>
                    <button onclick="clearSelection()" class="text-blue-600 hover:text-blue-800">
                        إلغاء التحديد
                    </button>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-right">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الفئة</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الفئة الأصل</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عدد المنتجات</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإنشاء</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" name="selected_categories[]" value="<?php echo e($category->slug); ?>" 
                                       class="category-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if($category->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $category->image)); ?>" 
                                             alt="<?php echo e($category->name); ?>" 
                                             class="w-12 h-12 rounded-lg object-cover">
                                    <?php else: ?>
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-tag text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($category->name); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e(Str::limit($category->description ?? '', 50)); ?></div>
                                        <?php if($category->slug): ?>
                                            <div class="text-xs text-gray-400"><?php echo e($category->slug); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <?php if($category->parent): ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-800">
                                        <?php echo e($category->parent->name); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                        فئة رئيسية
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="flex items-center">
                                    <span class="font-medium"><?php echo e($category->products_count ?? 0); ?></span>
                                    <span class="text-gray-500 ml-2">منتج</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs 
                                        <?php echo e($category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($category->is_active ? 'نشط' : 'غير نشط'); ?>

                                    </span>
                                    <button onclick="toggleStatus('<?php echo e($category->slug); ?>')" 
                                            class="text-xs text-blue-600 hover:text-blue-800">
                                        تغيير
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?php echo e($category->created_at->format('Y-m-d')); ?>

                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="<?php echo e(route('admin.categories.show', $category)); ?>" 
                                       class="text-blue-600 hover:text-blue-800" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                                       class="text-indigo-600 hover:text-indigo-800" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="viewProducts('<?php echo e($category->slug); ?>')" 
                                            class="text-green-600 hover:text-green-800" title="عرض المنتجات">
                                        <i class="fas fa-box"></i>
                                    </button>
                                    <button onclick="duplicateCategory('<?php echo e($category->slug); ?>')" 
                                            class="text-purple-600 hover:text-purple-800" title="نسخ">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <button onclick="deleteCategory('<?php echo e($category->slug); ?>')" 
                                            class="text-red-600 hover:text-red-800" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    عرض <?php echo e($categories->firstItem()); ?> إلى <?php echo e($categories->lastItem()); ?> من <?php echo e($categories->total()); ?> فئة
                </div>
                <?php echo e($categories->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-tags text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد فئات</h3>
                <p class="text-gray-500 mb-6">ابدأ بإضافة فئات لتصنيف منتجاتك</p>
                <a href="<?php echo e(route('admin.categories.create')); ?>" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                    <i class="fas fa-plus"></i>
                    <span class="mr-2">إضافة أول فئة</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const selectedCountSpan = document.getElementById('selectedCount');

    selectAllCheckbox?.addEventListener('change', function() {
        categoryCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsBar();
    });

    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionsBar);
    });

    function updateBulkActionsBar() {
        const selectedCategories = document.querySelectorAll('.category-checkbox:checked');
        const count = selectedCategories.length;
        
        if (count > 0) {
            bulkActionsBar?.classList.remove('hidden');
            selectedCountSpan.textContent = count;
        } else {
            bulkActionsBar?.classList.add('hidden');
        }
        
        selectAllCheckbox.checked = count === categoryCheckboxes.length;
        selectAllCheckbox.indeterminate = count > 0 && count < categoryCheckboxes.length;
    }
});

function clearSelection() {
    document.querySelectorAll('.category-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    document.getElementById('bulkActionsBar')?.classList.add('hidden');
}

function toggleStatus(categoryId) {
    if (confirm('هل أنت متأكد من تغيير حالة الفئة؟')) {
        fetch(`/admin/categories/${categoryId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء تغيير الحالة');
            }
        });
    }
}

function viewProducts(categoryId) {
    window.location.href = `/admin/products?category=${categoryId}`;
}

function duplicateCategory(categoryId) {
    if (confirm('هل تريد إنشاء نسخة من هذه الفئة؟')) {
        fetch(`/admin/categories/${categoryId}/duplicate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('تم إنشاء نسخة من الفئة بنجاح');
                location.reload();
            } else {
                alert('حدث خطأ أثناء نسخ الفئة');
            }
        });
    }
}

function deleteCategory(categoryId) {
    if (confirm('هل أنت متأكد من حذف الفئة؟ سيتم حذف جميع الفئات الفرعية أيضاً.')) {
        fetch(`/admin/categories/${categoryId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء حذف الفئة');
            }
        });
    }
}

function bulkActivate() {
    bulkAction('activate', 'تفعيل');
}

function bulkDeactivate() {
    bulkAction('deactivate', 'إلغاء تفعيل');
}

function bulkDelete() {
    bulkAction('delete', 'حذف');
}

function bulkAction(action, actionName) {
    const selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(cb => cb.value);
    
    if (selectedCategories.length === 0) {
        alert('يجب تحديد فئة واحدة على الأقل');
        return;
    }
    
    if (confirm(`هل أنت متأكد من ${actionName} ${selectedCategories.length} فئة؟`)) {
        fetch('/admin/categories/bulk-action', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: action,
                category_ids: selectedCategories
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء تنفيذ الإجراء');
            }
        });
    }
}

function exportCategories() {
    window.location.href = '/admin/categories/export';
}
</script>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>