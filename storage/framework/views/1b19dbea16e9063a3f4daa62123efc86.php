

<?php $__env->startSection('title', 'جميع المنتجات - Malak Outlet'); ?>

<?php $__env->startSection('content'); ?>
<style>
/* Custom scrollbar for filter sidebar */
.filter-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #fb923c #f3f4f6;
    scroll-behavior: smooth;
}

.filter-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.filter-scrollbar::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 3px;
}

.filter-scrollbar::-webkit-scrollbar-thumb {
    background: #fb923c;
    border-radius: 3px;
    transition: background-color 0.2s ease;
}

.filter-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #f97316;
}

/* Ensure smooth scrolling for the entire page */
html {
    scroll-behavior: smooth;
}

/* Add padding to prevent content from being hidden under sticky elements */
.filter-content {
    padding-bottom: 1rem;
}
</style>

<main class="container mx-auto px-4" style="max-width: 1400px;">
    <div class="min-h-screen bg-gray-50 -mx-4 px-4">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 lg:mb-8 space-y-4 sm:space-y-0 pt-6 lg:pt-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">جميع المنتجات</h1>
            <div class="flex items-center space-x-4 space-x-reverse">
                <span class="text-gray-600"><?php echo e($products->total()); ?> منتج</span>
            </div>
        </div>

            <div class="lg:grid lg:grid-cols-4 lg:gap-6 xl:gap-8">
                <!-- Modern Filters Sidebar -->
                <div class="hidden lg:block lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 sticky top-24 max-h-[calc(100vh-7rem)] overflow-y-auto filter-scrollbar">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-gray-900">التصفية</h3>
                                <button onclick="clearFilters()" class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                                    مسح الكل
                                </button>
                            </div>
                        </div>
                        
                        <div class="px-6 pb-6 filter-content">
                            <form method="GET" action="<?php echo e(route('products.index')); ?>" id="filterForm">
                            <!-- Search Box -->
                            <div class="mb-6">
                                <div class="relative">
                                    <input type="text" name="search" placeholder="ابحث في المنتجات..." 
                                           value="<?php echo e(request('search')); ?>"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Categories Filter -->
                            <div class="mb-6">
                                <button type="button" onclick="toggleSection('categories')" class="w-full text-left">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center justify-between hover:text-orange-600 transition-colors">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 ml-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            التصنيفات
                                        </div>
                                        <svg id="categories-arrow" class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </h4>
                                </button>
                                <div id="categories-content" class="space-y-3 hidden">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Main Category -->
                                    <div class="category-group">
                                        <div class="flex items-center justify-between bg-orange-50 rounded-lg p-3 border border-orange-100">
                                            <label class="flex items-center group cursor-pointer flex-1">
                                                <input type="checkbox" name="category[]" value="<?php echo e($category->id); ?>" 
                                                       class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500"
                                                       <?php echo e(in_array($category->id, (array)request('category', [])) ? 'checked' : ''); ?>>
                                                <span class="mr-3 text-sm font-bold text-orange-700 group-hover:text-orange-800 transition-colors"><?php echo e($category->name); ?></span>
                                                <span class="mr-auto text-xs text-orange-600 bg-orange-200 px-2 py-1 rounded-full font-medium"><?php echo e($category->products_count); ?></span>
                                            </label>
                                            <?php if($category->children->count() > 0): ?>
                                            <button type="button" onclick="toggleSubcategories('<?php echo e($category->id); ?>')" class="mr-2 p-1 hover:bg-orange-200 rounded transition-colors">
                                                <svg id="arrow-<?php echo e($category->id); ?>" class="w-4 h-4 text-orange-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Subcategories -->
                                        <?php if($category->children->count() > 0): ?>
                                            <div id="subcategories-<?php echo e($category->id); ?>" class="mr-6 space-y-2 mt-2 hidden">
                                                <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <label class="flex items-center group cursor-pointer hover:bg-gray-50 rounded-lg p-2 transition-colors">
                                                    <input type="checkbox" name="category[]" value="<?php echo e($subcategory->id); ?>" 
                                                           class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500"
                                                           <?php echo e(in_array($subcategory->id, (array)request('category', [])) ? 'checked' : ''); ?>>
                                                    <span class="mr-3 text-sm text-gray-600 group-hover:text-orange-600 transition-colors flex items-center">
                                                        <svg class="w-3 h-3 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg>
                                                        <?php echo e($subcategory->name); ?>

                                                    </span>
                                                    <span class="mr-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full"><?php echo e($subcategory->products_count); ?></span>
                                                </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <!-- Brands Filter -->
                            <?php if($brands->count() > 0): ?>
                            <div class="mb-6" id="brands-filter-section">
                                <!-- Show message when no category is selected -->
                                <div id="brands-placeholder" class="<?php echo e(request('category') ? 'hidden' : ''); ?>">
                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-orange-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            <div>
                                                <h4 class="text-sm font-semibold text-orange-800">العلامات التجارية</h4>
                                                <p class="text-xs text-orange-600 mt-1">يرجى اختيار تصنيف أولاً لعرض العلامات التجارية المتاحة</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Show brands when category is selected -->
                                <div id="brands-active-section" class="<?php echo e(!request('category') ? 'hidden' : ''); ?>">
                                    <button type="button" onclick="toggleSection('brands')" class="w-full text-left">
                                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center justify-between hover:text-orange-600 transition-colors">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 ml-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                                العلامات التجارية
                                            </div>
                                            <svg id="brands-arrow" class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </h4>
                                    </button>
                                    <div id="brands-content" class="space-y-3 hidden">
                                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-center group cursor-pointer">
                                            <input type="checkbox" name="brand[]" value="<?php echo e($brand->id); ?>" 
                                                   class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500"
                                                   <?php echo e(in_array($brand->id, (array)request('brand', [])) ? 'checked' : ''); ?>>
                                            <span class="mr-3 text-sm text-gray-700 group-hover:text-orange-600 transition-colors"><?php echo e($brand->name); ?></span>
                                            <span class="mr-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full"><?php echo e($brand->products_count); ?></span>
                                        </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Price Range -->
                            <div class="mb-6">
                                <button type="button" onclick="toggleSection('price')" class="w-full text-left">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center justify-between hover:text-orange-600 transition-colors">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 ml-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            النطاق السعري
                                        </div>
                                        <svg id="price-arrow" class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </h4>
                                </button>
                                <div id="price-content" class="bg-gray-50 rounded-lg p-4 hidden">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-2">من</label>
                                            <input type="number" name="min_price" placeholder="0" 
                                                   value="<?php echo e(request('min_price')); ?>"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs text-gray-600 mb-2">إلى</label>
                                            <input type="number" name="max_price" placeholder="1000" 
                                                   value="<?php echo e(request('max_price')); ?>"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                        </div>
                                    </div>
                                    <div class="mt-3 text-xs text-gray-500 text-center">د.أ</div>
                                </div>
                            </div>

                            <!-- Special Options -->
                            <div class="mb-6">
                                <button type="button" onclick="toggleSection('special')" class="w-full text-left">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center justify-between hover:text-orange-600 transition-colors">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 ml-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                            </svg>
                                            خيارات خاصة
                                        </div>
                                        <svg id="special-arrow" class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </h4>
                                </button>
                                <div id="special-content" class="space-y-3 hidden">
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="checkbox" name="featured" value="1" 
                                               class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500"
                                               <?php echo e(request('featured') ? 'checked' : ''); ?>>
                                        <span class="mr-3 text-sm text-gray-700 group-hover:text-orange-600 transition-colors">منتجات مميزة</span>
                                    </label>
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="checkbox" name="in_stock" value="1" 
                                               class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500"
                                               <?php echo e(request('in_stock') ? 'checked' : ''); ?>>
                                        <span class="mr-3 text-sm text-gray-700 group-hover:text-orange-600 transition-colors">متوفر في المخزن</span>
                                    </label>
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="checkbox" name="on_sale" value="1" 
                                               class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500"
                                               <?php echo e(request('on_sale') ? 'checked' : ''); ?>>
                                        <span class="mr-3 text-sm text-gray-700 group-hover:text-orange-600 transition-colors">منتجات بخصم</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Sizes Filter -->
                            <?php if(!empty($availableSizes)): ?>
                            <div class="mb-6">
                                <button type="button" onclick="toggleSection('sizes')" class="w-full text-left">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center justify-between hover:text-orange-600 transition-colors">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 ml-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                            </svg>
                                            المقاسات
                                        </div>
                                        <svg id="sizes-arrow" class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </h4>
                                </button>
                                <div id="sizes-content" class="grid grid-cols-4 gap-2 hidden">
                                    <?php $__currentLoopData = $availableSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="relative cursor-pointer">
                                            <input type="checkbox" name="sizes[]" value="<?php echo e($size); ?>" class="sr-only size-checkbox"
                                                   <?php echo e(in_array($size, request('sizes', [])) ? 'checked' : ''); ?>>
                                            <div class="size-button w-full text-center py-2 px-1 text-xs font-medium border-2 rounded-lg transition-all duration-200 hover:border-orange-300
                                                  <?php echo e(in_array($size, request('sizes', [])) ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700 border-gray-300'); ?>">
                                                <div class="font-bold"><?php echo e($size); ?></div>
                                                <div class="text-xs opacity-75">(<?php echo e($count); ?>)</div>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Apply Filters Button -->
                            <div class="space-y-3">
                                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-orange-600 hover:to-orange-700 transition duration-200 transform hover:scale-105 shadow-lg">
                                    تطبيق التصفية
                                </button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="lg:col-span-3">
                    <!-- Mobile Filter Toggle -->
                    <div class="lg:hidden mb-4">
                        <button onclick="toggleMobileFilters()" class="bg-white border border-gray-300 rounded-md px-4 py-2 flex items-center justify-center w-full shadow-sm">
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                            </svg>
                            تصفية النتائج
                        </button>
                    </div>

                    <!-- Modern Sort Options -->
                    <div class="bg-white rounded-xl shadow-lg p-4 mb-6 border border-gray-100">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
                            <div class="flex items-center space-x-4 space-x-reverse">
                                <span class="text-sm font-medium text-gray-700">ترتيب حسب:</span>
                                <div class="relative">
                                    <select name="sort" onchange="this.form.submit()" form="filterForm" 
                                            class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                        <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>الأحدث</option>
                                        <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>السعر: من الأقل للأعلى</option>
                                        <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>السعر: من الأعلى للأقل</option>
                                        <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>الاسم</option>
                                        <option value="popularity" <?php echo e(request('sort') == 'popularity' ? 'selected' : ''); ?>>الأكثر شعبية</option>
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <span class="text-sm text-gray-600"><?php echo e($products->total()); ?> منتج</span>
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    <button onclick="toggleViewMode('grid')" id="grid-view" class="view-toggle p-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors active">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="toggleViewMode('list')" id="list-view" class="view-toggle p-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php if($products->count() > 0): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-6">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group border border-gray-100 flex flex-col h-full">
                            <div class="relative">
                                <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="block">
                                    <?php if($product->images->first()): ?>
                                        <img src="<?php echo e($product->images->first()->image_url); ?>" 
                                             alt="<?php echo e($product->name); ?>" 
                                             class="w-full h-48 sm:h-56 object-cover group-hover:scale-105 transition-transform duration-300">
                                    <?php else: ?>
                                        <div class="w-full h-48 sm:h-56 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                
                                <!-- Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    <?php if($product->discount_percentage > 0): ?>
                                        <span class="bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg border-2 border-white">
                                            خصم <?php echo e($product->discount_percentage); ?>%
                                        </span>
                                    <?php endif; ?>
                                    <?php if($product->is_featured): ?>
                                        <span class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg border-2 border-white">
                                            مميز
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Wishlist Button -->
                                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-lg hover:bg-white hover:shadow-xl text-gray-600 add-to-wishlist-btn <?php echo e(in_array($product->slug, $wishlistProductIds ?? []) ? 'is-in-wishlist text-red-500' : ''); ?> transition-all duration-200"
                                            data-product-id="<?php echo e($product->slug); ?>"
                                            title="<?php echo e(in_array($product->slug, $wishlistProductIds ?? []) ? 'موجود في قائمة الأمنيات' : 'إضافة إلى قائمة الأمنيات'); ?>">
                                        <svg class="w-4 h-4" 
                                             fill="<?php echo e(in_array($product->slug, $wishlistProductIds ?? []) ? 'currentColor' : 'none'); ?>" 
                                             stroke="currentColor" 
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Stock Status -->
                                <?php if($product->quantity <= 0 || $product->status != 'in_stock'): ?>
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                        <span class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold">غير متوفر</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="p-4 flex flex-col flex-1">
                                <!-- Product Brand -->
                                <?php if($product->brand): ?>
                                    <p class="text-xs text-orange-600 font-medium mb-1 uppercase tracking-wide"><?php echo e($product->brand->name); ?></p>
                                <?php endif; ?>

                                <!-- Product Name -->
                                <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="block">
                                    <h3 class="font-bold text-base sm:text-lg mb-2 text-gray-800 hover:text-orange-600 transition-colors duration-200 leading-tight h-12 overflow-hidden">
                                        <?php echo e(Str::limit($product->name, 60)); ?>

                                    </h3>
                                </a>

                                <!-- Product Category -->
                                <?php if($product->category): ?>
                                    <p class="text-xs text-gray-500 mb-3"><?php echo e($product->category->name); ?></p>
                                <?php endif; ?>
                                
                                <!-- Flexible content area -->
                                <div class="flex-1">
                                    <!-- Price Section -->
                                    <div class="mb-4">
                                        <?php if($product->discount_percentage > 0): ?>
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-lg font-bold text-orange-600"><?php echo e(number_format($product->effective_price, 2)); ?> د.أ</span>
                                                <span class="text-sm text-gray-500 line-through"><?php echo e(number_format($product->price, 2)); ?> د.أ</span>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-lg font-bold text-gray-800"><?php echo e(number_format($product->price, 2)); ?> د.أ</span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Rating (if available) -->
                                    <?php if(isset($product->average_rating) && $product->average_rating > 0): ?>
                                        <div class="flex items-center mb-3">
                                            <div class="flex items-center">
                                                <?php for($i = 1; $i <= 5; $i++): ?>
                                                    <svg class="w-4 h-4 <?php echo e($i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="text-xs text-gray-600 mr-2">(<?php echo e($product->reviews_count ?? 0); ?>)</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Action Buttons - Always at bottom -->
                                <div class="mt-auto">
                                    <!-- Quick Info -->
                                    <?php if($product->quantity > 0 && $product->quantity <= 5): ?>
                                        <p class="text-xs text-red-600 mb-3 font-medium">
                                            <svg class="w-3 h-3 inline ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            متبقي <?php echo e($product->quantity); ?> قطع فقط!
                                        </p>
                                    <?php endif; ?>

                                    <div class="flex items-center gap-2">
                                        <?php if($product->quantity > 0 && $product->status == 'in_stock'): ?>
                                            <?php if($product->sizes && $product->sizes->count() > 0): ?>
                                                <!-- Products with sizes - redirect to product page -->
                                                <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                                                   class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2.5 px-4 rounded-lg text-sm font-semibold hover:from-orange-600 hover:to-orange-700 transition-all duration-300 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                    اختر المقاس
                                                </a>
                                            <?php else: ?>
                                                <!-- Regular products without sizes -->
                                                <button onclick="addToCart('<?php echo e($product->slug); ?>')" 
                                                        class="flex-1 add-to-cart-btn bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2.5 px-4 rounded-lg text-sm font-semibold hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                    <span class="btn-text">أضف للسلة</span>
                                                    <span class="loading-text hidden">جاري الإضافة...</span>
                                                </button>
                                            <?php endif; ?>
                                            <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                                               class="px-3 py-2.5 border border-orange-300 text-orange-600 hover:bg-orange-50 rounded-lg text-sm font-medium transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        <?php else: ?>
                                            <div class="flex-1 bg-gray-100 text-gray-500 py-2.5 px-4 rounded-lg text-sm font-medium text-center">
                                                غير متوفر
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 px-6 py-4">
                        <?php echo e($products->appends(request()->query())->links('custom.pagination')); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-12 lg:py-16">
                    <svg class="w-20 sm:w-24 h-20 sm:h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                    </svg>
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-600 mb-2">لا توجد منتجات</h2>
                    <p class="text-sm sm:text-base text-gray-500">لم يتم العثور على أي منتجات حالياً</p>
                </div>
            <?php endif; ?>
    </div>
</main>

<!-- Mobile Filters Modal -->
<div id="mobileFilters" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileFilters()"></div>
    <div class="fixed right-0 top-0 h-full w-80 max-w-full bg-white shadow-lg transform translate-x-full transition-transform duration-300" id="mobileFiltersPanel">
        <div class="flex justify-between items-center p-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">تصفية المنتجات</h3>
            <button onclick="toggleMobileFilters()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex flex-col h-full">
            <div class="flex-1 overflow-y-auto p-4 filter-scrollbar max-h-[calc(100vh-12rem)]">
                <form method="GET" action="<?php echo e(route('products.index')); ?>" id="mobileFilterForm">
                    <!-- Mobile Search -->
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                                   placeholder="ابحث عن منتج..." 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Categories -->
                    <div class="mb-6">
                        <button type="button" onclick="toggleMobileSection('mobile-categories')" class="w-full text-left">
                            <div class="flex items-center space-x-3 space-x-reverse mb-4">
                                <div class="p-2 bg-gradient-to-r from-orange-500 to-pink-500 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7H3m16 14H3"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">التصنيفات</h4>
                                <svg id="mobile-categories-arrow" class="w-5 h-5 text-gray-400 transform transition-transform duration-200 mr-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div id="mobile-categories-content" class="space-y-3 hidden">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!-- Mobile Main Category -->
                            <label class="flex items-center p-3 bg-orange-50 hover:bg-orange-100 rounded-xl transition-colors cursor-pointer border border-orange-100">
                                <input type="checkbox" name="category[]" value="<?php echo e($category->id); ?>" 
                                       <?php echo e(in_array($category->id, (array)request('category', [])) ? 'checked' : ''); ?>

                                       class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                                <span class="mr-3 text-orange-700 font-bold"><?php echo e($category->name); ?></span>
                                <span class="mr-auto text-sm text-orange-600 bg-orange-200 px-2 py-1 rounded-full font-medium"><?php echo e($category->products_count); ?></span>
                            </label>
                            
                            <!-- Mobile Subcategories -->
                            <?php if($category->children->count() > 0): ?>
                                <div class="mr-6 space-y-2">
                                    <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center p-2 hover:bg-gray-50 rounded-lg transition-colors cursor-pointer">
                                        <input type="checkbox" name="category[]" value="<?php echo e($subcategory->id); ?>" 
                                               <?php echo e(in_array($subcategory->id, (array)request('category', [])) ? 'checked' : ''); ?>

                                               class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                                        <span class="mr-3 text-gray-600 font-medium flex items-center">
                                            <svg class="w-3 h-3 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            <?php echo e($subcategory->name); ?>

                                        </span>
                                        <span class="mr-auto text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-full"><?php echo e($subcategory->products_count); ?></span>
                                    </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Mobile Brands -->
                    <?php if($brands->count() > 0): ?>
                    <div class="mb-6" id="mobile-brands-filter-section">
                        <!-- Show message when no category is selected -->
                        <div id="mobile-brands-placeholder" class="<?php echo e(request('category') ? 'hidden' : ''); ?>">
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="p-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg ml-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-orange-800">العلامات التجارية</h4>
                                        <p class="text-sm text-orange-600 mt-1">يرجى اختيار تصنيف أولاً لعرض العلامات التجارية</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Show brands when category is selected -->
                        <div id="mobile-brands-active-section" class="<?php echo e(!request('category') ? 'hidden' : ''); ?>">
                            <button type="button" onclick="toggleMobileSection('mobile-brands')" class="w-full text-left">
                                <div class="flex items-center space-x-3 space-x-reverse mb-4">
                                    <div class="p-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">العلامات التجارية</h4>
                                    <svg id="mobile-brands-arrow" class="w-5 h-5 text-gray-400 transform transition-transform duration-200 mr-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>
                            <div id="mobile-brands-content" class="space-y-3 hidden">
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="flex items-center p-3 hover:bg-gray-50 rounded-xl transition-colors cursor-pointer">
                                    <input type="checkbox" name="brand[]" value="<?php echo e($brand->id); ?>" 
                                           <?php echo e(in_array($brand->id, (array)request('brand', [])) ? 'checked' : ''); ?>

                                           class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                                    <span class="mr-3 text-gray-700 font-medium"><?php echo e($brand->name); ?></span>
                                    <span class="mr-auto text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-full"><?php echo e($brand->products_count); ?></span>
                                </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Mobile Price Range -->
                    <div class="mb-6">
                        <button type="button" onclick="toggleMobileSection('mobile-price')" class="w-full text-left">
                            <div class="flex items-center space-x-3 space-x-reverse mb-4">
                                <div class="p-2 bg-gradient-to-r from-green-500 to-teal-500 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">نطاق السعر</h4>
                                <svg id="mobile-price-arrow" class="w-5 h-5 text-gray-400 transform transition-transform duration-200 mr-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div id="mobile-price-content" class="hidden grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">السعر الأدنى</label>
                                <input type="number" name="min_price" value="<?php echo e(request('min_price')); ?>" 
                                       placeholder="0" min="0" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">السعر الأعلى</label>
                                <input type="number" name="max_price" value="<?php echo e(request('max_price')); ?>" 
                                       placeholder="1000" min="0" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Mobile Filter Actions -->
            <div class="border-t border-gray-200 p-4">
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="clearFilters()" 
                            class="w-full py-3 px-4 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                        مسح الكل
                    </button>
                    <button type="submit" form="mobileFilterForm" 
                            class="w-full py-3 px-4 bg-gradient-to-r from-orange-500 to-pink-500 text-white font-bold rounded-xl hover:from-orange-600 hover:to-pink-600 transition-all transform hover:scale-105 shadow-lg">
                        تطبيق
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleMobileFilters() {
    const modal = document.getElementById('mobileFilters');
    const panel = document.getElementById('mobileFiltersPanel');
    
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            panel.classList.remove('translate-x-full');
        }, 10);
    } else {
        panel.classList.add('translate-x-full');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
}

function addToCart(productId) {
    const button = event.target.closest('.add-to-cart-btn');
    const btnText = button.querySelector('.btn-text');
    const loadingText = button.querySelector('.loading-text');
    
    // Show loading state
    btnText.classList.add('hidden');
    loadingText.classList.remove('hidden');
    button.disabled = true;
    
    fetch('<?php echo e(route("cart.add", ":productId")); ?>'.replace(':productId', productId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success state
            btnText.textContent = 'تم الإضافة';
            btnText.classList.remove('hidden');
            loadingText.classList.add('hidden');
            button.classList.remove('bg-orange-500', 'hover:bg-orange-600');
            button.classList.add('bg-green-500');
            
            // Reset after 2 seconds
            setTimeout(() => {
                btnText.textContent = 'أضف للسلة';
                button.classList.remove('bg-green-500');
                button.classList.add('bg-orange-500', 'hover:bg-orange-600');
                button.disabled = false;
            }, 2000);
        } else {
            throw new Error(data.message || 'حدث خطأ');
        }
    })
    .catch(error => {
        // Show error state
        btnText.textContent = 'خطأ';
        btnText.classList.remove('hidden');
        loadingText.classList.add('hidden');
        button.classList.remove('bg-orange-500', 'hover:bg-orange-600');
        button.classList.add('bg-red-500');
        
        // Reset after 2 seconds
        setTimeout(() => {
            btnText.textContent = 'أضف للسلة';
            button.classList.remove('bg-red-500');
            button.classList.add('bg-orange-500', 'hover:bg-orange-600');
            button.disabled = false;
        }, 2000);
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
    const isInWishlist = button.classList.contains('is-in-wishlist');
    const action = isInWishlist ? 'remove' : 'add';
    const method = isInWishlist ? 'DELETE' : 'POST';

    // Show loading state
    const originalIcon = button.innerHTML;
    button.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
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
                button.innerHTML = '<svg class="w-4 h-4" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
                button.classList.add('is-in-wishlist', 'text-red-500');
                button.classList.remove('text-gray-600');
                button.title = 'موجود في قائمة الأمنيات';
                showNotification('تم إضافة المنتج إلى قائمة الأمنيات!', 'success');
            } else {
                // Item removed from wishlist
                button.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
                button.classList.remove('is-in-wishlist', 'text-red-500');
                button.classList.add('text-gray-600');
                button.title = 'إضافة إلى قائمة الأمنيات';
                showNotification('تم حذف المنتج من قائمة الأمنيات!', 'success');
            }
            
            // Update wishlist count in header
            if (data.wishlist_count !== undefined) {
                updateWishlistBadge(data.wishlist_count);
            }
        } else {
            showNotification(data.message || 'حدث خطأ في تحديث قائمة الأمنيات', 'error');
            button.innerHTML = originalIcon;
        }
    })
    .catch(error => {
        console.error('Wishlist error:', error);
        showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
        button.innerHTML = originalIcon;
    })
    .finally(() => {
        button.disabled = false;
    });
}

function showNotification(message, type = 'success') {
    // Remove existing notifications
    document.querySelectorAll('.notification').forEach(notif => notif.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white shadow-lg transition-opacity duration-300 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Add event listeners when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add category checkbox event listeners to toggle brands visibility
    const categoryCheckboxes = document.querySelectorAll('input[name="category[]"]');
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBrandsVisibility);
    });
    
    // Initial check for brands visibility
    toggleBrandsVisibility();
    
    // Add wishlist button event listeners
    document.querySelectorAll('.add-to-wishlist-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            addToWishlist(productId, this);
        });
    });
    
    // Size filter functionality
    document.querySelectorAll('.size-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const sizeButton = this.nextElementSibling;
            if (this.checked) {
                sizeButton.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
                sizeButton.classList.add('bg-orange-500', 'text-white', 'border-orange-500');
            } else {
                sizeButton.classList.remove('bg-orange-500', 'text-white', 'border-orange-500');
                sizeButton.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
            }
        });
    });
    
    // Make size buttons clickable
    document.querySelectorAll('.size-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const checkbox = this.previousElementSibling;
            checkbox.checked = !checkbox.checked;
            checkbox.dispatchEvent(new Event('change'));
        });
    });
});

// Clear all filters function
function clearFilters() {
    window.location.href = '<?php echo e(route("products.index")); ?>';
}

// Toggle filter sections
function toggleSection(sectionName) {
    const content = document.getElementById(sectionName + '-content');
    const arrow = document.getElementById(sectionName + '-arrow');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        arrow.classList.add('rotate-180');
    } else {
        content.classList.add('hidden');
        arrow.classList.remove('rotate-180');
    }
}

// Function to toggle brands visibility based on category selection and load relevant brands
function toggleBrandsVisibility() {
    const categoryCheckboxes = document.querySelectorAll('input[name="category[]"]');
    const brandsPlaceholder = document.getElementById('brands-placeholder');
    const brandsActiveSection = document.getElementById('brands-active-section');
    const mobileBrandsPlaceholder = document.getElementById('mobile-brands-placeholder');
    const mobileBrandsActiveSection = document.getElementById('mobile-brands-active-section');
    
    let hasSelectedCategory = false;
    let selectedCategories = [];
    
    categoryCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            hasSelectedCategory = true;
            selectedCategories.push(checkbox.value);
        }
    });
    
    console.log('Selected categories:', selectedCategories); // Debug log
    
    // Handle desktop brands
    if (brandsPlaceholder && brandsActiveSection) {
        if (hasSelectedCategory) {
            brandsPlaceholder.classList.add('hidden');
            brandsActiveSection.classList.remove('hidden');
            // Load brands for selected categories
            loadBrandsForCategories(selectedCategories);
        } else {
            brandsPlaceholder.classList.remove('hidden');
            brandsActiveSection.classList.add('hidden');
            // Clear brand selections when no category is selected
            const brandCheckboxes = document.querySelectorAll('input[name="brand[]"]');
            brandCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    }
    
    // Handle mobile brands
    if (mobileBrandsPlaceholder && mobileBrandsActiveSection) {
        if (hasSelectedCategory) {
            mobileBrandsPlaceholder.classList.add('hidden');
            mobileBrandsActiveSection.classList.remove('hidden');
        } else {
            mobileBrandsPlaceholder.classList.remove('hidden');
            mobileBrandsActiveSection.classList.add('hidden');
        }
    }
}

// Function to load brands for selected categories via AJAX
function loadBrandsForCategories(categories) {
    console.log('Loading brands for categories:', categories); // Debug log
    
    if (categories.length === 0) return;
    
    // Show loading state
    const desktopBrandsContent = document.getElementById('brands-content');
    const mobileBrandsContent = document.getElementById('mobile-brands-content');
    
    if (desktopBrandsContent) {
        desktopBrandsContent.innerHTML = '<div class="text-center py-4"><div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-orange-500"></div></div>';
    }
    if (mobileBrandsContent) {
        mobileBrandsContent.innerHTML = '<div class="text-center py-4"><div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-orange-500"></div></div>';
    }
    
    const url = `/api/brands-by-categories?categories=${categories.join(',')}`;
    console.log('AJAX URL:', url); // Debug log
    
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status); // Debug log
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data); // Debug log
        if (data.success && data.brands) {
            updateBrandsContent(data.brands);
        } else {
            console.error('Invalid response format:', data);
            showBrandsError('تعذر تحميل العلامات التجارية');
        }
    })
    .catch(error => {
        console.error('Error loading brands:', error);
        showBrandsError('خطأ في تحميل العلامات التجارية');
    });
}

// Function to show error message in brands section
function showBrandsError(message) {
    const errorHtml = `<div class="text-center py-4 text-red-600 text-sm">${message}</div>`;
    
    const desktopBrandsContent = document.getElementById('brands-content');
    const mobileBrandsContent = document.getElementById('mobile-brands-content');
    
    if (desktopBrandsContent) {
        desktopBrandsContent.innerHTML = errorHtml;
    }
    if (mobileBrandsContent) {
        mobileBrandsContent.innerHTML = errorHtml;
    }
}

// Function to update brands content with new data
function updateBrandsContent(brands) {
    const desktopBrandsContent = document.getElementById('brands-content');
    const mobileBrandsContent = document.getElementById('mobile-brands-content');
    
    // Handle empty brands case
    if (!brands || brands.length === 0) {
        const emptyMessage = '<div class="text-center py-4 text-gray-500 text-sm">لا توجد علامات تجارية متاحة للتصنيفات المحددة</div>';
        if (desktopBrandsContent) {
            desktopBrandsContent.innerHTML = emptyMessage;
        }
        if (mobileBrandsContent) {
            mobileBrandsContent.innerHTML = emptyMessage;
        }
        return;
    }
    
    if (desktopBrandsContent) {
        let brandsHtml = '';
        brands.forEach(brand => {
            const isChecked = document.querySelector(`input[name="brand[]"][value="${brand.id}"]`)?.checked || false;
            brandsHtml += `
                <label class="flex items-center group cursor-pointer mb-3 last:mb-0">
                    <input type="checkbox" name="brand[]" value="${brand.id}" 
                           class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500"
                           ${isChecked ? 'checked' : ''}>
                    <span class="mr-3 text-sm text-gray-700 group-hover:text-orange-600 transition-colors">${brand.name}</span>
                    <span class="mr-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">${brand.products_count}</span>
                </label>
            `;
        });
        desktopBrandsContent.innerHTML = brandsHtml;
    }
    
    if (mobileBrandsContent) {
        let mobileBrandsHtml = '';
        brands.forEach(brand => {
            const isChecked = document.querySelector(`input[name="brand[]"][value="${brand.id}"]`)?.checked || false;
            mobileBrandsHtml += `
                <label class="flex items-center p-3 hover:bg-gray-50 rounded-xl transition-colors cursor-pointer">
                    <input type="checkbox" name="brand[]" value="${brand.id}" 
                           class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500 focus:ring-2"
                           ${isChecked ? 'checked' : ''}>
                    <span class="mr-3 text-gray-700 font-medium">${brand.name}</span>
                    <span class="mr-auto text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-full">${brand.products_count}</span>
                </label>
            `;
        });
        mobileBrandsContent.innerHTML = mobileBrandsHtml;
    }
}

// Toggle mobile filter sections
function toggleMobileSection(sectionName) {
    const content = document.getElementById(sectionName + '-content');
    const arrow = document.getElementById(sectionName + '-arrow');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        arrow.classList.add('rotate-180');
    } else {
        content.classList.add('hidden');
        arrow.classList.remove('rotate-180');
    }
}

// Toggle subcategories
function toggleSubcategories(categoryId) {
    const content = document.getElementById('subcategories-' + categoryId);
    const arrow = document.getElementById('arrow-' + categoryId);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        arrow.classList.add('rotate-180');
    } else {
        content.classList.add('hidden');
        arrow.classList.remove('rotate-180');
    }
}

// View mode toggle functionality
function toggleViewMode(mode) {
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    const productGrid = document.querySelector('.grid');
    
    if (mode === 'grid') {
        gridView.classList.add('active', 'bg-orange-500', 'text-white');
        gridView.classList.remove('border-gray-300', 'hover:bg-gray-50');
        listView.classList.remove('active', 'bg-orange-500', 'text-white');
        listView.classList.add('border-gray-300', 'hover:bg-gray-50');
        
        // Update grid layout
        productGrid.className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-6';
    } else {
        listView.classList.add('active', 'bg-orange-500', 'text-white');
        listView.classList.remove('border-gray-300', 'hover:bg-gray-50');
        gridView.classList.remove('active', 'bg-orange-500', 'text-white');
        gridView.classList.add('border-gray-300', 'hover:bg-gray-50');
        
        // Update grid layout for list view
        productGrid.className = 'grid grid-cols-1 gap-4';
    }
    
    // Store preference in localStorage
    localStorage.setItem('viewMode', mode);
}

// Load saved view mode on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedViewMode = localStorage.getItem('viewMode') || 'grid';
    toggleViewMode(savedViewMode);
});
</script>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/products/index.blade.php ENDPATH**/ ?>