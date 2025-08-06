@extends('layouts.app')

@section('title', 'الشروط والأحكام - MalakOutlet')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">الشروط والأحكام</h1>
            <p class="text-lg text-gray-600">تاريخ آخر تحديث: {{ date('Y/m/d') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white shadow-lg rounded-lg p-8 space-y-8">
            <!-- Introduction -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">مقدمة</h2>
                <p class="text-gray-700 leading-relaxed">
                    مرحباً بكم في متجر MalakOutlet. هذه الشروط والأحكام تحكم استخدامكم لموقعنا الإلكتروني وخدماتنا. 
                    باستخدام موقعنا، فإنكم توافقون على الالتزام بهذه الشروط والأحكام.
                </p>
            </section>

            <!-- Terms of Use -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">شروط الاستخدام</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">1. قبول الشروط</h3>
                        <p class="text-gray-700 leading-relaxed">
                            بالدخول إلى موقعنا واستخدامه، فإنكم تقرون بأنكم قد قرأتم وفهمتم ووافقتم على الالتزام بجميع الشروط والأحكام الواردة هنا.
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">2. استخدام الموقع</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-2">
                            <li>يجب أن تكونوا بعمر 18 سنة أو أكثر لاستخدام خدماتنا</li>
                            <li>يجب تقديم معلومات صحيحة ودقيقة عند التسجيل</li>
                            <li>أنتم مسؤولون عن الحفاظ على سرية معلومات حسابكم</li>
                            <li>لا يجوز استخدام الموقع لأي أغراض غير قانونية</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">3. المنتجات والخدمات</h3>
                        <p class="text-gray-700 leading-relaxed">
                            نحن نسعى لتقديم وصف دقيق لجميع المنتجات، ولكن لا نضمن أن الأوصاف أو المحتوى الآخر دقيق أو كامل أو موثوق أو خالي من الأخطاء.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Payment and Shipping -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">الدفع والشحن</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">طرق الدفع</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-2">
                            <li>الدفع عند الاستلام</li>
                            <li>التحويل البنكي</li>
                            <li>البطاقات الائتمانية</li>
                            <li>المحافظ الإلكترونية</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">سياسة الشحن</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-2">
                            <li>الشحن متاح لجميع المحافظات</li>
                            <li>مدة التوصيل من 2-5 أيام عمل</li>
                            <li>رسوم الشحن تختلف حسب المنطقة والوزن</li>
                            <li>الشحن مجاني للطلبات فوق 100 دينار</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Returns and Refunds -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">الإرجاع والاستبدال</h2>
                <div class="space-y-4">
                    <p class="text-gray-700 leading-relaxed">
                        يمكنكم إرجاع المنتجات خلال 14 يوماً من تاريخ الاستلام بشرط أن تكون المنتجات في حالتها الأصلية.
                    </p>
                    
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">شروط الإرجاع:</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>المنتج في حالته الأصلية وغير مستخدم</li>
                        <li>وجود الفاتورة الأصلية</li>
                        <li>المنتج في العبوة الأصلية</li>
                        <li>عدم وجود تلف أو خدوش</li>
                    </ul>
                </div>
            </section>

            <!-- Limitation of Liability -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">حدود المسؤولية</h2>
                <p class="text-gray-700 leading-relaxed">
                    لا نتحمل المسؤولية عن أي أضرار مباشرة أو غير مباشرة قد تنتج عن استخدام موقعنا أو منتجاتنا، 
                    باستثناء ما ينص عليه القانون صراحة.
                </p>
            </section>

            <!-- Changes to Terms -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">تعديل الشروط</h2>
                <p class="text-gray-700 leading-relaxed">
                    نحتفظ بالحق في تعديل هذه الشروط والأحكام في أي وقت. سيتم إشعاركم بأي تغييرات مهمة عبر البريد الإلكتروني أو من خلال إشعار على موقعنا.
                </p>
            </section>

            <!-- Contact Information -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">معلومات التواصل</h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p class="text-gray-700 leading-relaxed mb-4">
                        إذا كان لديكم أي أسئلة حول هذه الشروط والأحكام، يرجى التواصل معنا:
                    </p>
                    <div class="space-y-2 text-gray-700">
                        <p><strong>البريد الإلكتروني:</strong> support@malakoutlet.com</p>
                        <p><strong>الهاتف:</strong> +964 123 456 789</p>
                        <p><strong>العنوان:</strong> بغداد، العراق</p>
                    </div>
                </div>
            </section>

            <!-- Back to Register -->
            <div class="text-center pt-8 border-t border-gray-200">
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-medium rounded-lg hover:bg-orange-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    العودة للتسجيل
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
