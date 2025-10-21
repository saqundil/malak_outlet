<!-- Sale Products Section -->
<section class="my-8 md:my-12">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="w-1 h-8 bg-gradient-to-b from-red-500 to-red-600 rounded-full ml-3"></div>
            <h2 class="text-2xl md:text-3xl text-gray-800 font-bold">عروض وخصومات</h2>
            <span class="mr-3 bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded-full animate-pulse">🏷️ خصم</span>
        </div>
        <a href="<?php echo e(route('products.index', ['filter' => 'sale'])); ?>" class="flex items-center text-orange-500 no-underline font-bold text-sm md:text-base group">
            <span class="group-hover:ml-2 transition-all">عرض الكل</span>
            <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php if(isset($saleProducts) && $saleProducts->count() > 0): ?>
            <?php $__currentLoopData = $saleProducts->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-red-100 hover:border-red-300 transform hover:-translate-y-2 relative">
                    <div class="relative">
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="block">
                            <div class="h-56 relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                                <?php if($product->images->first()): ?>
                                    <img src="<?php echo e($product->images->first()->image_path); ?>" alt="<?php echo e($product->name); ?>" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                <?php else: ?>
                                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Big Sale Badge -->
                                <div class="absolute top-3 right-3">
                                    <?php if($product->discount_percentage > 0): ?>
                                        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg px-3 py-2 shadow-lg transform -rotate-12">
                                            <div class="text-xs font-bold">خصم</div>
                                            <div class="text-lg font-black"><?php echo e($product->discount_percentage); ?>%</div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="p-4">
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>">
                            <h3 class="text-base font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                <?php echo e($product->name); ?>

                            </h3>
                            
                            <!-- Price with prominent savings -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xl font-bold text-red-600"><?php echo e(number_format($product->final_price, 0)); ?> د.أ</span>
                                    <span class="text-sm text-gray-500 line-through"><?php echo e(number_format($product->price, 0)); ?> د.أ</span>
                                </div>
                                <div class="bg-green-50 text-green-700 text-xs font-bold px-3 py-1 rounded-full w-fit">
                                    وفّر <?php echo e(number_format($product->savings_amount, 0)); ?> د.أ
                                </div>
                            </div>
                        </a>
                        
                        <!-- Action Button -->
                        <?php if($product->sizes && $product->sizes->count() > 0): ?>
                            <!-- Product has sizes - redirect to product page -->
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                               class="block w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-bold py-3 px-4 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg text-center">
                                <span class="flex items-center justify-center">
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    اختر المقاس
                                </span>
                            </a>
                        <?php else: ?>
                            <!-- Product without sizes - direct add to cart -->
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-bold py-3 px-4 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg"
                                    data-product-id="<?php echo e($product->slug); ?>">
                                <span class="btn-text flex items-center justify-center">
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5m6 0L18 18H9m6 0a2 2 0 11-4 0m4 0a2 2 0 11-4 0m4 0h2a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                    اشتري بالخصم
                                </span>
                                <span class="loading-text hidden">
                                    <span class="flex items-center justify-center">
                                        <svg class="animate-spin w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        جاري الإضافة...
                                    </span>
                                </span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">لا توجد منتجات بخصم متاحة حالياً</p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/partials/home/sale-products.blade.php ENDPATH**/ ?>