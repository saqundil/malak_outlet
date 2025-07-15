

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
                <a href="<?php echo e(route('products.category', $product->category->slug)); ?>" class="hover:text-orange-500 transition-colors">
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
                                <img src="<?php echo e($product->images->first()->image_path); ?>" 
                                     alt="<?php echo e($product->name); ?>" 
                                     class="w-full h-full object-cover product-image-zoom cursor-zoom-in"
                                     id="main-image">
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
                        <?php if($product->sale_price): ?>
                            <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                وفر <?php echo e(number_format((($product->price - $product->sale_price) / $product->price) * 100, 0)); ?>%
                            </div>
                        <?php endif; ?>
                        
                        <!-- Stock Badge -->
                        <?php if($product->stock_quantity <= 5 && $product->stock_quantity > 0): ?>
                            <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                بقي <?php echo e($product->stock_quantity); ?> فقط!
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Thumbnail Gallery -->
                    <?php if($product->images->count() > 1): ?>
                        <div class="flex gap-3 overflow-x-auto pb-2">
                            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden cursor-pointer border-2 transition-all duration-200 <?php echo e($index === 0 ? 'border-orange-500' : 'border-transparent hover:border-gray-300'); ?> thumbnail-image"
                                     data-image-url="<?php echo e($image->image_path); ?>">
                                    <img src="<?php echo e($image->image_path); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
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
                                <span class="text-sm text-gray-500 bg-gray-200 px-3 py-1 rounded-full"><?php echo e($product->brand->name); ?></span>
                            </div>
                        <?php endif; ?>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3 leading-tight"><?php echo e($product->name); ?></h1>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span>رقم المنتج: <?php echo e($product->sku); ?></span>
                            <span>•</span>
                            <span>الفئة: <?php echo e($product->category->name); ?></span>
                        </div>
                    </div>

                    <!-- Price Section -->
                    <div class="mb-8 p-6 bg-white rounded-xl border">
                        <?php if($product->sale_price): ?>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-3xl lg:text-4xl font-bold text-orange-600"><?php echo e(number_format($product->sale_price, 2)); ?> د.أ</span>
                                    <span class="bg-red-100 text-red-800 text-sm font-bold px-3 py-1 rounded-full">
                                        خصم <?php echo e(number_format((($product->price - $product->sale_price) / $product->price) * 100, 0)); ?>%
                                    </span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-lg text-gray-500 line-through"><?php echo e(number_format($product->price, 2)); ?> د.أ</span>
                                    <span class="text-green-600 font-medium">
                                        وفرت <?php echo e(number_format($product->price - $product->sale_price, 2)); ?> د.أ
                                    </span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="flex items-center justify-between">
                                <span class="text-3xl lg:text-4xl font-bold text-gray-900"><?php echo e(number_format($product->price, 2)); ?> د.أ</span>
                                <span class="text-sm text-gray-500">السعر شامل الضريبة</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Stock & Availability -->
                    <div class="mb-8">
                        <?php if($product->stock_quantity > 0): ?>
                            <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                <div>
                                    <p class="font-semibold text-green-800">متوفر في المخزن</p>
                                    <p class="text-sm text-green-600"><?php echo e($product->stock_quantity); ?> قطعة متاحة</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl">
                                <i class="fas fa-times-circle text-red-600 text-xl"></i>
                                <div>
                                    <p class="font-semibold text-red-800">غير متوفر حالياً</p>
                                    <p class="text-sm text-red-600">سيتم إشعارك عند التوفر</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Product Sizes -->
                    <?php if($product->sizes && $product->sizes->count() > 0): ?>
                        <div class="mb-8 p-6 bg-white rounded-xl border">
                            <label class="text-lg font-semibold text-gray-700 mb-4 block">الحجم المتاح:</label>
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3" x-data="{ selectedSize: null }">
                                <?php $__currentLoopData = $product->availableSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button 
                                        type="button" 
                                        @click="selectedSize = <?php echo e($size->id); ?>"
                                        :class="selectedSize === <?php echo e($size->id); ?> ? 'border-orange-500 bg-orange-50 text-orange-600' : 'border-gray-300 hover:border-orange-300'"
                                        class="relative border-2 rounded-xl py-3 px-4 text-center transition-all duration-200 group"
                                        data-size-id="<?php echo e($size->id); ?>"
                                        data-additional-price="<?php echo e($size->additional_price); ?>">
                                        <div class="font-semibold text-sm"><?php echo e($size->size); ?></div>
                                        <?php if($size->additional_price > 0): ?>
                                            <div class="text-xs text-gray-500 mt-1">+<?php echo e(number_format($size->additional_price, 0)); ?> د.أ</div>
                                        <?php endif; ?>
                                        <?php if($size->stock_quantity < 5): ?>
                                            <div class="text-xs text-red-500 mt-1"><?php echo e($size->stock_quantity); ?> متبقي</div>
                                        <?php endif; ?>
                                        
                                        <!-- Selection indicator -->
                                        <div x-show="selectedSize === <?php echo e($size->id); ?>" 
                                             class="absolute -top-2 -right-2 w-5 h-5 bg-orange-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <!-- Size Guide Link -->
                            <div class="mt-4 text-center">
                                <button type="button" class="text-orange-500 hover:text-orange-600 underline text-sm">
                                    <i class="fas fa-ruler ml-1"></i>دليل المقاسات
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Quantity & Add to Cart -->
                    <?php if($product->stock_quantity > 0): ?>
                        <div class="mb-8 p-6 bg-white rounded-xl border">
                            <div class="flex items-center gap-4 mb-6">
                                <label class="text-lg font-semibold text-gray-700">الكمية:</label>
                                <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                                    <button type="button" class="quantity-btn-minus px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors border-r border-gray-200">
                                        <i class="fas fa-minus text-gray-600"></i>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1" max="<?php echo e($product->stock_quantity); ?>" 
                                           class="w-20 text-center py-3 border-0 focus:ring-0 focus:outline-none text-lg font-semibold">
                                    <button type="button" class="quantity-btn-plus px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors border-l border-gray-200">
                                        <i class="fas fa-plus text-gray-600"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <button data-product-id="<?php echo e($product->id); ?>" 
                                        class="add-to-cart-main w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-4 px-6 rounded-xl font-bold text-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg add-to-cart-btn">
                                    <i class="fas fa-shopping-cart ml-2"></i>
                                    <span class="btn-text">أضف إلى السلة</span>
                                    <span class="loading-text hidden">
                                        <i class="fas fa-spinner fa-spin ml-2"></i>جاري الإضافة...
                                    </span>
                                </button>
                                
                                <button data-product-id="<?php echo e($product->id); ?>" 
                                        class="add-to-wishlist-btn w-full border-2 py-4 px-6 rounded-xl font-bold text-lg transition-all duration-300 <?php echo e($isInWishlist ? 'border-red-500 text-red-500 bg-red-50' : 'border-orange-500 text-orange-500 hover:bg-orange-50'); ?>"
                                        title="<?php echo e($isInWishlist ? 'إزالة من المفضلة' : 'أضف إلى المفضلة'); ?>">
                                    <i class="fas fa-heart ml-2 <?php echo e($isInWishlist ? 'text-red-500' : ''); ?>"></i>
                                    <span class="wishlist-text"><?php echo e($isInWishlist ? 'في المفضلة' : 'أضف إلى المفضلة'); ?></span>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Product Features -->
                    <div class="mb-8 p-6 bg-white rounded-xl border">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">مميزات المنتج</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-shipping-fast text-orange-500"></i>
                                <span class="text-gray-700">شحن مجاني للطلبات فوق 200 د.أ</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-undo text-orange-500"></i>
                                <span class="text-gray-700">إمكانية الإرجاع خلال 14 يوم</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-shield-alt text-orange-500"></i>
                                <span class="text-gray-700">ضمان الجودة</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-headset text-orange-500"></i>
                                <span class="text-gray-700">دعم فني 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Tabbed Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200" dir="rtl">
                <nav class="flex space-x-8 space-x-reverse px-6">
                    <button class="tab-button py-4 px-2 border-b-2 font-medium text-sm transition-colors duration-200 border-orange-500 text-orange-600"
                            id="description-tab">
                        وصف المنتج
                    </button>
                    <button class="tab-button py-4 px-2 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                            id="specifications-tab">
                        المواصفات
                    </button>
                    <button class="tab-button py-4 px-2 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="font-semibold text-gray-900">رقم المنتج:</span>
                                <span class="text-gray-700"><?php echo e($product->sku); ?></span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="font-semibold text-gray-900">الفئة:</span>
                                <span class="text-gray-700"><?php echo e($product->category->name); ?></span>
                            </div>
                            <?php if($product->brand): ?>
                                <div class="flex justify-between py-3 border-b border-gray-200">
                                    <span class="font-semibold text-gray-900">العلامة التجارية:</span>
                                    <span class="text-gray-700"><?php echo e($product->brand->name); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="font-semibold text-gray-900">الوزن:</span>
                                <span class="text-gray-700"><?php echo e($product->formatted_weight); ?></span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="font-semibold text-gray-900">الأبعاد:</span>
                                <span class="text-gray-700"><?php echo e($product->formatted_dimensions); ?></span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="font-semibold text-gray-900">المواد:</span>
                                <span class="text-gray-700"><?php echo e($product->formatted_materials); ?></span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="font-semibold text-gray-900">بلد المنشأ:</span>
                                <span class="text-gray-700"><?php echo e($product->formatted_country); ?></span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="font-semibold text-gray-900">الضمان:</span>
                                <span class="text-gray-700"><?php echo e($product->formatted_warranty); ?></span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-gray-200">
                                <span class="font-semibold text-gray-900">الكمية المتاحة:</span>
                                <span class="text-gray-700"><?php echo e($product->stock_quantity); ?> قطعة</span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Specifications -->
                    <div class="mt-8">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">مواصفات إضافية</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php if($product->suitable_age): ?>
                                <div class="flex justify-between py-3 border-b border-gray-200">
                                    <span class="font-semibold text-gray-900">العمر المناسب:</span>
                                    <span class="text-gray-700"><?php echo e($product->formatted_suitable_age); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($product->pieces_count): ?>
                                <div class="flex justify-between py-3 border-b border-gray-200">
                                    <span class="font-semibold text-gray-900">عدد القطع:</span>
                                    <span class="text-gray-700"><?php echo e($product->formatted_pieces_count); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($product->standards): ?>
                                <div class="flex justify-between py-3 border-b border-gray-200">
                                    <span class="font-semibold text-gray-900">المعايير:</span>
                                    <span class="text-gray-700"><?php echo e($product->formatted_standards); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($product->battery_type): ?>
                                <div class="flex justify-between py-3 border-b border-gray-200">
                                    <span class="font-semibold text-gray-900">نوع البطارية:</span>
                                    <span class="text-gray-700"><?php echo e($product->formatted_battery_type); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if(!is_null($product->washable)): ?>
                                <div class="flex justify-between py-3 border-b border-gray-200">
                                    <span class="font-semibold text-gray-900">قابل للغسل:</span>
                                    <span class="text-gray-700"><?php echo e($product->formatted_washable); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
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
                                            <span class="text-lg font-semibold text-gray-700"><?php echo e(number_format($product->average_rating, 1)); ?> من 5</span>
                                            <span class="text-gray-500">(<?php echo e($product->reviews_count); ?> <?php echo e($product->reviews_count == 1 ? 'تقييم' : 'تقييمات'); ?>)</span>
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
                                                        <div class="bg-yellow-400 h-2 rounded-full transition-all duration-300 rating-bar" data-width="<?php echo e($percentage); ?>"></div>
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
                                <button class="bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition-colors">
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
                                                <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold">
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
            </div>
        </div>
        <!-- Professional Related Products Section -->
        <?php if($relatedProducts->count() > 0): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="border-b border-gray-200 p-6">
                    <div class="flex items-center justify-between" dir="rtl">
                        <h2 class="text-2xl font-bold text-gray-900">منتجات ذات صلة</h2>
                        <a href="<?php echo e(route('products.category', $product->category->slug)); ?>" 
                           class="text-orange-500 hover:text-orange-600 font-medium transition-colors">
                            عرض المزيد <i class="fas fa-arrow-left mr-2"></i>
                        </a>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="group bg-gray-50 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="relative aspect-square overflow-hidden">
                                    <?php if($relatedProduct->images->first()): ?>
                                        <img src="<?php echo e($relatedProduct->images->first()->image_path); ?>" 
                                             alt="<?php echo e($relatedProduct->name); ?>" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Sale Badge -->
                                    <?php if($relatedProduct->sale_price): ?>
                                        <div class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                            خصم <?php echo e(number_format((($relatedProduct->price - $relatedProduct->sale_price) / $relatedProduct->price) * 100, 0)); ?>%
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Quick View Button -->
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                        <a href="<?php echo e(route('products.show', $relatedProduct->id)); ?>" 
                                           class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 shadow-lg">
                                            عرض سريع
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="p-4" dir="rtl">
                                    <h3 class="font-semibold text-lg mb-2 text-gray-800 group-hover:text-orange-600 transition-colors line-clamp-2">
                                        <?php echo e($relatedProduct->name); ?>

                                    </h3>
                                    
                                    <?php if($relatedProduct->brand): ?>
                                        <p class="text-sm text-gray-500 mb-3"><?php echo e($relatedProduct->brand->name); ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <?php if($relatedProduct->sale_price): ?>
                                                <div class="space-y-1">
                                                    <span class="text-lg font-bold text-orange-600"><?php echo e(number_format($relatedProduct->sale_price, 2)); ?> د.أ</span>
                                                    <br>
                                                    <span class="text-sm text-gray-500 line-through"><?php echo e(number_format($relatedProduct->price, 2)); ?> د.أ</span>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-lg font-bold text-gray-800"><?php echo e(number_format($relatedProduct->price, 2)); ?> د.أ</span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if($relatedProduct->stock_quantity > 0): ?>
                                            <button data-product-id="<?php echo e($relatedProduct->id); ?>" 
                                                    class="add-to-cart-quick bg-orange-500 text-white p-2 rounded-lg hover:bg-orange-600 transition-colors shadow-md">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        <?php else: ?>
                                            <span class="text-xs text-red-500 font-medium">غير متوفر</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php $__env->startPush('scripts'); ?>
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
    const originalPrice = <?php echo e($product->sale_price ?? $product->price); ?>;
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
        body: JSON.stringify({ quantity: 1 })
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
document.addEventListener('DOMContentLoaded', function() {
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
        quantityInput.addEventListener('input', function() {
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
        button.addEventListener('click', function() {
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
    document.querySelector('.add-to-cart-main')?.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        addToCartWithQuantity(parseInt(productId));
    });
    
    // Main wishlist button
    document.querySelector('.add-to-wishlist-btn')?.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        addToWishlist(parseInt(productId), this);
    });
    
    // Quick add to cart buttons
    document.querySelectorAll('.add-to-cart-quick').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            addToCartQuick(parseInt(productId));
        });
    });
    
    // Related products wishlist buttons
    document.querySelectorAll('.wishlist-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            addToWishlist(parseInt(productId), this);
        });
    });
    
    // Thumbnail image clicks
    document.querySelectorAll('.thumbnail-image').forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const imageUrl = this.getAttribute('data-image-url');
            changeMainImage(imageUrl, this);
        });
    });
    
    // Tab navigation
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.id.replace('-tab', '');
            switchTab(tabName);
        });
    });
});

// Alpine.js component for product page
function productPage() {
    return {
        // Add any Alpine.js specific functionality here
    };
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/products/show.blade.php ENDPATH**/ ?>