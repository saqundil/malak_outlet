@extends('layouts.main')

@section('title', 'تحقق من البريد الإلكتروني - Malak Outlet')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="text-center">
                <div class="mx-auto w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">تحقق من بريدك الإلكتروني</h2>
                <p class="text-gray-600 mb-6">
                    لقد أرسلنا كود التحقق إلى البريد الإلكتروني
                    @if($email)
                        <br><strong class="text-orange-600">{{ $email }}</strong>
                    @endif
                </p>
            </div>
        </div>

        <!-- OTP Verification Form -->
        <form class="mt-8 space-y-6" id="otpForm" method="POST" action="{{ route('verify.otp') }}">
            @csrf
            <div>
                @if($email)
                    <input type="hidden" name="email" value="{{ $email }}">
                @else
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                        <input type="email" 
                               name="email" 
                               id="email"
                               class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                               placeholder="أدخل بريدك الإلكتروني"
                               value="{{ old('email') }}"
                               required>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div class="mb-6">
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">كود التحقق (6 أرقام)</label>
                    <div class="flex space-x-2 space-x-reverse justify-center">
                        @for($i = 0; $i < 6; $i++)
                            <input type="text" 
                                   class="otp-input w-12 h-12 text-center text-lg font-bold border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('otp') border-red-500 @enderror"
                                   maxlength="1"
                                   pattern="[0-9]"
                                   inputmode="numeric"
                                   data-index="{{ $i }}">
                        @endfor
                    </div>
                    <input type="hidden" name="otp" id="otpCode">
                    @error('otp')
                        <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" 
                        id="verifyBtn"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200">
                    <span id="verifyBtnText">التحقق من الكود</span>
                    <span id="verifyBtnLoading" class="hidden">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        جاري التحقق...
                    </span>
                </button>
            </div>

            <!-- Resend OTP -->
            <div class="text-center">
                <div class="mb-4">
                    <span class="text-sm text-gray-600">لم تصلك الرسالة؟</span>
                </div>
                <button type="button" 
                        id="resendBtn"
                        class="text-orange-600 hover:text-orange-500 text-sm font-medium focus:outline-none focus:underline disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="resendBtnText">إعادة إرسال الكود</span>
                    <span id="resendBtnLoading" class="hidden">جاري الإرسال...</span>
                </button>
                <div id="resendTimer" class="text-sm text-gray-500 mt-2 hidden"></div>
            </div>

            <!-- Help Text -->
            <div class="text-center text-xs text-gray-500 space-y-1">
                <p>• كود التحقق صالح لمدة 10 دقائق</p>
                <p>• تحقق من مجلد الرسائل غير المرغوب فيها</p>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    const otpCode = document.getElementById('otpCode');
    const otpForm = document.getElementById('otpForm');
    const verifyBtn = document.getElementById('verifyBtn');
    const verifyBtnText = document.getElementById('verifyBtnText');
    const verifyBtnLoading = document.getElementById('verifyBtnLoading');
    const resendBtn = document.getElementById('resendBtn');
    const resendBtnText = document.getElementById('resendBtnText');
    const resendBtnLoading = document.getElementById('resendBtnLoading');
    const resendTimer = document.getElementById('resendTimer');

    let resendTimeout = null;
    let timerInterval = null;

    // OTP input handling
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            const value = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = value;

            if (value && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }

            updateOtpCode();
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').substring(0, 6);
            
            for (let i = 0; i < pastedData.length && i < otpInputs.length; i++) {
                otpInputs[i].value = pastedData[i];
            }
            
            updateOtpCode();
            
            if (pastedData.length === 6) {
                otpInputs[5].focus();
            }
        });
    });

    function updateOtpCode() {
        const code = Array.from(otpInputs).map(input => input.value).join('');
        otpCode.value = code;
        
        if (code.length === 6) {
            verifyBtn.disabled = false;
        } else {
            verifyBtn.disabled = true;
        }
    }

    // Form submission
    otpForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (otpCode.value.length !== 6) {
            showNotification('يرجى إدخال كود التحقق كاملاً', 'error');
            return;
        }

        // Show loading state
        verifyBtn.disabled = true;
        verifyBtnText.classList.add('hidden');
        verifyBtnLoading.classList.remove('hidden');

        // Submit form
        const formData = new FormData(otpForm);

        fetch(otpForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    // Use redirect_url from response or default to home
                    const redirectUrl = data.redirect_url || '{{ route("home") }}';
                    window.location.href = redirectUrl;
                }, 1500);
            } else {
                showNotification(data.message || 'حدث خطأ في التحقق', 'error');
                // Clear OTP inputs
                otpInputs.forEach(input => input.value = '');
                otpInputs[0].focus();
                updateOtpCode();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('حدث خطأ في الاتصال', 'error');
        })
        .finally(() => {
            // Hide loading state
            verifyBtn.disabled = false;
            verifyBtnText.classList.remove('hidden');
            verifyBtnLoading.classList.add('hidden');
        });
    });

    // Resend OTP
    resendBtn.addEventListener('click', function() {
        const email = document.querySelector('input[name="email"]').value;
        
        if (!email) {
            showNotification('يرجى إدخال البريد الإلكتروني', 'error');
            return;
        }

        // Show loading state
        resendBtn.disabled = true;
        resendBtnText.classList.add('hidden');
        resendBtnLoading.classList.remove('hidden');

        fetch('{{ route("resend.otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                startResendTimer();
            } else {
                showNotification(data.message || 'فشل في إرسال الكود', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('حدث خطأ في الاتصال', 'error');
        })
        .finally(() => {
            // Hide loading state
            resendBtnText.classList.remove('hidden');
            resendBtnLoading.classList.add('hidden');
        });
    });

    function startResendTimer() {
        let timeLeft = 60;
        resendBtn.disabled = true;
        resendTimer.classList.remove('hidden');
        
        timerInterval = setInterval(() => {
            resendTimer.textContent = `يمكنك إعادة الإرسال خلال ${timeLeft} ثانية`;
            timeLeft--;
            
            if (timeLeft < 0) {
                clearInterval(timerInterval);
                resendBtn.disabled = false;
                resendTimer.classList.add('hidden');
            }
        }, 1000);
    }

    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} shadow-lg transition-opacity duration-300`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                if (notification.parentNode) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }

    // Auto-focus first input
    otpInputs[0].focus();
    
    // Initialize button state
    updateOtpCode();
});
</script>
@endsection
