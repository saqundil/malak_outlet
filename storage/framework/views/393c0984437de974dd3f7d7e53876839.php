

<?php $__env->startSection('title', 'سلة التسوق'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 mb-8 text-right">سلة التسوق</h1>

            <?php if(empty($cartItems)): ?>
                <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                    <div class="mb-8">
                        <div class="w-32 h-32 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m2.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6m-9 5a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">سلة التسوق فارغة</h2>
                    <p class="text-gray-600 mb-8 text-lg">اكتشف مجموعتنا الواسعة من المنتجات المميزة</p>
                    
                    <!-- Quick Category Links -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <a href="<?php echo e(route('products.category', 'clothing')); ?>" class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 group">
                            <i class="fas fa-tshirt text-blue-500 text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                            <h3 class="font-bold text-blue-800">الملابس</h3>
                            <p class="text-blue-600 text-sm">أحدث صيحات الموضة</p>
                        </a>
                        <a href="<?php echo e(route('products.category', 'sports-fitness')); ?>" class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 group">
                            <i class="fas fa-running text-green-500 text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                            <h3 class="font-bold text-green-800">الرياضة</h3>
                            <p class="text-green-600 text-sm">أحذية ومعدات رياضية</p>
                        </a>
                        <a href="<?php echo e(route('products.category', 'electronics')); ?>" class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 group">
                            <i class="fas fa-laptop text-purple-500 text-2xl mb-3 group-hover:scale-110 transition-transform"></i>
                            <h3 class="font-bold text-purple-800">الإلكترونيات</h3>
                            <p class="text-purple-600 text-sm">أجهزة ذكية وحديثة</p>
                        </a>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?php echo e(route('home')); ?>" class="inline-block bg-gradient-to-r from-orange-500 to-orange-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fas fa-home ml-2"></i>العودة للرئيسية
                        </a>
                        <a href="<?php echo e(route('products.index')); ?>" class="inline-block bg-white border-2 border-orange-500 text-orange-500 px-8 py-4 rounded-xl font-bold text-lg hover:bg-orange-50 transition-all duration-300">
                            <i class="fas fa-search ml-2"></i>تصفح المنتجات
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-6 text-right">المنتجات (<?php echo e(count($cartItems)); ?>)</h2>
                                
                                <div class="space-y-6">
                                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-center space-x-4 space-x-reverse border-b border-gray-200 pb-6" data-product-id="<?php echo e($item['product']->id); ?>">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0">
                                                <?php if($item['product']->images->first()): ?>
                                                    <img src="<?php echo e($item['product']->images->first()->image_url); ?>" 
                                                         alt="<?php echo e($item['product']->name); ?>" 
                                                         class="w-20 h-20 object-cover rounded-lg">
                                                <?php else: ?>
                                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Product Details -->
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-medium text-gray-900 text-right"><?php echo e($item['product']->name); ?></h3>
                                                <?php if($item['product']->brand): ?>
                                                    <p class="text-sm text-gray-500 text-right"><?php echo e($item['product']->brand->name); ?></p>
                                                <?php endif; ?>
                                                
                                                <!-- Size Information Enhanced -->
                                                <?php if(isset($item['size']) && $item['size']): ?>
                                                    <div class="mt-2 flex flex-wrap gap-2 text-right">
                                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-orange-100 to-orange-50 text-orange-800 border border-orange-200">
                                                            <i class="fas fa-shoe-prints ml-1 text-orange-600"></i>
                                                            الحجم: <?php echo e($item['size']->size); ?>

                                                        </span>
                                                        <?php if($item['size']->additional_price > 0): ?>
                                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 border border-blue-200">
                                                                <i class="fas fa-tag ml-1 text-blue-600"></i>
                                                                إضافي: +<?php echo e(number_format($item['size']->additional_price, 0)); ?> د.أ
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php if($item['size']->stock_quantity <= 5): ?>
                                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-yellow-100 to-yellow-50 text-yellow-800 border border-yellow-200">
                                                                <i class="fas fa-exclamation-triangle ml-1 text-yellow-600"></i>
                                                                <?php echo e($item['size']->stock_quantity); ?> قطع متبقية
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <!-- Price -->
                                                <div class="mt-2 text-right">
                                                    <span class="text-lg font-bold text-gray-900"><?php echo e(number_format($item['price'], 2)); ?> د.أ</span>
                                                    <?php if(isset($item['size']) && $item['size'] && $item['size']->additional_price > 0): ?>
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            (السعر الأساسي: <?php echo e(number_format($item['price'] - $item['size']->additional_price, 2)); ?> د.أ)
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <!-- Quantity Controls -->
                                            <div class="flex items-center space-x-2 space-x-reverse">
                                                <button onclick="updateQuantity('<?php echo e($item['cart_key']); ?>', <?php echo e($item['quantity'] - 1); ?>)" 
                                                        class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition duration-200"
                                                        <?php echo e($item['quantity'] <= 1 ? 'disabled' : ''); ?>>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                </button>
                                                
                                                <span class="w-12 text-center font-medium quantity-display"><?php echo e($item['quantity']); ?></span>
                                                
                                                <button onclick="updateQuantity('<?php echo e($item['cart_key']); ?>', <?php echo e($item['quantity'] + 1); ?>)"
                                                        class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Subtotal -->
                                            <div class="text-right">
                                                <div class="text-lg font-bold text-gray-900 subtotal"><?php echo e(number_format($item['subtotal'], 2)); ?> د.أ</div>
                                            </div>

                                            <!-- Remove Button -->
                                            <button onclick="removeFromCart('<?php echo e($item['cart_key']); ?>')" 
                                                    class="text-red-500 hover:text-red-700 transition duration-200 p-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6 text-right">ملخص الطلب</h2>
                            
                            <div class="space-y-4">
                                <!-- Cart Statistics -->
                                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                                    <div class="grid grid-cols-2 gap-4 text-center">
                                        <div>
                                            <div class="text-2xl font-bold text-orange-600"><?php echo e(count($cartItems)); ?></div>
                                            <div class="text-sm text-gray-600">منتج مختلف</div>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-orange-600"><?php echo e(array_sum(array_column($cartItems, 'quantity'))); ?></div>
                                            <div class="text-sm text-gray-600">إجمالي القطع</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">المجموع الفرعي</span>
                                    <span class="font-medium" id="subtotal"><?php echo e(number_format($total, 2)); ?> د.أ</span>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">الشحن</span>
                                    <span class="font-medium">مجاني</span>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-900">الإجمالي</span>
                                        <span class="text-xl font-bold text-orange-600" id="total"><?php echo e(number_format($total, 2)); ?> د.أ</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 space-y-3">
                                <?php if(auth()->guard()->check()): ?>
                                    <a href="<?php echo e(route('checkout.index')); ?>" class="block w-full bg-orange-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-600 transition duration-300 text-center">
                                        إتمام الطلب
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('login')); ?>" class="block w-full bg-orange-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-600 transition duration-300 text-center">
                                        تسجيل الدخول لإتمام الطلب
                                    </a>
                                <?php endif; ?>
                                
                                <a href="<?php echo e(route('home')); ?>" class="block w-full text-center bg-gray-100 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-200 transition duration-300">
                                    متابعة التسوق
                                </a>
                                
                                <button onclick="clearCart()" class="w-full text-red-500 py-2 px-4 rounded-lg font-medium hover:bg-red-50 transition duration-300">
                                    مسح السلة
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function updateQuantity(cartKey, quantity) {
    if (quantity < 1) return;
    
    fetch('<?php echo e(route("cart.update", ":cartKey")); ?>'.replace(':cartKey', cartKey), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ 
            quantity: quantity,
            cart_key: cartKey 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function removeFromCart(cartKey) {
    if (confirm('هل أنت متأكد من حذف هذا المنتج؟')) {
        fetch('<?php echo e(route("cart.remove", ":cartKey")); ?>'.replace(':cartKey', cartKey), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function clearCart() {
    if (confirm('هل أنت متأكد من مسح السلة بالكامل؟')) {
        fetch('<?php echo e(route("cart.clear")); ?>', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/cart/index.blade.php ENDPATH**/ ?>