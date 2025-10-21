

<?php $__env->startSection('title', $product->name . ' - Malak Outlet'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .product-image-zoom {
            transition: transform 0.3s ease;
        }

        .product-image-zoom:hover {
            transform: scale(1.05);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .prose {
            max-width: none;
        }

        .prose p {
            margin-bottom: 1rem;
            line-height: 1.8;
        }

        .notification {
            backdrop-filter: blur(10px);
        }

        .rating-bar {
            width: 0%;
            transition: width 0.8s ease-in-out;
        }

        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gray-50" x-data="productPage()">
        <!-- Professional Breadcrumb -->
        <div class="bg-white shadow-sm border-b">
            <div class="container mx-auto px-4 py-4" style="max-width: 1400px;">
                <nav class="flex items-center text-sm text-gray-600" dir="rtl">
                    <a href="<?php echo e(route('home')); ?>" class="hover:text-orange-500 transition-colors">
                        <i class="fas fa-home ml-2"></i>الرئيسية
                    </a>
                    <i class="fas fa-chevron-left mx-3 text-gray-400"></i>
                    <a href="<?php echo e(route('products.category', $product->category->slug)); ?>"
                        class="hover:text-orange-500 transition-colors">
                        <?php echo e($product->category->name); ?>

                    </a>
                    <?php if($product->brand): ?>
                        <i class="fas fa-chevron-left mx-3 text-gray-400"></i>
                        <span class="text-gray-500"><?php echo e($product->brand->name); ?></span>
                    <?php endif; ?>
                    <i class="fas fa-chevron-left mx-3 text-gray-400"></i>
                    <span class="text-gray-900 font-medium"><?php echo e(Str::limit($product->name, 30)); ?></span>
                </nav>
            </div>
        </div>
 <div x-show="showSizeGuide" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto"
        x-cloak style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black opacity-50" @click="showSizeGuide = false"></div>

            <div class="relative bg-white rounded-2xl max-w-2xl w-full p-8 shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">دليل المقاسات</h3>
                    <button @click="showSizeGuide = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="space-y-6" dir="rtl">
                    <!-- Shoes Size Guide -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">مقاسات الأحذية</h4>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm border-collapse border border-gray-300">
                                <thead>
                                    <tr class="bg-orange-50">
                                        <th class="border border-gray-300 px-3 py-2">المقاس الأوروبي</th>
                                        <th class="border border-gray-300 px-3 py-2">طول القدم (سم)</th>
                                        <th class="border border-gray-300 px-3 py-2">المقاس الأمريكي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-gray-300 px-3 py-2 text-center">38</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">24.0</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">6</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-3 py-2 text-center">39</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">24.7</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">6.5</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-3 py-2 text-center">40</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">25.3</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">7</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-3 py-2 text-center">41</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">26.0</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">8</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-3 py-2 text-center">42</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">26.7</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">8.5</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-3 py-2 text-center">43</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">27.3</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">9</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-3 py-2 text-center">44</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">28.0</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">10</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-3 py-2 text-center">45</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">28.7</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">11</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-300 px-3 py-2 text-center">46</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">29.3</td>
                                        <td class="border border-gray-300 px-3 py-2 text-center">12</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- How to measure -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">كيفية قياس قدمك</h4>
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <ol class="list-decimal list-inside space-y-2 text-gray-700">
                                <li>ضع قدمك على ورقة وأنت واقف</li>
                                <li>ضع علامة عند أطول نقطة في قدمك</li>
                                <li>اقس المسافة من الكعب إلى العلامة</li>
                                <li>قارن النتيجة مع الجدول أعلاه</li>
                                <li>ننصح بإضافة 0.5 سم للراحة</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">نصائح مهمة</h4>
                        <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
                            <ul class="list-disc list-inside space-y-2 text-gray-700">
                                <li>قس قدمك في نهاية اليوم عندما تكون في أكبر حجم لها</li>
                                <li>إذا كان هناك اختلاف بين القدمين، اختر المقاس الأكبر</li>
                                <li>المقاسات قد تختلف قليلاً بين العلامات التجارية</li>
                                <li>يمكنك التواصل معنا لمساعدتك في اختيار المقاس المناسب</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <button @click="showSizeGuide = false"
                        class="bg-orange-500 text-white px-6 py-3 rounded-xl font-medium hover:bg-orange-600 transition-colors">
                        فهمت، شكراً
                    </button>
                </div>
            </div>
        </div>
    </div>
        <main class="container mx-auto px-4 py-8" style="max-width: 1400px;">
            <!-- Product Main Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                    <!-- Professional Product Gallery -->
                    <div class="p-6 lg:p-8">
                        <!-- Main Product Image -->
                        <div class="relative mb-6">
                            <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden group">
                                <?php if($product->images->first()): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->images->first()->image_path)); ?>" alt="<?php echo e($product->name); ?>"
                                        class="w-full h-full object-cover product-image-zoom cursor-zoom-in" id="main-image">
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="fas fa-image text-6xl text-gray-400 mb-4"></i>
                                            <p class="text-gray-500">لا توجد صورة متاحة</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Sale Badge -->
                            <?php if($product->has_discount): ?>
                                <div
                                    class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    وفر
                                    <?php echo e(number_format($product->discount_percentage, 0)); ?>%
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Thumbnail Gallery -->
                        <?php if($product->images->count() > 1): ?>
                            <div class="flex gap-3 overflow-x-auto pb-2">
                                <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden cursor-pointer border-2 transition-all duration-200 <?php echo e($index === 0 ? 'border-orange-500' : 'border-transparent hover:border-gray-300'); ?> thumbnail-image"
                                        data-image-url="<?php echo e(asset('storage/' . $image->image_path)); ?>">
                                        <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>" alt="<?php echo e($product->name); ?>"
                                            class="w-full h-full object-cover">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Professional Product Details -->
                    <div class="p-6 lg:p-8 bg-gray-50" dir="rtl">
                        <!-- Product Header -->
                        <div class="mb-6">
                            <?php if($product->brand): ?>
                                <div class="flex items-center mb-3">
                                    <span
                                        class="text-sm text-gray-500 bg-gray-200 px-3 py-1 rounded-full"><?php echo e($product->brand->name); ?></span>
                                </div>
                            <?php endif; ?>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3 leading-tight"><?php echo e($product->name); ?>

                            </h1>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span>رقم المنتج: <?php echo e($product->sku); ?></span>
                                <span>•</span>
                                <span>الفئة: <?php echo e($product->category->name); ?></span>
                            </div>
                        </div>

                        <!-- Price Section -->
                        <div class="mb-8 p-6 bg-white rounded-xl border">
                            <?php if($product->has_discount): ?>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span
                                            class="text-3xl lg:text-4xl font-bold text-orange-600"><?php echo e(number_format($product->final_price, 2)); ?>

                                            د.أ</span>
                                        <span class="bg-red-100 text-red-800 text-sm font-bold px-3 py-1 rounded-full">
                                            خصم
                                            <?php echo e(number_format($product->discount_percentage, 0)); ?>%
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-lg text-gray-500 line-through"><?php echo e(number_format($product->price, 2)); ?>

                                            د.أ</span>
                                        <span class="text-green-600 font-medium">
                                            وفرت <?php echo e(number_format($product->savings_amount, 2)); ?> د.أ
                                        </span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-3xl lg:text-4xl font-bold text-gray-900"><?php echo e(number_format($product->price, 2)); ?>

                                        د.أ</span>
                                    <span class="text-sm text-gray-500">السعر شامل الضريبة</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Product Sizes -->
                        <?php if($product->sizes && $product->sizes->count() > 0): ?>
                            <div x-data="{
                                selectedSize: null,
                                sizes: <?php echo \Illuminate\Support\Js::from($product->availableSizes->map(function($size) {
                                    return [
                                        'id' => $size->id,
                                        'size' => $size->size,
                                        'stock_quantity' => $size->stock_quantity,
                                        'additional_price' => $size->additional_price,
                                        'is_popular' => $size->is_popular ?? false
                                    ];
                                }))->toHtml() ?>,
                                getSelectedSizeData() {
                                    return this.sizes.find(size => size.id === this.selectedSize) || null;
                                }
                            }" class="mb-8 p-6 bg-white rounded-xl border" x-init="
                                $watch('selectedSize', value => {
                                    const addToCartBtn = document.querySelector('.add-to-cart-main');
                                    const btnText = addToCartBtn?.querySelector('.btn-text');
                                    if (btnText) {
                                        if (value) {
                                            btnText.innerHTML = '<i class=\"fas fa-shopping-cart ml-2\"></i>أضف إلى السلة';
                                            addToCartBtn.classList.remove('opacity-75');
                                        } else {
                                            btnText.innerHTML = '<i class=\"fas fa-hand-point-up ml-2\"></i>اختر المقاس أولاً';
                                            addToCartBtn.classList.add('opacity-75');
                                        }
                                    }
                                })
                            ">
                                <label class="text-lg font-semibold text-gray-700 mb-4 block">الحجم المتاح:</label>
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                                    <?php $__currentLoopData = $product->availableSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button type="button" @click="selectedSize = <?php echo e($size->id); ?>"
                                            :class="selectedSize === <?php echo e($size->id); ?> ? 'border-orange-500 bg-orange-50 text-orange-600' : 'border-gray-300 hover:border-orange-300'"
                                            class="relative border-2 rounded-xl py-3 px-4 text-center transition-all duration-200 group"
                                            data-size-id="<?php echo e($size->id); ?>" data-additional-price="<?php echo e($size->additional_price); ?>">
                                            <div class="font-semibold text-sm"><?php echo e($size->size); ?></div>
                                            <?php if($size->additional_price > 0): ?>
                                                <div class="text-xs text-gray-500 mt-1">+<?php echo e(number_format($size->additional_price, 0)); ?>

                                                    د.أ</div>
                                            <?php endif; ?>
                                            <?php if($size->stock_quantity < 5): ?>
                                                <div class="text-xs text-red-500 mt-1"><?php echo e($size->stock_quantity); ?> متبقي
                                                </div>
                                            <?php endif; ?>

                                            <!-- Stock status -->
                                            <?php if($size->stock_quantity == 0): ?>
                                                <div
                                                    class="absolute inset-0 bg-gray-200 bg-opacity-75 rounded-xl flex items-center justify-center">
                                                    <span class="text-gray-600 text-xs font-medium">نفذ المخزون</span>
                                                </div>
                                            <?php elseif($size->stock_quantity <= 3): ?>
                                                <div class="absolute top-1 left-1 bg-red-500 text-white rounded-full text-xs px-2 py-1">
                                                    <?php echo e($size->stock_quantity); ?>

                                                </div>
                                            <?php elseif($size->stock_quantity <= 10): ?>
                                                <div
                                                    class="absolute top-1 left-1 bg-yellow-500 text-white rounded-full text-xs px-2 py-1">
                                                    <?php echo e($size->stock_quantity); ?>

                                                </div>
                                            <?php endif; ?>

                                            <!-- Popular size indicator -->
                                            <?php if($size->is_popular ?? false): ?>
                                                <div
                                                    class="absolute -top-1 -left-1 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-full text-xs px-2 py-1 font-bold shadow-lg">
                                                    <i class="fas fa-star mr-1"></i>شائع
                                                </div>
                                            <?php endif; ?>

                                            <!-- Selection indicator -->
                                            <div x-show="selectedSize === <?php echo e($size->id); ?>"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                class="absolute -top-2 -right-2 w-5 h-5 bg-orange-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <!-- Size Guide Link -->
                                <div class="mt-4 text-center">
                                    <button type="button" class="text-orange-500 hover:text-orange-600 underline text-sm"
                                        @click="showSizeGuide = true">
                                        <i class="fas fa-ruler ml-1"></i>دليل المقاسات
                                    </button>
                                </div>

                                <!-- Selected Size Summary -->
                                <div x-show="selectedSize" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-check-circle text-green-600"></i>
                                            <span class="text-green-800 font-medium">تم اختيار الحجم:</span>
                                            <span x-text="getSelectedSizeData()?.size || ''" 
                                                  class="bg-green-100 text-green-800 px-2 py-1 rounded-lg text-sm font-bold"></span>
                                        </div>
                                        <button @click="selectedSize = null"
                                            class="text-green-600 hover:text-green-800 text-sm">
                                            <i class="fas fa-times"></i> تغيير
                                        </button>
                                    </div>
                                </div>

                                <!-- Size Selection Alert -->
                                <div x-show="!selectedSize && Object.keys($data).includes('selectedSize')"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl">
                                    <div class="flex items-center gap-2 text-yellow-800">
                                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                        <span class="text-sm font-medium">يرجى اختيار الحجم المطلوب قبل الإضافة للسلة</span>
                                    </div>
                                </div>

                                <!-- Enhanced Size Information Panel -->
                               
                            </div>
                        <?php endif; ?>

                        <!-- Quantity & Add to Cart -->
                        <?php if($product->stock_quantity > 0): ?>
                            <div class="mb-8 p-6 bg-white rounded-xl border">
                                <div class="flex items-center gap-4 mb-6">
                                    <label class="text-lg font-semibold text-gray-700">الكمية:</label>
                                    <div class="flex items-center border-2 border-gray-300 rounded-lg overflow-hidden bg-white">
                                        <button type="button"
                                            class="quantity-btn-minus px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors border-l border-gray-300 flex items-center justify-center">
                                            <span class="text-gray-600 font-bold text-lg">-</span>
                                        </button>
                                        <input type="number" id="quantity" value="1" min="1"
                                            max="<?php echo e($product->stock_quantity); ?>"
                                            class="w-20 text-center py-3 border-0 focus:ring-0 focus:outline-none text-lg font-semibold bg-white">
                                        <button type="button"
                                            class="quantity-btn-plus px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors border-r border-gray-300 flex items-center justify-center">
                                            <span class="text-gray-600 font-bold text-lg">+</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <button data-product-id="<?php echo e($product->slug); ?>"
                                        class="add-to-cart-main w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-4 px-6 rounded-xl font-bold text-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg add-to-cart-btn <?php echo e($product->sizes && $product->sizes->count() > 0 ? 'opacity-75' : ''); ?>">
                                        <?php if($product->sizes && $product->sizes->count() > 0): ?>
                                            <i class="fas fa-hand-point-up ml-2"></i>
                                            <span class="btn-text">اختر المقاس أولاً</span>
                                        <?php else: ?>
                                            <i class="fas fa-shopping-cart ml-2"></i>
                                            <span class="btn-text">أضف إلى السلة</span>
                                        <?php endif; ?>
                                        <span class="loading-text hidden">
                                            <i class="fas fa-spinner fa-spin ml-2"></i>جاري الإضافة...
                                        </span>
                                    </button>

                                    <button data-product-id="<?php echo e($product->slug); ?>"
                                        class="add-to-wishlist-btn w-full border-2 py-4 px-6 rounded-xl font-bold text-lg transition-all duration-300 <?php echo e($isInWishlist ? 'border-red-500 text-red-500 bg-red-50' : 'border-orange-500 text-orange-500 hover:bg-orange-50'); ?>"
                                        title="<?php echo e($isInWishlist ? 'إزالة من المفضلة' : 'أضف إلى المفضلة'); ?>">
                                        <i class="fas fa-heart ml-2 <?php echo e($isInWishlist ? 'text-red-500' : ''); ?>"></i>
                                        <span
                                            class="wishlist-text"><?php echo e($isInWishlist ? 'في المفضلة' : 'أضف إلى المفضلة'); ?></span>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Professional Tabbed Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200" dir="rtl">
                    <nav class="flex space-x-8 space-x-reverse px-6">
                        <button
                            class="tab-button py-4 px-2 border-b-2 font-medium text-sm transition-colors duration-200 border-orange-500 text-orange-600"
                            id="description-tab">
                            وصف المنتج
                        </button>
                        <button
                            class="tab-button py-4 px-2 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                            id="specifications-tab">
                            المواصفات
                        </button>
                        <button
                            class="tab-button py-4 px-2 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                            id="reviews-tab">
                            التقييمات <?php if($product->reviews_count > 0): ?>(<?php echo e($product->reviews_count); ?>)<?php endif; ?>
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6 lg:p-8">
                    <!-- Description Tab -->
                    <div id="description-content" class="tab-content active" dir="rtl">
                        <div class="prose prose-lg max-w-none">
                            <?php if($product->description): ?>
                                <div class="text-gray-700 leading-relaxed text-lg">
                                    <?php echo nl2br(e($product->description)); ?>

                                </div>
                            <?php else: ?>
                                <div class="text-center py-12">
                                    <i class="fas fa-file-alt text-gray-300 text-6xl mb-4"></i>
                                    <p class="text-gray-500 text-lg">لا يوجد وصف متاح لهذا المنتج</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Dynamic Specifications Tab -->
                    <div id="specifications-content" class="tab-content" dir="rtl">
                        <!-- Product Attributes from attribute_values table -->
                        <?php if($product->attributeValues && $product->attributeValues->count() > 0): ?>
                            <div class="mb-12">
                                <!-- Enhanced Header with Icon and Divider -->
                                <div class="flex items-center mb-8">
                                    <div class="flex items-center">
                                        <div class="bg-gradient-to-r from-orange-500 to-red-500 p-3 rounded-xl shadow-lg ml-4">
                                            <i class="fas fa-cogs text-white text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-2xl font-bold text-gray-900 mb-1">مواصفات المنتج</h4>
                                            <p class="text-sm text-gray-500">التفاصيل التقنية والخصائص المميزة</p>
                                        </div>
                                    </div>
                                    <div class="flex-grow mr-6">
                                        <div class="h-px bg-gradient-to-l from-orange-200 to-transparent"></div>
                                    </div>
                                </div>

                                <?php
                                    // Group attribute values by attribute name
                                    $groupedAttributes = [];
                                    foreach($product->attributeValues as $attributeValue) {
                                        if($attributeValue->attribute) {
                                            $attributeName = $attributeValue->attribute->name;
                                            if (!isset($groupedAttributes[$attributeName])) {
                                                $groupedAttributes[$attributeName] = [];
                                            }
                                            $groupedAttributes[$attributeName][] = $attributeValue->value;
                                        }
                                    }
                                ?>

                                <!-- Professional Attributes Grid -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <?php $__currentLoopData = $groupedAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attributeName => $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="group">
                                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-100">
                                                    <div class="flex items-center">
                                                        <div class="w-2 h-2 bg-orange-500 rounded-full ml-3 animate-pulse"></div>
                                                        <h5 class="font-bold text-gray-800 text-lg"><?php echo e($attributeName); ?></h5>
                                                    </div>
                                                </div>
                                                <div class="p-6">
                                                    <div class="flex flex-wrap gap-2">
                                                        <?php $__currentLoopData = array_unique($values); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-orange-100 to-yellow-100 text-orange-800 border border-orange-200 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105">
                                                                <i class="fas fa-check-circle text-orange-600 text-xs ml-2"></i>
                                                                <?php echo e($value); ?>

                                                            </span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <!-- Enhanced Footer with Additional Info -->
                                <div class="mt-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100">
                                    <div class="flex items-center justify-center text-center">
                                        <div class="bg-blue-100 p-2 rounded-full ml-3">
                                            <i class="fas fa-info-circle text-blue-600"></i>
                                        </div>
                                        <p class="text-blue-800 font-medium">
                                            جميع المواصفات المذكورة أعلاه تخضع لمعايير الجودة العالية لضمان أفضل تجربة للعميل
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Enhanced Basic Product Information -->
                        <div class="mt-12">
                            <!-- Enhanced Header -->
                            <div class="flex items-center mb-8">
                                <div class="flex items-center">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-3 rounded-xl shadow-lg ml-4">
                                        <i class="fas fa-info-circle text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-2xl font-bold text-gray-900 mb-1">المعلومات الأساسية</h4>
                                        <p class="text-sm text-gray-500">تفاصيل المنتج والمعلومات العامة</p>
                                    </div>
                                </div>
                                <div class="flex-grow mr-6">
                                    <div class="h-px bg-gradient-to-l from-blue-200 to-transparent"></div>
                                </div>
                            </div>

                            <!-- Professional Info Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Product SKU -->
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-6">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-purple-100 p-2 rounded-lg ml-3">
                                            <i class="fas fa-barcode text-purple-600"></i>
                                        </div>
                                        <span class="font-bold text-gray-800">رقم المنتج</span>
                                    </div>
                                    <p class="text-gray-600 font-medium bg-gray-50 px-3 py-2 rounded-lg text-center"><?php echo e($product->sku); ?></p>
                                </div>

                                <!-- Category -->
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-6">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-green-100 p-2 rounded-lg ml-3">
                                            <i class="fas fa-tags text-green-600"></i>
                                        </div>
                                        <span class="font-bold text-gray-800">الفئة</span>
                                    </div>
                                    <p class="text-gray-600 font-medium bg-green-50 px-3 py-2 rounded-lg text-center"><?php echo e($product->category->name); ?></p>
                                </div>

                                <!-- Brand -->
                                <?php if($product->brand): ?>
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-6">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-orange-100 p-2 rounded-lg ml-3">
                                            <i class="fas fa-award text-orange-600"></i>
                                        </div>
                                        <span class="font-bold text-gray-800">العلامة التجارية</span>
                                    </div>
                                    <p class="text-gray-600 font-medium bg-orange-50 px-3 py-2 rounded-lg text-center"><?php echo e($product->brand->name); ?></p>
                                </div>
                                <?php endif; ?>

                                <!-- Weight -->
                                <?php if($product->weight): ?>
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-6">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-blue-100 p-2 rounded-lg ml-3">
                                            <i class="fas fa-weight text-blue-600"></i>
                                        </div>
                                        <span class="font-bold text-gray-800">الوزن</span>
                                    </div>
                                    <p class="text-gray-600 font-medium bg-blue-50 px-3 py-2 rounded-lg text-center"><?php echo e($product->weight); ?> كجم</p>
                                </div>
                                <?php endif; ?>

                                <!-- Dimensions -->
                                <?php if($product->dimensions): ?>
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-6">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-indigo-100 p-2 rounded-lg ml-3">
                                            <i class="fas fa-ruler-combined text-indigo-600"></i>
                                        </div>
                                        <span class="font-bold text-gray-800">الأبعاد</span>
                                    </div>
                                    <p class="text-gray-600 font-medium bg-indigo-50 px-3 py-2 rounded-lg text-center"><?php echo e($product->dimensions); ?></p>
                                </div>
                                <?php endif; ?>

                                <!-- Materials -->
                                <?php if($product->materials): ?>
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-6">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-yellow-100 p-2 rounded-lg ml-3">
                                            <i class="fas fa-industry text-yellow-600"></i>
                                        </div>
                                        <span class="font-bold text-gray-800">المواد</span>
                                    </div>
                                    <p class="text-gray-600 font-medium bg-yellow-50 px-3 py-2 rounded-lg text-center"><?php echo e($product->materials); ?></p>
                                </div>
                                <?php endif; ?>

                                <!-- Country of Origin -->
                                <?php if($product->country_of_origin): ?>
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-6">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-red-100 p-2 rounded-lg ml-3">
                                            <i class="fas fa-globe text-red-600"></i>
                                        </div>
                                        <span class="font-bold text-gray-800">بلد المنشأ</span>
                                    </div>
                                    <p class="text-gray-600 font-medium bg-red-50 px-3 py-2 rounded-lg text-center"><?php echo e($product->country_of_origin); ?></p>
                                </div>
                                <?php endif; ?>

                                <!-- Warranty -->
                                <?php if($product->warranty_period): ?>
                                <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 p-6">
                                    <div class="flex items-center mb-3">
                                        <div class="bg-teal-100 p-2 rounded-lg ml-3">
                                            <i class="fas fa-shield-alt text-teal-600"></i>
                                        </div>
                                        <span class="font-bold text-gray-800">فترة الضمان</span>
                                    </div>
                                    <p class="text-gray-600 font-medium bg-teal-50 px-3 py-2 rounded-lg text-center"><?php echo e($product->warranty_period); ?> شهر</p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                                <?php if($product->color): ?>
                                    <div class="flex justify-between py-3 border-b border-gray-200">
                                        <span class="font-semibold text-gray-900">اللون:</span>
                                        <span class="text-gray-700"><?php echo e($product->color); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->material): ?>
                                    <div class="flex justify-between py-3 border-b border-gray-200">
                                        <span class="font-semibold text-gray-900">الخامة:</span>
                                        <span class="text-gray-700"><?php echo e($product->material); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Additional Product Specifications -->
                        <?php if($product->suitable_age || $product->pieces_count || $product->standards || $product->battery_type || !is_null($product->washable)): ?>
                            <div class="mt-8">
                                <h4 class="text-lg font-bold text-gray-900 mb-4">مواصفات إضافية</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php if($product->suitable_age): ?>
                                        <div class="flex justify-between py-3 border-b border-gray-200">
                                            <span class="font-semibold text-gray-900">العمر المناسب:</span>
                                            <span class="text-gray-700"><?php echo e($product->suitable_age); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($product->pieces_count): ?>
                                        <div class="flex justify-between py-3 border-b border-gray-200">
                                            <span class="font-semibold text-gray-900">عدد القطع:</span>
                                            <span class="text-gray-700"><?php echo e($product->pieces_count); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($product->standards): ?>
                                        <div class="flex justify-between py-3 border-b border-gray-200">
                                            <span class="font-semibold text-gray-900">المعايير:</span>
                                            <span class="text-gray-700"><?php echo e($product->standards); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($product->battery_type): ?>
                                        <div class="flex justify-between py-3 border-b border-gray-200">
                                            <span class="font-semibold text-gray-900">نوع البطارية:</span>
                                            <span class="text-gray-700"><?php echo e($product->battery_type); ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!is_null($product->washable)): ?>
                                        <div class="flex justify-between py-3 border-b border-gray-200">
                                            <span class="font-semibold text-gray-900">قابل للغسل:</span>
                                            <span class="text-gray-700"><?php echo e($product->washable ? 'نعم' : 'لا'); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Dynamic Reviews Tab -->
                    <div id="reviews-content" class="tab-content" dir="rtl">
                        <div class="space-y-8">
                            <!-- Reviews Summary -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2">تقييم العملاء</h3>
                                        <?php if($product->reviews_count > 0): ?>
                                            <div class="flex items-center gap-2">
                                                <div class="flex text-yellow-400">
                                                    <?php $__currentLoopData = range(1, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productStar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($productStar <= floor($product->average_rating)): ?>
                                                            <i class="fas fa-star"></i>
                                                        <?php elseif($productStar <= ceil($product->average_rating)): ?>
                                                            <i class="fas fa-star-half-alt"></i>
                                                        <?php else: ?>
                                                            <i class="far fa-star"></i>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <span
                                                    class="text-lg font-semibold text-gray-700"><?php echo e(number_format($product->average_rating, 1)); ?>

                                                    من 5</span>
                                                <span class="text-gray-500">(<?php echo e($product->reviews_count); ?>

                                                    <?php echo e($product->reviews_count == 1 ? 'تقييم' : 'تقييمات'); ?>)</span>
                                            </div>

                                            <!-- Rating Breakdown -->
                                            <div class="mt-4 space-y-2">
                                                <?php $__currentLoopData = range(5, 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $count = $product->rating_breakdown[$rating] ?? 0;
                                                        $percentage = $product->reviews_count > 0 ? ($count / $product->reviews_count) * 100 : 0;
                                                    ?>
                                                    <div class="flex items-center gap-2 text-sm">
                                                        <span class="w-8"><?php echo e($rating); ?> ★</span>
                                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                            <div class="bg-yellow-400 h-2 rounded-full transition-all duration-300 rating-bar"
                                                                data-width="<?php echo e($percentage); ?>"></div>
                                                        </div>
                                                        <span class="text-gray-600 w-8"><?php echo e($count); ?></span>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-center py-8">
                                                <i class="fas fa-star text-gray-300 text-4xl mb-4"></i>
                                                <p class="text-gray-500">لا توجد تقييمات بعد</p>
                                                <p class="text-sm text-gray-400">كن أول من يقيم هذا المنتج</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <button
                                        class="bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition-colors">
                                        اكتب تقييم
                                    </button>
                                </div>
                            </div>

                            <!-- Individual Reviews -->
                            <?php if($product->approvedReviews->count() > 0): ?>
                                <div class="space-y-6">
                                    <?php $__currentLoopData = $product->approvedReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="border-b border-gray-200 pb-6 <?php echo e($loop->last ? 'border-b-0 pb-0' : ''); ?>">
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold">
                                                        <?php echo e($review->author_initial); ?>

                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-900"><?php echo e($review->user->name); ?></p>
                                                        <div class="flex text-yellow-400 text-sm">
                                                            <?php echo $review->star_rating; ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="text-sm text-gray-500"><?php echo e($review->time_ago); ?></span>
                                            </div>
                                            <p class="text-gray-700 leading-relaxed"><?php echo e($review->comment); ?></p>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Professional Related Products Section -->
                    <?php if($relatedProducts->count() > 0): ?>
                        <div class="border-t border-gray-200">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-6" dir="rtl">
                                    <h2 class="text-2xl font-bold text-gray-900">منتجات ذات صلة</h2>
                                    <a href="<?php echo e(route('products.category', $product->category->slug)); ?>"
                                        class="text-orange-500 hover:text-orange-600 font-medium transition-colors">
                                        عرض المزيد <i class="fas fa-arrow-left mr-2"></i>
                                    </a>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
                                    <?php $__currentLoopData = $relatedProducts->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="bg-white rounded-lg sm:rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group border border-gray-100 flex flex-col h-full">
                                            <div class="relative">
                                                <a href="<?php echo e(route('products.show', $relatedProduct->slug)); ?>" class="block">
                                                    <?php if($relatedProduct->images->first()): ?>
                                                        <img src="<?php echo e(asset('storage/' . $relatedProduct->images->first()->image_path)); ?>" 
                                                             alt="<?php echo e($relatedProduct->name); ?>" 
                                                             class="w-full h-40 sm:h-48 lg:h-56 object-cover group-hover:scale-105 transition-transform duration-300">
                                                    <?php else: ?>
                                                        <div class="w-full h-40 sm:h-48 lg:h-56 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                            <svg class="w-8 h-8 sm:w-12 sm:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 01-2-2z"></path>
                                                            </svg>
                                                        </div>
                                                    <?php endif; ?>
                                                </a>
                                                
                                                <!-- Badges -->
                                                <div class="absolute top-2 sm:top-3 left-2 sm:left-3 flex flex-col gap-1 sm:gap-2">
                                                    <?php if($relatedProduct->has_discount): ?>
                                                        <span class="bg-gradient-to-r from-red-500 to-red-600 text-white px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs font-bold shadow-lg border-2 border-white">
                                                            خصم <?php echo e(number_format($relatedProduct->discount_percentage, 0)); ?>%
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if($relatedProduct->is_featured): ?>
                                                        <span class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs font-bold shadow-lg border-2 border-white">
                                                            مميز
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <!-- Wishlist Button -->
                                                <div class="absolute top-2 sm:top-3 right-2 sm:right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                    <button class="bg-white/90 backdrop-blur-sm p-1.5 sm:p-2 rounded-full shadow-lg hover:bg-white hover:shadow-xl text-gray-600 add-to-wishlist-btn transition-all duration-200"
                                                            data-product-id="<?php echo e($relatedProduct->slug); ?>"
                                                            title="إضافة إلى قائمة الأمنيات">
                                                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Stock Status -->
                                                <?php if($relatedProduct->stock_quantity <= 0): ?>
                                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                                        <span class="bg-red-500 text-white px-3 sm:px-4 py-2 rounded-lg font-semibold text-sm">غير متوفر</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="p-3 sm:p-4 flex flex-col flex-1" dir="rtl">
                                                <!-- Product Brand -->
                                                <?php if($relatedProduct->brand): ?>
                                                    <p class="text-xs text-orange-600 font-medium mb-1 uppercase tracking-wide"><?php echo e($relatedProduct->brand->name); ?></p>
                                                <?php endif; ?>

                                                <!-- Product Name -->
                                                <a href="<?php echo e(route('products.show', $relatedProduct->slug)); ?>" class="block">
                                                    <h3 class="font-bold text-sm sm:text-base lg:text-lg mb-2 text-gray-800 hover:text-orange-600 transition-colors duration-200 leading-tight line-clamp-2">
                                                        <?php echo e(Str::limit($relatedProduct->name, 50)); ?>

                                                    </h3>
                                                </a>

                                                <!-- Product Category -->
                                                <?php if($relatedProduct->category): ?>
                                                    <p class="text-xs text-gray-500 mb-2 sm:mb-3"><?php echo e($relatedProduct->category->name); ?></p>
                                                <?php endif; ?>
                                                
                                                <!-- Flexible content area -->
                                                <div class="flex-1">
                                                    <!-- Price Section -->
                                                    <div class="mb-3 sm:mb-4">
                                                        <?php if($relatedProduct->has_discount): ?>
                                                            <div class="flex items-center gap-1 sm:gap-2 mb-1">
                                                                <span class="text-base sm:text-lg font-bold text-orange-600"><?php echo e(number_format($relatedProduct->final_price, 2)); ?> د.أ</span>
                                                                <span class="text-xs sm:text-sm text-gray-500 line-through"><?php echo e(number_format($relatedProduct->price, 2)); ?> د.أ</span>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="text-base sm:text-lg font-bold text-gray-800"><?php echo e(number_format($relatedProduct->price, 2)); ?> د.أ</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                <!-- Action Buttons - Always at bottom -->
                                                <div class="mt-auto">
                                                    <!-- Quick Info -->
                                                    <?php if($relatedProduct->stock_quantity > 0 && $relatedProduct->stock_quantity <= 5): ?>
                                                        <p class="text-xs text-red-600 mb-2 sm:mb-3 font-medium">
                                                            <svg class="w-3 h-3 inline ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            متبقي <?php echo e($relatedProduct->stock_quantity); ?> قطع فقط!
                                                        </p>
                                                    <?php endif; ?>

                                                    <div class="flex items-center gap-1.5 sm:gap-2">
                                                        <?php if($relatedProduct->stock_quantity > 0): ?>
                                                            <?php if($relatedProduct->sizes && $relatedProduct->sizes->count() > 0): ?>
                                                                <!-- Products with sizes - redirect to product page -->
                                                                <a href="<?php echo e(route('products.show', $relatedProduct->slug)); ?>" 
                                                                   class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2 sm:py-2.5 px-3 sm:px-4 rounded-lg text-xs sm:text-sm font-semibold hover:from-orange-600 hover:to-orange-700 transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                                    اختر المقاس
                                                                </a>
                                                            <?php else: ?>
                                                                <!-- Regular products without sizes -->
                                                                <button data-product-id="<?php echo e($relatedProduct->slug); ?>" 
                                                                        class="flex-1 add-to-cart-quick bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2 sm:py-2.5 px-3 sm:px-4 rounded-lg text-xs sm:text-sm font-semibold hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                                    <span class="btn-text">أضف للسلة</span>
                                                                    <span class="loading-text hidden">جاري الإضافة...</span>
                                                                </button>
                                                            <?php endif; ?>
                                                            <a href="<?php echo e(route('products.show', $relatedProduct->slug)); ?>" 
                                                               class="px-2 sm:px-3 py-2 sm:py-2.5 border border-orange-300 text-orange-600 hover:bg-orange-50 rounded-lg text-xs sm:text-sm font-medium transition-colors duration-200">
                                                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                                </svg>
                                                            </a>
                                                        <?php else: ?>
                                                            <div class="flex-1 bg-gray-100 text-gray-500 py-2 sm:py-2.5 px-3 sm:px-4 rounded-lg text-xs sm:text-sm font-medium text-center">
                                                                غير متوفر
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Size Guide Modal -->
   
    

        <script>
            // Professional Product Page JavaScript
            function changeMainImage(imageUrl, thumbnailElement) {
                const mainImage = document.getElementById('main-image');
                if (mainImage) {
                    mainImage.src = imageUrl;

                    // Update thumbnail borders
                    document.querySelectorAll('.flex-shrink-0').forEach(thumb => {
                        thumb.classList.remove('border-orange-500');
                        thumb.classList.add('border-transparent');
                    });

                    if (thumbnailElement) {
                        thumbnailElement.classList.remove('border-transparent');
                        thumbnailElement.classList.add('border-orange-500');
                    }
                }
            }

            function changeQuantity(change) {
                const quantityInput = document.getElementById('quantity');
                if (!quantityInput) return;

                const currentValue = parseInt(quantityInput.value) || 1;
                const newValue = currentValue + change;
                const maxValue = parseInt(quantityInput.max) || 999;

                if (newValue >= 1 && newValue <= maxValue) {
                    quantityInput.value = newValue;
                }
            }

            // Size selection functionality
            function updatePriceWithSize() {
                const selectedSizeButton = document.querySelector('[data-size-id].border-orange-500');
                const originalPrice = <?php echo e(floatval($product->final_price)); ?>;
            let additionalPrice = 0;


            if (selectedSizeButton) {
                additionalPrice = parseFloat(selectedSizeButton.getAttribute('data-additional-price')) || 0;
            }

            const finalPrice = originalPrice + additionalPrice;

            // Update main price display
            const priceElement = document.querySelector('.text-3xl.font-bold');
            if (priceElement) {
                priceElement.textContent = new Intl.NumberFormat('ar-JO', {
                    style: 'decimal',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(finalPrice) + ' د.أ';
            }
            }

            function getSelectedSize() {
                const selectedSizeButton = document.querySelector('[data-size-id].border-orange-500');
                return selectedSizeButton ? {
                    id: selectedSizeButton.getAttribute('data-size-id'),
                    additionalPrice: parseFloat(selectedSizeButton.getAttribute('data-additional-price')) || 0
                } : null;
            }

            function addToCartWithQuantity(productId) {
                const quantityElement = document.getElementById('quantity');
                const quantity = quantityElement ? parseInt(quantityElement.value) || 1 : 1;
                const selectedSize = getSelectedSize();
                const button = event.target.closest('.add-to-cart-btn');

                if (!button) return;

                // Check if size is required but not selected
                const sizeOptions = document.querySelectorAll('[data-size-id]');
                if (sizeOptions.length > 0 && !selectedSize) {
                    showNotification('يرجى اختيار الحجم المطلوب', 'error');
                    return;
                }

                const btnText = button.querySelector('.btn-text');
                const loadingText = button.querySelector('.loading-text');

                // Show loading state
                if (btnText) btnText.classList.add('hidden');
                if (loadingText) loadingText.classList.remove('hidden');
                button.disabled = true;

                const requestData = {
                    quantity: quantity,
                    size_id: selectedSize ? selectedSize.id : null
                };

                fetch('<?php echo e(route("cart.add", ":productId")); ?>'.replace(':productId', productId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(requestData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateCartBadge(data.cart_count);
                            showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
                        } else {
                            showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('حدث خطأ في إضافة المنتج', 'error');
                    })
                    .finally(() => {
                        // Reset button state
                        if (btnText) btnText.classList.remove('hidden');
                        if (loadingText) loadingText.classList.add('hidden');
                        button.disabled = false;
                    });
            }

            function addToCartQuick(productId) {
                fetch('<?php echo e(route("cart.add", ":productId")); ?>'.replace(':productId', productId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        quantity: 1
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateCartBadge(data.cart_count);
                            showNotification('تم إضافة المنتج إلى السلة!', 'success');
                        } else {
                            showNotification(data.message || 'حدث خطأ', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('حدث خطأ في إضافة المنتج', 'error');
                    });
            }

            function updateWishlistBadge(wishlistCount) {
                let wishlistBadge = document.getElementById('wishlist-count');

                if (wishlistBadge) {
                    wishlistBadge.textContent = wishlistCount;
                    if (wishlistCount > 0) {
                        wishlistBadge.classList.remove('hidden');
                        wishlistBadge.style.display = 'flex';
                    } else {
                        wishlistBadge.classList.add('hidden');
                        wishlistBadge.style.display = 'none';
                    }
                } else if (wishlistCount > 0) {
                    // Create wishlist badge if it doesn't exist
                    const wishlistLink = document.querySelector('a[href*="/wishlist"]');
                    if (wishlistLink && !wishlistLink.querySelector('#wishlist-count')) {
                        wishlistLink.style.position = 'relative';
                        const badge = document.createElement('span');
                        badge.id = 'wishlist-count';
                        badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
                        badge.textContent = wishlistCount;
                        wishlistLink.appendChild(badge);
                    }
                }
            }

            function updateCartBadge(cartCount) {
                let cartBadge = document.getElementById('cart-count');

                if (cartBadge) {
                    cartBadge.textContent = cartCount;
                    if (cartCount > 0) {
                        cartBadge.classList.remove('hidden');
                    } else {
                        cartBadge.classList.add('hidden');
                    }
                } else if (cartCount > 0) {
                    // Create cart badge if it doesn't exist
                    const cartLink = document.querySelector('a[href*="/cart"]');
                    if (cartLink && cartLink.style.position !== 'relative') {
                        cartLink.style.position = 'relative';
                        const badge = document.createElement('span');
                        badge.id = 'cart-count';
                        badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold';
                        badge.textContent = cartCount;
                        cartLink.appendChild(badge);
                    }
                }
            }

            function switchTab(tabName) {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Remove active state from all tab buttons
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.classList.remove('border-orange-500', 'text-orange-600');
                    button.classList.add('border-transparent', 'text-gray-500');
                });

                // Show selected tab content
                const selectedContent = document.getElementById(tabName + '-content');
                const selectedTab = document.getElementById(tabName + '-tab');

                if (selectedContent) {
                    selectedContent.classList.add('active');
                }

                if (selectedTab) {
                    selectedTab.classList.remove('border-transparent', 'text-gray-500');
                    selectedTab.classList.add('border-orange-500', 'text-orange-600');
                }
            }

            function addToWishlist(productId, button) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    showNotification('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
                    return;
                }

                // Check if user is authenticated
                const isAuthenticated = <?php echo e(auth()->check() ? 'true' : 'false'); ?>;
            if (!isAuthenticated) {
                showNotification('يجب تسجيل الدخول أولاً لإضافة المنتجات إلى قائمة الأمنيات', 'error');
                setTimeout(() => {
                    window.location.href = '<?php echo e(route("login")); ?>';
                }, 2000);
                return;
            }

            // Check if already in wishlist
            const isCurrentlyInWishlist = button.classList.contains('border-red-500');
            const action = isCurrentlyInWishlist ? 'remove' : 'add';
            const method = isCurrentlyInWishlist ? 'DELETE' : 'POST';

            // Show loading state
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i><span>جاري التحديث...</span>';
            button.disabled = true;

            fetch(`/wishlist/${action}/${productId}`, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (action === 'add') {
                            // Item added to wishlist
                            button.classList.remove('border-orange-500', 'text-orange-500', 'hover:bg-orange-50');
                            button.classList.add('border-red-500', 'text-red-500', 'bg-red-50');
                            button.innerHTML = '<i class="fas fa-heart ml-2 text-red-500"></i><span class="wishlist-text">في المفضلة</span>';
                            button.title = 'إزالة من المفضلة';
                            showNotification('تم إضافة المنتج إلى قائمة الأمنيات!', 'success');
                        } else {
                            // Item removed from wishlist
                            button.classList.remove('border-red-500', 'text-red-500', 'bg-red-50');
                            button.classList.add('border-orange-500', 'text-orange-500', 'hover:bg-orange-50');
                            button.innerHTML = '<i class="fas fa-heart ml-2"></i><span class="wishlist-text">أضف إلى المفضلة</span>';
                            button.title = 'أضف إلى المفضلة';
                            showNotification('تم حذف المنتج من قائمة الأمنيات!', 'success');
                        }

                        // Update wishlist count in header
                        if (data.wishlist_count !== undefined) {
                            updateWishlistBadge(data.wishlist_count);
                        }
                    } else {
                        showNotification(data.message || 'حدث خطأ في تحديث قائمة الأمنيات', 'error');
                        button.innerHTML = originalContent;
                    }
                })
                .catch(error => {
                    console.error('Wishlist error:', error);
                    showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
                    button.innerHTML = originalContent;
                })
                .finally(() => {
                    button.disabled = false;
                });
            }

            function showNotification(message, type = 'success') {
                // Remove existing notifications
                document.querySelectorAll('.notification').forEach(notif => notif.remove());

                const notification = document.createElement('div');
                notification.className = `notification fixed top-4 right-4 z-50 px-6 py-4 rounded-xl text-white shadow-xl transition-all duration-300 transform translate-x-full ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;

                notification.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} text-xl"></i>
                <span class="font-medium">${message}</span>
            </div>
        `;

                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 100);

                // Animate out and remove
                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }, 3000);
            }

            // Initialize page
            document.addEventListener('DOMContentLoaded', function () {
                // Set first tab as active
                switchTab('description');

                // Animate rating bars
                setTimeout(() => {
                    document.querySelectorAll('.rating-bar').forEach(bar => {
                        const width = bar.getAttribute('data-width');
                        bar.style.width = Math.min(100, Math.max(0, width)) + '%';
                    });
                }, 500);

                // Add quantity input validation
                const quantityInput = document.getElementById('quantity');
                if (quantityInput) {
                    quantityInput.addEventListener('input', function () {
                        const value = parseInt(this.value);
                        const max = parseInt(this.max);

                        if (value < 1) this.value = 1;
                        if (value > max) this.value = max;
                    });
                }

                // Quantity buttons
                document.querySelector('.quantity-btn-minus')?.addEventListener('click', () => changeQuantity(-1));
                document.querySelector('.quantity-btn-plus')?.addEventListener('click', () => changeQuantity(1));

                // Size selection buttons
                document.querySelectorAll('[data-size-id]').forEach(button => {
                    button.addEventListener('click', function () {
                        // Remove selection from all size buttons
                        document.querySelectorAll('[data-size-id]').forEach(btn => {
                            btn.classList.remove('border-orange-500', 'bg-orange-50', 'text-orange-600');
                            btn.classList.add('border-gray-300');
                        });

                        // Add selection to clicked button
                        this.classList.remove('border-gray-300');
                        this.classList.add('border-orange-500', 'bg-orange-50', 'text-orange-600');

                        // Update price if there's additional cost
                        updatePriceWithSize();
                    });
                });

                // Main add to cart button
                document.querySelector('.add-to-cart-main')?.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id');
                    addToCartWithQuantity(productId);
                });

                // Main wishlist button
                document.querySelector('.add-to-wishlist-btn')?.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id');
                    addToWishlist(productId, this);
                });

                // Quick add to cart buttons
                document.querySelectorAll('.add-to-cart-quick').forEach(button => {
                    button.addEventListener('click', function () {
                        const productId = this.getAttribute('data-product-id');
                        addToCartQuick(productId);
                    });
                });

                // Related products wishlist buttons
                document.querySelectorAll('.wishlist-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const productId = this.getAttribute('data-product-id');
                        addToWishlist(productId, this);
                    });
                });

                // Thumbnail image clicks
                document.querySelectorAll('.thumbnail-image').forEach(thumbnail => {
                    thumbnail.addEventListener('click', function () {
                        const imageUrl = this.getAttribute('data-image-url');
                        changeMainImage(imageUrl, this);
                    });
                });

                // Tab navigation
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.addEventListener('click', function () {
                        const tabName = this.id.replace('-tab', '');
                        switchTab(tabName);
                    });
                });
            });

            // Alpine.js component for product page
            function productPage() {
                return {
                    selectedSize: null,
                    showSizeGuide: false,
                    // Add any additional Alpine.js specific functionality here
                };
            }
        </script>

        <!-- Enhanced Professional Styling -->
        <style>
            /* Smooth entrance animations for attribute cards */
            .group:nth-child(1) { animation: slideInUp 0.6s ease-out 0.1s both; }
            .group:nth-child(2) { animation: slideInUp 0.6s ease-out 0.2s both; }
            .group:nth-child(3) { animation: slideInUp 0.6s ease-out 0.3s both; }
            .group:nth-child(4) { animation: slideInUp 0.6s ease-out 0.4s both; }
            .group:nth-child(5) { animation: slideInUp 0.6s ease-out 0.5s both; }
            .group:nth-child(6) { animation: slideInUp 0.6s ease-out 0.6s both; }

            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Enhanced hover effects */
            .group:hover .bg-white {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            /* Pulse animation for the status indicators */
            .animate-pulse {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            /* Subtle gradient animations */
            .bg-gradient-to-r:hover {
                background-size: 200% 200%;
                animation: gradientShift 3s ease infinite;
            }

            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* Enhanced tag hover effects */
            .group span:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
            }

            /* Professional card entrance */
            .bg-white {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Smooth icon rotations */
            .group:hover i {
                animation: iconSpin 0.5s ease-in-out;
            }

            @keyframes iconSpin {
                0% { transform: rotate(0deg); }
                50% { transform: rotate(10deg); }
                100% { transform: rotate(0deg); }
            }

            /* Professional loading shimmer effect */
            .shimmer {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: shimmer 1.5s infinite;
            }

            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }
        </style>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/products/show.blade.php ENDPATH**/ ?>