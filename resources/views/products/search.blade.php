@extends('layouts.main')

@section('title', 'نتائج البحث - ' . ($query ?: 'المنتجات'))

@section('content')
<div class="container mx-auto px-4 py-8" style="max-width: 1400px;">
    <!-- Search Header -->
    <div class="mb-8">
        <nav class="text-sm text-gray-500 mb-4">
            <a href="{{ route('home') }}" class="hover:text-orange-500 transition-colors">الرئيسية</a>
            <span class="mx-2">•</span>
            <span class="text-gray-700">نتائج البحث</span>
        </nav>
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                    @if($query)
                        نتائج البحث عن "{{ $query }}"
                    @else
                        جميع المنتجات
                    @endif
                </h1>
                <p class="text-gray-600">
                    {{ $products->total() }} منتج {{ $products->total() == 1 ? 'موجود' : 'موجودة' }}
                </p>
            </div>
            
            <!-- Search Refinement -->
            <div class="mt-4 md:mt-0">
                <form action="{{ route('search') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                    <input type="hidden" name="q" value="{{ $query }}">
                    
                    <!-- Sort Options -->
                    <select name="sort" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-orange-500" onchange="this.form.submit()">
                        <option value="">ترتيب حسب</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>السعر من الأقل للأعلى</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>السعر من الأعلى للأقل</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>الأكثر شعبية</option>
                    </select>
                    
                    <!-- Category Filter -->
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-orange-500" onchange="this.form.submit()">
                        <option value="">جميع الفئات</option>
                        @foreach(\App\Models\Category::where('is_active', true)->get() as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        
        <!-- Active Filters -->
        @if($query || request('category') || request('sort'))
            <div class="flex flex-wrap gap-2 mb-4">
                @if($query)
                    <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm flex items-center">
                        "{{ $query }}"
                        <a href="{{ route('search') }}" class="mr-2 text-orange-600 hover:text-orange-800">×</a>
                    </span>
                @endif
                
                @if(request('category'))
                    @php $categoryName = \App\Models\Category::find(request('category'))->name ?? 'فئة' @endphp
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm flex items-center">
                        {{ $categoryName }}
                        <a href="{{ route('search', ['q' => $query]) }}" class="mr-2 text-blue-600 hover:text-blue-800">×</a>
                    </span>
                @endif
                
                @if(request('sort'))
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm flex items-center">
                        مرتب
                        <a href="{{ route('search', ['q' => $query, 'category' => request('category')]) }}" class="mr-2 text-green-600 hover:text-green-800">×</a>
                    </span>
                @endif
            </div>
        @endif
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($products as $product)
                <div class="group product-card bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-200 transform hover:-translate-y-2">
                    <div class="relative overflow-hidden">
                        <a href="{{ route('products.show', $product->id) }}" class="block">
                            <div class="h-56 md:h-64 relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                                @if($product->images->first())
                                    <img src="{{ $product->images->first()->image_path }}" alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Product badges -->
                                <div class="absolute top-3 right-3 flex flex-col space-y-2">
                                    @if($product->sale_price)
                                        <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full py-1.5 px-3 shadow-lg animate-pulse">
                                            خصم {{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}%
                                        </span>
                                    @endif
                                    
                                    @if($product->is_featured)
                                        <span class="bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold rounded-full py-1.5 px-3 shadow-lg">⭐ مميز</span>
                                    @endif
                                    
                                    @if($product->created_at->diffInDays() < 30)
                                        <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold rounded-full py-1.5 px-3 shadow-lg">🆕 جديد</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="p-5">
                        <a href="{{ route('products.show', $product->id) }}" class="block">
                            <!-- Category and Brand -->
                            <div class="flex items-center justify-between mb-3">
                                @if($product->category)
                                    <span class="text-orange-600 text-xs font-medium bg-orange-50 px-3 py-1 rounded-full border border-orange-200">{{ $product->category->name }}</span>
                                @endif
                                @if($product->brand)
                                    <span class="text-gray-500 text-xs font-medium bg-gray-100 px-2 py-1 rounded">{{ $product->brand->name }}</span>
                                @endif
                            </div>
                            
                            <!-- Product Name -->
                            <h3 class="text-base md:text-lg font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                {{ $product->name }}
                            </h3>
                            
                            <!-- Price Section -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex flex-col">
                                    @if($product->sale_price)
                                        <div class="flex items-center space-x-2 space-x-reverse">
                                            <span class="text-xl font-bold text-gradient">{{ number_format($product->sale_price, 0) }} د.أ</span>
                                            <span class="text-sm text-gray-500 line-through">{{ number_format($product->price, 0) }} د.أ</span>
                                        </div>
                                    @else
                                        <span class="text-xl font-bold text-gradient">{{ number_format($product->price, 0) }} د.أ</span>
                                    @endif
                                </div>
                                
                                <!-- Stock Status -->
                                <div class="text-right">
                                    @if($product->stock_quantity > 0)
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-green-500 rounded-full ml-2 animate-pulse"></div>
                                            <span class="text-xs text-green-600 font-medium">متوفر</span>
                                        </div>
                                    @else
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-red-500 rounded-full ml-2"></div>
                                            <span class="text-xs text-red-600 font-medium">نفذت الكمية</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                        
                        <!-- Action Button -->
                        <button class="add-to-cart-btn w-full btn-gradient text-white font-bold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl {{ $product->stock_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                data-product-id="{{ $product->id }}"
                                {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                            {{ $product->stock_quantity <= 0 ? 'نفذت الكمية' : 'أضف للسلة' }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <!-- No Results -->
        <div class="text-center py-16">
            <div class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-3">
                @if($query)
                    لم نجد نتائج لـ "{{ $query }}"
                @else
                    لا توجد منتجات متاحة
                @endif
            </h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                @if($query)
                    جرب البحث بكلمات مختلفة أو تصفح الفئات المختلفة
                @else
                    سنقوم بإضافة منتجات جديدة قريباً
                @endif
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="btn-gradient text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 inline-block">
                    العودة للرئيسية
                </a>
                @if($query)
                    <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-all duration-200 inline-block hover:bg-gray-300">
                        تصفح جميع المنتجات
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
// Add to cart functionality for search results
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            if (this.disabled) {
                showNotification('هذا المنتج غير متوفر حالياً', 'error');
                return;
            }
            
            // Add to cart logic (same as home page)
            addToCart(productId, this);
        });
    });
});

function addToCart(productId, button) {
    button.disabled = true;
    button.textContent = 'جاري الإضافة...';
    
    fetch('{{ url("/cart/add") }}/' + productId, {
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
            button.textContent = 'تم الإضافة ✓';
            button.classList.remove('btn-gradient');
            button.classList.add('bg-green-500');
            
            // Update cart count in header
            const cartBadge = document.getElementById('cart-count');
            if (cartBadge) {
                cartBadge.textContent = data.cart_count;
            }
            
            showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
            
            // Reset button after 2 seconds
            setTimeout(() => {
                button.textContent = 'أضف للسلة';
                button.classList.add('btn-gradient');
                button.classList.remove('bg-green-500');
                button.disabled = false;
            }, 2000);
        } else {
            showNotification('حدث خطأ في إضافة المنتج', 'error');
            button.textContent = 'أضف للسلة';
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('حدث خطأ في إضافة المنتج', 'error');
        button.textContent = 'أضف للسلة';
        button.disabled = false;
    });
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} shadow-lg transition-opacity duration-300`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            if (notification.parentNode) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>
@endsection
