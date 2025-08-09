

<?php $__env->startSection('title', 'عرض المنتج: ' . $product->name); ?>
<?php $__env->startSection('page-title', 'عرض المنتج'); ?>
<?php $__env->startSection('page-description', $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Product Header -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900"><?php echo e($product->name); ?></h1>
                <p class="text-gray-600 mt-1">رقم المنتج: <?php echo e($product->sku); ?></p>
                <div class="flex items-center gap-4 mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        <?php echo e($product->stock_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                        <?php echo e($product->stock_quantity > 0 ? 'متوفر' : 'غير متوفر'); ?>

                    </span>
                    <?php if($product->sale_price): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                            <i class="fas fa-tag ml-1"></i>
                            تخفيض
                        </span>
                    <?php endif; ?>
                    <?php if($product->is_featured): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            <i class="fas fa-star ml-1"></i>
                            مميز
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="<?php echo e(route('admin.products.edit', $product)); ?>" 
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-edit ml-2"></i>
                    تعديل
                </a>
                <a href="<?php echo e(route('products.show', $product)); ?>" target="_blank"
                   class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                    <i class="fas fa-external-link-alt ml-2"></i>
                    عرض في الموقع
                </a>
                <button onclick="deleteProduct()" 
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
            <!-- Product Images -->
            <?php if($product->images->count() > 0): ?>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">صور المنتج</h3>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="relative group">
                            <img src="<?php echo e($image->image_path); ?>" alt="<?php echo e($product->name); ?>" 
                                 class="w-full h-48 object-cover rounded-lg border border-gray-300 cursor-pointer hover:opacity-75 transition-opacity"
                                 onclick="openImageModal('<?php echo e($image->image_path); ?>')">
                            <?php if($image->is_primary): ?>
                                <div class="absolute top-2 right-2 bg-orange-500 text-white text-xs px-2 py-1 rounded">
                                    <i class="fas fa-star"></i>
                                    الصورة الرئيسية
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Product Description -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">وصف المنتج</h3>
                <div class="prose max-w-none text-gray-700">
                    <?php echo e($product->description); ?>

                </div>
            </div>
            
            <!-- Product Specifications -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">مواصفات المنتج</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php if($product->weight): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">الوزن:</span>
                            <span class="font-medium"><?php echo e($product->weight); ?> كجم</span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($product->dimensions): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">الأبعاد:</span>
                            <span class="font-medium"><?php echo e($product->dimensions); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($product->materials): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">المواد:</span>
                            <span class="font-medium"><?php echo e($product->materials); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($product->country_of_origin): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">بلد المنشأ:</span>
                            <span class="font-medium"><?php echo e($product->country_of_origin); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($product->warranty_period): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">فترة الضمان:</span>
                            <span class="font-medium"><?php echo e($product->warranty_period); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($product->suitable_age): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">العمر المناسب:</span>
                            <span class="font-medium"><?php echo e($product->suitable_age); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($product->pieces_count): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">عدد القطع:</span>
                            <span class="font-medium"><?php echo e($product->pieces_count); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($product->standards): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">المعايير:</span>
                            <span class="font-medium"><?php echo e($product->standards); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($product->battery_type): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">نوع البطارية:</span>
                            <span class="font-medium"><?php echo e($product->battery_type); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(isset($product->washable)): ?>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">قابل للغسل:</span>
                            <span class="font-medium"><?php echo e($product->washable ? 'نعم' : 'لا'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Product Reviews -->
            <?php if($product->reviews->count() > 0): ?>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">التقييمات والمراجعات</h3>
                
                <div class="space-y-4">
                    <?php $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border-b border-gray-100 pb-4 last:border-b-0">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <h4 class="font-medium text-gray-900"><?php echo e($review->user->name); ?></h4>
                                    <div class="flex items-center">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star text-sm <?php echo e($i <= $review->rating ? 'text-yellow-400' : 'text-gray-300'); ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500"><?php echo e($review->created_at->format('d/m/Y')); ?></span>
                            </div>
                            <?php if($review->comment): ?>
                                <p class="text-gray-700"><?php echo e($review->comment); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Pricing Info -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات السعر</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">السعر الأساسي:</span>
                        <span class="text-lg font-bold text-gray-900"><?php echo e(number_format($product->price, 2)); ?> د.أ</span>
                    </div>
                    
                    <?php if($product->sale_price): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">سعر التخفيض:</span>
                            <span class="text-lg font-bold text-orange-500"><?php echo e(number_format($product->sale_price, 2)); ?> د.أ</span>
                        </div>
                        
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">مقدار التوفير:</span>
                            <span class="text-green-600 font-medium">
                                <?php echo e(number_format($product->price - $product->sale_price, 2)); ?> د.أ 
                                (<?php echo e(round((($product->price - $product->sale_price) / $product->price) * 100)); ?>%)
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Stock & Category Info -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات إضافية</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">الفئة:</span>
                        <span class="font-medium"><?php echo e($product->category->name); ?></span>
                    </div>
                    
                    <?php if($product->brand): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">العلامة التجارية:</span>
                            <span class="font-medium"><?php echo e($product->brand->name); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">كمية المخزون:</span>
                        <span class="font-medium <?php echo e($product->stock_quantity < 10 ? 'text-red-500' : 'text-green-600'); ?>">
                            <?php echo e($product->stock_quantity); ?>

                            <?php if($product->stock_quantity < 10): ?>
                                <i class="fas fa-exclamation-triangle ml-1"></i>
                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">تاريخ الإنشاء:</span>
                        <span class="text-sm text-gray-500"><?php echo e($product->created_at->format('d/m/Y H:i')); ?></span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">آخر تحديث:</span>
                        <span class="text-sm text-gray-500"><?php echo e($product->updated_at->format('d/m/Y H:i')); ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">إحصائيات المنتج</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">عدد المراجعات:</span>
                        <span class="font-medium"><?php echo e($product->reviews->count()); ?></span>
                    </div>
                    
                    <?php if($product->reviews->count() > 0): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">متوسط التقييم:</span>
                            <div class="flex items-center gap-2">
                                <span class="font-medium"><?php echo e(number_format($product->reviews->avg('rating'), 1)); ?></span>
                                <div class="flex">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star text-sm <?php echo e($i <= round($product->reviews->avg('rating')) ? 'text-yellow-400' : 'text-gray-300'); ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">في قائمة الرغبات:</span>
                        <span class="font-medium"><?php echo e($product->favorites->count()); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-screen">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl z-10 bg-black bg-opacity-50 w-10 h-10 rounded-full flex items-center justify-center hover:bg-opacity-75">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 max-w-md w-full">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-trash text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">حذف المنتج</h3>
            <p class="text-sm text-gray-500 mb-6">هل أنت متأكد من حذف هذا المنتج؟ لا يمكن التراجع عن هذا الإجراء.</p>
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

<form id="delete-form" action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function openImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
    }
    
    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }
    
    function deleteProduct() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    function confirmDelete() {
        document.getElementById('delete-form').submit();
    }
    
    // Close modals when clicking outside
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
    
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
    
    // Close modals with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
            closeDeleteModal();
        }
    });
</script>
<?php $__env->stopPush(); ?>





<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/products/show.blade.php ENDPATH**/ ?>