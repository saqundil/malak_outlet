<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="register-form">
    <!-- Welcome Header with Enhanced Background -->
    <div class="welcome-header">
        <h2 class="welcome-title">إنشاء حساب جديد</h2>
        <p class="welcome-subtitle">انضم إلينا واستمتع بتجربة تسوق مميزة</p>
        <div class="welcome-underline"></div>
    </div>

    <!-- Registration Form -->
    <form method="POST" action="<?php echo e(route('register')); ?>" x-data="{ 
        loading: false, 
        showPassword: false, 
        showPasswordConfirm: false,
        passwordStrength: 0,
        checkPasswordStrength() {
            const password = this.$refs.password.value;
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            this.passwordStrength = strength;
        }
    }" 
    @submit="loading = true">
        <?php echo csrf_field(); ?>

        <!-- Name Field -->
        <div class="input-container">
            <div class="input-wrapper">
                <input id="name" 
                       name="name" 
                       type="text" 
                       class="input-field input-glow" 
                       placeholder="الاسم الكامل"
                       value="<?php echo e(old('name')); ?>" 
                       required 
                       autofocus 
                       autocomplete="name">
                <div class="input-overlay"></div>
                <div class="input-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message animate-shake">
                    <svg class="error-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Email Field -->
        <div class="input-container">
            <div class="input-wrapper">
                <input id="email" 
                       name="email" 
                       type="email" 
                       class="input-field input-glow" 
                       placeholder="البريد الإلكتروني"
                       value="<?php echo e(old('email')); ?>" 
                       required 
                       autocomplete="username">
                <div class="input-overlay"></div>
                <div class="input-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
            </div>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message animate-shake">
                    <svg class="error-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Password Field -->
        <div class="input-container">
            <div class="input-wrapper">
                <input x-ref="password"
                       id="password" 
                       name="password" 
                       :type="showPassword ? 'text' : 'password'" 
                       class="input-field input-glow" 
                       placeholder="كلمة المرور"
                       required 
                       autocomplete="new-password"
                       @input="checkPasswordStrength()">
                <div class="input-overlay"></div>
                <div class="input-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <button type="button" 
                        class="password-toggle" 
                        @click="showPassword = !showPassword"
                        :class="{ 'active': showPassword }">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                    </svg>
                </button>
            </div>

            <!-- Password Strength Indicator -->
            <div class="password-strength" x-show="$refs.password && $refs.password.value.length > 0">
                <div class="strength-bars">
                    <div class="strength-bar" :class="{ 'active': passwordStrength >= 1, 'weak': passwordStrength === 1 }"></div>
                    <div class="strength-bar" :class="{ 'active': passwordStrength >= 2, 'medium': passwordStrength === 2 }"></div>
                    <div class="strength-bar" :class="{ 'active': passwordStrength >= 3, 'strong': passwordStrength >= 3 }"></div>
                    <div class="strength-bar" :class="{ 'active': passwordStrength >= 4, 'very-strong': passwordStrength === 4 }"></div>
                </div>
                <span class="strength-text" x-text="
                    passwordStrength === 0 ? '' :
                    passwordStrength === 1 ? 'ضعيفة' :
                    passwordStrength === 2 ? 'متوسطة' :
                    passwordStrength === 3 ? 'قوية' : 'قوية جداً'
                "></span>
            </div>

            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message animate-shake">
                    <svg class="error-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Password Confirmation Field -->
        <div class="input-container">
            <div class="input-wrapper">
                <input id="password_confirmation" 
                       name="password_confirmation" 
                       :type="showPasswordConfirm ? 'text' : 'password'" 
                       class="input-field input-glow" 
                       placeholder="تأكيد كلمة المرور"
                       required 
                       autocomplete="new-password">
                <div class="input-overlay"></div>
                <div class="input-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <button type="button" 
                        class="password-toggle" 
                        @click="showPasswordConfirm = !showPasswordConfirm"
                        :class="{ 'active': showPasswordConfirm }">
                    <svg x-show="!showPasswordConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg x-show="showPasswordConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                    </svg>
                </button>
            </div>
            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message animate-shake">
                    <svg class="error-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Terms and Conditions -->
        <div class="checkbox-container">
            <label class="checkbox-label">
                <input type="checkbox" class="checkbox-input" required>
                <div class="checkbox-custom">
                    <svg class="checkbox-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="checkbox-text">
                    أوافق على
                    <a href="<?php echo e(route('legal.terms')); ?>" class="terms-link" target="_blank">الشروط والأحكام</a>
                    و
                    <a href="<?php echo e(route('legal.privacy')); ?>" class="terms-link" target="_blank">سياسة الخصوصية</a>
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="btn-gradient btn-register" 
                :disabled="loading"
                :class="{ 'loading': loading }">
            <span x-show="!loading" class="btn-text">إنشاء حساب</span>
            <span x-show="loading" class="btn-loading">
                <svg class="spinner" viewBox="0 0 24 24">
                    <circle class="spinner-circle" cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="4"></circle>
                    <path class="spinner-path" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                جاري إنشاء الحساب...
            </span>
        </button>

        <!-- Login Link -->
        <div class="auth-links">
            <p class="auth-text">
                لديك حساب بالفعل؟
                <a href="<?php echo e(route('login')); ?>" class="auth-link">تسجيل دخول</a>
            </p>
        </div>
    </form>
</div>

<style>
/* Register Form Specific Styles */
.register-form {
    width: 100%;
    max-width: 100%;
}

.welcome-header {
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
    padding: 1.5rem 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    backdrop-filter: blur(10px);
    border-radius: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.welcome-title {
    font-size: 1.75rem;
    font-weight: 700;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.95rem;
    margin-bottom: 1rem;
}

.welcome-underline {
    height: 3px;
    width: 60px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    margin: 0 auto;
    border-radius: 2px;
    position: relative;
}

.welcome-underline::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 2px;
    animation: pulse-glow 2s ease-in-out infinite alternate;
}

/* Input Container Styles */
.input-container {
    margin-bottom: 1.5rem;
    position: relative;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-field {
    width: 100%;
    padding: 0.875rem 3rem 0.875rem 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    color: white;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.input-field:focus {
    outline: none;
    border-color: rgba(255, 255, 255, 0.5);
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
}

.input-field::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.input-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    border-radius: 0.75rem;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 1;
}

.input-wrapper:focus-within .input-overlay {
    opacity: 1;
}

.input-icon {
    position: absolute;
    right: 1rem;
    color: rgba(255, 255, 255, 0.6);
    z-index: 3;
    pointer-events: none;
}

.password-toggle {
    position: absolute;
    left: 1rem;
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    z-index: 3;
    transition: all 0.3s ease;
    transform: scale(1);
}

.password-toggle:hover,
.password-toggle.active {
    color: #ffffff;
    transform: scale(1.1);
}

/* Password Strength Indicator */
.password-strength {
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.strength-bars {
    display: flex;
    gap: 0.25rem;
    flex: 1;
}

.strength-bar {
    height: 4px;
    flex: 1;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
    transition: all 0.3s ease;
}

.strength-bar.active.weak {
    background: #ef4444;
    box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
}

.strength-bar.active.medium {
    background: #f59e0b;
    box-shadow: 0 0 10px rgba(245, 158, 11, 0.5);
}

.strength-bar.active.strong {
    background: #10b981;
    box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
}

.strength-bar.active.very-strong {
    background: #06d6a0;
    box-shadow: 0 0 10px rgba(6, 214, 160, 0.5);
}

.strength-text {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
    min-width: 60px;
    text-align: right;
}

/* Checkbox Styles */
.checkbox-container {
    margin-bottom: 1.5rem;
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.5;
}

.checkbox-input {
    display: none;
}

.checkbox-custom {
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 0.375rem;
    background: rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.checkbox-input:checked + .checkbox-custom {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-color: #ffffff;
    transform: scale(1.05);
}

.checkbox-icon {
    width: 12px;
    height: 12px;
    stroke-width: 3;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.2s ease;
}

.checkbox-input:checked + .checkbox-custom .checkbox-icon {
    opacity: 1;
    transform: scale(1);
}

.checkbox-text {
    flex: 1;
}

.terms-link {
    color: #ffffff;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}

.terms-link:hover {
    color: #f8fafc;
}

.terms-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 1px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    transition: width 0.3s ease;
}

.terms-link:hover::after {
    width: 100%;
}

/* Button Styles */
.btn-gradient {
    background: linear-gradient(135deg, #f97316, #ea580c, #dc2626);
    background-size: 200% 200%;
    border: none;
    border-radius: 0.75rem;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-gradient::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.6s;
}

.btn-gradient:hover {
    background-position: 100% 0;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(249, 115, 22, 0.5);
}

.btn-gradient:hover::before {
    left: 100%;
}

.btn-gradient:active {
    transform: translateY(0);
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
}

.btn-gradient:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.btn-gradient.loading {
    pointer-events: none;
}

.btn-register {
    width: 100%;
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.btn-text {
    transition: opacity 0.3s ease;
}

.btn-loading {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: opacity 0.3s ease;
}

.spinner {
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
}

.spinner-circle {
    opacity: 0.25;
}

.spinner-path {
    opacity: 0.75;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Auth Links */
.auth-links {
    text-align: center;
    margin-top: 1rem;
}

.auth-text {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
}

.auth-link {
    color: #ffffff;
    text-decoration: none;
    font-weight: 600;
    margin-right: 0.5rem;
    transition: all 0.3s ease;
    position: relative;
}

.auth-link:hover {
    color: #f8fafc;
}

.auth-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 1px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    transition: width 0.3s ease;
}

.auth-link:hover::after {
    width: 100%;
}

/* Error Messages */
.error-message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #ef4444;
    font-size: 0.8rem;
    margin-top: 0.5rem;
    padding: 0.5rem;
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 0.5rem;
    backdrop-filter: blur(10px);
}

.error-icon {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

/* Responsive Design */
@media (max-width: 640px) {
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .welcome-subtitle {
        font-size: 0.9rem;
    }
    
    .input-field {
        padding: 0.75rem 2.5rem 0.75rem 0.875rem;
        font-size: 0.9rem;
    }
    
    .checkbox-label {
        font-size: 0.85rem;
    }
}
</style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/auth/register.blade.php ENDPATH**/ ?>