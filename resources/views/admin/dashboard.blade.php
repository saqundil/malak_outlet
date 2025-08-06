@extends('admin.layout')

@section('title', 'لوحة التحكم الرئيسية')
@section('page-title', 'لوحة التحكم')
@section('page-description', 'نظرة عامة شاملة على نشاط المتجر والإحصائيات')

@section('content')
<div class="space-y-8">
    <!-- Quick Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Products -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">إجمالي المنتجات</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_products']) }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-arrow-up"></i> 
                        +{{ $stats['active_products'] ?? 0 }} نشط
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-blue-100 rounded-xl">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    إدارة المنتجات
                </a>
                <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-xs">
                    إضافة منتج
                </a>
            </div>
        </div>
        
        <!-- Total Orders -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">إجمالي الطلبات</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_orders']) }}</p>
                    <p class="text-xs text-orange-600 mt-1">
                        <i class="fas fa-clock"></i> 
                        {{ $stats['pending_orders'] ?? 0 }} في الانتظار
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-green-100 rounded-xl">
                    <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <a href="{{ route('admin.orders.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                    إدارة الطلبات
                </a>
                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-md text-xs">
                    جديد
                </span>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">إجمالي المبيعات</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_revenue'] ?? 0) }} ر.س</p>
                    <p class="text-xs text-green-600 mt-1">
                        <i class="fas fa-chart-line"></i> 
                        هذا الشهر
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-yellow-100 rounded-xl">
                    <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ min(100, ($stats['total_revenue'] ?? 0) / 1000) }}%"></div>
                </div>
            </div>
        </div>
        
        <!-- Total Categories -->
        <div class="stat-card p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">الفئات والعلامات</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_categories'] + $stats['total_brands'] }}</p>
                    <p class="text-xs text-purple-600 mt-1">
                        {{ $stats['total_categories'] }} فئة، {{ $stats['total_brands'] }} علامة
                    </p>
                </div>
                <div class="flex items-center justify-center w-14 h-14 bg-purple-100 rounded-xl">
                    <i class="fas fa-tags text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <a href="{{ route('admin.categories.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    إدارة الفئات
                </a>
                <a href="{{ route('admin.brands.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                    العلامات
                </a>
            </div>
        </div>
    </div>

    <!-- Management Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Management Section -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">إدارة المنتجات</h3>
                <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus ml-2"></i> إضافة منتج جديد
                </a>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-box text-blue-500 ml-3"></i>
                        <span class="font-medium">المنتجات النشطة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-blue-600">{{ $stats['active_products'] ?? 0 }}</span>
                        <a href="{{ route('admin.products.index') }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-eye-slash text-gray-500 ml-3"></i>
                        <span class="font-medium">المنتجات غير النشطة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-gray-600">{{ $stats['inactive_products'] ?? 0 }}</span>
                        <a href="{{ route('admin.products.index') }}?status=inactive" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-500 ml-3"></i>
                        <span class="font-medium">المنتجات المميزة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-yellow-600">{{ $stats['featured_products'] ?? 0 }}</span>
                        <a href="{{ route('admin.products.index') }}?featured=1" class="text-yellow-500 hover:text-yellow-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Management Section -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">إدارة الطلبات</h3>
                <a href="{{ route('admin.orders.index') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-list ml-2"></i> عرض جميع الطلبات
                </a>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-orange-500 ml-3"></i>
                        <span class="font-medium">طلبات في الانتظار</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-orange-600">{{ $stats['pending_orders'] ?? 0 }}</span>
                        <a href="{{ route('admin.orders.index') }}?status=pending" class="text-orange-500 hover:text-orange-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-truck text-blue-500 ml-3"></i>
                        <span class="font-medium">طلبات قيد التوصيل</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-blue-600">{{ $stats['shipping_orders'] ?? 0 }}</span>
                        <a href="{{ route('admin.orders.index') }}?status=shipping" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 ml-3"></i>
                        <span class="font-medium">طلبات مكتملة</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-green-600">{{ $stats['completed_orders'] ?? 0 }}</span>
                        <a href="{{ route('admin.orders.index') }}?status=completed" class="text-green-500 hover:text-green-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories and Brands Management -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Categories Management -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">إدارة الفئات</h3>
                <a href="{{ route('admin.categories.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus ml-2"></i> إضافة فئة
                </a>
            </div>
            
            <div class="space-y-3">
                @if($recentCategories->count() > 0)
                    @foreach($recentCategories->take(5) as $category)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-10 h-10 rounded-lg object-cover ml-3">
                            @else
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center ml-3">
                                    <i class="fas fa-folder text-purple-500"></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900">{{ $category->name }}</p>
                                <p class="text-sm text-gray-500">{{ $category->products_count ?? 0 }} منتج</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 rounded-full text-xs {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                            <a href="{{ route('admin.categories.show', $category) }}" class="text-purple-500 hover:text-purple-700">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-folder-open text-4xl mb-4"></i>
                        <p>لا توجد فئات حالياً</p>
                        <a href="{{ route('admin.categories.create') }}" class="text-purple-500 hover:text-purple-700 mt-2 inline-block">
                            إضافة أول فئة
                        </a>
                    </div>
                @endif
                
                @if($recentCategories->count() > 5)
                <div class="text-center pt-4">
                    <a href="{{ route('admin.categories.index') }}" class="text-purple-500 hover:text-purple-700 font-medium">
                        عرض جميع الفئات ({{ $stats['total_categories'] }})
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Brands Management -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">إدارة العلامات التجارية</h3>
                <a href="{{ route('admin.brands.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-plus ml-2"></i> إضافة علامة
                </a>
            </div>
            
            <div class="space-y-3">
                @if($recentBrands->count() > 0)
                    @foreach($recentBrands->take(5) as $brand)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            @if($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="w-10 h-10 rounded-lg object-cover ml-3">
                            @else
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center ml-3">
                                    <i class="fas fa-tag text-indigo-500"></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900">{{ $brand->name }}</p>
                                <p class="text-sm text-gray-500">{{ $brand->products_count ?? 0 }} منتج</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 rounded-full text-xs {{ $brand->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $brand->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                            <a href="{{ route('admin.brands.show', $brand) }}" class="text-indigo-500 hover:text-indigo-700">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-tags text-4xl mb-4"></i>
                        <p>لا توجد علامات تجارية حالياً</p>
                        <a href="{{ route('admin.brands.create') }}" class="text-indigo-500 hover:text-indigo-700 mt-2 inline-block">
                            إضافة أول علامة تجارية
                        </a>
                    </div>
                @endif
                
                @if($recentBrands->count() > 5)
                <div class="text-center pt-4">
                    <a href="{{ route('admin.brands.index') }}" class="text-indigo-500 hover:text-indigo-700 font-medium">
                        عرض جميع العلامات ({{ $stats['total_brands'] }})
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity and Quick Links -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">أحدث الطلبات</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                    عرض الكل
                </a>
            </div>
            
            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders->take(5) as $order)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center ml-4">
                                <i class="fas fa-receipt text-blue-500"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">طلب #{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-500">{{ $order->user->name ?? 'زائر' }}</p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-gray-900">{{ number_format($order->total) }} ر.س</p>
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status == 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ 
                                    $order->status == 'pending' ? 'في الانتظار' :
                                    ($order->status == 'processing' ? 'قيد المعالجة' :
                                    ($order->status == 'shipped' ? 'تم الشحن' :
                                    ($order->status == 'delivered' ? 'تم التوصيل' :
                                    ($order->status == 'cancelled' ? 'ملغي' : $order->status))))
                                }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                    <p>لا توجد طلبات حالياً</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-bold text-gray-900 mb-6">إجراءات سريعة</h3>
            
            <div class="space-y-4">
                <a href="{{ route('admin.products.create') }}" class="flex items-center justify-between p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-plus-circle text-blue-500 ml-3"></i>
                        <span class="font-medium text-blue-900">إضافة منتج جديد</span>
                    </div>
                    <i class="fas fa-arrow-left text-blue-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="{{ route('admin.categories.create') }}" class="flex items-center justify-between p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-folder-plus text-purple-500 ml-3"></i>
                        <span class="font-medium text-purple-900">إضافة فئة جديدة</span>
                    </div>
                    <i class="fas fa-arrow-left text-purple-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="{{ route('admin.brands.create') }}" class="flex items-center justify-between p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-tag text-indigo-500 ml-3"></i>
                        <span class="font-medium text-indigo-900">إضافة علامة تجارية</span>
                    </div>
                    <i class="fas fa-arrow-left text-indigo-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-list-alt text-green-500 ml-3"></i>
                        <span class="font-medium text-green-900">مراجعة الطلبات</span>
                    </div>
                    <i class="fas fa-arrow-left text-green-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
                
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                    <div class="flex items-center">
                        <i class="fas fa-external-link-alt text-gray-500 ml-3"></i>
                        <span class="font-medium text-gray-900">زيارة الموقع</span>
                    </div>
                    <i class="fas fa-arrow-left text-gray-500 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card:hover {
        transform: translateY(-2px);
    }
    
    .group:hover .group-hover\:translate-x-1 {
        transform: translateX(-0.25rem);
    }
</style>
@endsection




