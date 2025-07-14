@extends('layouts.main')

@section('title', 'الأسئلة الشائعة - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-teal-600 to-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">الأسئلة الشائعة</h1>
            <p class="text-xl opacity-90">إجابات على أكثر الأسئلة تكراراً من عملائنا</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            <!-- Search FAQ -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">ابحث في الأسئلة الشائعة</h2>
                    <div class="relative max-w-md mx-auto">
                        <input type="text" placeholder="ابحث عن سؤالك..." 
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               id="faq-search">
                        <svg class="w-5 h-5 text-gray-400 absolute right-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- FAQ Categories -->
            <div class="grid md:grid-cols-4 gap-4 mb-8">
                <button class="bg-white rounded-lg p-4 text-center hover:bg-blue-50 transition-colors faq-category active" data-category="all">
                    <h3 class="font-semibold text-gray-800">جميع الأسئلة</h3>
                </button>
                <button class="bg-white rounded-lg p-4 text-center hover:bg-blue-50 transition-colors faq-category" data-category="orders">
                    <h3 class="font-semibold text-gray-800">الطلبات</h3>
                </button>
                <button class="bg-white rounded-lg p-4 text-center hover:bg-blue-50 transition-colors faq-category" data-category="shipping">
                    <h3 class="font-semibold text-gray-800">الشحن</h3>
                </button>
                <button class="bg-white rounded-lg p-4 text-center hover:bg-blue-50 transition-colors faq-category" data-category="returns">
                    <h3 class="font-semibold text-gray-800">الإرجاع</h3>
                </button>
            </div>

            <!-- FAQ Items -->
            <div class="space-y-4" id="faq-container">
                <!-- Orders FAQ -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="orders">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">كيف يمكنني تتبع طلبي؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            بعد تأكيد طلبك، ستتلقى رسالة بريد إلكتروني تحتوي على رقم التتبع. يمكنك استخدام هذا الرقم لتتبع حالة طلبك على موقعنا في قسم "تتبع الطلب" أو التواصل معنا مباشرة.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="orders">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">كم يستغرق تأكيد الطلب؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            يتم تأكيد الطلبات خلال 2-4 ساعات من وقت الطلب في أيام العمل. في نهاية الأسبوع والعطل، قد يستغرق التأكيد حتى 24 ساعة.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="orders">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">هل يمكنني تعديل أو إلغاء طلبي؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            يمكنك تعديل أو إلغاء طلبك خلال ساعة واحدة من وقت الطلب. بعد ذلك، إذا لم يتم شحن الطلب بعد، تواصل معنا وسنحاول مساعدتك.
                        </p>
                    </div>
                </div>

                <!-- Shipping FAQ -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="shipping">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">ما هي مدة التوصيل؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <div class="text-gray-600 leading-relaxed">
                            <p class="mb-3">مدة التوصيل تختلف حسب المنطقة:</p>
                            <ul class="list-disc list-inside space-y-1 mr-4">
                                <li>عمان: 1-2 أيام عمل</li>
                                <li>إربد والزرقاء: 2-3 أيام عمل</li>
                                <li>المدن الرئيسية: 3-4 أيام عمل</li>
                                <li>المناطق النائية: 5-7 أيام عمل</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="shipping">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">كم تبلغ رسوم الشحن؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <div class="text-gray-600 leading-relaxed">
                            <p class="mb-3">رسوم الشحن كالتالي:</p>
                            <ul class="list-disc list-inside space-y-1 mr-4">
                                <li>مجاني للطلبات أكثر من 50 دينار</li>
                                <li>3 دينار للطلبات داخل المدن الرئيسية</li>
                                <li>5 دينار للمناطق النائية</li>
                                <li>رسوم إضافية للتوصيل السريع</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="shipping">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">هل توصلون خارج الأردن؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            حالياً نوصل داخل المملكة الأردنية الهاشمية فقط. نعمل على توسيع خدماتنا لتشمل دول المنطقة قريباً.
                        </p>
                    </div>
                </div>

                <!-- Returns FAQ -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="returns">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">كم المدة المسموحة لإرجاع المنتج؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            يمكنك إرجاع المنتج خلال 14 يوماً من تاريخ الاستلام، شرط أن يكون في حالته الأصلية وغير مستخدم مع جميع الملحقات والعبوة الأصلية.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="returns">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">هل رسوم الإرجاع مجانية؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            نعم، نتحمل نحن رسوم استلام المنتجات المرتجعة من عنوانك. لن تدفع أي رسوم إضافية للإرجاع.
                        </p>
                    </div>
                </div>

                <!-- General FAQ -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="general">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">ما هي طرق الدفع المتاحة؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <div class="text-gray-600 leading-relaxed">
                            <p class="mb-3">نقبل طرق الدفع التالية:</p>
                            <ul class="list-disc list-inside space-y-1 mr-4">
                                <li>بطاقات الائتمان (فيزا، ماستركارد، أمريكان إكسبريس)</li>
                                <li>مدى</li>
                                <li>أبل باي</li>
                                <li>الدفع عند التسليم</li>
                                <li>التحويل البنكي</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="general">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">هل منتجاتكم أصلية ومضمونة؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            نعم، جميع منتجاتنا أصلية 100% ونحصل عليها من الموردين المعتمدين والوكلاء الرسميين. كما نقدم ضمان الوكيل على جميع المنتجات حسب نوع كل منتج.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden faq-item" data-category="general">
                    <button class="w-full px-8 py-6 text-right flex justify-between items-center hover:bg-gray-50 faq-toggle">
                        <span class="text-lg font-semibold text-gray-800">كيف يمكنني التواصل مع خدمة العملاء؟</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform faq-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-8 pb-6">
                        <div class="text-gray-600 leading-relaxed">
                            <p class="mb-3">يمكنك التواصل معنا عبر:</p>
                            <ul class="list-disc list-inside space-y-1 mr-4">
                                <li>الهاتف: +962-6-234-5678</li>
                                <li>البريد الإلكتروني: support@malakoutlet.com</li>
                                <li>الواتساب: +962-79-123-4567</li>
                                <li>ساعات العمل: الأحد - الخميس، 9:00 ص - 6:00 م</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Still Need Help -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl p-8 mt-12 text-center">
                <h2 class="text-2xl font-bold mb-4">لم تجد إجابة لسؤالك؟</h2>
                <p class="text-lg opacity-90 mb-6">فريق خدمة العملاء لدينا جاهز لمساعدتك</p>
                <a href="mailto:support@malakoutlet.com" 
                   class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                    تواصل معنا
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ toggle functionality
    const faqToggles = document.querySelectorAll('.faq-toggle');
    const faqCategories = document.querySelectorAll('.faq-category');
    const faqItems = document.querySelectorAll('.faq-item');
    const searchInput = document.getElementById('faq-search');

    faqToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const arrow = this.querySelector('.faq-arrow');
            
            content.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });
    });

    // Category filtering
    faqCategories.forEach(category => {
        category.addEventListener('click', function() {
            const targetCategory = this.dataset.category;
            
            // Update active category
            faqCategories.forEach(cat => cat.classList.remove('active', 'bg-blue-50'));
            this.classList.add('active', 'bg-blue-50');
            
            // Filter FAQ items
            faqItems.forEach(item => {
                if (targetCategory === 'all' || item.dataset.category === targetCategory) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        faqItems.forEach(item => {
            const questionText = item.querySelector('.faq-toggle span').textContent.toLowerCase();
            const answerText = item.querySelector('.faq-content').textContent.toLowerCase();
            
            if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>

<style>
.faq-category.active {
    background-color: #dbeafe;
    border-color: #3b82f6;
}
</style>
@endsection
