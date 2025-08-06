@extends('layouts.main')

@section('title', 'اتصل بنا - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="py-10">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">اتصل بنا</h1>
            <p class="text-xl opacity-90">نحن هنا لمساعدتك في أي استفسار</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-10">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">أرسل لنا رسالة</h2>
                    
                    <form class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل *</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="أدخل اسمك الكامل">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني *</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="example@email.com">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                            <input type="tel" id="phone" name="phone" dir="rtl"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="05xxxxxxxx">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">الموضوع *</label>
                            <select id="subject" name="subject" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">اختر الموضوع</option>
                                <option value="general">استفسار عام</option>
                                <option value="order">استفسار عن طلب</option>
                                <option value="return">استبدال أو إرجاع</option>
                                <option value="technical">مشكلة تقنية</option>
                                <option value="suggestion">اقتراح أو ملاحظة</option>
                                <option value="other">أخرى</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">الرسالة *</label>
                            <textarea id="message" name="message" rows="6" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                      placeholder="اكتب رسالتك هنا..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition duration-200 font-medium">
                            إرسال الرسالة
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-6 sm:space-y-8">
                    <!-- Contact Cards -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 lg:p-8">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">معلومات التواصل</h2>
                        
                        <div class="space-y-6 sm:space-y-8">
                            <!-- Address & Phone (Mobile: Stacked, Desktop: Side by side) -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                                <!-- Address -->
                                <div class="flex items-start">
                                    <div class="bg-green-100 p-2 sm:p-3 rounded-lg ml-3 sm:ml-4 flex-shrink-0">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">العنوان</h3>
                                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed whitespace-pre-line">{{ $contactInfo['address'] ?? 'لم يتم تحديد العنوان بعد' }}</p>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="flex items-start">
                                    <div class="bg-blue-100 p-2 sm:p-3 rounded-lg ml-3 sm:ml-4 flex-shrink-0">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">الهاتف</h3>
                                        <p class="text-sm sm:text-base text-gray-600 font-medium" dir="ltr">
                                            <a href="tel:{{ str_replace(['+', ' '], '', $contactInfo['phone'] ?? '') }}" 
                                               class="hover:text-blue-600 transition-colors">
                                                {{ $contactInfo['phone'] ?? 'لم يتم تحديد الهاتف بعد' }}
                                            </a>
                                        </p>
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-relaxed whitespace-pre-line">{{ $contactInfo['phone_hours'] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Email & WhatsApp (Mobile: Stacked, Desktop: Side by side) -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                                <!-- Email -->
                                <div class="flex items-start">
                                    <div class="bg-purple-100 p-2 sm:p-3 rounded-lg ml-3 sm:ml-4 flex-shrink-0">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">البريد الإلكتروني</h3>
                                        @if($contactInfo['email_info'])
                                        <p class="text-sm sm:text-base text-gray-600 break-all">
                                            <a href="mailto:{{ $contactInfo['email_info'] }}" 
                                               class="hover:text-purple-600 transition-colors">
                                                {{ $contactInfo['email_info'] }}
                                            </a>
                                        </p>
                                        @endif
                                        @if($contactInfo['email_support'])
                                        <p class="text-sm sm:text-base text-gray-600 break-all">
                                            <a href="mailto:{{ $contactInfo['email_support'] }}" 
                                               class="hover:text-purple-600 transition-colors">
                                                {{ $contactInfo['email_support'] }}
                                            </a>
                                        </p>
                                        @endif
                                        @if($contactInfo['email_response_time'])
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ $contactInfo['email_response_time'] }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- WhatsApp -->
                                <div class="flex items-start">
                                    <div class="bg-green-100 p-2 sm:p-3 rounded-lg ml-3 sm:ml-4 flex-shrink-0">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.108"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">واتساب</h3>
                                        @if($contactInfo['whatsapp'])
                                        <a href="{{ $contactInfo['whatsapp_url'] ?? '#' }}" 
                                           class="text-sm sm:text-base text-green-600 hover:text-green-800 font-medium" 
                                           dir="ltr">{{ $contactInfo['whatsapp'] }}</a>
                                        @endif
                                        @if($contactInfo['whatsapp_description'])
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ $contactInfo['whatsapp_description'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 lg:p-8">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">ساعات العمل</h2>
                        
                        <div class="space-y-2 sm:space-y-3">
                            @if(isset($businessHours['hours']) && is_array($businessHours['hours']))
                                @foreach($businessHours['hours'] as $period)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="font-medium text-gray-800 text-sm sm:text-base">{{ $period['label'] ?? '' }}</span>
                                        <span class="{{ isset($period['closed']) && $period['closed'] ? 'text-red-600 font-medium' : 'text-gray-600' }} text-sm sm:text-base">
                                            {{ $period['hours'] ?? '' }}
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <!-- Fallback if no business hours are set -->
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="font-medium text-gray-800 text-sm sm:text-base">السبت - الأربعاء</span>
                                    <span class="text-gray-600 text-sm sm:text-base">9:00 صباحاً - 9:00 مساءً</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="font-medium text-gray-800 text-sm sm:text-base">الخميس</span>
                                    <span class="text-gray-600 text-sm sm:text-base">9:00 صباحاً - 6:00 مساءً</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="font-medium text-gray-800 text-sm sm:text-base">الجمعة</span>
                                    <span class="text-red-600 font-medium text-sm sm:text-base">مغلق</span>
                                </div>
                            @endif
                        </div>

                        @if($businessHours['whatsapp_24_7'])
                        <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-blue-50 rounded-lg">
                            <p class="text-xs sm:text-sm text-blue-800">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 inline ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $businessHours['whatsapp_24_7'] }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- FAQ Quick Links -->
            <div class="mt-12 sm:mt-16 bg-white rounded-lg shadow-lg p-4 sm:p-6 lg:p-8">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 text-center">أسئلة شائعة</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <a href="{{ route('faq') }}" class="p-4 sm:p-6 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition duration-200">
                        <div class="text-green-600 text-2xl sm:text-3xl mb-2 sm:mb-3">❓</div>
                        <h3 class="font-semibold text-gray-800 mb-1 sm:mb-2 text-sm sm:text-base">كيف أتتبع طلبي؟</h3>
                        <p class="text-gray-600 text-xs sm:text-sm">تعرف على كيفية تتبع حالة طلبك</p>
                    </a>

                    <a href="{{ route('returns') }}" class="p-4 sm:p-6 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition duration-200">
                        <div class="text-blue-600 text-2xl sm:text-3xl mb-2 sm:mb-3">🔄</div>
                        <h3 class="font-semibold text-gray-800 mb-1 sm:mb-2 text-sm sm:text-base">سياسة الاستبدال</h3>
                        <p class="text-gray-600 text-xs sm:text-sm">تفاصيل عملية الاستبدال والإرجاع</p>
                    </a>

                    <a href="{{ route('faq') }}" class="p-4 sm:p-6 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition duration-200 sm:col-span-2 lg:col-span-1">
                        <div class="text-purple-600 text-2xl sm:text-3xl mb-2 sm:mb-3">🚚</div>
                        <h3 class="font-semibold text-gray-800 mb-1 sm:mb-2 text-sm sm:text-base">معلومات الشحن</h3>
                        <p class="text-gray-600 text-xs sm:text-sm">تكلفة ومدة الشحن والتوصيل</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simulate form submission
        const button = form.querySelector('button[type="submit"]');
        const originalText = button.textContent;
        
        button.textContent = 'جاري الإرسال...';
        button.disabled = true;
        
        setTimeout(() => {
            alert('تم إرسال رسالتك بنجاح! سنقوم بالرد عليك في أقرب وقت ممكن.');
            form.reset();
            button.textContent = originalText;
            button.disabled = false;
        }, 2000);
    });
});
</script>
@endsection




