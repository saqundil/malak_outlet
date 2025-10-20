

<?php $__env->startSection('title', 'اختبار التنبيهات - متجر ملاك'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-8">اختبار نظام التنبيهات الجديد</h1>
            
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Success Alert -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-green-600">تنبيهات النجاح</h3>
                        <button onclick="showSuccess('تم حفظ البيانات بنجاح!')" 
                                class="w-full bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition-colors font-medium">
                            عرض تنبيه نجاح
                        </button>
                        <button onclick="showSuccess('تمت إضافة المنتج للسلة بنجاح! 🛒')" 
                                class="w-full bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition-colors font-medium">
                            نجاح مع أيقونة
                        </button>
                    </div>
                    
                    <!-- Error Alert -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-red-600">تنبيهات الخطأ</h3>
                        <button onclick="showError('حدث خطأ أثناء معالجة الطلب')" 
                                class="w-full bg-red-500 text-white py-3 px-6 rounded-lg hover:bg-red-600 transition-colors font-medium">
                            عرض تنبيه خطأ
                        </button>
                        <button onclick="showError('فشل في الاتصال بالخادم. يرجى المحاولة مرة أخرى.')" 
                                class="w-full bg-red-500 text-white py-3 px-6 rounded-lg hover:bg-red-600 transition-colors font-medium">
                            خطأ اتصال
                        </button>
                    </div>
                    
                    <!-- Warning Alert -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-yellow-600">تنبيهات التحذير</h3>
                        <button onclick="showWarning('يجب ملء جميع الحقول المطلوبة')" 
                                class="w-full bg-yellow-500 text-white py-3 px-6 rounded-lg hover:bg-yellow-600 transition-colors font-medium">
                            عرض تنبيه تحذير
                        </button>
                        <button onclick="showWarning('سيتم حذف البيانات نهائياً بعد 30 يوم ⚠️')" 
                                class="w-full bg-yellow-500 text-white py-3 px-6 rounded-lg hover:bg-yellow-600 transition-colors font-medium">
                            تحذير هام
                        </button>
                    </div>
                    
                    <!-- Info Alert -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-blue-600">تنبيهات المعلومات</h3>
                        <button onclick="showInfo('تم إرسال رسالة التفعيل إلى بريدك الإلكتروني')" 
                                class="w-full bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-600 transition-colors font-medium">
                            عرض تنبيه معلومات
                        </button>
                        <button onclick="showInfo('جديد! يمكنك الآن استخدام ميزة الدفع السريع 💳')" 
                                class="w-full bg-blue-500 text-white py-3 px-6 rounded-lg hover:blue-600 transition-colors font-medium">
                            معلومات جديدة
                        </button>
                    </div>
                </div>
                
                <div class="mt-12 border-t border-gray-200 pt-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 text-center">تنبيهات التأكيد المخصصة</h3>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button onclick="showConfirm('هل تريد حذف هذا العنصر؟', () => showSuccess('تم الحذف بنجاح'), () => showInfo('تم إلغاء العملية'))" 
                                class="bg-orange-500 text-white py-3 px-6 rounded-lg hover:bg-orange-600 transition-colors font-medium">
                            تأكيد الحذف
                        </button>
                        <button onclick="showConfirm('هل تريد حفظ التغييرات؟', () => showSuccess('تم حفظ التغييرات'), () => showWarning('التغييرات غير محفوظة'))" 
                                class="bg-purple-500 text-white py-3 px-6 rounded-lg hover:bg-purple-600 transition-colors font-medium">
                            تأكيد الحفظ
                        </button>
                        <button onclick="showConfirm('هل تريد الخروج من التطبيق؟', () => showInfo('تم تسجيل الخروج'), () => showSuccess('مرحباً بك مرة أخرى'))" 
                                class="bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 transition-colors font-medium">
                            تأكيد الخروج
                        </button>
                    </div>
                </div>
                
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">اختبارات متقدمة</h3>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button onclick="testMultipleAlerts()" 
                                class="bg-indigo-500 text-white py-3 px-6 rounded-lg hover:bg-indigo-600 transition-colors font-medium">
                            عدة تنبيهات متتالية
                        </button>
                        <button onclick="testLongMessage()" 
                                class="bg-pink-500 text-white py-3 px-6 rounded-lg hover:bg-pink-600 transition-colors font-medium">
                            رسالة طويلة
                        </button>
                    </div>
                </div>
                
                <div class="mt-8 text-center">
                    <a href="<?php echo e(route('home')); ?>" class="text-orange-600 hover:text-orange-700 font-medium">
                        ← العودة للصفحة الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testMultipleAlerts() {
    showInfo('بدء الاختبار...');
    
    setTimeout(() => {
        showWarning('جاري المعالجة...');
    }, 1000);
    
    setTimeout(() => {
        showSuccess('تم بنجاح!');
    }, 2000);
    
    setTimeout(() => {
        showError('حدث خطأ في النهاية');
    }, 3000);
}

function testLongMessage() {
    showInfo('هذه رسالة طويلة جداً لاختبار كيفية عرض النص الطويل في التنبيهات المخصصة. يجب أن يتم عرضها بشكل صحيح ومقروء مع الحفاظ على التصميم الجميل والوضوح. يمكن أن تحتوي الرسائل على معلومات مفصلة أو تعليمات مهمة للمستخدم.');
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/test-alerts.blade.php ENDPATH**/ ?>