@extends('layouts.main')

@section('title', 'سلة التسوق - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 sm:mb-8 gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">سلة التسوق</h1>
                    <p class="text-gray-600 text-sm sm:text-base">مراجعة المنتجات المحددة قبل الشراء</p>
                </div>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    متابعة التسوق
                </a>
            </div>

            @if(count($cartItems) > 0)
            <div class="lg:grid lg:grid-cols-12 lg:gap-8 space-y-8 lg:space-y-0">
                <!-- Cart Items -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 ml-2 sm:ml-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                المنتجات المحددة ({{ count($cartItems) }})
                            </h2>
                        </div>
                        
                        <div class="divide-y divide-gray-100">
                            @foreach($cartItems as $item)
                            <div class="p-4 sm:p-6 cart-item hover:bg-gray-50 transition-colors duration-200" data-cart-key="{{ $item['cart_key'] }}">
                                <!-- Mobile Layout (below sm) -->
                                <div class="sm:hidden">
                                    <!-- Product Header -->
                                    <div class="flex items-start gap-4 mb-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            <div class="w-20 h-20 rounded-xl overflow-hidden border-2 border-gray-100 shadow-sm">
                                                <img src="{{ $item['product']->main_image }}" 
                                                     alt="{{ $item['product']->name }}" 
                                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                                            </div>
                                        </div>
                                        
                                        <!-- Product Info -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-base font-bold text-gray-900 mb-2 hover:text-orange-600 transition-colors duration-200 leading-tight">
                                                {{ $item['product']->name }}
                                            </h3>
                                            
                                            @if($item['size'])
                                            <div class="mb-2">
                                                <span class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full border border-blue-200">
                                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                                    </svg>
                                                    المقاس: {{ $item['size']->size ?? $item['size'] }}
                                                </span>
                                            </div>
                                            @endif
                                            
                                            <!-- Price on Mobile -->
                                            <div class="text-right">
                                                @if($item['product']->price > $item['product']->final_price)
                                                    <!-- Show original price crossed out if there's a discount -->
                                                    <div class="text-sm text-gray-400 line-through mb-1">
                                                        {{ number_format($item['product']->price * $item['quantity'], 2) }} د.أ
                                                    </div>
                                                    <div class="inline-flex items-center gap-2 mb-2">
                                                        <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-bold">
                                                            خصم {{ round((($item['product']->price - $item['product']->final_price) / $item['product']->price) * 100) }}%
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="text-lg font-bold text-orange-600">
                                                    {{ number_format($item['subtotal'], 2) }} د.أ
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ number_format($item['price'], 2) }} د.أ للوحدة
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Mobile Controls -->
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-gray-600">الكمية:</span>
                                            <div class="flex items-center bg-gray-50 rounded-lg border border-gray-200">
                                                <button type="button" 
                                                        class="quantity-btn decrease-qty p-2 text-gray-600 hover:text-orange-600 hover:bg-orange-50 rounded-r-lg transition-colors duration-200"
                                                        data-product-id="{{ $item['product']->id }}"
                                                        data-size="{{ $item['size']->size ?? '' }}"
                                                        data-color="{{ $item['color'] ?? '' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                </button>
                                                
                                                <input type="number" 
                                                       class="quantity-input w-12 text-center bg-transparent border-none py-2 text-gray-900 font-semibold text-sm"
                                                       value="{{ $item['quantity'] }}"
                                                       min="1"
                                                       data-product-id="{{ $item['product']->id }}"
                                                       data-size="{{ $item['size']->size ?? '' }}"
                                                       data-color="{{ $item['color'] ?? '' }}">
                                                
                                                <button type="button" 
                                                        class="quantity-btn increase-qty p-2 text-gray-600 hover:text-orange-600 hover:bg-orange-50 rounded-l-lg transition-colors duration-200"
                                                        data-product-id="{{ $item['product']->id }}"
                                                        data-size="{{ $item['size']->size ?? '' }}"
                                                        data-color="{{ $item['color'] ?? '' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Remove Button -->
                                        <button type="button" 
                                                class="remove-item inline-flex items-center px-3 py-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-lg transition-colors duration-200 font-medium text-sm"
                                                data-product-id="{{ $item['product']->id }}"
                                                data-size="{{ $item['size']->size ?? '' }}">
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span class="hidden xs:inline">حذف</span>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Desktop Layout (sm and above) -->
                                <div class="hidden sm:flex items-start gap-6">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        <div class="w-24 h-24 rounded-xl overflow-hidden border-2 border-gray-100 shadow-sm">
                                            <img src="{{ $item['product']->main_image }}" 
                                                 alt="{{ $item['product']->name }}" 
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                                        </div>
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3 hover:text-orange-600 transition-colors duration-200">
                                            {{ $item['product']->name }}
                                        </h3>
                                        
                                        @if($item['size'])
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 text-sm font-medium rounded-full border border-blue-200">
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                                                </svg>
                                                المقاس: {{ $item['size']->size ?? $item['size'] }}
                                            </span>
                                        </div>
                                        @endif
                                        
                                        <!-- Quantity and Controls Row -->
                                        <div class="flex items-center justify-between flex-wrap gap-4">
                                            <!-- Quantity Controls -->
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm font-medium text-gray-600">الكمية:</span>
                                                <div class="flex items-center bg-gray-50 rounded-lg border border-gray-200">
                                                    <button type="button" 
                                                            class="quantity-btn decrease-qty p-2 text-gray-600 hover:text-orange-600 hover:bg-orange-50 rounded-r-lg transition-colors duration-200"
                                                            data-product-id="{{ $item['product']->id }}"
                                                            data-size="{{ $item['size']->size ?? '' }}"
                                                            data-color="{{ $item['color'] ?? '' }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    
                                                    <input type="number" 
                                                           class="quantity-input w-16 text-center bg-transparent border-none py-2 text-gray-900 font-semibold"
                                                           value="{{ $item['quantity'] }}"
                                                           min="1"
                                                           data-product-id="{{ $item['product']->id }}"
                                                           data-size="{{ $item['size']->size ?? '' }}"
                                                           data-color="{{ $item['color'] ?? '' }}">
                                                    
                                                    <button type="button" 
                                                            class="quantity-btn increase-qty p-2 text-gray-600 hover:text-orange-600 hover:bg-orange-50 rounded-l-lg transition-colors duration-200"
                                                            data-product-id="{{ $item['product']->id }}"
                                                            data-size="{{ $item['size']->size ?? '' }}"
                                                            data-color="{{ $item['color'] ?? '' }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <!-- Remove Button -->
                                            <button type="button" 
                                                    class="remove-item inline-flex items-center px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-lg transition-colors duration-200 font-medium text-sm"
                                                    data-product-id="{{ $item['product']->id }}"
                                                    data-size="{{ $item['size']->size ?? '' }}">
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                حذف
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Price Section -->
                                    <div class="text-left flex-shrink-0">
                                        @if($item['product']->price > $item['product']->final_price)
                                            <!-- Show discount badge and original price -->
                                            <div class="flex items-center justify-end gap-2 mb-2">
                                                <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-bold">
                                                    خصم {{ round((($item['product']->price - $item['product']->final_price) / $item['product']->price) * 100) }}%
                                                </span>
                                            </div>
                                            <div class="text-sm text-gray-400 line-through mb-1">السعر الأصلي: {{ number_format($item['product']->price, 2) }} د.أ</div>
                                            <div class="text-sm text-green-600 font-medium mb-1">سعر الوحدة بعد الخصم</div>
                                        @else
                                            <div class="text-sm text-gray-500 mb-1">سعر الوحدة</div>
                                        @endif
                                        <div class="text-lg font-bold text-gray-900 mb-2">{{ number_format($item['price'], 2) }} د.أ</div>
                                        @if($item['quantity'] > 1)
                                        <div class="text-sm text-gray-500 mb-2">
                                            {{ $item['quantity'] }} × {{ number_format($item['price'], 2) }} د.أ
                                        </div>
                                        @endif
                                        <div class="text-xl font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-lg">
                                            {{ number_format($item['subtotal'], 2) }} د.أ
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6 sticky top-4">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 ml-2 sm:ml-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            ملخص الطلب
                        </h2>
                        
                        <div class="space-y-3 sm:space-y-4 mb-6">
                            @if($totalSavings > 0)
                            <div class="flex justify-between text-gray-600 text-sm sm:text-base">
                                <span>السعر الأصلي:</span>
                                <span class="font-semibold line-through text-gray-400">{{ number_format($totalOriginal, 2) }} د.أ</span>
                            </div>
                            <div class="flex justify-between text-green-600 text-sm sm:text-base">
                                <span>إجمالي الخصم:</span>
                                <span class="font-bold">-{{ number_format($totalSavings, 2) }} د.أ</span>
                            </div>
                            @endif
                            <div class="flex justify-between text-gray-600 text-sm sm:text-base">
                                <span>إجمالي المنتجات:</span>
                                <span class="font-semibold">{{ number_format($total, 2) }} د.أ</span>
                            </div>
                            <div class="flex justify-between text-gray-600 text-sm sm:text-base">
                                <span>الشحن:</span>
                                <span class="font-medium text-blue-600">سيتم تحديده عند اختيار المدينة</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 sm:pt-4">
                                <div class="flex justify-between">
                                    <span class="font-bold text-gray-900 text-base sm:text-lg">المجموع النهائي:</span>
                                    <div class="text-left">
                                        <span class="font-bold text-xl sm:text-2xl text-orange-600">{{ number_format($total, 2) }} د.أ</span>
                                        <div class="text-xs text-gray-500 mt-1">+ رسوم الشحن</div>
                                    </div>
                                </div>
                                @if($totalSavings > 0)
                                <div class="text-center mt-2">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">
                                        🎉 وفرت {{ number_format($totalSavings, 2) }} د.أ
                                    </span>
                                </div>
                                @endif
                                
                                <!-- Shipping Notice -->
                                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-start">
                                        <svg class="w-4 h-4 text-blue-500 mt-0.5 ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-blue-700 text-sm font-medium">
                                            ستتمكن من معرفة تكلفة الشحن الدقيقة عند اختيار مدينتك في صفحة الدفع
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            @auth
                            <a href="{{ route('checkout.index') }}" 
                               class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 sm:py-4 px-4 sm:px-6 rounded-xl font-bold text-base sm:text-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200 text-center block shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                متابعة إلى الدفع
                                <div class="text-xs font-normal mt-1 opacity-90">سيتم حساب رسوم الشحن في الخطوة التالية</div>
                            </a>
                            @else
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-blue-700 font-medium">يجب تسجيل الدخول لإتمام عملية الشراء</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('login') }}" 
                                   class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 sm:py-4 px-4 sm:px-6 rounded-xl font-bold text-base sm:text-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200 text-center block shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    تسجيل الدخول
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="flex-1 bg-gray-100 text-gray-700 py-3 sm:py-4 px-4 sm:px-6 rounded-xl font-bold text-base sm:text-lg hover:bg-gray-200 transition-all duration-200 text-center block border-2 border-gray-200">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    إنشاء حساب
                                </a>
                            </div>
                            @endauth
                            
                            <button type="button" 
                                    id="clear-cart"
                                    class="w-full border-2 border-gray-300 text-gray-700 py-2 sm:py-3 px-4 sm:px-6 rounded-xl font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                تفريغ السلة
                            </button>
                        </div>
                        
                        <!-- Cart Count Display -->
                        <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600" id="cart-items-count">{{ count($cartItems) }}</div>
                                <div class="text-sm text-blue-600 font-medium">منتج في السلة</div>
                            </div>
                        </div>
                        
                        <!-- Security Badge -->
                        <div class="mt-4 flex items-center justify-center text-sm text-gray-500">
                            <svg class="w-4 h-4 ml-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            دفع آمن ومضمون
                        </div>
                    </div>
                </div>
            </div>
            
            @else
            <!-- Empty Cart State -->
            <div class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <div class="mx-auto w-32 h-32 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full flex items-center justify-center mb-8 shadow-lg">
                        <svg class="w-16 h-16 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">سلة التسوق فارغة</h2>
                    <p class="text-gray-600 mb-8 text-lg">لم تقم بإضافة أي منتجات إلى سلة التسوق بعد</p>
                    <div class="space-y-4">
                        <a href="{{ route('products.index') }}" 
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold text-lg rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            ابدأ التسوق الآن
                        </a>
                        <div class="text-sm text-gray-500">
                            أو <a href="{{ route('home') }}" class="text-orange-600 hover:text-orange-700 font-medium">العودة للصفحة الرئيسية</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if CSRF token is available
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        showError('خطأ في الأمان - يرجى إعادة تحميل الصفحة');
        return;
    }
    
    // Quantity controls
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const size = this.dataset.size || '';
            const isIncrease = this.classList.contains('increase-qty');
            
            const input = document.querySelector(`input[data-product-id="${productId}"][data-size="${size}"]`);
            if (!input) {
                console.error('Quantity input not found');
                return;
            }
            
            let quantity = parseInt(input.value);
            
            if (isIncrease) {
                quantity++;
            } else if (quantity > 1) {
                quantity--;
            }
            
            input.value = quantity;
            updateCartItem(productId, quantity, size);
        });
    });
    
    // Quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const quantity = Math.max(1, parseInt(this.value));
            this.value = quantity;
            
            updateCartItem(
                this.dataset.productId, 
                quantity, 
                this.dataset.size || ''
            );
        });
    });
    
    // Remove item
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const size = this.dataset.size || '';
            
            showConfirm('هل أنت متأكد من حذف هذا المنتج من السلة؟', () => {
                removeFromCart(productId, size);
            });
        });
    });
    
    // Clear cart
    document.getElementById('clear-cart')?.addEventListener('click', function() {
        showConfirm('هل أنت متأكد من تفريغ السلة بالكامل؟', () => {
            clearCart();
        });
    });
    
    function updateCartItem(productId, quantity, size) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            showError('خطأ في الأمان - يرجى إعادة تحميل الصفحة');
            return;
        }
        
        // Create cart key same way as backend
        let cartKey = productId;
        if (size && size !== '') {
            // Find the size ID from the size name 
            const sizeInput = document.querySelector(`input[data-product-id="${productId}"][data-size="${size}"]`);
            if (sizeInput) {
                const cartItem = sizeInput.closest('.cart-item');
                const actualCartKey = cartItem?.dataset.cartKey;
                if (actualCartKey) {
                    cartKey = actualCartKey;
                } else {
                    cartKey = productId + '_size_' + size;
                }
            }
        }
        
        fetch(`/cart/update/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                quantity: quantity,
                cart_key: cartKey
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Response is not JSON');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showSuccess('تم تحديث السلة بنجاح');
                setTimeout(() => location.reload(), 1000); // Reload after showing success message
            } else {
                showError('حدث خطأ أثناء تحديث السلة: ' + (data.message || 'خطأ غير معروف'));
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
            showError('حدث خطأ أثناء تحديث السلة: ' + error.message);
        });
    }
    
    function removeFromCart(productId, size) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            showError('خطأ في الأمان - يرجى إعادة تحميل الصفحة');
            return;
        }
        
        // Create cart key same way as backend
        let cartKey = productId;
        if (size && size !== '') {
            const sizeInput = document.querySelector(`input[data-product-id="${productId}"][data-size="${size}"]`);
            if (sizeInput) {
                const cartItem = sizeInput.closest('.cart-item');
                const actualCartKey = cartItem?.dataset.cartKey;
                if (actualCartKey) {
                    cartKey = actualCartKey;
                } else {
                    cartKey = productId + '_size_' + size;
                }
            }
        }
        
        fetch(`/cart/remove/${cartKey}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Response is not JSON');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showSuccess('تم حذف المنتج من السلة بنجاح');
                setTimeout(() => location.reload(), 1000); // Reload after showing success message
            } else {
                showError('حدث خطأ أثناء حذف المنتج: ' + (data.message || 'خطأ غير معروف'));
            }
        })
        .catch(error => {
            console.error('Error removing from cart:', error);
            showError('حدث خطأ أثناء حذف المنتج: ' + error.message);
        });
    }
    
    function clearCart() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            showError('خطأ في الأمان - يرجى إعادة تحميل الصفحة');
            return;
        }
        
        fetch('/cart/clear', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Response is not JSON');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showSuccess('تم تفريغ السلة بنجاح');
                setTimeout(() => location.reload(), 1000); // Reload after showing success message
            } else {
                showError('حدث خطأ أثناء تفريغ السلة: ' + (data.message || 'خطأ غير معروف'));
            }
        })
        .catch(error => {
            console.error('Error clearing cart:', error);
            showError('حدث خطأ أثناء تفريغ السلة: ' + error.message);
        });
    }
});
</script>
@endpush
@endsection
