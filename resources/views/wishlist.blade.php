@extends('layouts.main')

@section('title', 'قائمة الأمنيات - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-pink-600 to-red-600 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">قائمة الأمنيات</h1>
            <p class="text-lg opacity-90">منتجاتك المفضلة في مكان واحد</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Wishlist Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">منتجاتي المفضلة</h2>
                <p class="text-gray-600">لديك <span id="wishlist-count">3</span> منتجات في قائمة الأمنيات</p>
            </div>
            <div class="flex gap-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    إضافة الكل للسلة
                </button>
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    مسح القائمة
                </button>
            </div>
        </div>

        <!-- Wishlist Items -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="wishlist-items">
            <!-- Wishlist Item 1 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group wishlist-item" data-product-id="1">
                <div class="relative">
                    <div class="aspect-square bg-gray-100 overflow-hidden">
                        <img src="https://via.placeholder.com/300x300/FF6B6B/FFFFFF?text=سيارة" 
                             alt="سيارة التحكم عن بعد" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    
                    <div class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                        خصم 25%
                    </div>
                    
                    <button class="absolute top-3 left-3 p-2 bg-white rounded-full shadow-lg hover:bg-red-50 transition-colors remove-from-wishlist" data-product-id="1">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">سيارة التحكم عن بعد الرياضية</h3>
                    
                    <p class="text-sm text-gray-500 mb-2">ألعاب إلكترونية</p>
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xl font-bold text-red-600">149.99 ر.س</span>
                        <span class="text-sm text-gray-500 line-through">199.99 ر.س</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">(15 تقييم)</span>
                    </div>
                    
                    <div class="flex gap-2">
                        <button class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold add-to-cart" data-product-id="1">
                            إضافة للسلة
                        </button>
                        <a href="{{ route('products.show', 1) }}" 
                           class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Wishlist Item 2 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group wishlist-item" data-product-id="2">
                <div class="relative">
                    <div class="aspect-square bg-gray-100 overflow-hidden">
                        <img src="https://via.placeholder.com/300x300/4ECDC4/FFFFFF?text=دمية" 
                             alt="دمية الدب الناعمة" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    
                    <button class="absolute top-3 left-3 p-2 bg-white rounded-full shadow-lg hover:bg-red-50 transition-colors remove-from-wishlist" data-product-id="2">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">دمية الدب الناعمة الكبيرة</h3>
                    
                    <p class="text-sm text-gray-500 mb-2">الدمى والحيوانات</p>
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xl font-bold text-gray-800">79.99 ر.س</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= 5 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">(8 تقييم)</span>
                    </div>
                    
                    <div class="flex gap-2">
                        <button class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold add-to-cart" data-product-id="2">
                            إضافة للسلة
                        </button>
                        <a href="{{ route('products.show', 2) }}" 
                           class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Wishlist Item 3 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group wishlist-item" data-product-id="3">
                <div class="relative">
                    <div class="aspect-square bg-gray-100 overflow-hidden">
                        <img src="https://via.placeholder.com/300x300/45B7D1/FFFFFF?text=لعبة" 
                             alt="لعبة الألغاز الذكية" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    
                    <div class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                        خصم 23%
                    </div>
                    
                    <button class="absolute top-3 left-3 p-2 bg-white rounded-full shadow-lg hover:bg-red-50 transition-colors remove-from-wishlist" data-product-id="3">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">لعبة الألغاز الذكية ثلاثية الأبعاد</h3>
                    
                    <p class="text-sm text-gray-500 mb-2">الألعاب التعليمية</p>
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xl font-bold text-red-600">99.99 ر.س</span>
                        <span class="text-sm text-gray-500 line-through">129.99 ر.س</span>
                    </div>
                    
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">(22 تقييم)</span>
                    </div>
                    
                    <div class="flex gap-2">
                        <button class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold add-to-cart" data-product-id="3">
                            إضافة للسلة
                        </button>
                        <a href="{{ route('products.show', 3) }}" 
                           class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty Wishlist State -->
        <div class="text-center py-16 hidden" id="empty-wishlist">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-600 mb-2">قائمة الأمنيات فارغة</h3>
            <p class="text-gray-500 mb-6">لم تقم بإضافة أي منتجات لقائمة الأمنيات بعد</p>
            <a href="{{ route('products.index') }}" 
               class="bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition-colors font-semibold">
                تصفح المنتجات
            </a>
        </div>

        <!-- Recommendations -->
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">منتجات قد تعجبك</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Sample recommended products -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="aspect-square bg-gray-100">
                        <img src="https://via.placeholder.com/300x300/96CEB4/FFFFFF?text=روبوت" 
                             alt="روبوت تعليمي" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 mb-2">روبوت تعليمي قابل للبرمجة</h3>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-lg font-bold text-red-600">249.99 ر.س</span>
                            <span class="text-sm text-gray-500 line-through">299.99 ر.س</span>
                        </div>
                        <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            إضافة للأمنيات
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove from wishlist
    document.querySelectorAll('.remove-from-wishlist').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const wishlistItem = document.querySelector(`.wishlist-item[data-product-id="${productId}"]`);
            
            // Add fade out animation
            wishlistItem.style.transform = 'scale(0.8)';
            wishlistItem.style.opacity = '0';
            
            setTimeout(() => {
                wishlistItem.remove();
                updateWishlistCount();
                
                // Check if wishlist is empty
                const remainingItems = document.querySelectorAll('.wishlist-item');
                if (remainingItems.length === 0) {
                    document.getElementById('wishlist-items').classList.add('hidden');
                    document.getElementById('empty-wishlist').classList.remove('hidden');
                }
            }, 300);
        });
    });

    // Add to cart
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            // Show success message
            this.innerHTML = '<svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
            this.classList.add('bg-green-600');
            this.classList.remove('bg-blue-600');
            
            setTimeout(() => {
                this.innerHTML = 'إضافة للسلة';
                this.classList.remove('bg-green-600');
                this.classList.add('bg-blue-600');
            }, 2000);
        });
    });

    function updateWishlistCount() {
        const count = document.querySelectorAll('.wishlist-item').length;
        document.getElementById('wishlist-count').textContent = count;
    }
});
</script>
@endsection
