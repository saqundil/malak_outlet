<!-- Best Sellers Section -->
<section class="my-12 md:my-16">
    <!-- Section Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div class="flex items-center">
            <div class="w-1.5 h-10 bg-gradient-to-b from-green-500 to-green-600 rounded-full ml-4"></div>
            <div class="flex flex-col">
                <h2 class="text-3xl md:text-4xl text-gray-800 font-bold">الأكثر مبيعاً</h2>
                <p class="text-gray-600 mt-1 text-sm">منتجات محبوبة من عملائنا</p>
            </div>
            <span class="mr-4 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-3 py-2 rounded-full shadow-lg">
                🔥 ترند
            </span>
        </div>
        <a href="<?php echo e(route('products.index', ['filter' => 'popular'])); ?>" 
           class="flex items-center text-orange-500 hover:text-orange-600 no-underline font-bold text-base group transition-all duration-300 bg-orange-50 hover:bg-orange-100 px-4 py-2 rounded-full">
            <span class="group-hover:ml-2 transition-all">عرض الكل</span>
            <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
        <?php if(isset($popularProducts) && $popularProducts->count() > 0): ?>
            <?php $__currentLoopData = $popularProducts->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-200 transform hover:-translate-y-2 relative flex flex-col h-full">
                    
                    <!-- Ranking Badge -->
                    <div class="absolute top-3 left-3 z-20">
                        <div class="bg-gradient-to-br from-yellow-400 via-orange-500 to-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-xs shadow-lg">
                            <?php echo e($index + 1); ?>

                        </div>
                    </div>
                    
                    <!-- Product Image -->
                    <div class="relative">
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="block">
                            <div class="h-48 md:h-56 relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                                <?php if($product->images->first()): ?>
                                    <img src="<?php echo e($product->images->first()->image_path); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                                <?php else: ?>
                                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Trending Badge -->
                                <div class="absolute top-3 right-3">
                                    <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold rounded-full py-1.5 px-2.5 shadow-lg animate-bounce">
                                        🔥 مطلوب
                                    </span>
                                </div>

                                <?php if($product->has_discount): ?>
                                    <!-- Discount Badge -->
                                    <div class="absolute bottom-3 left-3">
                                        <span class="bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-lg">
                                            خصم <?php echo e($product->discount_percentage); ?>%
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex-grow">
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>">
                                <h3 class="text-sm md:text-base font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors leading-snug min-h-[2.5rem]">
                                    <?php echo e($product->name); ?>

                                </h3>
                                
                                <!-- Rating Section -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <div class="flex text-yellow-400 mr-1">
                                            <?php $__currentLoopData = range(1, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $starIndex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <svg class="w-3 h-3 <?php echo e($starIndex <= round($product->average_rating ?? 4.5) ? 'fill-current' : 'text-gray-300'); ?>" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <span class="text-gray-500 text-xs">(<?php echo e(number_format($product->average_rating ?? 4.5, 1)); ?>)</span>
                                    </div>
                                    
                                    <div class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full font-semibold">
                                        <?php echo e(rand(100, 500)); ?>+ مبيع
                                    </div>
                                </div>
                                
                                <!-- Price Section -->
                                <div class="mb-4">
                                    <?php if($product->has_discount): ?>
                                        <div class="flex items-center gap-1 flex-wrap">
                                            <span class="text-lg font-bold text-orange-600"><?php echo e(number_format($product->final_price, 0)); ?> د.أ</span>
                                            <span class="text-sm text-gray-500 line-through"><?php echo e(number_format($product->price, 0)); ?> د.أ</span>
                                        </div>
                                        <div class="text-xs text-green-600 font-semibold mt-1">
                                            وفر <?php echo e(number_format($product->savings_amount, 0)); ?> د.أ
                                        </div>
                                    <?php else: ?>
                                        <span class="text-lg font-bold text-gray-800"><?php echo e(number_format($product->price, 0)); ?> د.أ</span>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </div>
                        
                        <!-- Action Buttons - Fixed at bottom -->
                        <div class="mt-auto">
                            <div class="flex items-center gap-2">
                                <?php if($product->quantity > 0 && $product->status == 'in_stock'): ?>
                                    <?php if($product->sizes && $product->sizes->count() > 0): ?>
                                        <!-- Products with sizes - redirect to product page -->
                                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                                           class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2.5 px-3 rounded-lg text-xs font-bold hover:from-orange-600 hover:to-orange-700 transition-all duration-300 text-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                            اختر المقاس
                                        </a>
                                    <?php else: ?>
                                        <!-- Regular products without sizes -->
                                        <button onclick="addToCart('<?php echo e($product->slug); ?>')" 
                                                class="flex-1 add-to-cart-btn bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2.5 px-3 rounded-lg text-xs font-bold hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                                                data-product-id="<?php echo e($product->slug); ?>">
                                            <span class="btn-text">أضف للسلة</span>
                                        </button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button disabled class="flex-1 bg-gray-300 text-gray-500 py-2.5 px-3 rounded-lg text-xs font-bold cursor-not-allowed">
                                        غير متوفر
                                    </button>
                                <?php endif; ?>
                                
                                <!-- Wishlist Button -->
                                <button onclick="toggleWishlist('<?php echo e($product->slug); ?>')" 
                                        class="wishlist-btn p-2.5 bg-gray-100 hover:bg-pink-50 text-gray-600 hover:text-pink-600 rounded-lg transition-all duration-300 shadow-sm hover:shadow-md transform hover:scale-110"
                                        data-product-slug="<?php echo e($product->slug); ?>">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="col-span-full text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">لا توجد منتجات</h3>
                    <p class="text-gray-500">لا توجد منتجات شائعة متاحة حالياً</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/partials/home/best-sellers.blade.php ENDPATH**/ ?>