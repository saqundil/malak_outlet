@extends('layouts.main')

@section('title', 'إتمام الطلب - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">إتمام الطلب</h1>
            <p class="text-xl opacity-90">خطوة واحدة أخيرة لإتمام طلبك</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        @if(empty($cartItems))
            <div class="max-w-2xl mx-auto text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6M9 19h6"></path>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-600 mb-2">السلة فارغة</h2>
                <p class="text-gray-500 mb-6">يجب إضافة منتجات للسلة قبل إتمام الطلب</p>
                <a href="{{ route('products.index') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                    تصفح المنتجات
                </a>
            </div>
        @else
            <div class="max-w-6xl mx-auto">
                <form action="{{ route('checkout.store') }}" method="POST" class="lg:grid lg:grid-cols-2 lg:gap-12">
                    @csrf
                    
                    <!-- Shipping & Payment Information -->
                    <div class="space-y-8">
                        <!-- Shipping Information -->
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">معلومات الشحن</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل</label>
                                    <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" readonly>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف *</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="05xxxxxxxx">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">عنوان الشحن *</label>
                                    <textarea id="shipping_address" name="shipping_address" rows="4" required
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              placeholder="المدينة، الحي، اسم الشارع، رقم المبنى، رقم الشقة">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">ملاحظات إضافية</label>
                                    <textarea id="notes" name="notes" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              placeholder="أي ملاحظات خاصة بالطلب...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">طريقة الدفع</h3>
                            
                            <div class="space-y-4">
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="cash" class="ml-3" checked>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-green-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <div>
                                            <div class="font-medium">الدفع عند الاستلام</div>
                                            <div class="text-sm text-gray-500">ادفع نقداً عند وصول الطلب</div>
                                        </div>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="card" class="ml-3">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-blue-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        <div>
                                            <div class="font-medium">الدفع بالبطاقة الائتمانية</div>
                                            <div class="text-sm text-gray-500">فيزا، ماستركارد، مدى</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-8 lg:mt-0">
                        <div class="bg-white rounded-lg shadow-md p-8 sticky top-4">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">ملخص الطلب</h3>
                            
                            <div class="space-y-4 mb-6">
                                @foreach($cartItems as $item)
                                    <div class="flex items-center space-x-4 space-x-reverse">
                                        @if($item['product']->images->first())
                                            <img src="{{ $item['product']->images->first()->image_url }}" 
                                                 alt="{{ $item['product']->name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-800">{{ $item['product']->name }}</h4>
                                            <div class="flex justify-between items-center mt-1">
                                                <span class="text-sm text-gray-600">الكمية: {{ $item['quantity'] }}</span>
                                                <span class="font-medium">{{ number_format($item['subtotal'], 2) }} د.أ</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between">
                                    <span>المجموع الفرعي:</span>
                                    <span>{{ number_format($total, 2) }} د.أ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>الشحن:</span>
                                    <span class="text-green-600">مجاني</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>الضريبة (15%):</span>
                                    <span>{{ number_format($total * 0.15, 2) }} د.أ</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold border-t pt-2">
                                    <span>الإجمالي:</span>
                                    <span>{{ number_format($total * 1.15, 2) }} د.أ</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-lg hover:bg-green-700 transition duration-200 font-medium text-lg mt-6">
                                تأكيد الطلب
                            </button>

                            <div class="mt-4 text-center">
                                <a href="{{ route('cart') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    العودة إلى السلة
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
