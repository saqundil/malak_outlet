@extends('layouts.main')

@section('title', 'تفاصيل عناصر الطلب #' . $order->order_number . ' - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" dir="rtl">
    <!-- Professional Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="h-12 w-12 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-receipt text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">تفاصيل فاتورة الطلب</h1>
                        <div class="flex items-center space-x-3 space-x-reverse mt-1">
                            <span class="text-sm text-gray-500">رقم الطلب:</span>
                            <span class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">#{{ $order->order_number }}</span>
                            <span class="text-xs text-gray-400">•</span>
                            <span class="text-sm text-gray-500">{{ $order->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 space-x-reverse">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $order->status_badge_class }}">
                        {{ $order->status_arabic ?? $order->status }}
                    </span>
                    <a href="{{ route('orders.show', $order->order_number) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200">
                        <i class="fas fa-arrow-right ml-2"></i>
                        عودة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-8">
        <!-- Professional Info Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center space-x-3 space-x-reverse mb-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-sm"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">معلومات العميل</h3>
                </div>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">{{ $order->user->name ?? $order->customer_name }}</p>
                    <p class="text-sm text-gray-500">{{ $order->user->email ?? $order->customer_email }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center space-x-3 space-x-reverse mb-3">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-phone text-green-600 text-sm"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">الاتصال</h3>
                </div>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">{{ $order->phone ?? 'غير محدد' }}</p>
                    <p class="text-sm text-gray-500">الهاتف الأساسي</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center space-x-3 space-x-reverse mb-3">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-credit-card text-purple-600 text-sm"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">الدفع</h3>
                </div>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">
                        @switch($order->payment_method)
                            @case('cash_on_delivery')
                                الدفع عند الاستلام
                                @break
                            @case('credit_card')
                                بطاقة ائتمانية
                                @break
                            @case('bank_transfer')
                                تحويل بنكي
                                @break
                            @default
                                {{ $order->payment_method }}
                        @endswitch
                    </p>
                    <p class="text-sm text-gray-500">طريقة الدفع</p>
                </div>
            </div>
        </div>

        <!-- Professional Main Layout -->
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            
            <!-- Items List - Professional Table Design -->
            <div class="xl:col-span-3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-list text-white"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">تفاصيل المنتجات</h2>
                                    <p class="text-sm text-gray-500">{{ $pricingBreakdown['items_count'] }} منتج في هذا الطلب</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-blue-600">{{ number_format($pricingBreakdown['subtotal'], 2) }}</p>
                                <p class="text-xs text-gray-500">المجموع الفرعي</p>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-8 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المنتج</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">السعر</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">الكمية</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">المقاس</th>
                                    <th class="px-8 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">المجموع</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($order->items as $index => $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-25' }}">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4 space-x-reverse">
                                            <div class="flex-shrink-0">
                                                @if($item->product && $item->product->images->count() > 0)
                                                    <img class="h-16 w-16 rounded-xl object-cover ring-2 ring-gray-100"
                                                         src="{{ asset('images/' . $item->product->images->first()->image_path) }}"
                                                         alt="{{ $item->product->name }}">
                                                @else
                                                    <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center ring-2 ring-gray-100">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ $item->product->name ?? 'منتج غير متاح' }}
                                                </h4>
                                                @if($item->product && $item->product->category)
                                                    <p class="text-xs text-gray-500 mt-1">{{ $item->product->category->name }}</p>
                                                @endif
                                                <div class="flex items-center space-x-2 space-x-reverse mt-2">
                                                    @if($item->product && $item->product->status === 'active')
                                                        <a href="{{ route('products.show', $item->product->id) }}" 
                                                           class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                                            عرض المنتج
                                                        </a>
                                                    @endif
                                                    <button type="button" 
                                                            onclick="addToCart({{ $item->product_id ?? 0 }}, {{ $item->quantity }})"
                                                            class="text-xs text-green-600 hover:text-green-800 font-medium">
                                                        إضافة للسلة
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <span class="text-sm font-semibold text-gray-900">{{ number_format($item->price, 2) }}</span>
                                        <p class="text-xs text-gray-500">د.أ</p>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg text-sm font-bold text-gray-900">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        @if($item->size)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $item->size }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <span class="text-lg font-bold text-gray-900">{{ number_format($item->total, 2) }}</span>
                                        <p class="text-xs text-gray-500">د.أ</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Professional Sidebar -->
            <div class="xl:col-span-1">
                <div class="space-y-6">
                    
                    <!-- Invoice Summary Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white">ملخص الفاتورة</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Subtotal -->
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm text-gray-600">المجموع الفرعي</span>
                                <span class="font-semibold text-gray-900">{{ number_format($pricingBreakdown['subtotal'], 2) }} د.أ</span>
                            </div>
                            
                            <!-- Tax -->
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm text-gray-600">الضريبة ({{ number_format($pricingBreakdown['tax_rate'], 0) }}%)</span>
                                <span class="font-semibold text-gray-900">{{ number_format($pricingBreakdown['tax_amount'], 2) }} د.أ</span>
                            </div>
                            
                            <!-- Shipping -->
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm text-gray-600">رسوم الشحن</span>
                                <span class="font-semibold text-gray-900">{{ number_format($pricingBreakdown['shipping_cost'], 2) }} د.أ</span>
                            </div>
                            
                            <hr class="border-gray-200">
                            
                            <!-- Total -->
                            <div class="flex justify-between items-center py-3 bg-gray-50 rounded-xl px-4">
                                <span class="text-lg font-bold text-gray-900">المجموع الإجمالي</span>
                                <span class="text-2xl font-bold text-blue-600">{{ number_format($pricingBreakdown['total'], 2) }} د.أ</span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Actions -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">إجراءات الطلب</h3>
                        <div class="space-y-3">
                            <!-- Download Invoice -->
                            <a href="{{ route('orders.download', $order->order_number) }}" 
                               class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-download ml-2"></i>
                                تحميل الفاتورة
                            </a>
                            
                            @if(in_array($order->status, ['pending', 'processing']))
                                <!-- Cancel Order -->
                                <button type="button"
                                        onclick="cancelOrder('{{ $order->order_number }}')"
                                        class="w-full flex items-center justify-center px-4 py-3 bg-red-50 hover:bg-red-100 text-red-700 hover:text-red-800 font-semibold rounded-xl border border-red-200 hover:border-red-300 transition-all duration-200">
                                    <i class="fas fa-times ml-2"></i>
                                    إلغاء الطلب
                                </button>
                            @else
                                <!-- Reorder -->
                                <button type="button"
                                        onclick="reorderItems('{{ $order->order_number }}')"
                                        class="w-full flex items-center justify-center px-4 py-3 bg-green-50 hover:bg-green-100 text-green-700 hover:text-green-800 font-semibold rounded-xl border border-green-200 hover:border-green-300 transition-all duration-200">
                                    <i class="fas fa-redo ml-2"></i>
                                    إعادة طلب جميع المنتجات
                                </button>
                            @endif
                            
                            <!-- View Order Details -->
                            <a href="{{ route('orders.show', $order->order_number) }}" 
                               class="w-full flex items-center justify-center px-4 py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 hover:text-gray-800 font-semibold rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-200">
                                <i class="fas fa-eye ml-2"></i>
                                عرض تفاصيل الطلب
                            </a>
                        </div>
                    </div>

                    <!-- Order Status Timeline -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">حالة الطلب</h3>
                        <div class="space-y-4">
                            <!-- Order Placed -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-3 h-3 bg-green-500 rounded-full ring-4 ring-green-100"></div>
                                <div class="mr-4">
                                    <p class="text-sm font-semibold text-gray-900">تم إنشاء الطلب</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y، h:i A') }}</p>
                                </div>
                            </div>

                            @if($order->status !== 'pending')
                            <!-- Processing -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-3 h-3 bg-blue-500 rounded-full ring-4 ring-blue-100"></div>
                                <div class="mr-4">
                                    <p class="text-sm font-semibold text-gray-900">قيد المعالجة</p>
                                    <p class="text-xs text-gray-500">{{ $order->updated_at->format('d M Y، h:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($order->shipped_at)
                            <!-- Shipped -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-3 h-3 bg-yellow-500 rounded-full ring-4 ring-yellow-100"></div>
                                <div class="mr-4">
                                    <p class="text-sm font-semibold text-gray-900">تم الشحن</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order->shipped_at)->format('d M Y، h:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($order->delivered_at)
                            <!-- Delivered -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-3 h-3 bg-green-600 rounded-full ring-4 ring-green-100"></div>
                                <div class="mr-4">
                                    <p class="text-sm font-semibold text-gray-900">تم التسليم</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order->delivered_at)->format('d M Y، h:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($order->cancelled_at)
                            <!-- Cancelled -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-3 h-3 bg-red-500 rounded-full ring-4 ring-red-100"></div>
                                <div class="mr-4">
                                    <p class="text-sm font-semibold text-gray-900">تم الإلغاء</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($order->cancelled_at)->format('d M Y، h:i A') }}</p>
                                    @if($order->cancellation_reason)
                                        <p class="text-xs text-red-600 mt-1">{{ $order->cancellation_reason }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function addToCart(productId, quantity = 1) {
    if (!productId) {
        alert('هذا المنتج غير متاح حاليا');
        return;
    }
    
    // Add to cart logic (implement based on your cart system)
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('تمت إضافة المنتج للسلة بنجاح');
        } else {
            alert('حدث خطأ في إضافة المنتج للسلة');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ في إضافة المنتج للسلة');
    });
}

function cancelOrder(orderNumber) {
    if (confirm('هل أنت متأكد من إلغاء هذا الطلب؟')) {
        fetch(`/orders/${orderNumber}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ في إلغاء الطلب');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ في إلغاء الطلب');
        });
    }
}

function reorderItems(orderNumber) {
    if (confirm('هل تريد إعادة طلب جميع العناصر؟')) {
        fetch(`/orders/${orderNumber}/reorder`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('تم إضافة العناصر للسلة بنجاح');
                window.location.href = '/cart';
            } else {
                alert('حدث خطأ في إعادة الطلب');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ في إعادة الطلب');
        });
    }
}
</script>
@endpush
@endsection
