@extends('layouts.main')

@section('title', 'طلباتي - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">طلباتي</h1>
            <p class="text-lg opacity-90">تتبع حالة طلباتك وتاريخ مشترياتك</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Filter Tabs -->
        <div class="bg-white rounded-xl shadow-lg mb-8">
            <div class="flex flex-wrap border-b border-gray-200">
                <button class="px-6 py-4 text-blue-600 border-b-2 border-blue-600 font-semibold order-filter active" data-status="all">
                    جميع الطلبات
                </button>
                <button class="px-6 py-4 text-gray-600 hover:text-blue-600 font-semibold order-filter" data-status="pending">
                    قيد المراجعة
                </button>
                <button class="px-6 py-4 text-gray-600 hover:text-blue-600 font-semibold order-filter" data-status="confirmed">
                    مؤكدة
                </button>
                <button class="px-6 py-4 text-gray-600 hover:text-blue-600 font-semibold order-filter" data-status="shipped">
                    تم الشحن
                </button>
                <button class="px-6 py-4 text-gray-600 hover:text-blue-600 font-semibold order-filter" data-status="delivered">
                    تم التسليم
                </button>
                <button class="px-6 py-4 text-gray-600 hover:text-blue-600 font-semibold order-filter" data-status="cancelled">
                    ملغية
                </button>
            </div>
        </div>

        <!-- Orders List -->
        <div class="space-y-6" id="orders-container">
            @foreach($orders as $order)
            <!-- Order {{ $loop->iteration }} - {{ ucfirst($order->status) }} -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden order-item" data-status="{{ $order->status }}" data-order-id="{{ $order->order_number }}">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">طلب رقم #{{ $order->order_number }}</h3>
                            <p class="text-gray-600">تاريخ الطلب: {{ $order->created_at->format('j F Y') }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="{{ $order->status_badge_class }} px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $order->status_arabic }}
                            </span>
                            <span class="text-lg font-bold text-gray-800">{{ number_format($order->total_amount, 2) }} د.أ</span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Order Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                @if($item->product && $item->product->images->first())
                                    <img src="{{ $item->product->images->first()->image_path }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $item->product_name }}</h4>
                                <p class="text-sm text-gray-600">الكمية: {{ $item->quantity }} × {{ number_format($item->product_price, 2) }} د.أ</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">{{ number_format($item->total_price, 2) }} د.أ</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($order->status == 'pending')
                    <!-- Pending Notice -->
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <span class="text-yellow-800 font-semibold">طلبك قيد المراجعة</span>
                        </div>
                        <p class="text-sm text-yellow-700 mt-2">سنتواصل معك خلال 24 ساعة لتأكيد الطلب وتفاصيل التسليم</p>
                    </div>
                    @endif

                    @if($order->status == 'shipped')
                    <!-- Shipping Progress -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-semibold text-blue-800 mb-3">حالة الشحن</h4>
                        <div class="relative">
                            <div class="flex justify-between items-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs mt-1 text-blue-600 font-semibold">تم الاستلام</span>
                                </div>
                                <div class="flex-1 h-1 bg-blue-600 mx-2"></div>
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs mt-1 text-blue-600 font-semibold">جاري الشحن</span>
                                </div>
                                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                        <div class="w-3 h-3 bg-white rounded-full"></div>
                                    </div>
                                    <span class="text-xs mt-1 text-gray-500">التسليم</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-blue-600 mt-3">التسليم المتوقع: {{ $order->created_at->addDays(5)->format('j F Y') }}</p>
                    </div>
                    @endif

                    <!-- Order Actions -->
                    <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                        @if($order->status == 'delivered')
                            <button onclick="trackOrder('{{ $order->order_number }}')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                تتبع الطلب
                            </button>
                            <button onclick="reorderItems('{{ $order->order_number }}')" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                إعادة الطلب
                            </button>
                            <button onclick="downloadInvoice('{{ $order->order_number }}')" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                تحميل الفاتورة
                            </button>
                            <button onclick="rateProducts('{{ $order->order_number }}')" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
                                تقييم المنتجات
                            </button>
                        @elseif($order->status == 'shipped')
                            <button onclick="trackOrder('{{ $order->order_number }}')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                تتبع الطلب
                            </button>
                            @if($order->canBeCancelled())
                            <button onclick="cancelOrder('{{ $order->order_number }}')" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                إلغاء الطلب
                            </button>
                            @endif
                            <button onclick="downloadInvoice('{{ $order->order_number }}')" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                تحميل الفاتورة
                            </button>
                        @elseif($order->status == 'pending')
                            @if($order->canBeCancelled())
                            <button onclick="cancelOrder('{{ $order->order_number }}')" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                إلغاء الطلب
                            </button>
                            @endif
                            @if($order->canBeEdited())
                            <button onclick="editOrder('{{ $order->order_number }}')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                تعديل الطلب
                            </button>
                            @endif
                            <button onclick="viewOrderDetails('{{ $order->order_number }}')" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                تفاصيل الطلب
                            </button>
                        @else
                            <button onclick="trackOrder('{{ $order->order_number }}')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                تتبع الطلب
                            </button>
                            <button onclick="downloadInvoice('{{ $order->order_number }}')" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                تحميل الفاتورة
                            </button>
                            <button onclick="viewOrderDetails('{{ $order->order_number }}')" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                تفاصيل الطلب
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($orders->count() == 0)
        <div class="text-center py-16" id="empty-orders">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-600 mb-2">لا توجد طلبات</h3>
            <p class="text-gray-500 mb-6">لم تقم بأي طلبات بعد</p>
            <a href="{{ route('products.index') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                ابدأ التسوق
            </a>
        </div>
        @else
        <div class="text-center py-16 hidden" id="empty-orders">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-600 mb-2">لا توجد طلبات</h3>
            <p class="text-gray-500 mb-6">لا توجد طلبات تطابق الفلتر المحدد</p>
            <a href="{{ route('products.index') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                ابدأ التسوق
            </a>
        </div>
        @endif

        <!-- Pagination -->
        @if($orders->count() > 0)
        <div class="mt-8 flex justify-center">
            <nav class="flex items-center gap-2">
                <button onclick="goToPage(0)" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50" disabled>
                    السابق
                </button>
                <button onclick="goToPage(1)" class="px-3 py-2 bg-blue-600 text-white border border-blue-600 rounded-lg">1</button>
                <button onclick="goToPage(2)" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50" disabled>
                    التالي
                </button>
            </nav>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.order-filter');
    const orderItems = document.querySelectorAll('.order-item');
    const emptyState = document.getElementById('empty-orders');
    const ordersContainer = document.getElementById('orders-container');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.dataset.status;
            
            // Update active button
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'text-blue-600', 'border-b-2', 'border-blue-600');
                btn.classList.add('text-gray-600');
            });
            this.classList.add('active', 'text-blue-600', 'border-b-2', 'border-blue-600');
            this.classList.remove('text-gray-600');
            
            // Filter orders
            let visibleOrders = 0;
            orderItems.forEach(item => {
                if (status === 'all' || item.dataset.status === status) {
                    item.style.display = 'block';
                    visibleOrders++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide empty state
            if (visibleOrders === 0) {
                ordersContainer.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                ordersContainer.classList.remove('hidden');
                emptyState.classList.add('hidden');
            }
        });
    });
});

// Order Action Functions
function trackOrder(orderId) {
    // Create a modal or redirect to tracking page
    showModal('تتبع الطلب', `
        <div class="text-center">
            <div class="mb-4">
                <svg class="w-16 h-16 text-blue-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold mb-2">طلب رقم: ${orderId}</h3>
            <p class="text-gray-600 mb-4">يمكنك تتبع طلبك عبر الرابط أدناه</p>
            <div class="bg-gray-100 p-3 rounded-lg mb-4">
                <p class="text-sm font-mono">${orderId}</p>
            </div>
            <button onclick="window.open('https://track.example.com/${orderId}', '_blank')" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                فتح صفحة التتبع
            </button>
        </div>
    `);
}

function reorderItems(orderId) {
    if (confirm('هل تريد إعادة طلب نفس المنتجات؟')) {
        showLoadingToast('جاري إضافة المنتجات للسلة...');
        
        // Simulate API call
        setTimeout(() => {
            hideLoadingToast();
            showSuccessToast('تمت إضافة المنتجات للسلة بنجاح!');
            
            // Redirect to cart after a delay
            setTimeout(() => {
                window.location.href = "{{ route('cart') }}";
            }, 1500);
        }, 2000);
    }
}

function downloadInvoice(orderId) {
    showLoadingToast('جاري تحضير الفاتورة...');
    
    // Simulate invoice generation
    setTimeout(() => {
        hideLoadingToast();
        
        // Create a mock PDF download
        const link = document.createElement('a');
        link.href = 'data:application/pdf;base64,JVBERi0xLjQKJdPr6eEKMSAwIG9iago8PAovVHlwZSAvQ2F0YWxvZwovUGFnZXMgMiAwIFIKPj4KZW5kb2JqCjIgMCBvYmoKPDwKL1R5cGUgL1BhZ2VzCi9LaWRzIFszIDAgUl0KL0NvdW50IDEKPD4KZW5kb2JqCjMgMCBvYmoKPDwKL1R5cGUgL1BhZ2UK';
        link.download = `invoice-${orderId}.pdf`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        showSuccessToast('تم تحميل الفاتورة بنجاح!');
    }, 1500);
}

function rateProducts(orderId) {
    showModal('تقييم المنتجات', `
        <div>
            <h3 class="text-lg font-bold mb-4">قيم تجربة الشراء</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">سيارة التحكم عن بعد الرياضية</label>
                    <div class="flex gap-1 mb-2" data-rating="product1">
                        ${generateStarRating('product1')}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">دمية الدب الناعمة الكبيرة</label>
                    <div class="flex gap-1 mb-2" data-rating="product2">
                        ${generateStarRating('product2')}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">تعليق إضافي</label>
                    <textarea class="w-full p-3 border rounded-lg" rows="3" placeholder="شاركنا رأيك في المنتجات..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button onclick="submitRating('${orderId}')" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                        إرسال التقييم
                    </button>
                    <button onclick="closeModal()" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                        إلغاء
                    </button>
                </div>
            </div>
        </div>
    `);
}

function cancelOrder(orderId) {
    showModal('إلغاء الطلب', `
        <div class="text-center">
            <div class="mb-4">
                <svg class="w-16 h-16 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold mb-2">تأكيد إلغاء الطلب</h3>
            <p class="text-gray-600 mb-6">هل أنت متأكد من إلغاء الطلب رقم: ${orderId}؟</p>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">سبب الإلغاء (اختياري)</label>
                <select class="w-full p-3 border rounded-lg" id="cancelReason">
                    <option value="">اختر السبب</option>
                    <option value="changed_mind">غيرت رأيي</option>
                    <option value="found_better_price">وجدت سعر أفضل</option>
                    <option value="long_delivery">وقت التسليم طويل</option>
                    <option value="other">سبب آخر</option>
                </select>
            </div>
            <div class="flex gap-3 justify-center">
                <button onclick="confirmCancelOrder('${orderId}')" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                    تأكيد الإلغاء
                </button>
                <button onclick="closeModal()" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                    تراجع
                </button>
            </div>
        </div>
    `);
}

function editOrder(orderId) {
    showModal('تعديل الطلب', `
        <div>
            <h3 class="text-lg font-bold mb-4">تعديل الطلب رقم: ${orderId}</h3>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <p class="text-yellow-800 text-sm">
                    يمكن تعديل الطلب فقط إذا لم يتم تأكيده بعد. بعض التعديلات قد تؤثر على سعر الطلب.
                </p>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">عنوان التسليم</label>
                    <textarea id="editShippingAddress" class="w-full p-3 border rounded-lg" rows="3" placeholder="أدخل العنوان الجديد..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">رقم الهاتف</label>
                    <input type="tel" id="editPhone" class="w-full p-3 border rounded-lg" placeholder="05xxxxxxxx">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">ملاحظات إضافية</label>
                    <textarea id="editNotes" class="w-full p-3 border rounded-lg" rows="2" placeholder="أي ملاحظات خاصة..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button onclick="saveOrderEdit('${orderId}')" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        حفظ التعديلات
                    </button>
                    <button onclick="closeModal()" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                        إلغاء
                    </button>
                </div>
            </div>
        </div>
    `);
}

function viewOrderDetails(orderId) {
    showLoadingToast('جاري تحميل تفاصيل الطلب...');
    
    fetch('{{ route("orders.show", ":orderId") }}'.replace(':orderId', orderId), {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(order => {
        hideLoadingToast();
        
        showModal('تفاصيل الطلب', `
            <div>
                <h3 class="text-lg font-bold mb-4">تفاصيل الطلب رقم: ${order.order_number}</h3>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">معلومات الطلب</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">تاريخ الطلب:</span>
                                <span class="font-medium">${new Date(order.created_at).toLocaleDateString('ar-SA')}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">الحالة:</span>
                                <span class="font-medium text-yellow-600">${order.status_arabic}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">طريقة الدفع:</span>
                                <span class="font-medium">${order.payment_method == 'cod' ? 'الدفع عند الاستلام' : 'دفع إلكتروني'}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">المجموع:</span>
                                <span class="font-medium">${parseFloat(order.total_amount).toFixed(2)} د.أ</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">عنوان التسليم</h4>
                        <p class="text-sm text-gray-600">${order.shipping_address}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">تفاصيل الاتصال</h4>
                        <p class="text-sm text-gray-600">الهاتف: ${order.phone}</p>
                    </div>
                    ${order.notes ? `
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold mb-2">ملاحظات</h4>
                        <p class="text-sm text-gray-600">${order.notes}</p>
                    </div>
                    ` : ''}
                    <button onclick="closeModal()" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        إغلاق
                    </button>
                </div>
            </div>
        `);
    })
    .catch(error => {
        hideLoadingToast();
        showErrorToast('حدث خطأ أثناء تحميل تفاصيل الطلب');
        console.error('Error:', error);
    });
}

function goToPage(page) {
    if (page > 0) {
        showLoadingToast('جاري تحميل الصفحة...');
        setTimeout(() => {
            hideLoadingToast();
            showInfoToast('تم الانتقال للصفحة ' + page);
        }, 1000);
    }
}

// Helper Functions
function generateStarRating(productId) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        stars += '<button onclick="setRating(\'' + productId + '\', ' + i + ')" class="star-btn text-2xl text-gray-300 hover:text-yellow-400" data-product="' + productId + '" data-rating="' + i + '">★</button>';
    }
    return stars;
}

function setRating(productId, rating) {
    const stars = document.querySelectorAll('[data-product="' + productId + '"]');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

function submitRating(orderId) {
    showLoadingToast('جاري إرسال التقييم...');
    setTimeout(() => {
        hideLoadingToast();
        closeModal();
        showSuccessToast('شكراً لك! تم إرسال التقييم بنجاح');
    }, 1500);
}

function confirmCancelOrder(orderId) {
    const reason = document.getElementById('cancelReason').value;
    showLoadingToast('جاري إلغاء الطلب...');
    
    // Get order ID from order number
    const orderElement = document.querySelector('[data-order-id="' + orderId + '"]');
    if (!orderElement) {
        hideLoadingToast();
        closeModal();
        showErrorToast('لم يتم العثور على الطلب');
        return;
    }

    // Make AJAX request to cancel order
    fetch('{{ route("orders.cancel", ":orderId") }}'.replace(':orderId', orderId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            reason: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        hideLoadingToast();
        closeModal();
        
        if (data.success) {
            showSuccessToast(data.message);
            
            // Update order status in UI
            orderElement.style.opacity = '0.6';
            const statusBadge = orderElement.querySelector('.bg-yellow-100, .bg-blue-100');
            if (statusBadge) {
                statusBadge.className = 'bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold';
                statusBadge.textContent = 'ملغي';
            }
            
            // Hide cancel and edit buttons
            const cancelBtn = orderElement.querySelector('button[onclick*="cancelOrder"]');
            const editBtn = orderElement.querySelector('button[onclick*="editOrder"]');
            if (cancelBtn) cancelBtn.style.display = 'none';
            if (editBtn) editBtn.style.display = 'none';
        } else {
            showErrorToast(data.message);
        }
    })
    .catch(error => {
        hideLoadingToast();
        closeModal();
        showErrorToast('حدث خطأ أثناء إلغاء الطلب');
        console.error('Error:', error);
    });
}

function saveOrderEdit(orderId) {
    const shippingAddress = document.getElementById('editShippingAddress').value;
    const phone = document.getElementById('editPhone').value;
    const notes = document.getElementById('editNotes').value;
    
    if (!shippingAddress || !phone) {
        showErrorToast('الرجاء ملء جميع الحقول المطلوبة');
        return;
    }
    
    showLoadingToast('جاري حفظ التعديلات...');
    
    fetch('{{ route("orders.update", ":orderId") }}'.replace(':orderId', orderId), {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            shipping_address: shippingAddress,
            phone: phone,
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        hideLoadingToast();
        closeModal();
        
        if (data.success) {
            showSuccessToast(data.message);
        } else {
            showErrorToast(data.message);
        }
    })
    .catch(error => {
        hideLoadingToast();
        closeModal();
        showErrorToast('حدث خطأ أثناء حفظ التعديلات');
        console.error('Error:', error);
    });
}

// Modal Functions
function showModal(title, content) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
    modal.innerHTML = 
        '<div class="bg-white rounded-lg max-w-md w-full max-h-[90vh] overflow-y-auto">' +
            '<div class="p-6">' +
                '<div class="flex justify-between items-center mb-4">' +
                    '<h2 class="text-xl font-bold">' + title + '</h2>' +
                    '<button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">' +
                        '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>' +
                        '</svg>' +
                    '</button>' +
                '</div>' +
                content +
            '</div>' +
        '</div>';
    document.body.appendChild(modal);
    window.currentModal = modal;
}

function closeModal() {
    if (window.currentModal) {
        document.body.removeChild(window.currentModal);
        window.currentModal = null;
    }
}

// Toast Functions
function showSuccessToast(message) {
    showToast(message, 'success');
}

function showErrorToast(message) {
    showToast(message, 'error');
}

function showInfoToast(message) {
    showToast(message, 'info');
}

function showLoadingToast(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-3';
    toast.innerHTML = 
        '<div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>' +
        message;
    toast.id = 'loading-toast';
    document.body.appendChild(toast);
}

function hideLoadingToast() {
    const toast = document.getElementById('loading-toast');
    if (toast) {
        document.body.removeChild(toast);
    }
}

function showToast(message, type = 'info') {
    const colors = {
        success: 'bg-green-600',
        error: 'bg-red-600',
        info: 'bg-blue-600'
    };
    
    const toast = document.createElement('div');
    toast.className = 'fixed top-4 right-4 ' + colors[type] + ' text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 translate-x-full';
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 3000);
}
</script>

<style>
.order-filter.active {
    color: #2563eb !important;
    border-bottom: 2px solid #2563eb;
}
</style>
@endsection
