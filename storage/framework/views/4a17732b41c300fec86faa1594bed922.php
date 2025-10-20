

<?php $__env->startSection('title', 'تعديل المدينة - ' . $city->display_name); ?>
<?php $__env->startSection('page-title', 'تعديل المدينة'); ?>
<?php $__env->startSection('page-description', 'تعديل معلومات وإعدادات مدينة ' . $city->display_name); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        margin-bottom: 24px;
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.2s ease;
    }
    .form-input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .form-input.error {
        border-color: #ef4444;
    }
    .form-error {
        color: #ef4444;
        font-size: 14px;
        margin-top: 4px;
    }
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    .action-btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        min-width: 120px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
    }
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }
    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        color: white;
        text-decoration: none;
    }
    .preview-card {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 12px;
        padding: 20px;
        border: 2px dashed #cbd5e1;
        transition: all 0.3s ease;
    }
    .preview-active {
        border-color: #3b82f6;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    }
    .stats-mini {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 8px;
        padding: 12px;
        margin-top: 16px;
        text-align: center;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">تعديل المدينة</h1>
            <p class="text-gray-600 mt-2">تحديث معلومات وإعدادات <?php echo e($city->display_name); ?></p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.cities.show', $city)); ?>" class="action-btn btn-secondary">
                <i class="fas fa-eye"></i>
                عرض
            </a>
            <a href="<?php echo e(route('admin.cities.index')); ?>" class="action-btn btn-secondary">
                <i class="fas fa-arrow-right"></i>
                العودة
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="form-card">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-edit ml-3 text-blue-600"></i>
                    تعديل معلومات المدينة
                </h2>

                <form action="<?php echo e(route('admin.cities.update', $city)); ?>" method="POST" id="cityForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Arabic Name -->
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-font ml-1 text-gray-500"></i>
                                الاسم العربي *
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-input <?php echo e($errors->has('name') ? 'error' : ''); ?>"
                                value="<?php echo e(old('name', $city->name_ar)); ?>"
                                placeholder="أدخل اسم المدينة بالعربية"
                                required
                            >
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="form-error"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- English Name -->
                        <div class="form-group">
                            <label for="name_en" class="form-label">
                                <i class="fas fa-font ml-1 text-gray-500"></i>
                                الاسم الإنجليزي
                            </label>
                            <input 
                                type="text" 
                                id="name_en" 
                                name="name_en" 
                                class="form-input <?php echo e($errors->has('name_en') ? 'error' : ''); ?>"
                                value="<?php echo e(old('name_en', $city->name_en)); ?>"
                                placeholder="Enter city name in English"
                            >
                            <?php $__errorArgs = ['name_en'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="form-error"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Delivery Cost -->
                        <div class="form-group">
                            <label for="delivery_cost" class="form-label">
                                <i class="fas fa-dollar-sign ml-1 text-gray-500"></i>
                                تكلفة التوصيل (د.أ) *
                            </label>
                            <input 
                                type="number" 
                                id="delivery_cost" 
                                name="delivery_cost" 
                                class="form-input <?php echo e($errors->has('delivery_cost') ? 'error' : ''); ?>"
                                value="<?php echo e(old('delivery_cost', $city->delivery_cost)); ?>"
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                                required
                            >
                            <?php $__errorArgs = ['delivery_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="form-error"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Delivery Days -->
                        <div class="form-group">
                            <label for="delivery_days" class="form-label">
                                <i class="fas fa-clock ml-1 text-gray-500"></i>
                                مدة التوصيل (أيام)
                            </label>
                            <select id="delivery_days" name="delivery_days" class="form-input <?php echo e($errors->has('delivery_days') ? 'error' : ''); ?>">
                                <option value="1" <?php echo e(old('delivery_days', $city->delivery_days) == 1 ? 'selected' : ''); ?>>يوم واحد</option>
                                <option value="2" <?php echo e(old('delivery_days', $city->delivery_days) == 2 ? 'selected' : ''); ?>>يومين</option>
                                <option value="3" <?php echo e(old('delivery_days', $city->delivery_days) == 3 ? 'selected' : ''); ?>>3 أيام</option>
                                <option value="4" <?php echo e(old('delivery_days', $city->delivery_days) == 4 ? 'selected' : ''); ?>>4 أيام</option>
                                <option value="5" <?php echo e(old('delivery_days', $city->delivery_days) == 5 ? 'selected' : ''); ?>>5 أيام</option>
                                <option value="7" <?php echo e(old('delivery_days', $city->delivery_days) == 7 ? 'selected' : ''); ?>>أسبوع</option>
                                <option value="10" <?php echo e(old('delivery_days', $city->delivery_days) == 10 ? 'selected' : ''); ?>>10 أيام</option>
                                <option value="14" <?php echo e(old('delivery_days', $city->delivery_days) == 14 ? 'selected' : ''); ?>>أسبوعين</option>
                            </select>
                            <?php $__errorArgs = ['delivery_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="form-error"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Status Toggle -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-toggle-on ml-1 text-gray-500"></i>
                            حالة المدينة
                        </label>
                        <div class="flex items-center gap-4">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $city->is_active) ? 'checked' : ''); ?>>
                                <span class="slider"></span>
                            </label>
                            <span class="text-gray-700" id="statusText">
                                <?php echo e(old('is_active', $city->is_active) ? 'نشط' : 'غير نشط'); ?>

                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            عندما تكون المدينة غير نشطة، لن تظهر كخيار للعملاء عند الطلب
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t">
                        <div class="flex items-center gap-3">
                            <button type="submit" class="action-btn btn-primary">
                                <i class="fas fa-save"></i>
                                حفظ التغييرات
                            </button>
                            <a href="<?php echo e(route('admin.cities.index')); ?>" class="action-btn btn-secondary">
                                <i class="fas fa-times"></i>
                                إلغاء
                            </a>
                        </div>
                        
                        <button type="button" onclick="confirmDelete()" class="action-btn btn-danger">
                            <i class="fas fa-trash"></i>
                            حذف المدينة
                        </button>
                    </div>
                </form>
                
                <!-- Separate Delete Form -->
                <form action="<?php echo e(route('admin.cities.destroy', $city)); ?>" method="POST" id="deleteForm" class="hidden">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                </form>
            </div>
        </div>

        <!-- Preview & Statistics -->
        <div class="space-y-6">
            <!-- Live Preview -->
            <div class="form-card">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-eye ml-2 text-green-600"></i>
                    معاينة مباشرة
                </h3>
                
                <div id="cityPreview" class="preview-card">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center ml-2">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900" id="previewName"><?php echo e($city->display_name); ?></div>
                                <div class="text-sm text-gray-500" id="previewNameEn"><?php echo e($city->name_en ?: 'لا يوجد اسم إنجليزي'); ?></div>
                            </div>
                        </div>
                        <div id="previewStatus" class="px-2 py-1 text-xs rounded-full <?php echo e($city->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($city->is_active ? 'نشط' : 'غير نشط'); ?>

                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">تكلفة التوصيل:</span>
                            <span class="font-bold text-green-600" id="previewCost"><?php echo e(number_format($city->delivery_cost, 2)); ?> د.أ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">مدة التوصيل:</span>
                            <span class="font-medium text-orange-600" id="previewDays"><?php echo e($city->delivery_days); ?> <?php echo e($city->delivery_days == 1 ? 'يوم' : 'أيام'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Statistics -->
            <div class="form-card">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-bar ml-2 text-purple-600"></i>
                    إحصائيات حالية
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <span class="text-blue-700 font-medium">إجمالي الطلبات</span>
                        <span class="text-blue-900 font-bold"><?php echo e($city->orders_count ?? 0); ?></span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <span class="text-green-700 font-medium">إيرادات التوصيل</span>
                        <span class="text-green-900 font-bold"><?php echo e(number_format(($city->orders_count ?? 0) * $city->delivery_cost, 2)); ?> د.أ</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                        <span class="text-orange-700 font-medium">آخر طلب</span>
                        <span class="text-orange-900 font-medium">
                            <?php if($city->orders()->latest()->first()): ?>
                                <?php echo e($city->orders()->latest()->first()->created_at->diffForHumans()); ?>

                            <?php else: ?>
                                لا يوجد
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                <?php if($city->orders_count > 0): ?>
                <div class="stats-mini mt-4">
                    <div class="text-sm font-medium text-amber-800 mb-1">متوسط الطلبات الشهرية</div>
                    <div class="text-lg font-bold text-amber-900">
                        <?php echo e(number_format($city->orders_count / max(1, $city->created_at->diffInMonths(now()) ?: 1), 1)); ?>

                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live preview functionality
    const nameInput = document.getElementById('name');
    const nameEnInput = document.getElementById('name_en');
    const costInput = document.getElementById('delivery_cost');
    const daysSelect = document.getElementById('delivery_days');
    const statusToggle = document.querySelector('input[name="is_active"]');
    
    const previewName = document.getElementById('previewName');
    const previewNameEn = document.getElementById('previewNameEn');
    const previewCost = document.getElementById('previewCost');
    const previewDays = document.getElementById('previewDays');
    const previewStatus = document.getElementById('previewStatus');
    const previewCard = document.getElementById('cityPreview');
    const statusText = document.getElementById('statusText');

    function updatePreview() {
        // Update name
        if (nameInput.value.trim()) {
            previewName.textContent = nameInput.value.trim();
        }

        // Update English name
        if (nameEnInput.value.trim()) {
            previewNameEn.textContent = nameEnInput.value.trim();
        } else {
            previewNameEn.textContent = 'لا يوجد اسم إنجليزي';
        }

        // Update cost
        if (costInput.value) {
            previewCost.textContent = parseFloat(costInput.value).toFixed(2) + ' د.أ';
        }

        // Update days
        if (daysSelect.value) {
            const days = parseInt(daysSelect.value);
            previewDays.textContent = days + (days === 1 ? ' يوم' : ' أيام');
        }

        // Update status
        const isActive = statusToggle.checked;
        statusText.textContent = isActive ? 'نشط' : 'غير نشط';
        previewStatus.textContent = isActive ? 'نشط' : 'غير نشط';
        previewStatus.className = 'px-2 py-1 text-xs rounded-full ' + 
            (isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800');

        // Update preview card style
        previewCard.className = 'preview-card ' + (isActive ? 'preview-active' : '');
    }

    // Add event listeners
    nameInput.addEventListener('input', updatePreview);
    nameEnInput.addEventListener('input', updatePreview);
    costInput.addEventListener('input', updatePreview);
    daysSelect.addEventListener('change', updatePreview);
    statusToggle.addEventListener('change', updatePreview);

    // Form validation
    document.getElementById('cityForm').addEventListener('submit', function(e) {
        console.log('Form submission triggered'); // Debug log
        
        let isValid = true;
        
        // Clear previous errors
        document.querySelectorAll('.form-input').forEach(input => {
            input.classList.remove('error');
        });

        // Validate name
        if (!nameInput.value.trim()) {
            nameInput.classList.add('error');
            isValid = false;
            console.log('Name validation failed'); // Debug log
        }

        // Validate delivery cost
        if (!costInput.value || parseFloat(costInput.value) < 0) {
            costInput.classList.add('error');
            isValid = false;
            console.log('Cost validation failed'); // Debug log
        }

        if (!isValid) {
            e.preventDefault();
            alert('يرجى تصحيح الأخطاء في النموذج');
            return false;
        }
        
        console.log('Form validation passed, submitting...'); // Debug log
        return true;
    });
});

// Delete confirmation function
function confirmDelete() {
    if (confirm('هل أنت متأكد من حذف هذه المدينة؟ سيؤثر هذا على جميع الطلبات المرتبطة بها.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/cities/edit.blade.php ENDPATH**/ ?>