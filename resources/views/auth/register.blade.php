<x-guest-layout>
    <div class="space-y-8">
        <!-- Welcome Header -->
        <div class="text-center space-y-2">
            <h2 class="text-3xl font-bold text-white">انضم إلى عائلتنا</h2>
            <p class="text-white text-opacity-80 text-lg">أنشئ حساباً واستمتع بتجربة تسوق مميزة</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name Field -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-semibold text-white">
                    الاسم الكامل
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-white text-opacity-60 group-focus-within:text-orange-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input id="name" 
                           type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autofocus 
                           autocomplete="name"
                           class="input-glow w-full pr-12 pl-4 py-4 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-2xl text-white text-lg placeholder-white placeholder-opacity-60 focus:outline-none focus:border-orange-400 focus:bg-opacity-20 transition-all duration-300"
                           placeholder="أحمد محمد">
                </div>
                @if ($errors->get('name'))
                    <p class="text-red-300 text-sm font-medium">{{ implode(' ', $errors->get('name')) }}</p>
                @endif
            </div>

            <!-- Email Field -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-semibold text-white">
                    البريد الإلكتروني
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-white text-opacity-60 group-focus-within:text-orange-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="username"
                           class="input-glow w-full pr-12 pl-4 py-4 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-2xl text-white text-lg placeholder-white placeholder-opacity-60 focus:outline-none focus:border-orange-400 focus:bg-opacity-20 transition-all duration-300"
                           placeholder="example@email.com">
                </div>
                @if ($errors->get('email'))
                    <p class="text-red-300 text-sm font-medium">{{ implode(' ', $errors->get('email')) }}</p>
                @endif
            </div>

            <!-- Phone Field -->
            <div class="space-y-2">
                <label for="phone" class="block text-sm font-semibold text-white">
                    رقم الهاتف <span class="text-white text-opacity-60">(اختياري)</span>
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-white text-opacity-60 group-focus-within:text-orange-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <input id="phone" 
                           type="tel" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           class="input-glow w-full pr-12 pl-4 py-4 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-2xl text-white text-lg placeholder-white placeholder-opacity-60 focus:outline-none focus:border-orange-400 focus:bg-opacity-20 transition-all duration-300"
                           placeholder="05xxxxxxxx">
                </div>
                @if ($errors->get('phone'))
                    <p class="text-red-300 text-sm font-medium">{{ implode(' ', $errors->get('phone')) }}</p>
                @endif
            </div>

            <!-- Password Fields Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-white">
                        كلمة المرور
                    </label>
                    <div class="relative group" x-data="{ showPassword: false }">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white text-opacity-60 group-focus-within:text-orange-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password" 
                               :type="showPassword ? 'text' : 'password'"
                               name="password" 
                               required 
                               autocomplete="new-password"
                               class="input-glow w-full pr-12 pl-12 py-4 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-2xl text-white text-lg placeholder-white placeholder-opacity-60 focus:outline-none focus:border-orange-400 focus:bg-opacity-20 transition-all duration-300"
                               placeholder="••••••••">
                        <button type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 left-0 pl-4 flex items-center text-white text-opacity-60 hover:text-opacity-100 transition-colors">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @if ($errors->get('password'))
                        <p class="text-red-300 text-sm font-medium">{{ implode(' ', $errors->get('password')) }}</p>
                    @endif
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-white">
                        تأكيد كلمة المرور
                    </label>
                    <div class="relative group" x-data="{ showConfirmPassword: false }">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white text-opacity-60 group-focus-within:text-orange-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <input id="password_confirmation" 
                               :type="showConfirmPassword ? 'text' : 'password'"
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               class="input-glow w-full pr-12 pl-12 py-4 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-2xl text-white text-lg placeholder-white placeholder-opacity-60 focus:outline-none focus:border-orange-400 focus:bg-opacity-20 transition-all duration-300"
                               placeholder="••••••••">
                        <button type="button" 
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 left-0 pl-4 flex items-center text-white text-opacity-60 hover:text-opacity-100 transition-colors">
                            <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @if ($errors->get('password_confirmation'))
                        <p class="text-red-300 text-sm font-medium">{{ implode(' ', $errors->get('password_confirmation')) }}</p>
                    @endif
                </div>
            </div>

            <!-- Terms Agreement -->
            <div class="flex items-start space-x-3 space-x-reverse">
                <input id="terms" 
                       type="checkbox" 
                       required
                       class="w-5 h-5 text-orange-500 bg-white bg-opacity-20 border border-white border-opacity-30 rounded focus:ring-orange-500 focus:ring-2 mt-1">
                <label for="terms" class="text-white text-opacity-80 text-sm leading-relaxed">
                    أوافق على 
                    <a href="#" class="text-white font-semibold hover:underline">شروط الخدمة</a> 
                    و 
                    <a href="#" class="text-white font-semibold hover:underline">سياسة الخصوصية</a>
                    الخاصة بمتجر ملاك
                </label>
            </div>

            <!-- Register Button -->
            <button type="submit" 
                    class="btn-gradient w-full text-white font-bold py-4 px-6 rounded-2xl text-lg transition-all duration-300 transform hover:scale-105">
                <span class="flex items-center justify-center space-x-2 space-x-reverse">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <span>إنشاء حساب جديد</span>
                </span>
            </button>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white border-opacity-20"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-transparent text-white text-opacity-60">أو</span>
                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center space-y-4">
                <p class="text-white text-opacity-80">
                    لديك حساب بالفعل؟
                </p>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-white border-opacity-30 rounded-2xl text-white font-semibold hover:bg-white hover:bg-opacity-10 hover:border-opacity-50 transition-all duration-300">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    تسجيل الدخول
                </a>
            </div>

            <!-- Benefits -->
            <div class="bg-white bg-opacity-5 rounded-2xl p-6 space-y-4">
                <h3 class="text-white font-semibold text-lg text-center">مميزات الحساب</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <svg class="w-5 h-5 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-white text-opacity-80 text-sm">تتبع الطلبات</span>
                    </div>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <svg class="w-5 h-5 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-white text-opacity-80 text-sm">عروض حصرية</span>
                    </div>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <svg class="w-5 h-5 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-white text-opacity-80 text-sm">قائمة المفضلة</span>
                    </div>
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <svg class="w-5 h-5 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-white text-opacity-80 text-sm">دعم أولوية</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
