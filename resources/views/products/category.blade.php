@extends('layouts.main')

@section('title', $category->name . ' - Malak Outlet')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="text-sm mb-6" dir="ltr">
                <a href="{{ route('home') }}" class="text-orange-500 hover:underline">الرئيسية</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">{{ $category->name }}</span>
            </nav>

            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                <div class="flex items-center space-x-4 space-x-reverse">
                    <span class="text-gray-600">{{ $products->total() }} منتج</span>
                </div>
            </div>

            <!-- Filters Section -->
            @if(count($availableSizes) > 0)
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <form method="GET" action="{{ route('products.category', $category->slug) }}" id="categoryFilterForm">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Size Filter -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 mb-3">
                                <i class="fas fa-ruler-horizontal ml-1 text-orange-500"></i>
                                الأحجام المتاحة
                            </h4>
                            <div class="grid grid-cols-4 sm:grid-cols-6 lg:grid-cols-8 gap-2">
                                @foreach($availableSizes as $size => $count)
                                    <label class="flex items-center justify-center cursor-pointer">
                                        <input type="checkbox" name="sizes[]" value="{{ $size }}" class="hidden size-checkbox"
                                               {{ in_array($size, request('sizes', [])) ? 'checked' : '' }}>
                                        <span class="size-button w-full text-center py-2 px-2 text-xs font-medium border border-gray-300 rounded-lg transition-all duration-200 hover:border-orange-300
                                              {{ in_array($size, request('sizes', [])) ? 'bg-orange-500 text-white border-orange-500' : 'bg-white text-gray-700' }}">
                                            <div>{{ $size }}</div>
                                            <div class="text-xs opacity-75">({{ $count }})</div>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Sort Options -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 mb-3">
                                <i class="fas fa-sort ml-1 text-orange-500"></i>
                                ترتيب حسب
                            </h4>
                            <select name="sort" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>السعر: من الأقل للأعلى</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>السعر: من الأعلى للأقل</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>الاسم</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Filter Buttons -->
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex space-x-3 space-x-reverse">
                            <button type="submit" class="bg-orange-500 text-white py-2 px-6 rounded-lg hover:bg-orange-600 transition duration-200">
                                <i class="fas fa-filter ml-1"></i>
                                تطبيق التصفية
                            </button>
                            <a href="{{ route('products.category', $category->slug) }}" class="bg-gray-200 text-gray-700 py-2 px-6 rounded-lg hover:bg-gray-300 transition duration-200">
                                <i class="fas fa-undo ml-1"></i>
                                إعادة تعيين
                            </a>
                        </div>
                        
                        <!-- Popular sizes indicator -->
                        <div class="hidden sm:flex items-center text-xs text-gray-500">
                            <i class="fas fa-star text-yellow-400 ml-1"></i>
                            <span>الأحجام الشائعة: 41، 42، 43</span>
                        </div>
                    </div>
                </form>
            </div>
            @endif

            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 group">
                            <div class="relative">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    @if($product->images->first())
                                        <img src="{{ $product->images->first()->image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
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
                                    <button class="bg-white p-2 rounded-full shadow-lg hover:bg-gray-100 text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <div class="text-right">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <h3 class="font-semibold text-lg mb-1 text-gray-800 hover:text-orange-600 transition duration-200">{{ $product->name }}</h3>
                                    </a>
                                    @if($product->brand)
                                        <p class="text-sm text-gray-500 mb-2">{{ $product->brand->name }}</p>
                                    @endif
                                    
                                    <div class="mb-3">
                                        @if($product->sale_price)
                                            <span class="text-lg font-bold text-orange-600">{{ number_format($product->sale_price, 2) }} د.أ</span>
                                            <span class="text-sm text-gray-500 line-through mr-2">{{ number_format($product->price, 2) }} د.أ</span>
                                        @else
                                            <span class="text-lg font-bold text-gray-800">{{ number_format($product->price, 2) }} د.أ</span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        @if($product->quantity > 0 && $product->status == 'in_stock')
                                            <button onclick="addToCart({{ $product->slug }})" 
                                                    class="add-to-cart-btn bg-orange-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-orange-600 transition duration-300">
                                                <span class="btn-text">أضف للسلة</span>
                                                <span class="loading-text hidden">جاري...</span>
                                            </button>
                                        @else
                                            <span class="text-xs text-red-500 bg-red-50 px-2 py-1 rounded">غير متوفر</span>
                                        @endif
                                        
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           class="text-orange-500 hover:text-orange-600 text-sm font-medium">
                                            عرض التفاصيل
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h2 class="text-2xl font-semibold text-gray-600 mb-2">لا توجد منتجات في {{ $category->name }}</h2>
                    <p class="text-gray-500">لم يتم العثور على أي منتجات في هذه الفئة حالياً</p>
                    <a href="{{ route('home') }}" class="inline-block mt-4 bg-orange-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-orange-600 transition duration-300">
                        العودة للرئيسية
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Add to cart functionality
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
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count in header
            const cartBadge = document.getElementById('cart-count');
            if (cartBadge) {
                cartBadge.textContent = data.cart_count;
                cartBadge.classList.remove('hidden');
            } else if (data.cart_count > 0) {
                // Create cart badge if it doesn't exist
                const cartLink = document.querySelector('a[href*="cart"]');
                if (cartLink && cartLink.querySelector('svg')) {
                    const badge = document.createElement('span');
                    badge.id = 'cart-count';
                    badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
                    badge.textContent = data.cart_count;
                    cartLink.appendChild(badge);
                }
            }
            
            // Show success message
            showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
        } else {
            showNotification('حدث خطأ في إضافة المنتج', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('حدث خطأ في إضافة المنتج', 'error');
    })
    .finally(() => {
        // Reset button state
        btnText.classList.remove('hidden');
        loadingText.classList.add('hidden');
        button.disabled = false;
    });
}

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} shadow-lg transition-opacity duration-300`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Add size filter functionality
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Auto-submit on sort change
    document.querySelector('select[name="sort"]')?.addEventListener('change', function() {
        document.getElementById('categoryFilterForm').submit();
    });
});
</script>
@endsection




