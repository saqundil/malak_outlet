<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
                box-shadow: 
                    0 25px 45px rgba(0, 0, 0, 0.1),
                    0 0 0 1px rgba(255, 255, 255, 0.05);
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }
            
            .glass-card:hover {
                transform: translateY(-2px);
                box-shadow: 
                    0 32px 60px rgba(0, 0, 0, 0.15),
                    0 0 0 1px rgba(255, 255, 255, 0.1);
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
            
            .glass-card::after {
                content: '';
                position: absolute;
                top: 1px;
                left: 1px;
                right: 1px;
                bottom: 1px;
                background: rgba(255, 255, 255, 0.02);
                border-radius: inherit;
                pointer-events: none;
            }
            
            .input-glow {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                backdrop-filter: blur(10px);
            }
            
            .input-glow:focus {
                box-shadow: 
                    0 0 0 3px rgba(249, 115, 22, 0.3), 
                    0 8px 25px rgba(249, 115, 22, 0.2),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
                transform: translateY(-1px);
                background: rgba(255, 255, 255, 0.15);
            }
            
            .input-glow:hover {
                background: rgba(255, 255, 255, 0.12);
                transform: translateY(-0.5px);
            }
            
            .btn-gradient {
                background: linear-gradient(135deg, #f97316, #ea580c, #dc2626);
                background-size: 200% 200%;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
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
                backdrop-filter: blur(15px);
                border: 2px solid rgba(255, 255, 255, 0.2);
                transition: all 0.4s ease;
                box-shadow: 
                    0 8px 25px rgba(0, 0, 0, 0.15),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2);
                position: relative;
                overflow: hidden;
            }
            
            .logo-container::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: conic-gradient(transparent, rgba(249, 115, 22, 0.1), transparent);
                animation: logoRotate 10s linear infinite;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            
            .logo-container:hover::before {
                opacity: 1;
            }
            
            @keyframes logoRotate {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            
            .logo-container:hover {
                transform: scale(1.05) translateY(-5px);
                box-shadow: 
                    0 15px 40px rgba(249, 115, 22, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
                border-color: rgba(249, 115, 22, 0.4);
            }
            
            .logo-container img {
                filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
                transition: filter 0.3s ease;
            }
            
            .logo-container:hover img {
                filter: drop-shadow(0 6px 12px rgba(249, 115, 22, 0.2));
            }
            
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
                20%, 40%, 60%, 80% { transform: translateX(2px); }
            }
            
            .animate-shake {
                animation: shake 0.5s ease-in-out;
            }
            
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 5px rgba(249, 115, 22, 0.3); }
                50% { box-shadow: 0 0 20px rgba(249, 115, 22, 0.6); }
            }
            
            .pulse-glow {
                animation: pulse-glow 2s ease-in-out infinite;
            }
            
            [x-cloak] { 
                display: none !important; 
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen auth-bg flex items-center justify-center px-4 relative overflow-hidden">
            <!-- Floating Shapes -->
            <div class="floating-shapes"></div>
            
            <div class="max-w-4xl w-full relative z-10">
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <!-- Logo Section -->
                    <div class="text-center items-center lg:text-center space-y-6">
                        <a href="{{ route('home') }}" class="flex items-center justify-center">
                            <div class="logo-container mx-auto lg:mx-0 w-32 h-32 rounded-3xl flex items-center justify-center p-3">
                                <!-- Your Actual Logo -->
                                <img src="{{ asset('images/malak.png') }}" 
                                     alt="MalakOutlet Logo" 
                                     class="w-full h-full object-contain rounded-2xl">
                            </div>
                        </a>
                        <div class="space-y-3">
                            <h1 class="text-4xl lg:text-5xl font-bold text-white">MalakOutlet</h1>
                            <p class="text-white text-opacity-90 text-lg font-medium">متجر الألعاب والليجو المتميز</p>
                            <p class="text-white text-opacity-80 text-sm max-w-md mx-auto lg:mx-0">
                                اكتشف مجموعة رائعة من الألعاب التعليمية ومجموعات الليجو المميزة لجميع الأعمار
                            </p>
                        </div>
                    </div>

                    <!-- Auth Card -->
                    <div class="glass-card rounded-2xl shadow-2xl p-6">
                    {{ $slot }}
                </div>
                    </div>
                </div>
                
                <!-- Footer -->
                
            </div>
            
        </div>

    </body>
</html>




