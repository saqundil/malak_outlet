

<?php $__env->startSection('title', 'إدارة الخصومات'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6" dir="rtl">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-percentage text-red-500 ml-3"></i>
                إدارة الخصومات
            </h1>
            <p class="text-gray-600 mt-2">إدارة الخصومات والعروض الترويجية</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('admin.discounts.create')); ?>" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center">
                <i class="fas fa-plus "></i>
                <span class="mr-2">إضافة خصم جديد</span>
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-red-50 to-orange-50 p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-filter text-red-500 ml-2"></i>
                <span class="mr-2">البحث والفلترة</span>
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('admin.discounts.index')); ?>" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                <div class="lg:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">البحث</label>
                    <div class="relative">
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" 
                               id="search" name="search" value="<?php echo e(request('search')); ?>" placeholder="البحث في الأسماء والأكواد">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" id="status" name="status">
                        <option value="">جميع الحالات</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>مفعل</option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>غير مفعل</option>
                        <option value="deleted" <?php echo e(request('status') == 'deleted' ? 'selected' : ''); ?>>محذوف</option>
                    </select>
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">النوع</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" id="type" name="type">
                        <option value="">جميع الأنواع</option>
                        <option value="percentage" <?php echo e(request('type') == 'percentage' ? 'selected' : ''); ?>>نسبة مئوية</option>
                        <option value="fixed" <?php echo e(request('type') == 'fixed' ? 'selected' : ''); ?>>مبلغ ثابت</option>
                    </select>
                </div>
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">الترتيب</label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" id="sort" name="sort">
                        <option value="created_at" <?php echo e(request('sort') == 'created_at' ? 'selected' : ''); ?>>تاريخ الإنشاء</option>
                        <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>الاسم</option>
                        <option value="discount_value" <?php echo e(request('sort') == 'discount_value' ? 'selected' : ''); ?>>القيمة</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-search ml-2"></i>
                        <span class="mr-2">بحث</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Discounts Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-red-50 to-orange-50 p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-list text-red-500 ml-2"></i>
                <span class="mr-2">قائمة الخصومات</span>
                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-bold mr-3"><?php echo e($discounts->total()); ?> خصم</span>
            </h3>
        </div>
        <div class="p-6">
            <?php if($discounts->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-300" id="discountsTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">النوع</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">القيمة</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ البداية</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ النهاية</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $discounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-bold text-gray-900"><?php echo e($discount->name); ?></div>
                                            <?php if($discount->description): ?>
                                                <div class="text-xs text-gray-500 mt-1"><?php echo e(Str::limit($discount->description, 50)); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if($discount->discount_type == 'percentage'): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                
                                                نسبة مئوية
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                
                                                مبلغ ثابت
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">
                                            <?php if($discount->discount_type == 'percentage'): ?>
                                                <span class="text-green-600"><?php echo e($discount->discount_value); ?>%</span>
                                            <?php else: ?>
                                                <span class="text-blue-600"><?php echo e(number_format($discount->discount_value, 2)); ?> د.أ</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if($discount->starts_at): ?>
                                            <div class="text-xs text-gray-600"><?php echo e($discount->starts_at->format('Y-m-d')); ?></div>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-xs">غير محدد</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if($discount->ends_at): ?>
                                            <?php if($discount->ends_at->isPast()): ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-clock"></i>
                                                    <span class="mr-0">منتهي</span>
                                                </span>
                                            <?php else: ?>
                                                <div class="text-xs text-green-600 font-medium"><?php echo e($discount->ends_at->format('Y-m-d')); ?></div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-xs">غير محدد</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="sr-only status-toggle" 
                                                   data-id="<?php echo e($discount->id); ?>"
                                                   <?php echo e($discount->is_active ? 'checked' : ''); ?>>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-1">
                                            <a href="<?php echo e(route('admin.discounts.show', $discount)); ?>" 
                                               class="bg-blue-100 hover:bg-blue-200 text-blue-700 p-2 rounded-lg transition-colors"
                                               title="عرض التفاصيل">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.discounts.edit', $discount)); ?>" 
                                               class="bg-green-100 hover:bg-green-200 text-green-700 p-2 rounded-lg transition-colors"
                                               title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.discounts.products', $discount)); ?>" 
                                               class="bg-purple-100 hover:bg-purple-200 text-purple-700 p-2 rounded-lg transition-colors"
                                               title="إدارة المنتجات">
                                                <i class="fas fa-box"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.discounts.categories', $discount)); ?>" 
                                               class="bg-orange-100 hover:bg-orange-200 text-orange-700 p-2 rounded-lg transition-colors"
                                               title="إدارة الفئات">
                                                <i class="fas fa-tags"></i>
                                            </a>
                                            <form method="POST" action="<?php echo e(route('admin.discounts.destroy', $discount)); ?>" 
                                                  class="inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg transition-colors"
                                                        title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-6">
                    <?php echo e($discounts->appends(request()->query())->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-percentage text-3xl text-red-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">لا توجد خصومات</h3>
                    <p class="text-gray-600 mb-6">لم يتم العثور على أي خصومات بناءً على الفلاتر المحددة</p>
                    <a href="<?php echo e(route('admin.discounts.create')); ?>" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 inline-flex items-center">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة خصم جديد
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    const selectAllCheckbox = document.getElementById('selectAll');
    const discountCheckboxes = document.querySelectorAll('.discount-checkbox');
    const bulkActionBtn = document.getElementById('bulkActionBtn');

    selectAllCheckbox.addEventListener('change', function() {
        discountCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionButton();
    });

    // Individual checkbox change
    discountCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionButton);
    });

    // Status toggle
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const discountId = this.dataset.id;
            const isActive = this.checked;
            
            fetch(`/admin/discounts/${discountId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ is_active: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                } else {
                    showNotification('حدث خطأ أثناء تحديث الحالة', 'error');
                    this.checked = !isActive; // Revert toggle
                }
            })
            .catch(error => {
                showNotification('حدث خطأ أثناء تحديث الحالة', 'error');
                this.checked = !isActive; // Revert toggle
            });
        });
    });

    // Bulk action button
    bulkActionBtn.addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.discount-checkbox:checked')).map(cb => cb.value);
        document.getElementById('selectedCount').textContent = selectedIds.length;
        document.getElementById('bulkActionModal').classList.remove('hidden');
    });

    // Execute bulk action
    document.getElementById('executeBulkAction').addEventListener('click', function() {
        const action = document.getElementById('bulkAction').value;
        const selectedIds = Array.from(document.querySelectorAll('.discount-checkbox:checked')).map(cb => cb.value);

        if (!action) {
            showNotification('يرجى اختيار إجراء', 'error');
            return;
        }

        fetch('<?php echo e(route("admin.discounts.bulk-action")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                action: action,
                selected_items: selectedIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showNotification('حدث خطأ أثناء تنفيذ الإجراء', 'error');
            }
        })
        .catch(error => {
            showNotification('حدث خطأ أثناء تنفيذ الإجراء', 'error');
        });

        closeBulkModal();
    });

    function updateBulkActionButton() {
        const checkedCount = document.querySelectorAll('.discount-checkbox:checked').length;
        bulkActionBtn.disabled = checkedCount === 0;
        
        if (checkedCount > 0) {
            bulkActionBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            bulkActionBtn.classList.add('hover:bg-gray-600');
        } else {
            bulkActionBtn.classList.add('opacity-50', 'cursor-not-allowed');
            bulkActionBtn.classList.remove('hover:bg-gray-600');
        }
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 left-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} ml-2"></i>
                ${message}
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transform = 'translateX(-100%)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Initialize bulk action button state
    updateBulkActionButton();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/discounts/index.blade.php ENDPATH**/ ?>