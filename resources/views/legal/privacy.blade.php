@extends('layouts.app')

@section('title', 'سياسة الخصوصية - MalakOutlet')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">سياسة الخصوصية</h1>
            <p class="text-lg text-gray-600">تاريخ آخر تحديث: {{ date('Y/m/d') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white shadow-lg rounded-lg p-8 space-y-8">
            <!-- Introduction -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">مقدمة</h2>
                <p class="text-gray-700 leading-relaxed">
                    في MalakOutlet، نحن ملتزمون بحماية خصوصيتكم وأمان معلوماتكم الشخصية. 
                    توضح هذه السياسة كيفية جمعنا واستخدامنا وحماية المعلومات التي تقدمونها لنا.
                </p>
            </section>

            <!-- Information We Collect -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">المعلومات التي نجمعها</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">المعلومات الشخصية</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-2">
                            <li>الاسم الكامل</li>
                            <li>عنوان البريد الإلكتروني</li>
                            <li>رقم الهاتف</li>
                            <li>العنوان البريدي</li>
                            <li>معلومات الدفع (مشفرة وآمنة)</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">معلومات الاستخدام</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-2">
                            <li>عنوان IP الخاص بكم</li>
                            <li>نوع المتصفح ونظام التشغيل</li>
                            <li>الصفحات التي تزورونها</li>
                            <li>الوقت المقضي على الموقع</li>
                            <li>المصادر التي تحيلكم إلى موقعنا</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">ملفات الارتباط (Cookies)</h3>
                        <p class="text-gray-700 leading-relaxed">
                            نستخدم ملفات الارتباط لتحسين تجربتكم على موقعنا، وحفظ تفضيلاتكم، وتحليل كيفية استخدام الموقع.
                        </p>
                    </div>
                </div>
            </section>

            <!-- How We Use Information -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">كيفية استخدام المعلومات</h2>
                <div class="space-y-4">
                    <p class="text-gray-700 leading-relaxed">نستخدم المعلومات التي نجمعها للأغراض التالية:</p>
                    
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>معالجة وتنفيذ طلباتكم</li>
                        <li>تقديم خدمة العملاء والدعم الفني</li>
                        <li>إرسال تحديثات حول طلباتكم</li>
                        <li>تحسين منتجاتنا وخدماتنا</li>
                        <li>إرسال عروض ترويجية (بموافقتكم)</li>
                        <li>الامتثال للمتطلبات القانونية</li>
                        <li>منع الاحتيال والأنشطة غير القانونية</li>
                    </ul>
                </div>
            </section>

            <!-- Information Sharing -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">مشاركة المعلومات</h2>
                <div class="space-y-4">
                    <p class="text-gray-700 leading-relaxed">
                        نحن لا نبيع أو نؤجر أو نتاجر بمعلوماتكم الشخصية مع أطراف ثالثة. ومع ذلك، قد نشارك معلوماتكم في الحالات التالية:
                    </p>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">مقدمو الخدمات</h3>
                        <p class="text-gray-700 leading-relaxed">
                            نشارك المعلومات مع مقدمي الخدمات الموثوقين الذين يساعدوننا في تشغيل موقعنا وتقديم خدماتنا، مثل:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 space-y-1 mt-2">
                            <li>شركات معالجة المدفوعات</li>
                            <li>شركات الشحن والتوصيل</li>
                            <li>مقدمو خدمات التكنولوجيا</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">المتطلبات القانونية</h3>
                        <p class="text-gray-700 leading-relaxed">
                            قد نكشف عن معلوماتكم إذا كان ذلك مطلوباً بموجب القانون أو لحماية حقوقنا أو سلامة الآخرين.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Data Security -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">أمان البيانات</h2>
                <div class="space-y-4">
                    <p class="text-gray-700 leading-relaxed">
                        نطبق تدابير أمنية متقدمة لحماية معلوماتكم الشخصية:
                    </p>
                    
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>تشفير SSL لجميع عمليات نقل البيانات</li>
                        <li>تشفير معلومات بطاقات الائتمان</li>
                        <li>وصول محدود للمعلومات الشخصية</li>
                        <li>مراقبة أمنية مستمرة</li>
                        <li>تحديثات أمنية منتظمة</li>
                        <li>نسخ احتياطية آمنة للبيانات</li>
                    </ul>
                </div>
            </section>

            <!-- Data Retention -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">الاحتفاظ بالبيانات</h2>
                <p class="text-gray-700 leading-relaxed">
                    نحتفظ بمعلوماتكم الشخصية طالما كان حسابكم نشطاً أو حسب الحاجة لتقديم خدماتنا. 
                    قد نحتفظ ببعض المعلومات لفترة أطول للامتثال للمتطلبات القانونية أو لحل النزاعات.
                </p>
            </section>

            <!-- Your Rights -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">حقوقكم</h2>
                <div class="space-y-4">
                    <p class="text-gray-700 leading-relaxed">لديكم الحقوق التالية فيما يتعلق بمعلوماتكم الشخصية:</p>
                    
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li><strong>الوصول:</strong> طلب نسخة من المعلومات التي نحتفظ بها عنكم</li>
                        <li><strong>التصحيح:</strong> طلب تصحيح أي معلومات غير دقيقة</li>
                        <li><strong>الحذف:</strong> طلب حذف معلوماتكم الشخصية</li>
                        <li><strong>النقل:</strong> طلب نقل معلوماتكم إلى جهة أخرى</li>
                        <li><strong>الاعتراض:</strong> الاعتراض على معالجة معلوماتكم</li>
                        <li><strong>سحب الموافقة:</strong> سحب موافقتكم في أي وقت</li>
                    </ul>
                </div>
            </section>

            <!-- Third-Party Links -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">الروابط الخارجية</h2>
                <p class="text-gray-700 leading-relaxed">
                    قد يحتوي موقعنا على روابط لمواقع خارجية. نحن لسنا مسؤولين عن ممارسات الخصوصية لهذه المواقع. 
                    نشجعكم على قراءة سياسات الخصوصية لأي موقع تزورونه.
                </p>
            </section>

            <!-- Children's Privacy -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">خصوصية الأطفال</h2>
                <p class="text-gray-700 leading-relaxed">
                    خدماتنا غير مخصصة للأطفال دون سن 13 عاماً. نحن لا نجمع عمداً معلومات شخصية من الأطفال دون هذا السن. 
                    إذا علمنا أننا جمعنا معلومات من طفل دون سن 13، سنقوم بحذفها فوراً.
                </p>
            </section>

            <!-- Changes to Privacy Policy -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">تعديل سياسة الخصوصية</h2>
                <p class="text-gray-700 leading-relaxed">
                    قد نقوم بتحديث سياسة الخصوصية هذه من وقت لآخر. سنشعركم بأي تغييرات مهمة عبر البريد الإلكتروني أو من خلال إشعار على موقعنا. 
                    ننصحكم بمراجعة هذه الصفحة بانتظام للاطلاع على أي تحديثات.
                </p>
            </section>

            <!-- Contact Information -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">معلومات التواصل</h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p class="text-gray-700 leading-relaxed mb-4">
                        إذا كان لديكم أي أسئلة حول سياسة الخصوصية هذه أو تريدون ممارسة حقوقكم، يرجى التواصل معنا:
                    </p>
                    <div class="space-y-2 text-gray-700">
                        <p><strong>البريد الإلكتروني:</strong> privacy@malakoutlet.com</p>
                        <p><strong>الهاتف:</strong> +964 123 456 789</p>
                        <p><strong>العنوان:</strong> بغداد، العراق</p>
                        <p><strong>مسؤول حماية البيانات:</strong> dpo@malakoutlet.com</p>
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
