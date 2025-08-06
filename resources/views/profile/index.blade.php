@extends('layouts.main')

@section('title', 'الملف الشخصي - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">أهلاً {{ $user->name }}</h1>
                    <p class="text-lg opacity-90">مرحباً بك في لوحة التحكم الخاصة بك</p>
                    @if($stats['total_orders'] > 0)
                        <p class="text-sm opacity-75 mt-1">لديك {{ $stats['total_orders'] }} {{ $stats['total_orders'] == 1 ? 'طلب' : 'طلبات' }} و {{ $stats['wishlist_count'] }} {{ $stats['wishlist_count'] == 1 ? 'منتج مفضل' : 'منتجات مفضلة' }}</p>
                    @endif
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-6 text-center">
                    <div class="text-2xl font-bold">{{ $user->created_at->diffInDays() }}</div>
                    <div class="text-sm opacity-90">{{ $user->created_at->diffInDays() == 1 ? 'يوم معنا' : 'يوم معنا' }}</div>
                    <div class="text-xs opacity-75 mt-1">منذ {{ $user->created_at->format('M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">إجمالي الطلبات</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                        @if($stats['pending_orders'] > 0)
                            <p class="text-xs text-blue-600">{{ $stats['pending_orders'] }} قيد المعالجة</p>
                        @endif
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Wishlist Items -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">المفضلة</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['wishlist_count'] }}</p>
                        @if($stats['wishlist_count'] > 0)
                            <p class="text-xs text-red-600">منتج في قائمة الأمنيات</p>
                        @endif
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">السلة</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['cart_count'] }}</p>
                        @if($stats['cart_count'] > 0)
                            <p class="text-xs text-green-600">{{ $stats['cart_count'] == 1 ? 'منتج واحد' : 'منتجات' }}</p>
                        @endif
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6M9 19h6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Membership & Total Spent -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 {{ $membershipLevel['color'] }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">العضوية</p>
                        <p class="text-xl font-bold text-gray-900">{{ $membershipLevel['level'] }} {{ $membershipLevel['icon'] }}</p>
                        @if($stats['total_spent'] > 0)
                            <p class="text-xs text-gray-600">أنفقت {{ number_format($stats['total_spent'], 0) }} د.أ</p>
                        @endif
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Actions -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">الإجراءات السريعة</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('orders.index') }}" class="group bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 p-6 rounded-lg transition duration-200">
                            <div class="flex items-center">
                                <div class="bg-blue-500 p-3 rounded-lg group-hover:bg-blue-600 transition duration-200">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div class="mr-4">
                                    <h3 class="font-semibold text-gray-800">طلباتي</h3>
                                    <p class="text-sm text-gray-600">تتبع وإدارة طلباتك</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('wishlist') }}" class="group bg-gradient-to-r from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 p-6 rounded-lg transition duration-200">
                            <div class="flex items-center">
                                <div class="bg-red-500 p-3 rounded-lg group-hover:bg-red-600 transition duration-200">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <div class="mr-4">
                                    <h3 class="font-semibold text-gray-800">قائمة الأمنيات</h3>
                                    <p class="text-sm text-gray-600">المنتجات المفضلة لديك</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('cart') }}" class="group bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 p-6 rounded-lg transition duration-200">
                            <div class="flex items-center">
                                <div class="bg-green-500 p-3 rounded-lg group-hover:bg-green-600 transition duration-200">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6M9 19h6"></path>
                                    </svg>
                                </div>
                                <div class="mr-4">
                                    <h3 class="font-semibold text-gray-800">سلة التسوق</h3>
                                    <p class="text-sm text-gray-600">عرض وإدارة السلة</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="group bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 p-6 rounded-lg transition duration-200">
                            <div class="flex items-center">
                                <div class="bg-purple-500 p-3 rounded-lg group-hover:bg-purple-600 transition duration-200">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <div class="mr-4">
                                    <h3 class="font-semibold text-gray-800">تحرير الملف الشخصي</h3>
                                    <p class="text-sm text-gray-600">تحديث البيانات الشخصية</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">النشاط الأخير</h2>
                    
                    <!-- Progress Bar -->
                    @if($stats['total_orders'] > 0)
                    <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg">
                        <h3 class="font-semibold text-gray-800 mb-2">تقدمك في الرحلة معنا</h3>
                        <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                            <span>المستوى الحالي: {{ $membershipLevel['level'] }}</span>
                            @if($membershipLevel['level'] != 'بلاتيني')
                                <span>المستوى التالي: 
                                    @if($membershipLevel['level'] == 'برونزي') فضي
                                    @elseif($membershipLevel['level'] == 'فضي') ذهبي
                                    @else بلاتيني
                                    @endif
                                </span>
                            @endif
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                            @php
                                $progressPercentage = 0;
                                if($membershipLevel['level'] == 'برونزي') $progressPercentage = min(($stats['total_orders'] / 3) * 100, 100);
                                elseif($membershipLevel['level'] == 'فضي') $progressPercentage = min((($stats['total_orders'] - 3) / 7) * 100 + 100, 100);
                                elseif($membershipLevel['level'] == 'ذهبي') $progressPercentage = min((($stats['total_orders'] - 10) / 10) * 100 + 100, 100);
                                else $progressPercentage = 100;
                            @endphp
                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-500" style="width: {{ min($progressPercentage, 100) }}%"></div>
                        </div>
                        @if($membershipLevel['level'] != 'بلاتيني')
                            <p class="text-xs text-gray-500">
                                @if($membershipLevel['level'] == 'برونزي') 
                                    {{ 3 - $stats['total_orders'] }} طلبات أخرى للوصول للمستوى الفضي
                                @elseif($membershipLevel['level'] == 'فضي') 
                                    {{ 10 - $stats['total_orders'] }} طلبات أخرى للوصول للمستوى الذهبي
                                @else 
                                    {{ 20 - $stats['total_orders'] }} طلبات أخرى للوصول للمستوى البلاتيني
                                @endif
                            </p>
                        @endif
                    </div>
                    @endif
                    
                    <div class="space-y-4">
                        <!-- Account Creation -->
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="bg-blue-100 p-2 rounded-full">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="mr-4">
                                <p class="font-medium text-gray-800">تم إنشاء الحساب</p>
                                <p class="text-sm text-gray-600">{{ $user->created_at->format('Y/m/d الساعة H:i') }}</p>
                            </div>
                        </div>
                        
                        <!-- Profile Updates -->
                        @if($user->updated_at->diffInDays($user->created_at) > 0)
                        <div class="flex items-center p-4 bg-green-50 rounded-lg">
                            <div class="bg-green-100 p-2 rounded-full">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div class="mr-4">
                                <p class="font-medium text-gray-800">تم تحديث الملف الشخصي</p>
                                <p class="text-sm text-gray-600">{{ $user->updated_at->format('Y/m/d الساعة H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Recent Orders -->
                        @forelse($recentOrders->take(3) as $order)
                        <div class="flex items-center p-4 bg-orange-50 rounded-lg">
                            <div class="bg-orange-100 p-2 rounded-full">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="mr-4 flex-1">
                                <p class="font-medium text-gray-800">طلب رقم #{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('Y/m/d') }} - {{ number_format($order->total_amount, 0) }} د.أ</p>
                                <span class="inline-block px-2 py-1 text-xs rounded-full 
                                    @if($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ 
                                        $order->status == 'completed' ? 'مكتمل' :
                                        ($order->status == 'pending' ? 'قيد المراجعة' :
                                        ($order->status == 'processing' ? 'قيد التجهيز' : $order->status))
                                    }}
                                </span>
                            </div>
                        </div>
                        @empty
                        @endforelse
                        
                        @if($recentOrders->isEmpty() && $user->updated_at->diffInDays($user->created_at) == 0)
                        <div class="text-center py-8">
                            <p class="text-gray-500">لا يوجد نشاط حديث</p>
                            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">ابدأ التسوق الآن</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Profile & Recommendations -->
            <div class="space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-gray-600 mb-2">{{ $user->email }}</p>
                        
                        <!-- Membership Badge -->
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $membershipLevel['color'] }} text-white mb-4">
                            {{ $membershipLevel['icon'] }} {{ $membershipLevel['level'] }}
                        </div>
                        
                        <div class="space-y-2">
                            @if($user->phone)
                                <p class="text-sm text-gray-600">📱 {{ $user->phone }}</p>
                            @endif
                            @if($user->date_of_birth)
                                <p class="text-sm text-gray-600">🎂 {{ $user->date_of_birth->format('Y/m/d') }}</p>
                            @endif
                            <p class="text-sm text-gray-600">📅 عضو منذ {{ $user->created_at->format('Y/m/d') }}</p>
                            @if($stats['total_spent'] > 0)
                                <p class="text-sm text-green-600 font-medium">💰 أنفقت {{ number_format($stats['total_spent'], 0) }} د.أ</p>
                            @endif
                        </div>

                        <a href="{{ route('profile.edit') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            تحرير الملف الشخصي
                        </a>
                    </div>
                </div>

                <!-- Recent Wishlist Items -->
                @if($recentWishlist->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">المنتجات المفضلة الأخيرة</h3>
                    <div class="space-y-3">
                        @foreach($recentWishlist->take(3) as $product)
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                @if($product->images->first())
                                    <img src="{{ $product->images->first()->image_path }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800 text-sm">{{ Str::limit($product->name, 30) }}</h4>
                                <p class="text-xs text-gray-600">
                                    @if($product->sale_price)
                                        {{ number_format($product->sale_price, 0) }} د.أ
                                        <span class="line-through text-gray-400">{{ number_format($product->price, 0) }}</span>
                                    @else
                                        {{ number_format($product->price, 0) }} د.أ
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('wishlist') }}" class="mt-4 block text-center text-blue-600 hover:text-blue-800 font-medium">عرض جميع المفضلة</a>
                </div>
                @endif

                <!-- Quick Links -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">روابط سريعة</h3>
                    <div class="space-y-3">
                        <a href="{{ route('products.index') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            تصفح المنتجات
                        </a>
                        <a href="{{ route('offers') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            العروض الخاصة
                        </a>
                        <a href="{{ route('contact') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            اتصل بنا
                        </a>
                        <a href="{{ route('faq') }}" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-200">
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            الأسئلة الشائعة
                        </a>
                    </div>
                </div>

                <!-- Support -->
                <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold mb-2">تحتاج مساعدة؟</h3>
                    <p class="text-sm opacity-90 mb-4">فريق الدعم متاح لمساعدتك</p>
                    <a href="{{ route('contact') }}" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition duration-200">
                        اتصل بنا
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




