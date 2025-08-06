@extends('admin.layout')

@section('title', 'إدارة الطلبات')
@section('page-title', 'إدارة الطلبات')
@section('page-description', 'عرض وإدارة جميع طلبات العملاء')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">إجمالي الطلبات</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_orders']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">إجمالي الإيرادات</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_revenue'], 2) }} د.أ</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">طلبات في الانتظار</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['pending_orders']) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">طلبات مكتملة</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['completed_orders']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4 space-x-reverse">
            <a href="{{ route('admin.orders.report') }}" 
               class="bg-orange-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                <i class="fas fa-chart-line ml-2"></i>
                تقرير المبيعات
            </a>
        </div>
        
        <!-- Bulk Actions -->
        <div class="bulk-actions hidden">
            <div class="flex items-center space-x-2 space-x-reverse">
                <select id="bulk-action" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">اختر عملية...</option>
                    <option value="mark_processing">قيد المعالجة</option>
                    <option value="mark_shipped">تم الشحن</option>
                    <option value="mark_delivered">تم التسليم</option>
                </select>
                <button onclick="executeBulkAction()" 
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700">
                    تنفيذ
                </button>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">البحث</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="رقم الطلب، اسم العميل..."
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">حالة الطلب</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <option value="">جميع الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">من تاريخ</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">إلى تاريخ</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            </div>
            
            <div class="md:col-span-4 flex items-center space-x-2 space-x-reverse">
                <button type="submit" 
                        class="bg-orange-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                    <i class="fas fa-search ml-2"></i>
                    بحث
                </button>
                <a href="{{ route('admin.orders.index') }}" 
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-gray-600 transition-colors">
                    <i class="fas fa-times ml-2"></i>
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>
    
    <!-- Orders Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" onchange="toggleAllCheckboxes(this)" 
                                       class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                رقم الطلب
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                العميل
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                العناصر
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                المجموع
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الحالة
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                التاريخ
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="selected_items[]" value="{{ $order->id }}" 
                                           class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        #{{ $order->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white text-sm font-bold ml-3">
                                            {{ substr($order->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $order->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $order->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->items->count() }} منتج
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ number_format($order->total_amount, 2) }} د.أ
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-purple-100 text-purple-800',
                                            'delivered' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusTexts = [
                                            'pending' => 'في الانتظار',
                                            'processing' => 'قيد المعالجة',
                                            'shipped' => 'تم الشحن',
                                            'delivered' => 'تم التسليم',
                                            'cancelled' => 'ملغي',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusTexts[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('Y/m/d') }}
                                    <br>
                                    <span class="text-xs">{{ $order->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2 space-x-reverse">
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="text-blue-600 hover:text-blue-900" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($order->status === 'cancelled')
                                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" 
                                                  class="inline" onsubmit="return confirmDelete('هل أنت متأكد من حذف هذا الطلب؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="bg-white px-6 py-3 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد طلبات</h3>
                <p class="text-gray-500">لم يتم العثور على طلبات بناءً على الفلاتر المحددة</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function executeBulkAction() {
        const action = document.getElementById('bulk-action').value;
        const selectedItems = Array.from(document.querySelectorAll('input[name="selected_items[]"]:checked')).map(cb => cb.value);
        
        if (!action) {
            alert('يرجى اختيار عملية');
            return;
        }
        
        if (selectedItems.length === 0) {
            alert('يرجى اختيار طلبات للعملية');
            return;
        }
        
        if (!confirm(`هل أنت متأكد من تنفيذ هذه العملية على ${selectedItems.length} طلب؟`)) {
            return;
        }
        
        fetch('{{ route("admin.orders.bulk-action") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                action: action,
                order_ids: selectedItems
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                showNotification('success', data.message);
                location.reload();
            } else if (data.error) {
                showNotification('error', data.error);
            }
        })
        .catch(error => {
            showNotification('error', 'حدث خطأ أثناء تنفيذ العملية');
        });
    }
</script>
@endpush




