@extends('layouts.main')

@section('title', 'جميع الفئات - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">فئات المنتجات</h1>
            <p class="text-xl opacity-90">اكتشف مجموعتنا المتنوعة من ألعاب الأطفال</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        <!-- Categories Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($categories ?? [] as $category)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-square bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                    @if($category->image)
                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $category->name }}</h3>
                    @if($category->description)
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($category->description, 80) }}</p>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">
                            {{ $category->products_count ?? 0 }} منتج
                        </span>
                        <a href="{{ route('categories.show', $category->id) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold">
                            عرض المنتجات
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Placeholder categories -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-square bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">الألعاب التعليمية</h3>
                    <p class="text-gray-600 text-sm mb-4">ألعاب تساعد على تطوير مهارات الطفل التعليمية والذهنية</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">15 منتج</span>
                        <a href="{{ route('products.index') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold">
                            عرض المنتجات
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-square bg-gradient-to-br from-green-100 to-teal-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.5a.5.5 0 01.5.5v1a1.5 1.5 0 003 0v-1a.5.5 0 01.5-.5H16m-7 0V9a2 2 0 012-2h2a2 2 0 012 2v1m-7 0H6m10 0h3"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">الدمى والحيوانات</h3>
                    <p class="text-gray-600 text-sm mb-4">دمى ناعمة ومحشوة آمنة ومريحة للأطفال</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">8 منتج</span>
                        <a href="{{ route('products.index') }}" 
                           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm font-semibold">
                            عرض المنتجات
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-square bg-gradient-to-br from-red-100 to-pink-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">السيارات والمركبات</h3>
                    <p class="text-gray-600 text-sm mb-4">سيارات تحكم عن بعد ومركبات متنوعة</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">12 منتج</span>
                        <a href="{{ route('products.index') }}" 
                           class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm font-semibold">
                            عرض المنتجات
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-square bg-gradient-to-br from-yellow-100 to-orange-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">الألعاب الإبداعية</h3>
                    <p class="text-gray-600 text-sm mb-4">ألعاب الرسم والتلوين والأنشطة الإبداعية</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">6 منتج</span>
                        <a href="{{ route('products.index') }}" 
                           class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors text-sm font-semibold">
                            عرض المنتجات
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-square bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">التجارب العلمية</h3>
                    <p class="text-gray-600 text-sm mb-4">مجموعات التجارب العلمية والاستكشاف</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">4 منتج</span>
                        <a href="{{ route('products.index') }}" 
                           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors text-sm font-semibold">
                            عرض المنتجات
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-square bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">ألعاب البنات</h3>
                    <p class="text-gray-600 text-sm mb-4">مجموعة خاصة من الألعاب المصممة للبنات</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">10 منتج</span>
                        <a href="{{ route('products.index') }}" 
                           class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition-colors text-sm font-semibold">
                            عرض المنتجات
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-square bg-gradient-to-br from-gray-100 to-blue-100 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a1 1 0 01-1-1V9a1 1 0 011-1h1a2 2 0 100-4H4a1 1 0 01-1-1V5a1 1 0 011-1h3a1 1 0 001-1V3a2 2 0 012-2z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">الألغاز والذكاء</h3>
                    <p class="text-gray-600 text-sm mb-4">ألعاب الألغاز وتطوير الذكاء والتفكير</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">7 منتج</span>
                        <a href="{{ route('products.index') }}" 
                           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors text-sm font-semibold">
                            عرض المنتجات
                        </a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- View All Products -->
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" 
               class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 inline-block">
                عرض جميع المنتجات
            </a>
        </div>
    </div>
</div>
@endsection
