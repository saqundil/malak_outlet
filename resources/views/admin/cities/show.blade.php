@extends('admin.layout')

@section('title', 'تفاصيل المدينة - ' . $city->display_name)
@section('page-title', 'تفاصيل المدينة')
@section('page-description', 'عرض تفاصيل وإحصائيات مدينة ' . $city->display_name)

@push('styles')
<style>
    .stats-card {
        background: linear-gradient(135deg, var(--bg-color-1), var(--bg-color-2));
        color: white;
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        transition: transform 0.3s ease;
    }
    .stats-card:hover {
        transform: translateY(-4px);
    }
    .info-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    .badge-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    .action-btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
    }
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        color: white;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="space-y-8">
    <!-- City Header -->
    <div class="info-card">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center ml-4">
                    <i class="fas fa-map-marker-alt text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $city->display_name }}</h1>
                    @if($city->name_en)
                        <p class="text-lg text-gray-600">{{ $city->name_en }}</p>
                    @endif
                    <div class="flex items-center gap-3 mt-2">
                        <span class="badge {{ $city->is_active ? 'badge-success' : 'badge-danger' }}">
                            <i class="fas fa-{{ $city->is_active ? 'check' : 'times' }} ml-1"></i>
                            {{ $city->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-calendar ml-1"></i>
                            أضيفت في {{ $city->created_at->format('Y/m/d') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.cities.edit', $city) }}" class="action-btn btn-warning">
                    <i class="fas fa-edit"></i>
                    تعديل
                </a>
                <a href="{{ route('admin.cities.index') }}" class="action-btn btn-secondary">
                    <i class="fas fa-arrow-right"></i>
                    العودة
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stats-card" style="--bg-color-1: #3b82f6; --bg-color-2: #1e40af;">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-shopping-cart text-2xl"></i>
            </div>
            <h3 class="text-3xl font-bold mb-2">{{ number_format($stats['total_orders']) }}</h3>
            <p class="text-sm opacity-90">إجمالي الطلبات</p>
        </div>

        <div class="stats-card" style="--bg-color-1: #f59e0b; --bg-color-2: #d97706;">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <h3 class="text-3xl font-bold mb-2">{{ number_format($stats['pending_orders']) }}</h3>
            <p class="text-sm opacity-90">طلبات معلقة</p>
        </div>

        <div class="stats-card" style="--bg-color-1: #10b981; --bg-color-2: #059669;">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <h3 class="text-3xl font-bold mb-2">{{ number_format($stats['completed_orders']) }}</h3>
            <p class="text-sm opacity-90">طلبات مكتملة</p>
        </div>

        <div class="stats-card" style="--bg-color-1: #8b5cf6; --bg-color-2: #7c3aed;">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-white bg-opacity-20 rounded-full">
                <i class="fas fa-dollar-sign text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2">{{ number_format($stats['total_revenue'], 2) }}</h3>
            <p class="text-sm opacity-90">إجمالي الإيرادات (د.أ)</p>
        </div>
    </div>

    <!-- City Details and Recent Orders -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- City Details -->
        <div class="info-card">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-info-circle ml-2 text-blue-600"></i>
                تفاصيل المدينة
            </h2>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">الاسم العربي</span>
                    <span class="font-medium text-gray-900">{{ $city->name ?: $city->name_ar }}</span>
                </div>
                
                @if($city->name_en)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">الاسم الإنجليزي</span>
                    <span class="font-medium text-gray-900">{{ $city->name_en }}</span>
                </div>
                @endif
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">تكلفة التوصيل</span>
                    <span class="font-bold text-green-600">{{ $city->formatted_delivery_cost }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">مدة التوصيل</span>
                    <span class="font-medium text-orange-600">
                        {{ $city->delivery_days }} {{ $city->delivery_days == 1 ? 'يوم' : 'أيام' }}
                    </span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">إيرادات التوصيل</span>
                    <span class="font-bold text-purple-600">{{ number_format($stats['delivery_revenue'], 2) }} د.أ</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-600">الحالة</span>
                    <span class="badge {{ $city->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $city->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                </div>
            </div>

            @if($stats['total_orders'] > 0)
            <div class="mt-6 pt-6 border-t">
                <a href="{{ route('admin.cities.orders', $city) }}" class="action-btn btn-primary w-full justify-center">
                    <i class="fas fa-list"></i>
                    عرض جميع الطلبات
                </a>
            </div>
            @endif
        </div>

        <!-- Recent Orders -->
        <div class="lg:col-span-2 info-card">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-shopping-cart ml-2 text-green-600"></i>
                    أحدث الطلبات
                </div>
                @if($stats['total_orders'] > 10)
                <a href="{{ route('admin.cities.orders', $city) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    عرض الكل ({{ $stats['total_orders'] }})
                </a>
                @endif
            </h2>

            @if($city->orders->count() > 0)
                <div class="space-y-3">
                    @foreach($city->orders as $order)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center ml-3">
                                <i class="fas fa-receipt text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">طلب #{{ $order->order_number }}</div>
                                <div class="text-sm text-gray-500">{{ $order->user->name ?? 'زائر' }}</div>
                                <div class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="text-left">
                            <div class="font-bold text-gray-900">{{ number_format($order->total_amount) }} د.أ</div>
                            <div class="text-xs text-gray-500">شحن: {{ number_format($order->shipping_cost) }} د.أ</div>
                            <span class="inline-block px-2 py-1 text-xs rounded-full
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
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-medium">لا توجد طلبات</p>
                    <p class="text-sm">لم يتم تسجيل أي طلبات لهذه المدينة بعد</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection