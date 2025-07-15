@extends('layouts.main')

@section('title', $category->name ?? 'فئة المنتجات' . ' - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl">
                <nav class="text-sm mb-4 opacity-90">
                    <ol class="flex flex-wrap items-center gap-2">
                        <li><a href="{{ route('home') }}" class="hover:underline">الرئيسية</a></li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <a href="{{ route('categories.index') }}" class="hover:underline">الفئات</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span>{{ $category->name ?? 'فئة المنتجات' }}</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $category->name ?? 'فئة المنتجات' }}</h1>
                @if($category->description ?? null)
                    <p class="text-xl opacity-90">{{ $category->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Filters and Sort -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <span class="text-gray-700 font-semibold">ترتيب حسب:</span>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>الأحدث</option>
                        <option>الأقل سعراً</option>
                        <option>الأعلى سعراً</option>
                        <option>الأكثر مبيعاً</option>
                        <option>الأعلى تقييماً</option>
                    </select>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-gray-600">
                        عرض {{ count($products ?? []) }} من أصل {{ count($products ?? []) }} منتج
                    </span>
                    <div class="flex items-center gap-2">
                        <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </button>
                        <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($products ?? [] as $product)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <div class="relative">
                        <div class="aspect-square bg-gray-100 overflow-hidden">
                            @if($product->images && $product->images->count() > 0)
                                <img src="{{ $product->images->first()->image_path }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        @if($product->sale_price)
                            <div class="absolute top-3 right-3 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                                خصم {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                            </div>
                        @endif
                        
                        <button class="absolute top-3 left-3 p-2 bg-white rounded-full shadow-lg hover:bg-red-50 transition-colors">
                            <svg class="w-5 h-5 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
                        
                        @if($product->brand)
                            <p class="text-sm text-gray-500 mb-2">{{ $product->brand->name }}</p>
                        @endif
                        
                        <div class="flex items-center gap-2 mb-3">
                            @if($product->sale_price)
                                <span class="text-xl font-bold text-red-600">{{ number_format($product->sale_price, 2) }} ر.س</span>
                                <span class="text-sm text-gray-500 line-through">{{ number_format($product->price, 2) }} ر.س</span>
                            @else
                                <span class="text-xl font-bold text-gray-800">{{ number_format($product->price, 2) }} ر.س</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex items-center">
                                @foreach(range(1, 5) as $categoryStars)
                                    <svg class="w-4 h-4 {{ $categoryStars <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endforeach
                            </div>
                            <span class="text-sm text-gray-500">(12 تقييم)</span>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center font-semibold">
                                عرض التفاصيل
                            </a>
                            <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 009.586 13H7"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-600 mb-2">لا توجد منتجات في هذه الفئة</h3>
                    <p class="text-gray-500 mb-6">نعمل على إضافة منتجات جديدة قريباً</p>
                    <a href="{{ route('products.index') }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        تصفح جميع المنتجات
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($products) && method_exists($products, 'links'))
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
