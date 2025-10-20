

<?php $__env->startSection('title', 'إتمام الطلب - متجر ملاك'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="py-10">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">إتمام الطلب</h1>
            <p class="text-xl opacity-90">خطوة واحدة أخيرة لإتمام طلبك</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-4">
        <!-- Flash messages will be shown via custom alerts -->

        <?php if(empty($cartItems)): ?>
            <div class="max-w-2xl mx-auto text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5 3H3m4 10v6a1 1 0 001 1h8a1 1 0 001-1v-6M9 19h6"></path>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-600 mb-2">السلة فارغة</h2>
                <p class="text-gray-500 mb-6">يجب إضافة منتجات للسلة قبل إتمام الطلب</p>
                <a href="<?php echo e(route('products.index')); ?>" class="bg-orange-500 text-white px-8 py-3 rounded-lg hover:bg-orange-600 transition duration-200">
                    تصفح المنتجات
                </a>
            </div>
        <?php else: ?>
            <div class="max-w-6xl mx-auto">
                <form action="<?php echo e(route('checkout.store')); ?>" method="POST" class="lg:grid lg:grid-cols-2 lg:gap-12">
                    <?php echo csrf_field(); ?>
                    
                    <!-- Shipping & Payment Information -->
                    <div class="space-y-8">
                        <!-- Shipping Information -->
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">معلومات الشحن</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل</label>
                                    <input type="text" id="name" name="name" value="<?php echo e(auth()->user()->name); ?>" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500" readonly>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف *</label>
                                    <input dir="rtl" type="tel" id="phone" name="phone" value="<?php echo e(old('phone', auth()->user()->phone ?? '')); ?>" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                           placeholder="07xxxxxxxx">
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="jordan_city_id" class="block text-sm font-medium text-gray-700 mb-2">المدينة / المحافظة *</label>
                                    <select id="jordan_city_id" name="jordan_city_id" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                        <option value="">اختر المدينة</option>
                                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($city->id); ?>" 
                                                    data-delivery-cost="<?php echo e($city->delivery_cost); ?>"
                                                    data-delivery-days="<?php echo e($city->delivery_days); ?>"
                                                    <?php echo e(old('jordan_city_id') == $city->id ? 'selected' : ''); ?>>
                                                <?php echo e($city->name_ar); ?> - <?php echo e($city->formatted_delivery_cost); ?>

                                                (<?php echo e($city->delivery_days == 1 ? 'يوم واحد' : $city->delivery_days . ' أيام'); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['jordan_city_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div id="delivery-info" class="mt-2 text-sm text-gray-600 hidden"></div>
                                </div>

                                <div>
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">عنوان الشحن التفصيلي *</label>
                                    <textarea id="shipping_address" name="shipping_address" rows="4" required
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                              placeholder="الحي، اسم الشارع، رقم المبنى، الطابق، أي معلومات إضافية للوصول"><?php echo e(old('shipping_address')); ?></textarea>
                                    <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">ملاحظات إضافية</label>
                                    <textarea id="notes" name="notes" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"
                                              placeholder="أي ملاحظات خاصة بالطلب..."><?php echo e(old('notes')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">طريقة الدفع</h3>
                            
                            <div class="space-y-4">
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="payment_method" value="cash" class="ml-3" checked>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-orange-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <div>
                                            <div class="font-medium">الدفع عند الاستلام</div>
                                            <div class="text-sm text-gray-500">ادفع نقداً عند وصول الطلب</div>
                                        </div>
                                    </div>
                                </label>

                                
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-8 lg:mt-0">
                        <div class="bg-white rounded-lg shadow-md p-8 sticky top-4">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">ملخص الطلب</h3>
                            
                            <div class="space-y-4 mb-6">
                                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center space-x-4 space-x-reverse">
                                        <?php if($item['product']->images->first()): ?>
                                            <img src="<?php echo e($item['product']->images->first()->image_path); ?>" 
                                                 alt="<?php echo e($item['product']->name); ?>" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        <?php else: ?>
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-800"><?php echo e($item['product']->name); ?></h4>
                                            <div class="flex justify-between items-center mt-1">
                                                <span class="text-sm text-gray-600">الكمية: <?php echo e($item['quantity']); ?></span>
                                                <span class="font-medium"><?php echo e(number_format($item['total'], 2)); ?> د.أ</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="border-t pt-4 space-y-2">
                                <?php if($totalSavings > 0): ?>
                                <div class="flex justify-between text-gray-600">
                                    <span>السعر الأصلي:</span>
                                    <span class="line-through text-gray-400"><?php echo e(number_format($totalOriginal, 2)); ?> د.أ</span>
                                </div>
                                <div class="flex justify-between text-green-600">
                                    <span>إجمالي الخصم:</span>
                                    <span class="font-bold">-<?php echo e(number_format($totalSavings, 2)); ?> د.أ</span>
                                </div>
                                <?php endif; ?>
                                <div class="flex justify-between">
                                    <span>المجموع الفرعي:</span>
                                    <span id="subtotal-display"><?php echo e(number_format($subtotal, 2)); ?> د.أ</span>
                                </div>
                                <div class="flex justify-between" id="delivery-cost-row">
                                    <span>تكلفة التوصيل:</span>
                                    <span id="delivery-cost-display" class="text-orange-600 font-medium">يرجى اختيار المدينة</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold border-t pt-2">
                                    <span>الإجمالي:</span>
                                    <span id="total-display" class="text-orange-600"><?php echo e(number_format($total, 2)); ?> د.أ</span>
                                </div>
                                <?php if($totalSavings > 0): ?>
                                <div class="text-center mt-2">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">
                                        🎉 وفرت <?php echo e(number_format($totalSavings, 2)); ?> د.أ
                                    </span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-orange-500 text-white py-4 rounded-lg hover:bg-orange-600 transition duration-200 font-medium text-lg mt-6 disabled:opacity-50 disabled:cursor-not-allowed"
                                    id="submitOrderBtn">
                                <span id="submitBtnText">تأكيد الطلب</span>
                                <span id="submitBtnLoader" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    جاري المعالجة...
                                </span>
                            </button>

                            <div class="mt-4 text-center">
                                <a href="<?php echo e(route('cart')); ?>" class="text-orange-600 hover:text-orange-800 text-sm">
                                    العودة إلى السلة
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if(!empty($cartItems)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show flash messages using custom alerts
    <?php if(session('success')): ?>
        showSuccess('<?php echo e(session('success')); ?>');
    <?php endif; ?>
    
    <?php if(session('error')): ?>
        showError('<?php echo e(session('error')); ?>');
    <?php endif; ?>
    
    <?php if($errors->any()): ?>
        let errorMessage = 'يرجى تصحيح الأخطاء التالية:\n';
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            errorMessage += '• <?php echo e($error); ?>\n';
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        showError(errorMessage);
    <?php endif; ?>
    const citySelect = document.getElementById('jordan_city_id');
    const deliveryInfo = document.getElementById('delivery-info');
    const deliveryCostDisplay = document.getElementById('delivery-cost-display');
    const totalDisplay = document.getElementById('total-display');
    const subtotal = <?php echo e($subtotal); ?>;
    
    // Handle city selection
    if (citySelect) {
        citySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                const deliveryCost = parseFloat(selectedOption.dataset.deliveryCost) || 0;
                const deliveryDays = selectedOption.dataset.deliveryDays;
                const cityName = selectedOption.text.split(' - ')[0];
                
                // Update delivery cost display
                deliveryCostDisplay.textContent = deliveryCost.toFixed(2) + ' د.أ';
                deliveryCostDisplay.className = 'text-orange-600 font-medium';
                
                // Update total
                const newTotal = subtotal + deliveryCost;
                totalDisplay.textContent = newTotal.toFixed(2) + ' د.أ';
                
                // Show delivery info
                if (deliveryInfo) {
                    const daysText = deliveryDays == 1 ? 'يوم واحد' : deliveryDays + ' أيام';
                    deliveryInfo.innerHTML = `
                        <div class="flex items-center text-blue-600">
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            التوصيل لمحافظة ${cityName} خلال ${daysText}
                        </div>
                    `;
                    deliveryInfo.classList.remove('hidden');
                }
            } else {
                // Reset displays
                deliveryCostDisplay.textContent = 'يرجى اختيار المدينة';
                deliveryCostDisplay.className = 'text-gray-500';
                totalDisplay.textContent = subtotal.toFixed(2) + ' د.أ';
                
                if (deliveryInfo) {
                    deliveryInfo.classList.add('hidden');
                }
            }
        });
    }
    
    const form = document.querySelector('form[action*="checkout"]');
    const submitBtn = document.getElementById('submitOrderBtn');
    const btnText = document.getElementById('submitBtnText');
    const btnLoader = document.getElementById('submitBtnLoader');
    
    if (form && submitBtn) {
        // Form validation
        function validateForm() {
            const phone = document.getElementById('phone');
            const address = document.getElementById('shipping_address');
            
            if (!phone.value.trim()) {
                phone.focus();
                phone.classList.add('border-red-500');
                showMessage('يرجى إدخال رقم الهاتف', 'error');
                return false;
            }
            
            if (!address.value.trim()) {
                address.focus();
                address.classList.add('border-red-500');
                showMessage('يرجى إدخال عنوان الشحن', 'error');
                return false;
            }
            
            return true;
        }
        
        // Show message using custom alert system
        function showMessage(message, type) {
            if (type === 'error') {
                showError(message);
            } else {
                showSuccess(message);
            }
        }
        
        // Handle form submission
        form.addEventListener('submit', function(e) {
            console.log('Form submission started');
            
            // Debug: Check if form data is correct
            const formData = new FormData(form);
            console.log('Form data:', {
                phone: formData.get('phone'),
                shipping_address: formData.get('shipping_address'),
                payment_method: formData.get('payment_method'),
                notes: formData.get('notes')
            });
            
            if (!validateForm()) {
                console.log('Validation failed');
                e.preventDefault();
                return;
            }
            
            // Show loading state
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');
            
            console.log('Form validation passed, submitting...');
            
            // Allow form to submit naturally
            // The form will be submitted to the server
        });
        
        // Remove error styling on input
        ['phone', 'shipping_address'].forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                });
            }
        });
    }
});
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/checkout/index.blade.php ENDPATH**/ ?>