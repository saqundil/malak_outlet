<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
         <script src="//unpkg.com/alpinejs" defer></script>

        <script src="https://cdn.tailwindcss.com"></script>
        
        <style>
            body {
                font-family: 'Cairo', sans-serif;
            }
            
            .auth-bg {
                background: linear-gradient(135deg, #1e293b 0%, #334155 30%, #f97316 100%);
                background-size: 400% 400%;
                animation: gradientShift 20s ease infinite;
                position: relative;
                overflow: hidden;
            }
            
            .auth-bg::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.03)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.03)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.03)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
                pointer-events: none;
            }
            
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                25% { background-position: 100% 30%; }
                50% { background-position: 50% 100%; }
                75% { background-position: 30% 0%; }
                100% { background-position: 0% 50%; }
            }
            
            .glass-card {
                backdrop-filter: blur(20px) saturate(180%);
                background: rgba(255, 255, 255, 0.08);
                border: 1px solid rgba(255, 255, 255, 0.15);
                box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
                position: relative;
                overflow: hidden;
            }
            
            .glass-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            }
            
            .input-glow {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
            }
            
            .input-glow:focus {
                box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.3), 0 8px 25px rgba(249, 115, 22, 0.2);
                transform: translateY(-2px);
            }
            
            .btn-gradient {
                background: linear-gradient(135deg, #f97316, #ea580c, #dc2626);
                background-size: 200% 200%;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }
            
            .btn-gradient::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: left 0.6s;
            }
            
            .btn-gradient:hover {
                background-position: 100% 0;
                transform: translateY(-3px);
                box-shadow: 0 15px 35px rgba(249, 115, 22, 0.4);
            }
            
            .btn-gradient:hover::before {
                left: 100%;
            }
            
            .floating-shapes {
                position: absolute;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
            }
            
            .floating-shapes::before,
            .floating-shapes::after {
                content: '';
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.05);
                animation: float 8s ease-in-out infinite;
            }
            
            .floating-shapes::before {
                width: 200px;
                height: 200px;
                top: 10%;
                right: 10%;
                animation-delay: -2s;
            }
            
            .floating-shapes::after {
                width: 150px;
                height: 150px;
                bottom: 15%;
                left: 15%;
                animation-delay: -4s;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                25% { transform: translateY(-20px) rotate(90deg); }
                50% { transform: translateY(-10px) rotate(180deg); }
                75% { transform: translateY(-30px) rotate(270deg); }
            }
            
            .logo-container {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                border: 2px solid rgba(255, 255, 255, 0.2);
                transition: all 0.3s ease;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }
            
            .logo-container:hover {
                transform: scale(1.05);
                box-shadow: 0 15px 40px rgba(249, 115, 22, 0.3);
                border-color: rgba(249, 115, 22, 0.4);
            }
            
            .logo-container img {
                filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
                transition: filter 0.3s ease;
            }
            
            .logo-container:hover img {
                filter: drop-shadow(0 6px 12px rgba(249, 115, 22, 0.2));
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen auth-bg flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
            <!-- Floating Shapes -->
            <div class="floating-shapes"></div>
            
            <div class="max-w-lg w-full space-y-8 relative z-10">
                <!-- Logo Section -->
                <div class="text-center mb-8">
                    <a href="<?php echo e(route('home')); ?>">
                        <div class="logo-container mx-auto w-28 h-28 rounded-3xl flex items-center justify-center mb-6 p-2">
                            <!-- Your Actual Logo -->
                            <img src="<?php echo e(asset('images/malak.png')); ?>" 
                                 alt="MalakOutlet Logo" 
                                 class="w-full h-full object-contain rounded-2xl">
                        </div>
                    </a>
                    <h1 class="text-4xl font-bold text-white mb-2">MalakOutlet</h1>
                    <p class="text-white text-opacity-90 text-lg font-medium">متجر الألعاب والليجو المتميز</p>
                </div>

                <!-- Auth Card -->
                <div class="glass-card rounded-3xl shadow-2xl p-10">
                    <?php echo e($slot); ?>

                </div>
                
                <!-- Footer -->
                <div class="text-center space-y-4">
                    <div class="flex justify-center space-x-6 space-x-reverse">
                        <a href="#" class="text-white text-opacity-70 hover:text-opacity-100 transition-all duration-200 text-sm hover:underline">
                            سياسة الخصوصية
                        </a>
                        <span class="text-white text-opacity-50">•</span>
                        <a href="#" class="text-white text-opacity-70 hover:text-opacity-100 transition-all duration-200 text-sm hover:underline">
                            شروط الاستخدام
                        </a>
                        <span class="text-white text-opacity-50">•</span>
                        <a href="<?php echo e(route('products.index')); ?>" class="text-white text-opacity-70 hover:text-opacity-100 transition-all duration-200 text-sm hover:underline">
                            العودة للمتجر
                        </a>
                    </div>
                    <p class="text-white text-opacity-60 text-xs">
                        © 2025 متجر ملاك. جميع الحقوق محفوظة.
                    </p>
                </div>
            </div>
        </div>

    </body>
</html>
<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/layouts/guest.blade.php ENDPATH**/ ?>