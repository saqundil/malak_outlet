<x-guest-layout>
<div class="login-form">
    <!-- Welcome Header with Enhanced Background -->
    <div class="welcome-header">
        <h2 class="welcome-title">أهلاً وسهلاً بعودتك</h2>
        <p class="welcome-subtitle">سعداء بعودتك إلى متجرنا</p>
        <div class="welcome-underline"></div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" x-data="{ 
        loading: false, 
        showPassword: false
    }" 
    @submit="loading = true">
        @csrf

        <!-- Email Field -->
        <div class="input-container">
            <div class="input-wrapper">
                <input id="email" 
                       name="email" 
                       type="email" 
                       class="input-field input-glow" 
                       placeholder="البريد الإلكتروني"
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username">
                <div class="input-overlay"></div>
                <div class="input-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
            </div>
            @error('email')
                <div class="error-message animate-shake">
                    <svg class="error-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="input-container">
            <div class="input-wrapper">
                <input id="password" 
                       name="password" 
                       :type="showPassword ? 'text' : 'password'" 
                       class="input-field input-glow" 
                       placeholder="كلمة المرور"
                       required 
                       autocomplete="current-password">
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
            @error('password')
                <div class="error-message animate-shake">
                    <svg class="error-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="auth-options">
            <label class="checkbox-label">
                <input type="checkbox" name="remember" class="checkbox-input">
                <div class="checkbox-custom">
                    <svg class="checkbox-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="checkbox-text">تذكرني</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    نسيت كلمة المرور؟
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="btn-gradient btn-login" 
                :disabled="loading"
                :class="{ 'loading': loading }">
            <span x-show="!loading" class="btn-text">تسجيل الدخول</span>
            <span x-show="loading" class="btn-loading">
                <svg class="spinner" viewBox="0 0 24 24">
                    <circle class="spinner-circle" cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="4"></circle>
                    <path class="spinner-path" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                جاري تسجيل الدخول...
            </span>
        </button>

        <!-- Register Link -->
        <div class="auth-links">
            <p class="auth-text">
                ليس لديك حساب؟
                <a href="{{ route('register') }}" class="auth-link">إنشاء حساب جديد</a>
            </p>
        </div>
    </form>
</div>

<style>
/* Login Form Specific Styles */
.login-form {
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

/* Auth Options */
.auth-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
}

.checkbox-input {
    display: none;
}

.checkbox-custom {
    width: 18px;
    height: 18px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 0.375rem;
    background: rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.checkbox-input:checked + .checkbox-custom {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-color: #ffffff;
    transform: scale(1.05);
}

.checkbox-icon {
    width: 10px;
    height: 10px;
    stroke-width: 3;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.2s ease;
    color: #1e293b;
}

.checkbox-input:checked + .checkbox-custom .checkbox-icon {
    opacity: 1;
    transform: scale(1);
}

.forgot-link {
    color: #ffffff;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    position: relative;
}

.forgot-link:hover {
    color: #f8fafc;
}

.forgot-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 1px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    transition: width 0.3s ease;
}

.forgot-link:hover::after {
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

.btn-login {
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

@keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 5px rgba(255, 255, 255, 0.3); }
    50% { box-shadow: 0 0 20px rgba(255, 255, 255, 0.6); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
    20%, 40%, 60%, 80% { transform: translateX(2px); }
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
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
    
    .auth-options {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}
</style>
</x-guest-layout>
