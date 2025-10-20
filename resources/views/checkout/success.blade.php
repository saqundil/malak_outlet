@extends('layouts.main')

@section('title', 'تم الطلب بنجاح - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="text-4xl font-bold text-gray-800 mb-4">تم تأكيد طلبك بنجاح!</h1>
            <p class="text-xl text-gray-600 mb-8">شكراً لك على ثقتك بمتجر ملاك</p>

            <!-- Order Details -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8 text-right">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">تفاصيل الطلب</h2>
                
                @if($order)
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="font-medium">رقم الطلب:</span>
                        <span class="text-blue-600 font-bold">#{{ $order->order_number }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="font-medium">التاريخ:</span>
                        <span>{{ $order->created_at->format('Y/m/d H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="font-medium">الإجمالي:</span>
                        <span class="text-green-600 font-bold">{{ number_format($order->total_amount, 2) }} د.أ</span>
                    </div>
                    
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="font-medium">طريقة الدفع:</span>
                        <span>{{ $order->payment_method === 'cod' ? 'الدفع عند الاستلام' : 'دفع إلكتروني' }}</span>
                    </div>
                    
                    <div class="flex justify-between items-start border-b pb-2">
                        <span class="font-medium">عنوان الشحن:</span>
                        <span class="text-left max-w-xs">{{ $order->shipping_address }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="font-medium">رقم الهاتف:</span>
                        <span>{{ $order->phone }}</span>
                    </div>
                    
                    @if($order->notes)
                    <div class="flex justify-between items-start border-b pb-2">
                        <span class="font-medium">ملاحظات:</span>
                        <span class="text-left max-w-xs">{{ $order->notes }}</span>
                    </div>
                    @endif
                </div>

                <!-- Order Items -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">المنتجات المطلوبة:</h3>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="flex justify-between items-center bg-gray-50 p-3 rounded">
                            <div class="flex items-center gap-3">
                                @if($item->product && $item->product->images->first())
                                    <img src="{{ $item->product->images->first()->image_path }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-xs text-gray-500">{{ $item->product ? substr($item->product->name, 0, 2) : 'N/A' }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium">{{ $item->product ? $item->product->name : 'منتج محذوف' }}</p>
                                    <p class="text-sm text-gray-600">الكمية: {{ $item->quantity }}</p>
                                    @if($item->size)
                                        <p class="text-sm text-gray-600">المقاس: {{ $item->size }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="font-semibold">{{ number_format($item->total, 2) }} د.أ</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="font-medium">رقم الطلب:</span>
                        <span class="text-blue-600 font-bold">#{{ session('last_order_number', '001') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="font-medium">التاريخ:</span>
                        <span>{{ now()->format('Y/m/d H:i') }}</span>
                    </div>
                    
                    <div class="text-center text-gray-600">
                        <p>تم إنشاء طلبك بنجاح وسيتم مراجعته قريباً</p>
                    </div>
                </div>
                @endif
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-blue-800 mb-4">الخطوات التالية</h3>
                <div class="space-y-3 text-blue-700">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>سيتم مراجعة طلبك خلال 24 ساعة</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>سيتم التواصل معك لتأكيد التفاصيل</span>
                    </div>
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>الشحن خلال 2-5 أيام عمل</span>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-gray-100 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">هل تحتاج مساعدة؟</h3>
                <div class="space-y-2 text-gray-600">
                    <p>يمكنك التواصل معنا عبر:</p>
                    <div class="flex justify-center space-x-6 space-x-reverse">
                        <a href="tel:+962790000000" class="flex items-center text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                            </svg>
                            +962 79 000 0000
                        </a>
                        <a href="mailto:support@malak-outlet.com" class="flex items-center text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            support@malak-outlet.com
                        </a>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4 sm:space-y-0 sm:flex sm:space-x-4 sm:space-x-reverse sm:justify-center">
                <a href="{{ route('orders.index') }}" 
                   class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                    عرض طلباتي
                </a>
                <a href="{{ route('products.index') }}" 
                   class="inline-block bg-gray-600 text-white px-8 py-3 rounded-lg hover:bg-gray-700 transition duration-200 font-medium">
                    متابعة التسوق
                </a>
            </div>

            <!-- Social Share -->
            <div class="mt-12 pt-8 border-t">
                <p class="text-gray-600 mb-4">شارك تجربتك مع أصدقائك</p>
                <div class="flex justify-center space-x-4 space-x-reverse">
                    <a href="#" class="text-blue-600 hover:text-blue-800">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-blue-600 hover:text-blue-800">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-green-600 hover:text-green-800">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.108"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




