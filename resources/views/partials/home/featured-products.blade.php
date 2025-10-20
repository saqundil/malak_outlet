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
        <div class="group product-card bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-200 transform hover:-translate-y-2 relative card-shine flex flex-col h-full">
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
            
            <div class="p-5 flex flex-col flex-grow">
                <div class="flex-grow">
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
                        <h3 class="text-base md:text-lg font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors min-h-[3rem]">
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
                                        <span class="text-xl font-bold text-gradient">{{ number_format($product->final_price, 0) }} د.أ</span>
                                        <span class="text-sm text-gray-500 line-through">{{ number_format($product->price, 0) }} د.أ</span>
                                    </div>
                                    <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-full inline-block w-fit">وفّر {{ number_format($product->savings_amount, 0) }} د.أ</span>
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
                </div>
                
                <!-- Action Buttons - Fixed at bottom -->
                <div class="mt-auto">
                    <div class="flex space-x-3 space-x-reverse mb-3">
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
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
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
                            ضمان سنة واحدة
                        </div>
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
