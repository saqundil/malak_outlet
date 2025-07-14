@extends('layouts.main')

@section('title', 'شروط الاستخدام - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">شروط الاستخدام</h1>
            <p class="text-xl opacity-90">الشروط والأحكام العامة لاستخدام متجر ملاك</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="mb-8">
                    <p class="text-gray-600 leading-relaxed">
                        آخر تحديث: {{ date('Y/m/d') }}
                    </p>
                    <p class="text-gray-600 leading-relaxed mt-4">
                        مرحباً بك في متجر ملاك. باستخدامك لموقعنا الإلكتروني وخدماتنا، فإنك توافق على الالتزام بهذه الشروط والأحكام. يرجى قراءتها بعناية قبل استخدام خدماتنا.
                    </p>
                </div>

                <!-- General Terms -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">1. الشروط العامة</h2>
                    <div class="space-y-4 text-gray-600">
                        <p>
                            باستخدام هذا الموقع، فإنك تؤكد أنك تبلغ من العمر 18 عاماً على الأقل أو تستخدم الموقع تحت إشراف والدك أو ولي أمرك.
                        </p>
                        <p>
                            نحتفظ بالحق في تعديل هذه الشروط في أي وقت دون إشعار مسبق. استمرارك في استخدام الموقع يعني موافقتك على التعديلات.
                        </p>
                        <p>
                            الموقع والمحتوى الموجود عليه محمي بحقوق الطبع والنشر وقوانين الملكية الفكرية.
                        </p>
                    </div>
                </div>

                <!-- Account Terms -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">2. حساب المستخدم</h2>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span class="text-gray-600">يجب تقديم معلومات صحيحة ودقيقة عند إنشاء الحساب</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span class="text-gray-600">أنت مسؤول عن الحفاظ على سرية كلمة المرور الخاصة بك</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span class="text-gray-600">أنت مسؤول عن جميع الأنشطة التي تحدث تحت حسابك</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span class="text-gray-600">يحق لنا تعليق أو إنهاء حسابك في حالة انتهاك الشروط</span>
                        </li>
                    </ul>
                </div>

                <!-- Orders and Payment -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">3. الطلبات والدفع</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">تأكيد الطلبات</h3>
                            <ul class="space-y-2 text-gray-600 mr-4">
                                <li>• جميع الطلبات خاضعة لتوفر المنتجات</li>
                                <li>• نحتفظ بالحق في رفض أو إلغاء أي طلب</li>
                                <li>• سيتم إرسال تأكيد الطلب عبر البريد الإلكتروني</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">الأسعار والدفع</h3>
                            <ul class="space-y-2 text-gray-600 mr-4">
                                <li>• جميع الأسعار بالريال السعودي وتشمل ضريبة القيمة المضافة</li>
                                <li>• نقبل بطاقات الائتمان والدفع عند التسليم</li>
                                <li>• الأسعار قابلة للتغيير دون إشعار مسبق</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Shipping and Delivery -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">4. الشحن والتوصيل</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">أوقات التوصيل</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• الرياض: 1-2 أيام عمل</li>
                                <li>• جدة والدمام: 2-3 أيام عمل</li>
                                <li>• باقي المدن: 3-5 أيام عمل</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">رسوم الشحن</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• مجاني للطلبات أكثر من 200 ريال</li>
                                <li>• 15 ريال للطلبات الأقل</li>
                                <li>• رسوم إضافية للمناطق النائية</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Returns and Refunds -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">5. الإرجاع والاستبدال</h2>
                    <div class="space-y-4 text-gray-600">
                        <p>
                            يمكن إرجاع المنتجات خلال 14 يوماً من تاريخ الاستلام بالشروط التالية:
                        </p>
                        <ul class="space-y-2 mr-4">
                            <li>• المنتج في حالته الأصلية وغير مستخدم</li>
                            <li>• وجود العبوة الأصلية وجميع الملحقات</li>
                            <li>• تقديم فاتورة الشراء</li>
                            <li>• المنتجات الصحية والشخصية غير قابلة للإرجاع</li>
                        </ul>
                        <p class="font-semibold">
                            سيتم رد المبلغ خلال 5-7 أيام عمل بعد استلام المنتج المرتجع.
                        </p>
                    </div>
                </div>

                <!-- Prohibited Uses -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">6. الاستخدامات المحظورة</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 mb-3">يُحظر استخدام الموقع لـ:</p>
                            <ul class="space-y-2 text-gray-600 text-sm">
                                <li>• أي أغراض غير قانونية</li>
                                <li>• انتهاك أي قوانين محلية أو دولية</li>
                                <li>• إرسال محتوى ضار أو فيروسات</li>
                                <li>• التدخل في أمان الموقع</li>
                            </ul>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-3">كما يُحظر:</p>
                            <ul class="space-y-2 text-gray-600 text-sm">
                                <li>• انتحال شخصية الآخرين</li>
                                <li>• جمع معلومات المستخدمين</li>
                                <li>• استخدام الموقع للتجارة غير المشروعة</li>
                                <li>• نشر محتوى مسيء أو مضلل</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Limitation of Liability -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">7. تحديد المسؤولية</h2>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed">
                            متجر ملاك غير مسؤول عن أي أضرار مباشرة أو غير مباشرة قد تنجم عن استخدام الموقع أو المنتجات، 
                            باستثناء ما ينص عليه القانون. مسؤوليتنا محدودة بقيمة المنتج المشترى.
                        </p>
                    </div>
                </div>

                <!-- Governing Law -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">8. القانون المطبق</h2>
                    <p class="text-gray-600">
                        هذه الشروط محكومة بالقوانين السارية في المملكة العربية السعودية. 
                        أي نزاع ينشأ عن هذه الشروط يخضع لاختصاص المحاكم السعودية.
                    </p>
                </div>

                <!-- Contact Information -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">تواصل معنا</h2>
                    <p class="text-gray-600 mb-4">
                        لأي استفسارات حول هذه الشروط، تواصل معنا:
                    </p>
                    <div class="space-y-2 text-gray-600">
                        <p><strong>البريد الإلكتروني:</strong> legal@malak-outlet.com</p>
                        <p><strong>الهاتف:</strong> +966-11-234-5678</p>
                        <p><strong>ساعات العمل:</strong> الأحد - الخميس، 9:00 ص - 6:00 م</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
