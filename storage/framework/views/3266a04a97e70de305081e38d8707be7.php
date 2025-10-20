<!-- New Arrivals Section -->
<section class="my-8 md:my-12">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="w-1 h-8 bg-gradient-to-b from-orange-500 to-orange-600 rounded-full ml-3"></div>
            <h2 class="text-2xl md:text-3xl text-gray-800 font-bold">وصل حديثاً</h2>
            <span class="mr-3 bg-orange-100 text-orange-600 text-xs font-bold px-2 py-1 rounded-full">جديد</span>
        </div>
        <a href="<?php echo e(route('products.index', ['filter' => 'new'])); ?>" class="flex items-center text-orange-500 no-underline font-bold text-sm md:text-base group">
            <span class="group-hover:ml-2 transition-all">عرض الكل</span>
            <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
        <?php if(isset($latestProducts) && $latestProducts->count() > 0): ?>
            <?php $__currentLoopData = $latestProducts->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-200 transform hover:-translate-y-1 flex flex-col h-full">
                    <div class="relative">
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="block">
                            <div class="h-40 md:h-48 relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                                <?php if($product->images->first()): ?>
                                    <img src="<?php echo e($product->images->first()->image_path); ?>" alt="<?php echo e($product->name); ?>" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
                                <?php else: ?>
                                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                        
                        <!-- New Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold rounded-full py-1 px-2 shadow-lg animate-pulse">
                                🆕 جديد
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-3 flex flex-col flex-grow">
                        <div class="flex-grow">
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>">
                                <h3 class="text-sm font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors min-h-[2.5rem]">
                                    <?php echo e(Str::limit($product->name, 40)); ?>

                                </h3>
                            </a>
                        </div>
                        
                        <!-- Price and Button - Fixed at bottom -->
                        <div class="mt-auto">
                            <div class="flex items-center justify-between">
                                <?php if($product->discount_percentage > 0): ?>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-orange-600"><?php echo e(number_format($product->final_price, 0)); ?> د.أ</span>
                                        <span class="text-xs text-gray-500 line-through"><?php echo e(number_format($product->price, 0)); ?> د.أ</span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-sm font-bold text-gray-800"><?php echo e(number_format($product->price, 0)); ?> د.أ</span>
                                <?php endif; ?>
                                
                                <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                                   class="bg-orange-500 text-white p-2 rounded-lg hover:bg-orange-600 transition-colors text-xs flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">لا توجد منتجات جديدة متاحة حالياً</p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/partials/home/new-arrivals.blade.php ENDPATH**/ ?>