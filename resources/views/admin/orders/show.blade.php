@extends('admin.layout')

@section('title', 'تفاصيل الطلب #' . $order->id)
@section('page-title', 'تفاصيل الطلب #' . $order->id)
@section('page-description', 'عرض تفاصيل الطلب ومعلومات العميل')

@section('content')
<div class="space-y-6">
    <!-- Order Header -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">طلب رقم #{{ $order->id }}</h3>
                <p class="text-gray-600">تاريخ الطلب: {{ $order->created_at->format('Y/m/d H:i') }}</p>
            </div>
            
            <!-- Order Status -->
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                    'shipped' => 'bg-purple-100 text-purple-800 border-purple-200',
                    'delivered' => 'bg-green-100 text-green-800 border-green-200',
                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                ];
                $statusTexts = [
                    'pending' => 'في الانتظار',
                    'processing' => 'قيد المعالجة',
                    'shipped' => 'تم الشحن',
                    'delivered' => 'تم التسليم',
                    'cancelled' => 'ملغي',
                ];
            @endphp
            <span class="px-4 py-2 text-sm font-medium rounded-lg border {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                {{ $statusTexts[$order->status] ?? $order->status }}
            </span>
        </div>
        
        <!-- Update Status Form -->
        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="flex items-center space-x-4 space-x-reverse">
            @csrf
            @method('PATCH')
            
            <div class="flex-1">
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>في الانتظار</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                </select>
            </div>
            
            <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                تحديث الحالة
            </button>
        </form>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Items -->
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">عناصر الطلب</h3>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center space-x-4 space-x-reverse p-4 border border-gray-200 rounded-lg">
                            @if($item->product && $item->product->images->first())
                                <img src="{{ $item->product->images->first()->image_path }}" 
                                     alt="{{ $item->product->name }}"
                                     class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">
                                    {{ $item->product->name ?? 'منتج محذوف' }}
                                </h4>
                                <div class="text-sm text-gray-600 space-y-1">
                                    <p>الكمية: {{ $item->quantity }}</p>
                                    @if($item->size)
                                        <p>المقاس: {{ $item->size }}</p>
                                    @endif
                                    <p>السعر: {{ number_format($item->price, 2) }} د.أ</p>
                                </div>
                            </div>
                            
                            <div class="text-left">
                                <p class="font-bold text-gray-900">{{ number_format($item->total, 2) }} د.أ</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Order Summary -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">المجموع الفرعي:</span>
                            <span class="font-medium">{{ number_format($order->items->sum('total'), 2) }} د.أ</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold">
                            <span>المجموع الكلي:</span>
                            <span>{{ number_format($order->total_amount, 2) }} د.أ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Customer & Order Info -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات العميل</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($order->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                        </div>
                    </div>
                    
                    @if($order->user->phone)
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-phone ml-2"></i>
                            {{ $order->user->phone }}
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Order Statistics -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">إحصائيات الطلب</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">عدد العناصر:</span>
                        <span class="font-medium">{{ $order->items->count() }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">إجمالي الكمية:</span>
                        <span class="font-medium">{{ $order->items->sum('quantity') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">متوسط سعر المنتج:</span>
                        <span class="font-medium">{{ number_format($order->items->avg('price'), 2) }} د.أ</span>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">إجراءات</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.orders.index') }}" 
                       class="w-full bg-gray-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors block text-center">
                        <i class="fas fa-arrow-right ml-2"></i>
                        العودة للطلبات
                    </a>
                    
                    @if($order->status === 'cancelled')
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" 
                              onsubmit="return confirmDelete('هل أنت متأكد من حذف هذا الطلب؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-600 transition-colors">
                                <i class="fas fa-trash ml-2"></i>
                                حذف الطلب
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




