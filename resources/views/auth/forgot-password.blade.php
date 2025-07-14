<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-white mb-2">استعادة كلمة المرور</h2>
            <p class="text-white opacity-80">لا تقلق! أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-white mb-2">
                    البريد الإلكتروني
                </label>
                <div class="relative">
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus
                           class="w-full px-4 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-lg text-white placeholder-white placeholder-opacity-70 focus:outline-none input-glow focus:border-blue-400 focus:bg-opacity-30 transition-all duration-300"
                           placeholder="أدخل بريدك الإلكتروني">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                </div>
                @if ($errors->get('email'))
                    <p class="mt-2 text-sm text-red-300">{{ implode(' ', $errors->get('email')) }}</p>
                @endif
            </div>

            <!-- Send Button -->
            <button type="submit" 
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    إرسال رابط إعادة التعيين
                </span>
            </button>

            <!-- Back to Login -->
            <div class="text-center">
                <p class="text-white opacity-80">
                    تذكرت كلمة المرور؟ 
                    <a href="{{ route('login') }}" 
                       class="text-white font-semibold hover:underline transition-all duration-200">
                        تسجيل الدخول
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="text-center pt-4 border-t border-white border-opacity-20">
                <a href="{{ route('products.index') }}" 
                   class="text-white opacity-80 hover:opacity-100 text-sm transition-all duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    العودة إلى المتجر
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
