@extends('layouts.main')

@section('title', 'جميع المنتجات - Malak Outlet')

@section('content')
<main class="container mx-auto px-4" style="max-width: 1400px;">
    <div class="min-h-screen bg-gray-50 -mx-4 px-4">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 lg:mb-8 space-y-4 sm:space-y-0 pt-6 lg:pt-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">جميع المنتجات</h1>
            <div class="flex items-center space-x-4 space-x-reverse">
                <span class="text-gray-600">{{ $products->total() }} منتج</span>
            </div>
        </div>

            <div class="lg:grid lg:grid-cols-4 lg:gap-6 xl:gap-8">
                <!-- Filters Sidebar -->
                <div class="hidden lg:block lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-4 lg:p-6 sticky top-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">تصفية النتائج</h3>
                        
                        <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                            <!-- Categories Filter -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">التصنيفات</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value="" class="ml-2" 
                                               {{ request('category') == '' ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">جميع التصنيفات</span>
                                    </label>
                                    @foreach($categories as $category)
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value="{{ $category->id }}" class="ml-2"
                                               {{ request('category') == $category->id ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">{{ $category->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Brands Filter -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">العلامات التجارية</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="brand" value="" class="ml-2"
                                               {{ request('brand') == '' ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">جميع العلامات</span>
                                    </label>
                                    @foreach($brands as $brand)
                                    <label class="flex items-center">
                                        <input type="radio" name="brand" value="{{ $brand->id }}" class="ml-2"
                                               {{ request('brand') == $brand->id ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">{{ $brand->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Price Range -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">النطاق السعري</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">من (د.أ)</label>
                                        <input type="number" name="min_price" placeholder="0" 
                                               value="{{ request('min_price') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">إلى (د.أ)</label>
                                        <input type="number" name="max_price" placeholder="1000" 
                                               value="{{ request('max_price') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Age Group -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">الفئة العمرية</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="age" value="" class="ml-2"
                                               {{ request('age') == '' ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">جميع الأعمار</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="age" value="0-2" class="ml-2"
                                               {{ request('age') == '0-2' ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">0-2 سنة</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="age" value="3-5" class="ml-2"
                                               {{ request('age') == '3-5' ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">3-5 سنوات</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="age" value="6-8" class="ml-2"
                                               {{ request('age') == '6-8' ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">6-8 سنوات</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="age" value="9+" class="ml-2"
                                               {{ request('age') == '9+' ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">9+ سنوات</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Special Options -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">خيارات خاصة</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="featured" value="1" class="ml-2"
                                               {{ request('featured') ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">منتجات مميزة</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="in_stock" value="1" class="ml-2"
                                               {{ request('in_stock') ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">متوفر في المخزن</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Sizes Filter (Only show if there are products with sizes) -->
                            @if(!empty($availableSizes))
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-700 mb-3">
                                    <i class="fas fa-ruler-horizontal ml-1 text-orange-500"></i>
                                    مقاسات الأحذية المتاحة
                                </h4>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach($availableSizes as $size => $count)
                                        <label class="flex items-center justify-center cursor-pointer">
                                            <input type="checkbox" name="sizes[]" value="{{ $size }}" class="hidden size-checkbox"
                                                   {{ in_array($size, request('sizes', [])) ? 'checked' : '' }}>
                                            <span class="size-button w-full text-center py-2 px-2 text-xs font-medium border border-gray-300 rounded-lg transition-all duration-200 hover:border-orange-300
                                                  {{ in_array($size, request('sizes', [])) ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700' }}">
                                                <div class="font-bold">{{ $size }}</div>
                                                <div class="text-xs opacity-75">({{ $count }})</div>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                
                                <!-- Popular sizes indicator -->
                                <div class="mt-3 text-center">
                                    <div class="inline-flex items-center text-xs text-gray-500">
                                        <i class="fas fa-star text-yellow-400 ml-1"></i>
                                        <span>المقاسات الشائعة للأطفال: 32، 33، 34، 35</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Filter Buttons -->
                            <div class="space-y-3">
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                                    تطبيق التصفية
                                </button>
                                <a href="{{ route('products.index') }}" class="w-full bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 transition duration-200 text-center block">
                                    إعادة تعيين
                                </a>
                            </div>
                        </form>
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

                    <!-- Sort Options -->
                    <div class="bg-white rounded-lg shadow-md p-4 mb-4 lg:mb-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0">
                            <div class="flex items-center space-x-4 space-x-reverse">
                                <span class="text-sm text-gray-600">ترتيب حسب:</span>
                                <select name="sort" onchange="this.form.submit()" form="filterForm" class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>السعر: من الأقل للأعلى</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>السعر: من الأعلى للأقل</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>الاسم</option>
                                </select>
                            </div>
                            <span class="text-sm text-gray-600">{{ $products->total() }} منتج</span>
                        </div>
                    </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 group">
                            <div class="relative">
                                <a href="{{ route('products.show', $product->id) }}">
                                    @if($product->images->first())
                                        <img src="{{ $product->images->first()->image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-48 sm:h-56 object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-48 sm:h-56 bg-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                
                                @if($product->sale_price)
                                    <span class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        خصم {{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}%
                                    </span>
                                @endif
                                
                                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition duration-300">
                                    <button class="bg-white p-2 rounded-full shadow-lg hover:bg-gray-100 text-gray-600 add-to-wishlist-btn {{ in_array($product->id, $wishlistProductIds) ? 'is-in-wishlist text-red-500' : '' }}"
                                            data-product-id="{{ $product->id }}"
                                            title="{{ in_array($product->id, $wishlistProductIds) ? 'موجود في قائمة الأمنيات' : 'إضافة إلى قائمة الأمنيات' }}">
                                        <svg class="w-4 h-4" 
                                             fill="{{ in_array($product->id, $wishlistProductIds) ? 'currentColor' : 'none' }}" 
                                             stroke="currentColor" 
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="p-3 sm:p-4">
                                <div class="text-right">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <h3 class="font-semibold text-base sm:text-lg mb-1 text-gray-800 hover:text-orange-600 transition duration-200 line-clamp-2">{{ $product->name }}</h3>
                                    </a>
                                    @if($product->brand)
                                        <p class="text-xs sm:text-sm text-gray-500 mb-2">{{ $product->brand->name }}</p>
                                    @endif
                                    
                                    <div class="mb-3">
                                        @if($product->sale_price)
                                            <span class="text-base sm:text-lg font-bold text-orange-600">{{ number_format($product->sale_price, 2) }} د.أ</span>
                                            <span class="text-xs sm:text-sm text-gray-500 line-through mr-2">{{ number_format($product->price, 2) }} د.أ</span>
                                        @else
                                            <span class="text-base sm:text-lg font-bold text-gray-800">{{ number_format($product->price, 2) }} د.أ</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Show sizes available for shoes -->
                                    @if($product->sizes && $product->sizes->count() > 0)
                                        <div class="mb-3">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($product->sizes->take(4) as $size)
                                                    <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">{{ $size->size }}</span>
                                                @endforeach
                                                @if($product->sizes->count() > 4)
                                                    <span class="text-gray-500 text-xs">+{{ $product->sizes->count() - 4 }}</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-orange-600 mt-1">
                                                <i class="fas fa-shoe-prints ml-1"></i>
                                                متوفر بمقاسات متعددة
                                            </p>
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between gap-2">
                                        @if($product->stock_quantity > 0)
                                            @if($product->sizes && $product->sizes->count() > 0)
                                                <!-- Shoes with sizes - redirect to product page -->
                                                <a href="{{ route('products.show', $product->id) }}" 
                                                   class="bg-orange-500 text-white px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm hover:bg-orange-600 transition duration-300 flex-shrink-0 text-center">
                                                    اختر المقاس
                                                </a>
                                            @else
                                                <!-- Regular products without sizes -->
                                                <button onclick="addToCart({{ $product->id }})" 
                                                        class="add-to-cart-btn bg-orange-500 text-white px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm hover:bg-orange-600 transition duration-300 flex-shrink-0">
                                                    <span class="btn-text">أضف للسلة</span>
                                                    <span class="loading-text hidden">جاري...</span>
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-xs text-red-500 bg-red-50 px-2 py-1 rounded flex-shrink-0">غير متوفر</span>
                                        @endif
                                        
                                        <a href="{{ route('products.show', $product->id) }}" 
                                           class="text-orange-500 hover:text-orange-600 text-xs sm:text-sm font-medium flex-shrink-0">
                                            عرض التفاصيل
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8 lg:mt-12 flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12 lg:py-16">
                    <svg class="w-20 sm:w-24 h-20 sm:h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                    </svg>
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-600 mb-2">لا توجد منتجات</h2>
                    <p class="text-sm sm:text-base text-gray-500">لم يتم العثور على أي منتجات حالياً</p>
                </div>
            @endif
    </div>
</main>

<!-- Mobile Filters Modal -->
<div id="mobileFilters" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileFilters()"></div>
    <div class="fixed right-0 top-0 h-full w-80 max-w-full bg-white shadow-lg transform translate-x-full transition-transform duration-300" id="mobileFiltersPanel">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">تصفية النتائج</h3>
            <button onclick="toggleMobileFilters()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4 overflow-y-auto h-full pb-20">
            <!-- Copy of the filter form for mobile -->
            <form method="GET" action="{{ route('products.index') }}">
                <!-- Mobile version of all filters (same as desktop) -->
                <!-- Categories -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-3">التصنيفات</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="category" value="" class="ml-2" 
                                   {{ request('category') == '' ? 'checked' : '' }}>
                            <span class="text-sm text-gray-600">جميع التصنيفات</span>
                        </label>
                        @foreach($categories as $category)
                        <label class="flex items-center">
                            <input type="radio" name="category" value="{{ $category->id }}" class="ml-2"
                                   {{ request('category') == $category->id ? 'checked' : '' }}>
                            <span class="text-sm text-gray-600">{{ $category->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Brands -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-700 mb-3">العلامات التجارية</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="brand" value="" class="ml-2"
                                   {{ request('brand') == '' ? 'checked' : '' }}>
                            <span class="text-sm text-gray-600">جميع العلامات</span>
                        </label>
                        @foreach($brands as $brand)
                        <label class="flex items-center">
                            <input type="radio" name="brand" value="{{ $brand->id }}" class="ml-2"
                                   {{ request('brand') == $brand->id ? 'checked' : '' }}>
                            <span class="text-sm text-gray-600">{{ $brand->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Apply button for mobile -->
                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                        تطبيق التصفية
                    </button>
                </div>
            </form>
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
    
    fetch('{{ route("cart.add", ":productId") }}'.replace(':productId', productId), {
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
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
    if (!isAuthenticated) {
        showNotification('يجب تسجيل الدخول أولاً لإضافة المنتجات إلى قائمة الأمنيات', 'error');
        setTimeout(() => {
            window.location.href = '{{ route("login") }}';
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
</script>
@endsection
