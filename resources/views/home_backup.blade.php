@extends('layouts.main')

@section('content')

<style>
/* Enhanced animations and effects */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-gradient {
    background-size: 400% 400%;
    animation: gradient 8s ease infinite;
}

.card-shine::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.5s;
}

.card-shine:hover::before {
    left: 100%;
}

.product-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-card:hover {
    transform: translateY(-8px) scale(1.02);
}

.btn-gradient {
    background: linear-gradient(135deg, #f97316, #ea580c, #dc2626);
    background-size: 200% 200%;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    background-position: right center;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(249, 115, 22, 0.4);
}

.text-gradient {
    background: linear-gradient(135deg, #f97316, #ea580c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Section dividers */
.section-divider {
    position: relative;
    margin: 3rem 0;
}

.section-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 2px;
    background: linear-gradient(90deg, transparent, #f97316, transparent);
}

/* Countdown timer styles */
.countdown-timer {
    background: rgba(0, 0, 0, 0.8);
    border-radius: 8px;
    padding: 8px 12px;
    color: white;
    font-size: 12px;
    font-weight: bold;
}

/* Custom scrollbar for horizontal scroll sections */
.custom-scrollbar::-webkit-scrollbar {
    height: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #f97316;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #ea580c;
}

/* Enhanced product cards */
.product-card-enhanced {
    position: relative;
    overflow: hidden;
}

.product-card-enhanced::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s;
}

.product-card-enhanced:hover::after {
    transform: translateX(100%);
}

/* Pulse animation for badges */
@keyframes pulse-orange {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.animate-pulse-orange {
    animation: pulse-orange 2s infinite;
}

/* Modern glass effect */
.glass-effect {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Enhanced hover effects */
.hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* Newsletter section background animation */
.newsletter-bg {
    background: linear-gradient(-45deg, #f97316, #ea580c, #dc2626, #f59e0b);
    background-size: 400% 400%;
    animation: gradient 15s ease infinite;
}

/* Enhanced loading animation */
.loading-dots::after {
    content: '';
    animation: loading-dots 1.5s infinite;
}

@keyframes loading-dots {
    0%, 20% { content: ''; }
    40% { content: '.'; }
    60% { content: '..'; }
    80%, 100% { content: '...'; }
}
</style>

<main class="container mx-auto px-4" style="max-width: 1400px;">
    <!-- Hero Section -->
    <section class="flex flex-col-reverse md:flex-row-reverse bg-orange-50 my-5 rounded-lg overflow-hidden relative">
        <div class="w-full md:w-1/2 flex items-center justify-center py-4">
            <img src="{{ asset('images/shop2.png') }}" alt="مجموعة حرب النجوم ليغو" class="max-w-full h-auto md:h-80" />
        </div>
        <div class="p-5 md:p-10 w-full md:w-1/2 text-right">
            <span class="inline-block py-1 px-4 bg-orange-100 text-orange-500 rounded-full font-bold mb-3 text-xs md:text-sm">مجموعة جديدة</span>
            <h1 class="text-2xl md:text-4xl my-2 md:my-3 text-gray-800 font-bold">لكل لحظة لعب... قصة خيالية تبدأ هنا!</h1>
            <p class="text-gray-600 mb-4 md:mb-8 text-sm md:text-base">متعة لا تنتهي... وأفكار تنمو مع كل لعبة!</p>
            <a href="{{ route('products.index') }}" class="inline-block py-2 px-6 md:py-3 md:px-8 bg-orange-500 text-white no-underline rounded font-bold transition-colors hover:bg-orange-600 text-sm md:text-base">تسوق الآن</a>
        </div>
    </section>

    <!-- Promotional Cards -->
    <div class="flex flex-col md:flex-row my-5 gap-5">
        <!-- Card 1 -->
        <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm flex flex-col md:flex-row w-full">
            <div class="flex-1 flex items-center justify-center p-4">
                <img src="{{ asset('images/pngegg.png') }}" alt="أحذية عالمية" class="max-w-full max-h-48 object-contain">
            </div>
            <div class="p-5 md:p-8 flex-1">
                <span class="inline-block py-1 px-3 bg-orange-50 text-orange-500 rounded-full font-bold mb-2 md:mb-4 text-xs md:text-sm">وصل حديثًا</span>
                <h2 class="text-xl md:text-2xl my-1 mb-2 md:mb-4">تشكيلتنا الجديدة من الأحذية العالمية وصلت!</h2>
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-orange-500 font-bold no-underline text-sm md:text-base">تصفح المجموعة ←</a>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm flex flex-col md:flex-row w-full mt-5 md:mt-0">
            <div class="flex-1 flex items-center justify-center p-4">
                <img src="{{ asset('images/baby.png') }}" alt="ألعاب تعليمية" class="max-w-full max-h-48 object-contain">
            </div>
            <div class="p-5 md:p-8 flex-1">
                <span class="inline-block py-1 px-3 bg-orange-50 text-orange-500 rounded-full font-bold mb-2 md:mb-4 text-xs md:text-sm">الأكثر رواجاً</span>
                <h2 class="text-xl md:text-2xl my-1 mb-2 md:mb-4">منتجات العناية بطفلك <br>بجودة تريحك وتريح طفلك.</h2>
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-orange-500 font-bold no-underline text-sm md:text-base">تصفح المجموعة ←</a>
            </div>
        </div>
    </div>

    <!-- Toy Subcategories Section -->
    <section class="my-8 md:my-10">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-xl md:text-2xl text-gray-800 m-0 font-bold">تصفح الألعاب</h2>
            <a href="{{ route('products.index') }}" class="flex items-center text-orange-500 no-underline font-bold text-sm md:text-base">
                عرض جميع الألعاب ←
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
            @php
                $subcategoryIcons = [
                    'lego-building' => ['icon' => '🧱', 'color' => 'bg-gradient-to-br from-red-50 to-red-100', 'age' => 'عمر 4+', 'border' => 'border-red-200'],
                    'action-figures' => ['icon' => '🦸', 'color' => 'bg-gradient-to-br from-blue-50 to-blue-100', 'age' => 'عمر 3+', 'border' => 'border-blue-200'],
                    'puzzles' => ['icon' => '🧩', 'color' => 'bg-gradient-to-br from-purple-50 to-purple-100', 'age' => 'عمر 5+', 'border' => 'border-purple-200'],
                    'remote-control' => ['icon' => '🚗', 'color' => 'bg-gradient-to-br from-green-50 to-green-100', 'age' => 'عمر 6+', 'border' => 'border-green-200'],
                    'educational' => ['icon' => '🎓', 'color' => 'bg-gradient-to-br from-indigo-50 to-indigo-100', 'age' => 'عمر 2+', 'border' => 'border-indigo-200'],
                    'board-games' => ['icon' => '�', 'color' => 'bg-gradient-to-br from-yellow-50 to-yellow-100', 'age' => 'عمر 8+', 'border' => 'border-yellow-200'],
                ];
            @endphp
            
            @if(isset($categories) && $categories->count() > 0)
                @php
                    $toysCategory = $categories->where('slug', 'toys-games')->first() ?? 
                                   $categories->where('name', 'LIKE', '%ألعاب%')->first() ??
                                   $categories->where('name', 'LIKE', '%toys%')->first();
                    $toySubcategories = $toysCategory ? $toysCategory->children : collect();
                @endphp
                
                @if($toySubcategories->count() > 0)
                    @foreach($toySubcategories->take(6) as $subcategory)
                        @php
                            $iconData = $subcategoryIcons[$subcategory->slug] ?? ['icon' => '🧸', 'color' => 'bg-gradient-to-br from-orange-50 to-orange-100', 'age' => 'جميع الأعمار', 'border' => 'border-orange-200'];
                        @endphp
                        <a href="{{ route('products.category', $subcategory->slug) }}" 
                           class="group flex flex-col items-center p-4 md:p-6 rounded-xl bg-white shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2 no-underline text-gray-700 border {{ $iconData['border'] }} hover:border-opacity-100">
                            <div class="w-16 h-16 md:w-20 md:h-20 {{ $iconData['color'] }} rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <span class="text-2xl md:text-3xl">{{ $iconData['icon'] }}</span>
                            </div>
                            <div class="font-bold text-center text-sm md:text-base group-hover:text-orange-600 transition-colors mb-2">{{ $subcategory->name }}</div>
                            <span class="inline-block py-1.5 px-3 bg-gradient-to-r from-orange-100 to-orange-200 text-orange-700 rounded-full text-xs font-medium shadow-sm">{{ $iconData['age'] }}</span>
                        </a>
                    @endforeach
                @else
                    <!-- Fallback: Show default toy categories if no subcategories exist -->
                    @foreach($subcategoryIcons as $slug => $iconData)
                        <a href="{{ route('products.index', ['category' => 'toys']) }}" 
                           class="group flex flex-col items-center p-4 md:p-6 rounded-xl bg-white shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2 no-underline text-gray-700 border {{ $iconData['border'] }} hover:border-opacity-100">
                            <div class="w-16 h-16 md:w-20 md:h-20 {{ $iconData['color'] }} rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <span class="text-2xl md:text-3xl">{{ $iconData['icon'] }}</span>
                            </div>
                            <div class="font-bold text-center text-sm md:text-base group-hover:text-orange-600 transition-colors mb-2">
                                @switch($slug)
                                    @case('lego-building') ليغو ومكعبات البناء @break
                                    @case('action-figures') شخصيات الأكشن @break
                                    @case('puzzles') الألغاز والأحاجي @break
                                    @case('remote-control') ألعاب التحكم عن بعد @break
                                    @case('educational') ألعاب تعليمية @break
                                    @case('board-games') ألعاب الطاولة @break
                                @endswitch
                            </div>
                            <span class="inline-block py-1.5 px-3 bg-gradient-to-r from-orange-100 to-orange-200 text-orange-700 rounded-full text-xs font-medium shadow-sm">{{ $iconData['age'] }}</span>
                        </a>
                    @endforeach
                @endif
            @else
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">لا توجد فئات متاحة حالياً</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="my-8 md:my-10">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-xl md:text-2xl text-gray-800 m-0 font-bold">منتجات مميزة</h2>
            <a href="{{ route('products.index') }}" class="flex items-center text-orange-500 no-underline font-bold text-sm md:text-base">
                عرض الكل ←
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                @foreach($featuredProducts->take(8) as $product)
            <div class="group product-card bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-200 transform hover:-translate-y-2 relative card-shine">
                <div class="relative overflow-hidden">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div class="h-56 md:h-64 relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                            @if($product->images->first())
                                <img src="{{ $product->images->first()->image_path }}" alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <div class="animate-float">
                                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Overlay with quick actions -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div class="flex space-x-3 space-x-reverse">
                                    <button class="bg-white text-gray-700 p-3 rounded-full shadow-lg hover:bg-orange-500 hover:text-white transition-all duration-200 transform hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button class="bg-white text-gray-700 p-3 rounded-full shadow-lg hover:bg-red-500 hover:text-white transition-all duration-200 transform hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Product badges -->
                            <div class="absolute top-3 right-3 flex flex-col space-y-2">
                                @if($product->discount_percentage > 0)
                                <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full py-1.5 px-3 shadow-lg animate-pulse">
                                    خصم {{ $product->discount_percentage }}%
                                </span>
                                @elseif($product->is_featured)
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
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
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
                        
                        <!-- Rating -->
                        <div class="flex items-center mb-3">
                            @if($product->reviews_count > 0)
                                <div class="flex text-yellow-400">
                                    @foreach(range(1, 5) as $starIndex)
                                        <svg class="w-4 h-4 {{ $starIndex <= round($product->average_rating) ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endforeach
                                </div>
                                <span class="text-gray-500 text-sm mr-2">({{ number_format($product->average_rating, 1) }})</span>
                                <span class="text-gray-400 text-xs">• {{ $product->reviews_count }} تقييم</span>
                            @else
                                <div class="flex text-gray-300">
                                    @foreach(range(1, 5) as $starEmpty)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endforeach
                                </div>
                                <span class="text-gray-400 text-xs mr-2">لا توجد تقييمات</span>
                            @endif
                        </div>
                        
                        <!-- Price Section -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex flex-col">
                                @if($product->discount_percentage > 0)
                                    <div class="flex items-center space-x-2 space-x-reverse">
                                        <span class="text-xl font-bold text-gradient">{{ number_format($product->effective_price, 0) }} د.أ</span>
                                        <span class="text-sm text-gray-500 line-through">{{ number_format($product->price, 0) }} د.أ</span>
                                    </div>
                                    <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-full inline-block w-fit">وفّر {{ number_format($product->price - $product->effective_price, 0) }} د.أ</span>
                                @else
                                    <span class="text-xl font-bold text-gradient">{{ number_format($product->price, 0) }} د.أ</span>
                                @endif
                            </div>
                            
                            <!-- Stock Status -->
                            <div class="text-right">
                                @if($product->stock_quantity > 0)
                                    <div class="flex items-center">
                                        @if($product->stock_quantity > 10)
                                            <div class="w-2 h-2 bg-green-500 rounded-full ml-2 animate-pulse"></div>
                                            <span class="text-xs text-green-600 font-medium">متوفر</span>
                                        @elseif($product->stock_quantity > 3)
                                            <div class="w-2 h-2 bg-yellow-500 rounded-full ml-2 animate-pulse"></div>
                                            <span class="text-xs text-yellow-600 font-medium">كمية محدودة</span>
                                        @else
                                            <div class="w-2 h-2 bg-orange-500 rounded-full ml-2 animate-pulse"></div>
                                            <span class="text-xs text-orange-600 font-medium">آخر القطع</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $product->stock_quantity }} {{ $product->stock_quantity == 1 ? 'قطعة متبقية' : 'قطع متبقية' }}</span>
                                @else
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-red-500 rounded-full ml-2"></div>
                                        <span class="text-xs text-red-600 font-medium">نفذت الكمية</span>
                                    </div>
                                    <span class="text-xs text-gray-400">غير متوفر حالياً</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-3 space-x-reverse">
                        <button class="add-to-cart-btn flex-1 btn-gradient text-white font-bold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed {{ $product->stock_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                data-product-id="{{ $product->slug }}"
                                {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                            <span class="btn-text flex items-center justify-center">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5m6 0L18 18H9m6 0a2 2 0 11-4 0m4 0a2 2 0 11-4 0m4 0h2a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                </svg>
                                {{ $product->stock_quantity <= 0 ? 'نفذت الكمية' : 'أضف للسلة' }}
                            </span>
                            <span class="loading-text hidden">
                                <svg class="animate-spin h-5 w-5 text-white mx-auto" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                        
                        <button class="bg-gray-100 text-gray-600 p-3 rounded-lg hover:bg-orange-50 hover:text-orange-600 transition-colors duration-200 group add-to-wishlist-btn {{ in_array($product->slug, $wishlistProductIds) ? 'is-in-wishlist text-red-500' : '' }}"
                                data-product-id="{{ $product->slug }}"
                                title="{{ in_array($product->slug, $wishlistProductIds) ? 'موجود في قائمة الأمنيات' : 'إضافة إلى قائمة الأمنيات' }}">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" 
                                 fill="{{ in_array($product->slug, $wishlistProductIds) ? 'currentColor' : 'none' }}" 
                                 stroke="currentColor" 
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Quick Features -->
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                        <div class="flex items-center text-xs text-gray-500">
                            <svg class="w-4 h-4 ml-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $product->price >= 100 ? 'توصيل مجاني' : 'توصيل 15 د.أ' }}
                        </div>
                        <div class="flex items-center text-xs text-gray-500">
                            <svg class="w-4 h-4 ml-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            ضمان {{ $product->formatted_warranty }}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-span-full text-center py-16">
                <div class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6 animate-float">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-3">لا توجد منتجات مميزة متاحة حالياً</h3>
                <p class="text-gray-500 mb-6">سنقوم بإضافة منتجات جديدة قريباً</p>
                <a href="{{ route('products.index') }}" class="btn-gradient text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 inline-block">
                    تصفح جميع المنتجات
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- New Arrivals Section -->
    <section class="my-8 md:my-12">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <div class="w-1 h-8 bg-gradient-to-b from-orange-500 to-orange-600 rounded-full ml-3"></div>
                <h2 class="text-2xl md:text-3xl text-gray-800 font-bold">وصل حديثاً</h2>
                <span class="mr-3 bg-orange-100 text-orange-600 text-xs font-bold px-2 py-1 rounded-full">جديد</span>
            </div>
            <a href="{{ route('products.index', ['filter' => 'new']) }}" class="flex items-center text-orange-500 no-underline font-bold text-sm md:text-base group">
                <span class="group-hover:ml-2 transition-all">عرض الكل</span>
                <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
            @if(isset($latestProducts) && $latestProducts->count() > 0)
                @foreach($latestProducts->take(10) as $product)
                    <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-200 transform hover:-translate-y-1">
                        <div class="relative">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <div class="h-40 md:h-48 relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                                    @if($product->images->first())
                                        <img src="{{ $product->images->first()->image_path }}" alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            
                            <!-- New Badge -->
                            <div class="absolute top-2 right-2">
                                <span class="bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold rounded-full py-1 px-2 shadow-lg animate-pulse">
                                    🆕 جديد
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-3">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <h3 class="text-sm font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                    {{ Str::limit($product->name, 40) }}
                                </h3>
                                <div class="flex items-center justify-between">
                                    @if($product->discount_percentage > 0)
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-orange-600">{{ number_format($product->effective_price, 0) }} د.أ</span>
                                            <span class="text-xs text-gray-500 line-through">{{ number_format($product->price, 0) }} د.أ</span>
                                        </div>
                                    @else
                                        <span class="text-sm font-bold text-gray-800">{{ number_format($product->price, 0) }} د.أ</span>
                                    @endif
                                    
                                    <button class="add-to-cart-btn bg-orange-500 text-white p-2 rounded-lg hover:bg-orange-600 transition-colors text-xs"
                                            data-product-id="{{ $product->slug }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">لا توجد منتجات جديدة متاحة حالياً</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Large Advertisement Banner -->
    <section class="my-8 md:my-12">
        <div class="relative bg-gradient-to-r from-purple-600 via-pink-600 to-orange-600 rounded-2xl overflow-hidden shadow-2xl">
            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-8 p-8 md:p-12">
                <div class="flex flex-col justify-center text-white">
                    <div class="inline-flex items-center bg-white bg-opacity-20 rounded-full px-4 py-2 mb-4 w-fit">
                        <span class="text-yellow-300 ml-2">⚡</span>
                        <span class="text-sm font-bold">عرض لفترة محدودة</span>
                    </div>
                    <h2 class="text-3xl md:text-5xl font-bold mb-4 leading-tight">
                        خصومات تصل إلى 
                        <span class="text-yellow-300">70%</span>
                    </h2>
                    <p class="text-lg md:text-xl mb-6 opacity-90">على مجموعة مختارة من أفضل المنتجات</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('products.index', ['filter' => 'sale']) }}" 
                           class="inline-flex items-center justify-center bg-white text-purple-600 font-bold py-3 px-8 rounded-xl hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg no-underline">
                            <span>تسوق الآن</span>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('products.index') }}" 
                           class="inline-flex items-center justify-center border-2 border-white text-white font-bold py-3 px-8 rounded-xl hover:bg-white hover:text-purple-600 transition-all duration-300 no-underline">
                            استكشف المزيد
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-center">
                    <div class="relative">
                        <div class="w-64 h-64 md:w-80 md:h-80 bg-white bg-opacity-10 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <div class="w-48 h-48 md:w-64 md:h-64 bg-white bg-opacity-20 rounded-full flex items-center justify-center animate-pulse">
                                <svg class="w-24 h-24 md:w-32 md:h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Floating discount badges -->
                        <div class="absolute -top-4 -right-4 bg-yellow-400 text-purple-600 rounded-full w-16 h-16 flex items-center justify-center font-bold text-lg animate-bounce">
                            50%
                        </div>
                        <div class="absolute -bottom-4 -left-4 bg-orange-400 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold animate-bounce" style="animation-delay: 0.5s">
                            70%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Best Sellers Section -->
    <section class="my-8 md:my-12">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <div class="w-1 h-8 bg-gradient-to-b from-green-500 to-green-600 rounded-full ml-3"></div>
                <h2 class="text-2xl md:text-3xl text-gray-800 font-bold">الأكثر مبيعاً</h2>
                <span class="mr-3 bg-green-100 text-green-600 text-xs font-bold px-2 py-1 rounded-full">🔥 ترند</span>
            </div>
            <a href="{{ route('products.index', ['filter' => 'popular']) }}" class="flex items-center text-orange-500 no-underline font-bold text-sm md:text-base group">
                <span class="group-hover:ml-2 transition-all">عرض الكل</span>
                <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @if(isset($popularProducts) && $popularProducts->count() > 0)
                @foreach($popularProducts->take(8) as $index => $product)
                    <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-200 transform hover:-translate-y-2 relative">
                        <!-- Bestseller ranking badge -->
                        <div class="absolute top-3 left-3 z-10">
                            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm shadow-lg">
                                {{ $index + 1 }}
                            </div>
                        </div>
                        
                        <div class="relative">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <div class="h-56 relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                                    @if($product->images->first())
                                        <img src="{{ $product->images->first()->image_path }}" alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Hot badge -->
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full py-1.5 px-3 shadow-lg animate-pulse">
                                            🔥 مطلوب
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="p-4">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <h3 class="text-base font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                    {{ $product->name }}
                                </h3>
                                
                                <!-- Rating -->
                                <div class="flex items-center mb-3">
                                    <div class="flex text-yellow-400">
                                        @foreach(range(1, 5) as $starIndex)
                                            <svg class="w-4 h-4 {{ $starIndex <= round($product->average_rating ?? 4.5) ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endforeach
                                    </div>
                                    <span class="text-gray-500 text-sm mr-2">({{ number_format($product->average_rating ?? 4.5, 1) }})</span>
                                </div>
                                
                                <!-- Price -->
                                <div class="flex items-center justify-between mb-4">
                                    @if($product->discount_percentage > 0)
                                        <div class="flex flex-col">
                                            <span class="text-lg font-bold text-orange-600">{{ number_format($product->effective_price, 0) }} د.أ</span>
                                            <span class="text-sm text-gray-500 line-through">{{ number_format($product->price, 0) }} د.أ</span>
                                        </div>
                                    @else
                                        <span class="text-lg font-bold text-gray-800">{{ number_format($product->price, 0) }} د.أ</span>
                                    @endif
                                    
                                    <div class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full font-medium">
                                        {{ rand(50, 200) }} مبيع
                                    </div>
                                </div>
                            </a>
                            
                            <!-- Action Button -->
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-2 px-4 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200"
                                    data-product-id="{{ $product->slug }}">
                                <span class="btn-text">أضف للسلة</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">لا توجد منتجات شائعة متاحة حالياً</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Sale Products Section -->
    <section class="my-8 md:my-12">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <div class="w-1 h-8 bg-gradient-to-b from-red-500 to-red-600 rounded-full ml-3"></div>
                <h2 class="text-2xl md:text-3xl text-gray-800 font-bold">عروض وخصومات</h2>
                <span class="mr-3 bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded-full animate-pulse">🏷️ خصم</span>
            </div>
            <a href="{{ route('products.index', ['filter' => 'sale']) }}" class="flex items-center text-orange-500 no-underline font-bold text-sm md:text-base group">
                <span class="group-hover:ml-2 transition-all">عرض الكل</span>
                <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @if(isset($saleProducts) && $saleProducts->count() > 0)
                @foreach($saleProducts->take(8) as $product)
                    <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-red-100 hover:border-red-300 transform hover:-translate-y-2 relative">
                        <div class="relative">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <div class="h-56 relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                                    @if($product->images->first())
                                        <img src="{{ $product->images->first()->image_path }}" alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Big Sale Badge -->
                                    <div class="absolute top-3 right-3">
                                        @if($product->discount_percentage > 0)
                                            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg px-3 py-2 shadow-lg transform -rotate-12">
                                                <div class="text-xs font-bold">خصم</div>
                                                <div class="text-lg font-black">{{ $product->discount_percentage }}%</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="p-4">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <h3 class="text-base font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                    {{ $product->name }}
                                </h3>
                                
                                <!-- Price with prominent savings -->
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xl font-bold text-red-600">{{ number_format($product->effective_price, 0) }} د.أ</span>
                                        <span class="text-sm text-gray-500 line-through">{{ number_format($product->price, 0) }} د.أ</span>
                                    </div>
                                    <div class="bg-green-50 text-green-700 text-xs font-bold px-3 py-1 rounded-full w-fit">
                                        وفّر {{ number_format($product->price - $product->effective_price, 0) }} د.أ
                                    </div>
                                </div>
                            </a>
                            
                            <!-- Action Button -->
                            <button class="add-to-cart-btn w-full bg-gradient-to-r from-red-500 to-red-600 text-white font-bold py-3 px-4 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg"
                                    data-product-id="{{ $product->slug }}">
                                <span class="btn-text flex items-center justify-center">
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5m6 0L18 18H9m6 0a2 2 0 11-4 0m4 0a2 2 0 11-4 0m4 0h2a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                    اشتري بالخصم
                                </span>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">لا توجد منتجات بخصم متاحة حالياً</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter Subscription Section -->
    <section class="my-8 md:my-12">
        <div class="bg-gradient-to-r from-orange-500 via-orange-600 to-red-600 rounded-2xl p-8 md:p-12 text-white text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-black bg-opacity-10"></div>
            <div class="relative z-10">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 3.26a2 2 0 001.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">ابق على اطلاع بأحدث العروض</h2>
                    <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto">
                        اشترك في نشرتنا البريدية واحصل على خصم 15% على طلبك الأول + أحدث المنتجات والعروض الحصرية
                    </p>
                </div>
                
                <form class="max-w-md mx-auto">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <input type="email" 
                               placeholder="أدخل بريدك الإلكتروني" 
                               class="flex-1 px-6 py-4 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50 text-center sm:text-right">
                        <button type="submit" 
                                class="bg-white text-orange-600 font-bold py-4 px-8 rounded-xl hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            اشتراك
                        </button>
                    </div>
                    <p class="text-sm opacity-75 mt-4">
                        💝 احصل على خصم فوري 15% عند الاشتراك
                    </p>
                </form>
            </div>
            
            <!-- Decorative elements -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-white bg-opacity-10 rounded-full -translate-x-16 -translate-y-16"></div>
            <div class="absolute bottom-0 right-0 w-48 h-48 bg-white bg-opacity-10 rounded-full translate-x-24 translate-y-24"></div>
        </div>
    </section>

    <!-- Brand Features Section -->
    <section class="my-8 md:my-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">شحن مجاني</h3>
                <p class="text-gray-600 text-sm">للطلبات فوق 200 د.أ</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">ضمان الجودة</h3>
                <p class="text-gray-600 text-sm">منتجات أصلية 100%</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">دعم 24/7</h3>
                <p class="text-gray-600 text-sm">خدمة عملاء متميزة</p>
            </div>
            
            <div class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">إرجاع سهل</h3>
                <p class="text-gray-600 text-sm">خلال 14 يوم</p>
            </div>
        </div>
    </section>

    
</main>

<script>
// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all add-to-cart buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            addToCart(productId, this);
        });
    });

    // Add event listeners to all add-to-wishlist buttons
    document.querySelectorAll('.add-to-wishlist-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            addToWishlist(productId, this);
        });
    });
});

// Add to cart functionality
function addToCart(productId, button) {
    const btnText = button.querySelector('.btn-text');
    const loadingText = button.querySelector('.loading-text');
    
    // Check for CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        showNotification('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
        return;
    }
    
    // Show loading state
    if (btnText) btnText.classList.add('hidden');
    if (loadingText) loadingText.classList.remove('hidden');
    button.disabled = true;
    
    fetch('{{ route("cart.add", ":productId") }}'.replace(':productId', productId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
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
            showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
        }
    })
    .catch(error => {
        console.error('Add to cart error:', error);
        showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
    })
    .finally(() => {
        // Reset button state
        if (btnText) btnText.classList.remove('hidden');
        if (loadingText) loadingText.classList.add('hidden');
        button.disabled = false;
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

// Add to wishlist functionality
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
    button.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
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
                button.innerHTML = '<svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
                button.classList.add('is-in-wishlist', 'text-red-500');
                button.classList.remove('text-gray-600', 'hover:text-orange-600');
                button.title = 'موجود في قائمة الأمنيات';
                showNotification('تم إضافة المنتج إلى قائمة الأمنيات!', 'success');
            } else {
                // Item removed from wishlist
                button.innerHTML = '<svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
                button.classList.remove('is-in-wishlist', 'text-red-500');
                button.classList.add('text-gray-600', 'hover:text-orange-600');
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
</script>
@endsection




