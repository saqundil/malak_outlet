@extends('layouts.main')

@section('title', 'طلباتي - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Professional Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">طلباتي</h1>
                    <p class="text-gray-600 mt-1">إدارة ومتابعة جميع طلباتك</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <select id="sortOrders" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="newest">الأحدث أولاً</option>
                            <option value="oldest">الأقدم أولاً</option>
                            <option value="highest">أعلى سعر</option>
                            <option value="lowest">أقل سعر</option>
                        </select>
                        <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <a href="{{ route('products.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        تسوق الآن
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Status Filter Tabs - Professional Design -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-8">
            <div class="flex overflow-x-auto scrollbar-hide">
                <button class="flex-shrink-0 px-8 py-4 text-blue-600 bg-blue-50 border-b-2 border-blue-600 font-semibold order-filter active whitespace-nowrap transition-colors" data-status="all">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                        جميع الطلبات
                        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">{{ $orders->count() }}</span>
                    </div>
                </button>
                <button class="flex-shrink-0 px-8 py-4 text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 font-semibold order-filter whitespace-nowrap transition-colors" data-status="pending">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                        قيد المراجعة
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $orders->where('status', 'pending')->count() }}</span>
                    </div>
                </button>
                <button class="flex-shrink-0 px-8 py-4 text-gray-600 hover:text-blue-600 hover:bg-blue-50 font-semibold order-filter whitespace-nowrap transition-colors" data-status="confirmed">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        مؤكدة
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $orders->where('status', 'confirmed')->count() }}</span>
                    </div>
                </button>
                <button class="flex-shrink-0 px-8 py-4 text-gray-600 hover:text-purple-600 hover:bg-purple-50 font-semibold order-filter whitespace-nowrap transition-colors" data-status="shipped">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                        تم الشحن
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $orders->where('status', 'shipped')->count() }}</span>
                    </div>
                </button>
                <button class="flex-shrink-0 px-8 py-4 text-gray-600 hover:text-green-600 hover:bg-green-50 font-semibold order-filter whitespace-nowrap transition-colors" data-status="delivered">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        تم التسليم
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $orders->where('status', 'delivered')->count() }}</span>
                    </div>
                </button>
                <button class="flex-shrink-0 px-8 py-4 text-gray-600 hover:text-red-600 hover:bg-red-50 font-semibold order-filter whitespace-nowrap transition-colors" data-status="cancelled">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        ملغية
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">{{ $orders->where('status', 'cancelled')->count() }}</span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Professional Orders List -->
        <div class="space-y-4" id="orders-container">
            @foreach($orders as $order)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 order-item" data-status="{{ $order->status }}" data-order-id="{{ $order->order_number }}">
                
                <!-- Order Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <div class="flex items-center gap-6">
                        <!-- Order Status Icon -->
                        <div class="flex-shrink-0">
                            @if($order->status == 'pending')
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @elseif($order->status == 'confirmed')
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @elseif($order->status == 'shipped')
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @elseif($order->status == 'delivered')
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Order Info -->
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-lg font-bold text-gray-900">#{{ $order->order_number }}</h3>
                                <span class="{{ $order->status_badge_class }} px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $order->status_arabic }}
                                </span>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span>{{ $order->created_at->format('j F Y - H:i') }}</span>
                                <span>•</span>
                                <span>{{ $order->items->count() }} منتج</span>
                                @if($order->jordanCity)
                                <span>•</span>
                                <span>{{ $order->jordanCity->name_ar }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Total & Actions -->
                    <div class="flex items-center gap-4">
                        <div class="text-left">
                            <div class="text-2xl font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} د.أ</div>
                            @if($order->subtotal != $order->total_amount)
                                <div class="text-sm text-gray-500">الأصلي: {{ number_format($order->subtotal + ($order->shipping_cost ?? 0), 2) }} د.أ</div>
                            @endif
                        </div>
                        
                        <!-- Quick Actions Dropdown -->
                        <div class="relative">
                            <button onclick="toggleOrderActions('{{ $order->order_number }}')" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                            </button>
                            <div id="actions-{{ $order->order_number }}" class="hidden absolute left-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                <div class="py-2">
                                    <button onclick="viewOrderDetails('{{ $order->order_number }}')" class="w-full text-right px-4 py-2 text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        عرض التفاصيل
                                    </button>
                                    @if($order->status != 'cancelled')
                                    <button onclick="trackOrder('{{ $order->order_number }}')" class="w-full text-right px-4 py-2 text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        تتبع الطلب
                                    </button>
                                    @endif
                                    @if($order->canBeCancelled())
                                    <button onclick="cancelOrder('{{ $order->order_number }}')" class="w-full text-right px-4 py-2 text-red-700 hover:bg-red-50 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        إلغاء الطلب
                                    </button>
                                    @endif
                                    @if($order->status == 'delivered')
                                    <button onclick="reorderItems('{{ $order->order_number }}')" class="w-full text-right px-4 py-2 text-green-700 hover:bg-green-50 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        إعادة الطلب
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items Preview -->
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <h4 class="font-semibold text-gray-900 mb-3">المنتجات ({{ $order->items->count() }})</h4>
                        @if($order->status == 'pending')
                            <div class="text-sm text-yellow-600 bg-yellow-50 px-3 py-1 rounded-full">
                                في انتظار التأكيد
                            </div>
                        @elseif($order->status == 'shipped')
                            <div class="text-sm text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                                التسليم المتوقع: {{ $order->created_at->addDays(3)->format('j M') }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Product Items -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($order->items->take(3) as $item)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <div class="w-16 h-16 bg-white rounded-lg overflow-hidden flex-shrink-0">
                                @if($item->product && $item->product->images->first())
                                    <img src="{{ $item->product->images->first()->image_path }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="font-medium text-gray-900 truncate">{{ $item->product ? $item->product->name : 'منتج محذوف' }}</h5>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-sm text-gray-500">الكمية: {{ $item->quantity }}</span>
                                    <span class="font-semibold text-gray-900">{{ number_format($item->total, 2) }} د.أ</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($order->items->count() > 3)
                        <div class="flex items-center justify-center p-3 bg-gray-100 rounded-xl border-2 border-dashed border-gray-300">
                            <span class="text-gray-600 font-medium">+{{ $order->items->count() - 3 }} منتج آخر</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Progress Bar for Shipped Orders -->
                @if($order->status == 'shipped')
                <div class="px-6 pb-6">
                    <div class="bg-blue-50 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium text-blue-900">تتبع الشحن</span>
                            <span class="text-sm text-blue-700">70% مكتمل</span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full w-3/4 transition-all duration-500"></div>
                        </div>
                        <div class="flex justify-between text-xs text-blue-700 mt-2">
                            <span>تم الاستلام</span>
                            <span>جاري الشحن</span>
                            <span>قيد التسليم</span>
                            <span class="text-blue-400">تم التسليم</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Modern Empty State -->
        @if($orders->count() == 0)
        <div class="text-center py-20" id="empty-orders">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">لا توجد طلبات بعد</h3>
                <p class="text-gray-600 mb-8 text-lg">ابدأ رحلة التسوق واكتشف منتجاتنا الرائعة</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('products.index') }}" 
                       class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 transition-colors font-semibold shadow-lg hover:shadow-xl">
                        تصفح المنتجات
                    </a>
                    <a href="{{ route('home') }}" 
                       class="bg-white text-blue-600 border-2 border-blue-600 px-8 py-3 rounded-xl hover:bg-blue-50 transition-colors font-semibold">
                        العودة للرئيسية
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-20 hidden" id="empty-filter-state">
            <div class="max-w-md mx-auto">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">لا توجد طلبات</h3>
                <p class="text-gray-600 mb-6">لا توجد طلبات تطابق الفلتر المحدد</p>
                <button onclick="resetFilters()" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-colors font-semibold">
                    إعادة تعيين الفلتر
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.order-filter');
    const orderItems = document.querySelectorAll('.order-item');
    const emptyState = document.getElementById('empty-orders');
    const emptyFilterState = document.getElementById('empty-filter-state');
    const ordersContainer = document.getElementById('orders-container');
    const sortSelect = document.getElementById('sortOrders');

    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.dataset.status;
            
            // Update active button styling
            filterButtons.forEach(btn => {
                btn.classList.remove('active', 'text-blue-600', 'bg-blue-50', 'border-b-2', 'border-blue-600');
                btn.classList.add('text-gray-600');
                
                // Reset hover classes
                if (btn.dataset.status === 'pending') {
                    btn.classList.add('hover:text-yellow-600', 'hover:bg-yellow-50');
                } else if (btn.dataset.status === 'confirmed') {
                    btn.classList.add('hover:text-blue-600', 'hover:bg-blue-50');
                } else if (btn.dataset.status === 'shipped') {
                    btn.classList.add('hover:text-purple-600', 'hover:bg-purple-50');
                } else if (btn.dataset.status === 'delivered') {
                    btn.classList.add('hover:text-green-600', 'hover:bg-green-50');
                } else if (btn.dataset.status === 'cancelled') {
                    btn.classList.add('hover:text-red-600', 'hover:bg-red-50');
                }
            });
            
            this.classList.add('active', 'text-blue-600', 'bg-blue-50', 'border-b-2', 'border-blue-600');
            this.classList.remove('text-gray-600');
            
            // Remove all hover classes from active button
            this.classList.remove('hover:text-yellow-600', 'hover:bg-yellow-50', 'hover:text-blue-600', 'hover:bg-blue-50', 'hover:text-purple-600', 'hover:bg-purple-50', 'hover:text-green-600', 'hover:bg-green-50', 'hover:text-red-600', 'hover:bg-red-50');
            
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
            
            // Show/hide empty states
            if (visibleOrders === 0) {
                ordersContainer.classList.add('hidden');
                if (emptyState) emptyState.classList.add('hidden');
                if (emptyFilterState) emptyFilterState.classList.remove('hidden');
            } else {
                ordersContainer.classList.remove('hidden');
                if (emptyState) emptyState.classList.add('hidden');
                if (emptyFilterState) emptyFilterState.classList.add('hidden');
            }
        });
    });

    // Sorting functionality
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortType = this.value;
            const container = document.getElementById('orders-container');
            const orders = Array.from(container.children);
            
            orders.sort((a, b) => {
                switch (sortType) {
                    case 'newest':
                        return new Date(b.dataset.date) - new Date(a.dataset.date);
                    case 'oldest':
                        return new Date(a.dataset.date) - new Date(b.dataset.date);
                    case 'highest':
                        return parseFloat(b.dataset.total) - parseFloat(a.dataset.total);
                    case 'lowest':
                        return parseFloat(a.dataset.total) - parseFloat(b.dataset.total);
                    default:
                        return 0;
                }
            });
            
            orders.forEach(order => container.appendChild(order));
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('[id^="actions-"]');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target) && !event.target.closest('button[onclick*="toggleOrderActions"]')) {
                dropdown.classList.add('hidden');
            }
        });
    });
});

// Toggle order actions dropdown
function toggleOrderActions(orderId) {
    const dropdown = document.getElementById('actions-' + orderId);
    const allDropdowns = document.querySelectorAll('[id^="actions-"]');
    
    // Close all other dropdowns
    allDropdowns.forEach(d => {
        if (d !== dropdown) {
            d.classList.add('hidden');
        }
    });
    
    dropdown.classList.toggle('hidden');
}

// Reset filters function
function resetFilters() {
    const allButton = document.querySelector('.order-filter[data-status="all"]');
    if (allButton) {
        allButton.click();
    }
}

// Order Action Functions
function viewOrderDetails(orderId) {
    showLoadingToast('جاري تحميل تفاصيل الطلب...');
    
    // Close dropdown
    const dropdown = document.getElementById('actions-' + orderId);
    if (dropdown) dropdown.classList.add('hidden');
    
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
            <div class="space-y-6">
                <div class="flex items-center gap-4 pb-4 border-b">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">#${order.order_number}</h3>
                        <p class="text-gray-600">${new Date(order.created_at).toLocaleDateString('ar-SA')}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-2">الحالة</h4>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            ${order.status_arabic}
                        </span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-2">طريقة الدفع</h4>
                        <p class="text-gray-600">${order.payment_method == 'cod' ? 'الدفع عند الاستلام' : 'دفع إلكتروني'}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-2">المجموع</h4>
                        <p class="text-2xl font-bold text-green-600">${parseFloat(order.total_amount).toFixed(2)} د.أ</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <h4 class="font-semibold text-gray-900 mb-2">عدد المنتجات</h4>
                        <p class="text-xl font-semibold text-gray-900">${order.items ? order.items.length : 0} منتج</p>
                    </div>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-xl">
                    <h4 class="font-semibold text-blue-900 mb-2">عنوان التسليم</h4>
                    <p class="text-blue-800">${order.shipping_address}</p>
                    <p class="text-blue-700 text-sm mt-1">الهاتف: ${order.phone}</p>
                </div>
                
                ${order.notes ? `
                <div class="bg-yellow-50 p-4 rounded-xl">
                    <h4 class="font-semibold text-yellow-900 mb-2">ملاحظات</h4>
                    <p class="text-yellow-800">${order.notes}</p>
                </div>
                ` : ''}
                
                <div class="flex gap-3">
                    <button onclick="closeModal()" class="flex-1 bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition-colors font-semibold">
                        إغلاق
                    </button>
                    ${order.status !== 'cancelled' ? `
                    <button onclick="trackOrder('${orderId}'); closeModal();" class="flex-1 bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 transition-colors font-semibold">
                        تتبع الطلب
                    </button>
                    ` : ''}
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

function trackOrder(orderId) {
    // Close dropdown
    const dropdown = document.getElementById('actions-' + orderId);
    if (dropdown) dropdown.classList.add('hidden');
    
    showModal('تتبع الطلب', `
        <div class="text-center space-y-6">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">تتبع الطلب</h3>
                <p class="text-gray-600 mb-1">طلب رقم: <span class="font-semibold text-blue-600">#${orderId}</span></p>
            </div>
            
            <!-- Tracking Progress -->
            <div class="bg-gray-50 rounded-2xl p-6">
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="text-right flex-1">
                            <p class="font-semibold text-gray-900">تم استلام الطلب</p>
                            <p class="text-sm text-gray-600">تم تأكيد طلبك وبدء التحضير</p>
                        </div>
                        <span class="text-xs text-gray-500">مكتمل</span>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div class="text-right flex-1">
                            <p class="font-semibold text-gray-900">جاري الشحن</p>
                            <p class="text-sm text-gray-600">طلبك في الطريق إليك</p>
                        </div>
                        <span class="text-xs text-blue-600">حالياً</span>
                    </div>
                    
                    <div class="flex items-center gap-4 opacity-50">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                            <div class="w-4 h-4 bg-white rounded-full"></div>
                        </div>
                        <div class="text-right flex-1">
                            <p class="font-semibold text-gray-900">تم التسليم</p>
                            <p class="text-sm text-gray-600">وصل طلبك بنجاح</p>
                        </div>
                        <span class="text-xs text-gray-500">قريباً</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-blue-50 rounded-xl p-4">
                <p class="text-blue-800 font-medium">التسليم المتوقع</p>
                <p class="text-blue-600 text-sm">خلال 2-3 أيام عمل</p>
            </div>
            
            <button onclick="closeModal()" class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 transition-colors font-semibold">
                إغلاق
            </button>
        </div>
    `);
}

function reorderItems(orderId) {
    // Close dropdown
    const dropdown = document.getElementById('actions-' + orderId);
    if (dropdown) dropdown.classList.add('hidden');
    
    showModal('إعادة الطلب', `
        <div class="text-center space-y-6">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">إعادة طلب المنتجات</h3>
                <p class="text-gray-600">هل تريد إعادة طلب نفس المنتجات من الطلب #${orderId}؟</p>
            </div>
            
            <div class="bg-green-50 rounded-xl p-4">
                <p class="text-green-800 text-sm">سيتم إضافة جميع منتجات هذا الطلب إلى سلة التسوق مع الأسعار الحالية</p>
            </div>
            
            <div class="flex gap-3">
                <button onclick="confirmReorder('${orderId}')" class="flex-1 bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 transition-colors font-semibold">
                    تأكيد إعادة الطلب
                </button>
                <button onclick="closeModal()" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-xl hover:bg-gray-400 transition-colors font-semibold">
                    إلغاء
                </button>
            </div>
        </div>
    `);
}

function confirmReorder(orderId) {
    closeModal();
    showLoadingToast('جاري إضافة المنتجات للسلة...');
    
    // Simulate API call
    setTimeout(() => {
        hideLoadingToast();
        showSuccessToast('تمت إضافة المنتجات للسلة بنجاح!');
        
        // Redirect to cart after a delay - FIXED ROUTE
        setTimeout(() => {
            window.location.href = "{{ route('cart') }}";
        }, 1500);
    }, 2000);
}

function cancelOrder(orderId) {
    // Close dropdown
    const dropdown = document.getElementById('actions-' + orderId);
    if (dropdown) dropdown.classList.add('hidden');
    
    showModal('إلغاء الطلب', `
        <div class="text-center space-y-6">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-red-600 mb-2">إلغاء الطلب</h3>
                <p class="text-gray-600">هل أنت متأكد من إلغاء الطلب #${orderId}؟</p>
            </div>
            
            <div class="text-right">
                <label class="block text-sm font-semibold text-gray-700 mb-2">سبب الإلغاء (اختياري)</label>
                <select class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500" id="cancelReason">
                    <option value="">اختر السبب</option>
                    <option value="changed_mind">غيرت رأيي</option>
                    <option value="found_better_price">وجدت سعر أفضل</option>
                    <option value="long_delivery">وقت التسليم طويل</option>
                    <option value="payment_issue">مشكلة في الدفع</option>
                    <option value="other">سبب آخر</option>
                </select>
            </div>
            
            <div class="bg-red-50 rounded-xl p-4">
                <p class="text-red-800 text-sm">⚠️ لن يمكن التراجع عن هذا الإجراء بعد التأكيد</p>
            </div>
            
            <div class="flex gap-3">
                <button onclick="confirmCancelOrder('${orderId}')" class="flex-1 bg-red-600 text-white py-3 rounded-xl hover:bg-red-700 transition-colors font-semibold">
                    تأكيد الإلغاء
                </button>
                <button onclick="closeModal()" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-xl hover:bg-gray-400 transition-colors font-semibold">
                    تراجع
                </button>
            </div>
        </div>
    `);
}

function confirmCancelOrder(orderId) {
    const reason = document.getElementById('cancelReason').value;
    closeModal();
    showLoadingToast('جاري إلغاء الطلب...');
    
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
        
        if (data.success) {
            showSuccessToast(data.message);
            
            // Update order status in UI
            const orderElement = document.querySelector('[data-order-id="' + orderId + '"]');
            if (orderElement) {
                // Update status badge
                const statusBadge = orderElement.querySelector('[class*="bg-yellow-100"], [class*="bg-blue-100"]');
                if (statusBadge) {
                    statusBadge.className = 'bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold';
                    statusBadge.textContent = 'ملغي';
                }
                
                // Update status icon
                const statusIcon = orderElement.querySelector('.w-12.h-12');
                if (statusIcon) {
                    statusIcon.className = 'w-12 h-12 bg-red-100 rounded-full flex items-center justify-center';
                    statusIcon.innerHTML = `
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    `;
                }
                
                // Update data status
                orderElement.dataset.status = 'cancelled';
                
                // Hide action buttons
                const dropdown = document.getElementById('actions-' + orderId);
                if (dropdown) {
                    dropdown.innerHTML = `
                        <div class="py-2">
                            <button onclick="viewOrderDetails('${orderId}')" class="w-full text-right px-4 py-2 text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                عرض التفاصيل
                            </button>
                        </div>
                    `;
                }
            }
        } else {
            showErrorToast(data.message || 'حدث خطأ أثناء إلغاء الطلب');
        }
    })
    .catch(error => {
        hideLoadingToast();
        showErrorToast('حدث خطأ أثناء إلغاء الطلب');
        console.error('Error:', error);
    });
}

// Modal Functions
function showModal(title, content) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4';
    modal.innerHTML = `
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">${title}</h2>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                ${content}
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
    window.currentModal = modal;
}

function closeModal() {
    if (window.currentModal) {
        document.body.removeChild(window.currentModal);
        document.body.style.overflow = 'auto';
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
    toast.className = 'fixed top-6 right-6 bg-blue-600 text-white px-6 py-4 rounded-2xl shadow-xl z-50 flex items-center gap-3 max-w-sm';
    toast.innerHTML = `
        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></div>
        <span class="font-medium">${message}</span>
    `;
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
    
    const icons = {
        success: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>`,
        error: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>`,
        info: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
               </svg>`
    };
    
    const toast = document.createElement('div');
    toast.className = `fixed top-6 right-6 ${colors[type]} text-white px-6 py-4 rounded-2xl shadow-xl z-50 transform transition-transform duration-300 translate-x-full max-w-sm`;
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            ${icons[type]}
            <span class="font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Remove after 4 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 4000);
}
</script>

<style>
/* Custom scrollbar for horizontal scroll */
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* Active filter styling */
.order-filter.active {
    border-bottom-width: 2px;
}

/* Smooth transitions */
.order-item {
    transition: all 0.2s ease-in-out;
}
.order-item:hover {
    transform: translateY(-2px);
}

/* Progress bar animation */
@keyframes progress-fill {
    from { width: 0%; }
    to { width: 75%; }
}

.bg-blue-600[style*="width: 3/4"] {
    animation: progress-fill 1s ease-in-out;
}
</style>
@endsection
