@extends('admin.layout')

@section('title', 'طلبات ' . $city->display_name)
@section('page-title', 'طلبات المدينة')
@section('page-description', 'جميع الطلبات المسجلة لمدينة ' . $city->display_name)

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 32px;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 24px 0;
    }
    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .stat-value {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .orders-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .filter-bar {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
    }
    .order-row {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .order-row:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        transform: translateY(-2px);
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 600;
        gap: 4px;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-processing { background: #dbeafe; color: #1e40af; }
    .status-shipped { background: #e0e7ff; color: #5b21b6; }
    .status-delivered { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
    
    .filter-input {
        padding: 8px 16px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
    }
    .filter-input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .action-btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
    }
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }
    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: white;
        text-decoration: none;
    }
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 24px;
        padding: 20px 0;
    }
    .pagination .page-link {
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .pagination .page-link:hover,
    .pagination .page-link.active {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">طلبات {{ $city->display_name }}</h1>
            <p class="text-lg opacity-90">إدارة ومتابعة جميع الطلبات المسجلة لهذه المدينة</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.cities.show', $city) }}" class="action-btn btn-secondary">
                <i class="fas fa-eye"></i>
                عرض المدينة
            </a>
            <a href="{{ route('admin.cities.index') }}" class="action-btn btn-secondary">
                <i class="fas fa-arrow-right"></i>
                العودة للمدن
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $orders->total() }}</div>
            <div class="text-sm opacity-90">إجمالي الطلبات</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($totalRevenue, 2) }}</div>
            <div class="text-sm opacity-90">إجمالي الإيرادات (د.أ)</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($deliveryRevenue, 2) }}</div>
            <div class="text-sm opacity-90">إيرادات التوصيل (د.أ)</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($avgOrderValue, 2) }}</div>
            <div class="text-sm opacity-90">متوسط قيمة الطلب (د.أ)</div>
        </div>
    </div>
</div>

<!-- Orders Management -->
<div class="orders-card">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900 flex items-center">
            <i class="fas fa-shopping-cart ml-3 text-blue-600"></i>
            قائمة الطلبات
        </h2>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-600">
                عرض {{ $orders->firstItem() ?? 0 }} إلى {{ $orders->lastItem() ?? 0 }} من {{ $orders->total() }} طلب
            </span>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-bar">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">رقم الطلب</label>
                <input type="text" name="order_number" value="{{ request('order_number') }}" 
                       placeholder="رقم الطلب" class="filter-input">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">اسم العميل</label>
                <input type="text" name="customer_name" value="{{ request('customer_name') }}" 
                       placeholder="اسم العميل" class="filter-input">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">حالة الطلب</label>
                <select name="status" class="filter-input">
                    <option value="">جميع الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">من تاريخ</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="filter-input">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">إلى تاريخ</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="filter-input">
            </div>
            
            <div class="flex items-end gap-2">
                <button type="submit" class="action-btn btn-primary">
                    <i class="fas fa-search"></i>
                    بحث
                </button>
                <a href="{{ route('admin.cities.orders', $city) }}" class="action-btn btn-secondary">
                    <i class="fas fa-refresh"></i>
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
        <div class="space-y-3">
            @foreach($orders as $order)
            <div class="order-row clickable-row" data-href="{{ route('admin.orders.show', $order->id) }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 items-center">
                    <!-- Order Info -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center ml-3">
                                <i class="fas fa-receipt text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">#{{ $order->order_number }}</div>
                                <div class="text-sm text-gray-500">{{ $order->created_at->format('Y/m/d H:i') }}</div>
                                <div class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer -->
                    <div>
                        <div class="font-medium text-gray-900">{{ $order->user->name ?? 'زائر' }}</div>
                        <div class="text-sm text-gray-500">{{ $order->customer_email ?? $order->user->email ?? 'غير محدد' }}</div>
                        <div class="text-xs text-gray-400">{{ $order->customer_phone ?? $order->user->phone ?? 'لا يوجد رقم' }}</div>
                    </div>

                    <!-- Amount -->
                    <div class="text-center">
                        <div class="font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} د.أ</div>
                        <div class="text-sm text-gray-500">شحن: {{ number_format($order->shipping_cost, 2) }} د.أ</div>
                        <div class="text-xs text-gray-400">صافي: {{ number_format($order->total_amount - $order->shipping_cost, 2) }} د.أ</div>
                    </div>

                    <!-- Status -->
                    <div class="text-center">
                        <span class="status-badge status-{{ $order->status }}">
                            <i class="fas fa-{{ 
                                $order->status == 'pending' ? 'clock' : 
                                ($order->status == 'processing' ? 'cog' : 
                                ($order->status == 'shipped' ? 'truck' : 
                                ($order->status == 'delivered' ? 'check-circle' : 'times-circle'))) 
                            }}"></i>
                            {{ 
                                $order->status == 'pending' ? 'في الانتظار' :
                                ($order->status == 'processing' ? 'قيد المعالجة' :
                                ($order->status == 'shipped' ? 'تم الشحن' :
                                ($order->status == 'delivered' ? 'تم التوصيل' :
                                ($order->status == 'cancelled' ? 'ملغي' : $order->status))))
                            }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="action-btn btn-primary" onclick="event.stopPropagation()">
                                <i class="fas fa-eye"></i>
                                عرض
                            </a>
                            @if($order->status == 'pending')
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline"
                                  onclick="event.stopPropagation()">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="processing">
                                <button type="submit" class="action-btn btn-success">
                                    <i class="fas fa-play"></i>
                                    معالجة
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items Preview -->
                @if($order->orderItems && $order->orderItems->count() > 0)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-box text-gray-400"></i>
                        <span class="font-medium">المنتجات:</span>
                        @foreach($order->orderItems->take(3) as $item)
                            <span class="bg-gray-100 px-2 py-1 rounded text-xs">
                                {{ $item->product_name }} ({{ $item->quantity }})
                            </span>
                        @endforeach
                        @if($order->orderItems->count() > 3)
                            <span class="text-gray-400">+{{ $order->orderItems->count() - 3 }} أخرى</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shopping-cart text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">لا توجد طلبات</h3>
            <p class="text-gray-500 mb-6">لم يتم العثور على طلبات تطابق معايير البحث المحددة</p>
            <a href="{{ route('admin.cities.orders', $city) }}" class="action-btn btn-primary">
                <i class="fas fa-refresh"></i>
                عرض جميع الطلبات
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle clickable rows
    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('a, button, form')) {
                window.location.href = this.dataset.href;
            }
        });
    });

    // Auto-submit form on status change
    document.querySelector('select[name="status"]').addEventListener('change', function() {
        if (this.value !== '') {
            this.closest('form').submit();
        }
    });

    // Quick status update
    document.querySelectorAll('form[action*="updateStatus"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('هل أنت متأكد من تغيير حالة هذا الطلب؟')) {
                fetch(this.action, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        status: this.querySelector('input[name="status"]').value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('حدث خطأ في تحديث حالة الطلب');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('حدث خطأ في تحديث حالة الطلب');
                });
            }
        });
    });
});
</script>
@endpush
@endsection