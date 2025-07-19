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
    <div class="space-y-8">
        <!-- Welcome Header -->
        <div class="text-center space-y-2">
            <h2 class="text-3xl font-bold text-white">أهلاً وسهلاً</h2>
            <p class="text-white text-opacity-80 text-lg">سعداء بعودتك إلى متجرنا</p>
        </div>

        <!-- Session Status -->
        <?php if (isset($component)) { $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-session-status','data' => ['class' => 'mb-4','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $attributes = $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $component = $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>

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
                           value="<?php echo e(old('email')); ?>" 
                           required 
                           autofocus 
                           autocomplete="username"
                           class="input-glow w-full pr-12 pl-4 py-4 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-2xl text-white text-lg placeholder-white placeholder-opacity-60 focus:outline-none focus:border-orange-400 focus:bg-opacity-20 transition-all duration-300"
                           placeholder="example@email.com">
                </div>
                <?php if($errors->get('email')): ?>
                    <p class="text-red-300 text-sm font-medium"><?php echo e(implode(' ', $errors->get('email'))); ?></p>
                <?php endif; ?>
            </div>

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
                           autocomplete="current-password"
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
                <?php if($errors->get('password')): ?>
                    <p class="text-red-300 text-sm font-medium"><?php echo e(implode(' ', $errors->get('password'))); ?></p>
                <?php endif; ?>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" 
                           type="checkbox" 
                           name="remember" 
                           class="w-4 h-4 text-orange-500 bg-white bg-opacity-20 border border-white border-opacity-30 rounded focus:ring-orange-500 focus:ring-2">
                    <span class="mr-2 text-white text-opacity-80 text-sm">تذكرني</span>
                </label>

                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" 
                       class="text-white text-opacity-80 hover:text-opacity-100 text-sm font-medium hover:underline transition-all duration-200">
                        نسيت كلمة المرور؟
                    </a>
                <?php endif; ?>
            </div>

            <!-- Login Button -->
            <button type="submit" 
                    class="btn-gradient w-full text-white font-bold py-4 px-6 rounded-2xl text-lg transition-all duration-300 transform hover:scale-105">
                <span class="flex items-center justify-center space-x-2 space-x-reverse">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>تسجيل الدخول</span>
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

            <!-- Register Link -->
            <div class="text-center space-y-4">
                <p class="text-white text-opacity-80">
                    ليس لديك حساب؟
                </p>
                <a href="<?php echo e(route('register')); ?>" 
                   class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-white border-opacity-30 rounded-2xl text-white font-semibold hover:bg-white hover:bg-opacity-10 hover:border-opacity-50 transition-all duration-300">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    إنشاء حساب جديد
                </a>
            </div>

            <!-- Quick Access -->
            <div class="text-center pt-6 border-t border-white border-opacity-20">
                <p class="text-white text-opacity-60 text-sm mb-3">الوصول السريع</p>
                <div class="flex justify-center space-x-4 space-x-reverse">
                    <a href="<?php echo e(route('products.index')); ?>" 
                       class="flex items-center px-4 py-2 bg-white bg-opacity-10 rounded-xl text-white text-opacity-80 hover:text-opacity-100 hover:bg-opacity-20 transition-all duration-200 text-sm">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        المتجر
                    </a>
                    <a href="#" 
                       class="flex items-center px-4 py-2 bg-white bg-opacity-10 rounded-xl text-white text-opacity-80 hover:text-opacity-100 hover:bg-opacity-20 transition-all duration-200 text-sm">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        المساعدة
                    </a>
                </div>
            </div>
        </form>
    </div>
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
<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/auth/login.blade.php ENDPATH**/ ?>