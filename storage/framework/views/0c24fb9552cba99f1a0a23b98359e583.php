

<?php $__env->startSection('title', 'عرض الفئة: ' . $category->name); ?>
<?php $__env->startSection('page-title', 'عرض الفئة'); ?>
<?php $__env->startSection('page-description', $category->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Category Header -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex justify-between items-start">
            <div class="flex items-center gap-6">
                <?php if($category->image): ?>
                    <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-300">
                        <img src="<?php echo e($category->image); ?>" alt="<?php echo e($category->name); ?>" 
                             class="w-full h-full object-cover">
                    </div>
                <?php else: ?>
                    <div class="w-20 h-20 bg-orange-100 rounded-lg flex items-center justify-center border border-gray-300">
                        <i class="fas fa-tag text-orange-600 text-2xl"></i>
                    </div>
                <?php endif; ?>
                
                <div>
                    <h1 class="text-2xl font-bold text-gray-900"><?php echo e($category->name); ?></h1>
                    <?php if($category->slug): ?>
                        <p class="text-gray-600 mt-1"><?php echo e($category->slug); ?></p>
                    <?php endif; ?>
                    
                    <div class="flex items-center gap-4 mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            <?php echo e($category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($category->is_active ? 'نشطة' : 'غير نشطة'); ?>

                        </span>
                        
                        <?php if($category->sort_order !== null): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-sort ml-1"></i>
                                ترتيب: <?php echo e($category->sort_order); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-edit ml-2"></i>
                    تعديل
                </a>
                <a href="<?php echo e(route('categories.show', $category->slug)); ?>" target="_blank"
                   class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                    <i class="fas fa-external-link-alt ml-2"></i>
                    عرض في الموقع
                </a>
                <button onclick="deleteCategory()" 
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-trash ml-2"></i>
                    حذف
                </button>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Category Description -->
            <?php if($category->description): ?>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">وصف الفئة</h3>
                <div class="prose max-w-none text-gray-700">
                    <?php echo e($category->description); ?>

                </div>
            </div>
            <?php endif; ?>
            
            <!-- SEO Information -->
            <?php if($category->meta_title || $category->meta_description || $category->meta_keywords): ?>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">معلومات SEO</h3>
                
                <div class="space-y-4">
                    <?php if($category->meta_title): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">عنوان الصفحة:</span>
                            <span class="font-medium"><?php echo e($category->meta_title); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($category->meta_description): ?>
                        <div class="py-2 border-b border-gray-100">
                            <span class="text-gray-600 block mb-2">وصف الصفحة:</span>
                            <p class="text-gray-900"><?php echo e($category->meta_description); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($category->meta_keywords): ?>
                        <div class="py-2">
                            <span class="text-gray-600 block mb-2">الكلمات المفتاحية:</span>
                            <div class="flex flex-wrap gap-2">
                                <?php $__currentLoopData = explode(',', $category->meta_keywords); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <?php echo e(trim($keyword)); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Recent Products -->
            <?php if($recentProducts->count() > 0): ?>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">المنتجات الحديثة</h3>
                    <a href="<?php echo e(route('admin.products.index', ['category_id' => $category->slug])); ?>" 
                       class="text-orange-500 hover:text-orange-700 text-sm font-medium">
                        عرض جميع المنتجات
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $recentProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center gap-4">
                                <?php if($product->images->first()): ?>
                                    <img src="<?php echo e($product->images->first()->image_path); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="w-12 h-12 object-cover rounded-lg border border-gray-300">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-300">
                                        <i class="fas fa-box text-gray-400"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 truncate"><?php echo e($product->name); ?></h4>
                                    <p class="text-sm text-gray-600"><?php echo e(number_format($product->price, 2)); ?> د.أ</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            <?php echo e($product->stock_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                            <?php echo e($product->stock_quantity > 0 ? 'متوفر' : 'غير متوفر'); ?>

                                        </span>
                                        <?php if($product->sale_price): ?>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                تخفيض
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col gap-1">
                                    <a href="<?php echo e(route('admin.products.show', $product)); ?>" 
                                       class="text-blue-600 hover:text-blue-900 text-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.products.edit', $product)); ?>" 
                                       class="text-orange-600 hover:text-orange-900 text-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistics -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">إحصائيات الفئة</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">إجمالي المنتجات:</span>
                        <span class="font-bold text-2xl text-blue-600"><?php echo e($totalProducts); ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">المنتجات النشطة:</span>
                        <span class="font-bold text-2xl text-green-600"><?php echo e($activeProducts); ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">المنتجات غير النشطة:</span>
                        <span class="font-bold text-2xl text-red-600"><?php echo e($totalProducts - $activeProducts); ?></span>
                    </div>
                    
                    <?php if($totalRevenue > 0): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">إجمالي المبيعات:</span>
                            <span class="font-bold text-2xl text-orange-600"><?php echo e(number_format($totalRevenue, 2)); ?> د.أ</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Category Info -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات الفئة</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">تاريخ الإنشاء:</span>
                        <span class="font-medium"><?php echo e($category->created_at->format('d/m/Y H:i')); ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">آخر تحديث:</span>
                        <span class="font-medium"><?php echo e($category->updated_at->format('d/m/Y H:i')); ?></span>
                    </div>
                    
                    <?php if($category->slug): ?>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">الرابط المختصر:</span>
                            <span class="font-medium text-blue-600"><?php echo e($category->slug); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">إجراءات سريعة</h3>
                
                <div class="space-y-3">
                    <a href="<?php echo e(route('admin.products.index', ['category_id' => $category->slug])); ?>" 
                       class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-600 transition-colors block text-center">
                        <i class="fas fa-box ml-2"></i>
                        عرض منتجات الفئة
                    </a>
                    
                    <a href="<?php echo e(route('admin.products.create', ['category_id' => $category->slug])); ?>" 
                       class="w-full bg-green-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-green-600 transition-colors block text-center">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة منتج جديد
                    </a>
                    
                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                       class="w-full bg-orange-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors block text-center">
                        <i class="fas fa-edit ml-2"></i>
                        تعديل الفئة
                    </a>
                    
                    <button onclick="toggleStatus()" 
                            class="<?php echo e($category->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600'); ?> w-full text-white py-2 px-4 rounded-lg font-medium transition-colors">
                        <i class="fas fa-<?php echo e($category->is_active ? 'ban' : 'check'); ?> ml-2"></i>
                        <?php echo e($category->is_active ? 'إلغاء تفعيل' : 'تفعيل'); ?>

                    </button>
                    
                    <a href="<?php echo e(route('admin.categories.index')); ?>" 
                       class="w-full bg-gray-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors block text-center">
                        <i class="fas fa-arrow-left ml-2"></i>
                        العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 max-w-md w-full">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-trash text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">حذف الفئة</h3>
            <p class="text-sm text-gray-500 mb-6">
                هل أنت متأكد من حذف هذه الفئة؟ 
                <?php if($totalProducts > 0): ?>
                    <br><strong class="text-red-600">تحتوي الفئة على <?php echo e($totalProducts); ?> منتج وسيتم حذفها جميعاً.</strong>
                <?php endif; ?>
                <br>لا يمكن التراجع عن هذا الإجراء.
            </p>
            <div class="flex gap-3 justify-center">
                <button onclick="confirmDelete()" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    نعم، احذف
                </button>
                <button onclick="closeDeleteModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                    إلغاء
                </button>
            </div>
        </div>
    </div>
</div>

<form id="delete-form" action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function toggleStatus() {
        const isActive = <?php echo e($category->is_active ? 'true' : 'false'); ?>;
        const action = isActive ? 'إلغاء تفعيل' : 'تفعيل';
        
        if (confirm(`هل أنت متأكد من ${action} هذه الفئة؟`)) {
            fetch(`/admin/categories/<?php echo e($category->slug); ?>/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ is_active: !isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('حدث خطأ أثناء تحديث حالة الفئة');
                }
            })
            .catch(error => {
                alert('حدث خطأ أثناء تحديث حالة الفئة');
            });
        }
    }
    
    function deleteCategory() {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
    
    function confirmDelete() {
        document.getElementById('delete-form').submit();
    }
    
    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
    
    // Close modal with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
<?php $__env->stopPush(); ?>





<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/categories/show.blade.php ENDPATH**/ ?>