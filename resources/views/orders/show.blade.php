@extends('layouts.main')

@section('title', 'تفاصيل الطلب #' . $order->order_number)

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ route('orders.index') }}" 
                       class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">تفاصيل الطلب #{{ $order->order_number }}</h1>
                        <p class="text-sm text-gray-600 mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                <!-- Order Status Badge -->
                <div class="flex items-center gap-2">
                    @php
                        $statusConfig = [
                            'pending' => ['color' => 'bg-yellow-100 text-yellow-800', 'text' => 'قيد المراجعة'],
                            'confirmed' => ['color' => 'bg-orange-100 text-orange-800', 'text' => 'مؤكدة'],
                            'shipped' => ['color' => 'bg-purple-100 text-purple-800', 'text' => 'تم الشحن'],
                            'delivered' => ['color' => 'bg-green-100 text-green-800', 'text' => 'تم التسليم'],
                            'cancelled' => ['color' => 'bg-red-100 text-red-800', 'text' => 'ملغية']
                        ];
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-xs sm:text-sm font-medium {{ $statusConfig[$order->status]['color'] }}">
                        {{ $statusConfig[$order->status]['text'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Order Items (Left Column - 2/3 width on desktop) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Order Items Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-100">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900">المنتجات المطلوبة ({{ $order->items->count() }})</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <div class="p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <!-- Product Image -->
                                <div class="flex-shrink-0 mx-auto sm:mx-0">
                                    @if($item->product && $item->product->images->first())
                                        <img src="{{ $item->product->images->first()->image_path }}" 
                                             alt="{{ $item->product->name }}"
                                             class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-lg">
                                    @else
                                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Product Details -->
                                <div class="flex-1 text-center sm:text-right">
                                    <h3 class="font-semibold text-gray-900 text-sm sm:text-base mb-2">
                                        {{ $item->product->name ?? 'منتج محذوف' }}
                                    </h3>
                                    
                                    <div class="text-xs sm:text-sm text-gray-600 space-y-1">
                                        <p>الكمية: <span class="font-medium">{{ $item->quantity }}</span></p>
                                        @if($item->size)
                                            <p>المقاس: <span class="font-medium">{{ $item->size }}</span></p>
                                        @endif
                                        <p>السعر الواحد: <span class="font-medium">{{ number_format($item->price, 2) }} د.أ</span></p>
                                    </div>
                                </div>
                                
                                <!-- Total Price -->
                                <div class="text-center sm:text-left">
                                    <p class="text-lg sm:text-xl font-bold text-orange-600">
                                        {{ number_format($item->total, 2) }} د.أ
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Progress (if shipped) -->
                @if($order->status == 'shipped')
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 sm:mb-6">تتبع الشحن</h3>
                    
                    <div class="relative">
                        <!-- Progress Line -->
                        <div class="absolute right-6 sm:right-8 top-8 bottom-0 w-0.5 bg-orange-200"></div>
                        <div class="absolute right-6 sm:right-8 top-8 w-0.5 bg-orange-500 transition-all duration-1000" style="height: 75%"></div>
                        
                        <div class="space-y-6 sm:space-y-8">
                            <!-- Order Confirmed -->
                            <div class="flex items-center gap-4 sm:gap-6">
                                <div class="w-3 h-3 sm:w-4 sm:h-4 bg-orange-500 rounded-full relative z-10"></div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 text-sm sm:text-base">تم تأكيد الطلب</h4>
                                    <p class="text-xs sm:text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <span class="text-xs text-green-600 font-medium">مكتمل</span>
                            </div>
                            
                            <!-- Processing -->
                            <div class="flex items-center gap-4 sm:gap-6">
                                <div class="w-3 h-3 sm:w-4 sm:h-4 bg-orange-500 rounded-full relative z-10"></div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 text-sm sm:text-base">جاري التحضير</h4>
                                    <p class="text-xs sm:text-sm text-gray-600">يتم تحضير طلبك</p>
                                </div>
                                <span class="text-xs text-green-600 font-medium">مكتمل</span>
                            </div>
                            
                            <!-- Shipped -->
                            <div class="flex items-center gap-4 sm:gap-6">
                                <div class="w-3 h-3 sm:w-4 sm:h-4 bg-orange-500 rounded-full relative z-10"></div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 text-sm sm:text-base">تم الشحن</h4>
                                    <p class="text-xs sm:text-sm text-gray-600">طلبك في الطريق إليك</p>
                                </div>
                                <span class="text-xs text-orange-600 font-medium">جارٍ</span>
                            </div>
                            
                            <!-- Delivered -->
                            <div class="flex items-center gap-4 sm:gap-6">
                                <div class="w-3 h-3 sm:w-4 sm:h-4 bg-gray-300 rounded-full relative z-10"></div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-400 text-sm sm:text-base">تم التسليم</h4>
                                    <p class="text-xs sm:text-sm text-gray-400">خلال 2-3 أيام عمل</p>
                                </div>
                                <span class="text-xs text-gray-400 font-medium">قريباً</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Order Summary & Actions (Right Column - 1/3 width on desktop) -->
            <div class="space-y-6">
                
                <!-- Order Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 sm:mb-6">ملخص الطلب</h3>
                    
                    <div class="space-y-3 sm:space-y-4">
                        <div class="flex justify-between items-center text-sm sm:text-base">
                            <span class="text-gray-600">المجموع الفرعي:</span>
                            <span class="font-medium">{{ number_format($order->subtotal ?? $order->items->sum('total'), 2) }} د.أ</span>
                        </div>
                        
                        @if($order->shipping_cost > 0)
                        <div class="flex justify-between items-center text-sm sm:text-base">
                            <span class="text-gray-600">رسوم الشحن:</span>
                            <span class="font-medium">{{ number_format($order->shipping_cost, 2) }} د.أ</span>
                        </div>
                        @endif
                        
                        @if($order->tax_amount > 0)
                        <div class="flex justify-between items-center text-sm sm:text-base">
                            <span class="text-gray-600">الضريبة:</span>
                            <span class="font-medium">{{ number_format($order->tax_amount, 2) }} د.أ</span>
                        </div>
                        @endif
                        
                        <div class="border-t border-gray-200 pt-3 sm:pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">المجموع الكلي:</span>
                                <span class="text-lg sm:text-xl font-bold text-orange-600">{{ number_format($order->total_amount, 2) }} د.أ</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 sm:mb-6">معلومات التسليم</h3>
                    
                    <div class="space-y-3 sm:space-y-4">
                        <div>
                            <h4 class="font-medium text-gray-900 text-sm sm:text-base mb-1">عنوان التسليم:</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $order->shipping_address }}</p>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-900 text-sm sm:text-base mb-1">رقم الهاتف:</h4>
                            <p class="text-sm text-gray-600">{{ $order->phone }}</p>
                        </div>
                        
                        @if($order->notes)
                        <div>
                            <h4 class="font-medium text-gray-900 text-sm sm:text-base mb-1">ملاحظات:</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $order->notes }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <h4 class="font-medium text-gray-900 text-sm sm:text-base mb-1">طريقة الدفع:</h4>
                            <p class="text-sm text-gray-600">
                                @if($order->payment_method === 'cod')
                                    الدفع عند الاستلام
                                @elseif($order->payment_method === 'card')
                                    بطاقة ائتمانية
                                @else
                                    {{ $order->payment_method }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                
                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 sm:mb-6">الإجراءات</h3>
                    
                    <div class="space-y-3">
                        @if($order->status !== 'cancelled')
                        <!-- Download Invoice -->
                        <a href="{{ route('orders.download', $order->order_number) }}" 
                           class="w-full bg-orange-500 text-white py-3 px-4 rounded-xl hover:bg-orange-600 transition-colors font-medium text-center inline-block text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            تحميل الفاتورة
                        </a>
                        
                        @if($order->status === 'delivered')
                        <!-- Reorder -->
                        <button onclick="reorderItems('{{ $order->order_number }}')" 
                                class="w-full bg-green-500 text-white py-3 px-4 rounded-xl hover:bg-green-600 transition-colors font-medium text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            إعادة الطلب
                        </button>
                        @endif
                        
                        @if($order->status === 'pending')
                        <!-- Cancel Order -->
                        <button onclick="cancelOrder('{{ $order->order_number }}')" 
                                class="w-full bg-red-500 text-white py-3 px-4 rounded-xl hover:bg-red-600 transition-colors font-medium text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            إلغاء الطلب
                        </button>
                        @endif
                        @endif
                        
                        <!-- Contact Support -->
                        <a href="#" class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-xl hover:bg-gray-200 transition-colors font-medium text-center inline-block text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            تواصل مع الدعم
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Reorder functionality
function reorderItems(orderNumber) {
    if (confirm('هل تريد إضافة جميع منتجات هذا الطلب إلى سلة التسوق؟')) {
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
                alert(data.message);
                window.location.href = '{{ route("cart") }}';
            } else {
                alert('حدث خطأ في إعادة الطلب');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ في الاتصال');
        });
    }
}

// Cancel order functionality
function cancelOrder(orderNumber) {
    const reason = prompt('يرجى إدخال سبب إلغاء الطلب (اختياري):');
    if (reason !== null) { // User didn't press cancel
        fetch(`/orders/${orderNumber}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                reason: reason
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'حدث خطأ في إلغاء الطلب');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ في الاتصال');
        });
    }
}
</script>
@endsection
