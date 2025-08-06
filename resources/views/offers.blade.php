@extends('layouts.main')

@section('title', 'العروض والخصومات - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-red-500 to-pink-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">العروض والخصومات</h1>
            <p class="text-xl opacity-90">اكتشف أفضل العروض على الألعاب المفضلة لأطفالك</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        <!-- Current Offers -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">العروض الحالية</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                استفد من عروضنا الحصرية واحصل على أفضل الألعاب بأسعار مذهلة. جميع العروض محدودة المدة!
            </p>
        </div>

        <!-- Featured Offers -->
        <div class="grid lg:grid-cols-2 gap-8 mb-16">
            <!-- Mega Sale Banner -->
            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl p-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-3xl font-bold mb-2">تخفيضات كبرى!</h3>
                    <p class="text-lg mb-4 opacity-90">خصم يصل إلى 50% على مجموعة مختارة</p>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-white text-orange-600 px-3 py-1 rounded-full text-sm font-bold">كود الخصم: MEGA50</span>
                    </div>
                    <a href="{{ route('products.index') }}" class="bg-white text-orange-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                        تسوق الآن
                    </a>
                </div>
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="stars" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                <circle cx="10" cy="10" r="2" fill="white"/>
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#stars)"/>
                    </svg>
                </div>
            </div>

            <!-- Free Shipping -->
            <div class="bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl p-8 text-white">
                <h3 class="text-3xl font-bold mb-2">شحن مجاني</h3>
                <p class="text-lg mb-4 opacity-90">على جميع الطلبات أكثر من 50 دينار</p>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="font-semibold">توصيل سريع خلال 24 ساعة</span>
                </div>
                <a href="{{ route('products.index') }}" class="bg-white text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                    ابدأ التسوق
                </a>
            </div>
        </div>

        <!-- Offer Categories -->
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">عروض نهاية الأسبوع</h3>
                <p class="text-gray-600 mb-4">خصومات خاصة كل نهاية أسبوع</p>
                <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">خصم 25%</span>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">عروض العملاء المفضلين</h3>
                <p class="text-gray-600 mb-4">خصومات حصرية للعملاء المسجلين</p>
                <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-sm font-semibold">خصم 15%</span>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">عروض المواسم</h3>
                <p class="text-gray-600 mb-4">خصومات خاصة في المناسبات والعطل</p>
                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm font-semibold">خصم 30%</span>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">شروط وأحكام العروض</h3>
            <div class="grid md:grid-cols-2 gap-6 text-gray-600">
                <div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>جميع العروض محدودة المدة وقابلة للانتهاء دون إشعار مسبق</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>لا يمكن دمج أكثر من عرض واحد في نفس الطلب</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>كوبونات الخصم صالحة لاستخدام واحد فقط لكل عميل</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>الخصومات تطبق على السعر الأصلي للمنتج</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>عرض الشحن المجاني يطبق داخل المملكة فقط</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>يحتفظ المتجر بحق تعديل أو إلغاء أي عرض</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




