<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-authenticated" content="{{ Auth::check() ? 'true' : 'false' }}">
    <title>@yield('title', 'MalakOutlet - Ultimate Toy & LEGO Store')</title>
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.0/cdn.min.js" defer></script>
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
        
        /* Custom Alert Styles */
        .custom-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 350px;
            max-width: 500px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }
        
        .custom-alert.show {
            transform: translateX(0);
            opacity: 1;
        }
        
        .custom-alert.hide {
            transform: translateX(100%);
            opacity: 0;
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.95) 0%, rgba(22, 163, 74, 0.95) 100%);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: white;
        }
        
        .alert-error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.95) 0%, rgba(220, 38, 38, 0.95) 100%);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: white;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.95) 0%, rgba(217, 119, 6, 0.95) 100%);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: white;
        }
        
        .alert-info {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.95) 0%, rgba(37, 99, 235, 0.95) 100%);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: white;
        }
        
        .alert-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }
        
        .alert-close {
            width: 20px;
            height: 20px;
            opacity: 0.7;
            transition: opacity 0.2s;
            cursor: pointer;
        }
        
        .alert-close:hover {
            opacity: 1;
        }
        
        .alert-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 0 0 12px 12px;
            overflow: hidden;
        }
        
        .alert-progress-bar {
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            width: 0%;
            transition: width 0.1s linear;
        }
        
        @media (max-width: 640px) {
            .custom-alert {
                top: 10px;
                right: 10px;
                left: 10px;
                min-width: auto;
                max-width: none;
                width: calc(100% - 20px);
            }
        }
        @media (max-width: 768px) {
            .mobile-menu {
                transform: translateX(100%);
                transition: transform 0.3s ease-in-out;
            }
            .mobile-menu.open {
                transform: translateX(0);
            }
            
            /* Mobile-specific improvements */
            body {
                overflow-x: hidden;
                min-width: 320px;
            }
            
            /* Ensure containers don't overflow */
            .container {
                max-width: 100%;
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            
            /* Fix header overflow */
            header {
                min-width: 320px;
                overflow-x: hidden;
            }
            
            header .container {
                padding-left: 0;
                padding-right: 0;
                max-width: 100vw;
            }
            
            /* Mobile typography scaling */
            h1 { font-size: 1.5rem !important; }
            h2 { font-size: 1.25rem !important; }
            h3 { font-size: 1.125rem !important; }
            
            /* Touch-friendly buttons */
            .btn, button, a[class*="btn"] {
                min-height: 44px;
                padding: 0.75rem 1rem;
            }
            
            /* Mobile grid fixes */
            .grid {
                gap: 0.75rem;
            }
            
            /* Prevent horizontal scrolling */
            * {
                max-width: 100%;
            }
            
            img {
                max-width: 100%;
                height: auto;
            }
        }
        
        /* Custom styles for professional look */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #f97316, #ea580c);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(135deg, #ea580c, #dc2626);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.4);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #f97316, #ea580c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .card-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .card-shine:hover::before {
            left: 100%;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #f97316;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #ea580c;
        }
    </style>
    
    @stack('styles')
    <meta name="google-site-verification" content="GOVH6m7DqDhN6O9TeJ_JeJBZIoK3smGM8BFNbnJ5SeA" />
</head>

<body class="text-gray-700 bg-white m-0 p-0" x-data="{ mobileMenuOpen: false }">
    <!-- Custom Alert Container -->
    <div id="alert-container"></div>
    
    <!-- Header Component -->
    @include('components.header')
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div id="flash-success" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mx-4 my-2 relative" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="document.getElementById('flash-success').remove()" class="absolute top-0 left-0 mt-2 ml-2 text-green-500 hover:text-green-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif
    
    @if(session('error'))
        <div id="flash-error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mx-4 my-2 relative" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="document.getElementById('flash-error').remove()" class="absolute top-0 left-0 mt-2 ml-2 text-red-500 hover:text-red-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif
    
    <!-- Main Content -->
    @yield('content')
    
    <!-- Footer Component -->
    @include('components.footer')
    
    <!-- Cart Helper Script -->
    <script src="{{ asset('js/cart-helper.js') }}"></script>
    <!-- Main Application Script -->
    <script src="{{ asset('js/malak-app.js') }}"></script>
    
    <!-- Flash message auto-hide script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide flash messages after 5 seconds
            const flashMessages = document.querySelectorAll('[id^="flash-"]');
            flashMessages.forEach(function(message) {
                setTimeout(function() {
                    if (message) {
                        message.style.opacity = '0';
                        message.style.transition = 'opacity 0.5s ease-out';
                        setTimeout(function() {
                            message.remove();
                        }, 500);
                    }
                }, 5000);
            });
        });
    </script>
    
    <!-- Custom Alert System -->
    <script>
        class CustomAlert {
            constructor() {
                this.container = document.getElementById('alert-container');
                this.alerts = [];
            }
            
            show(message, type = 'info', duration = 5000) {
                const alertId = 'alert-' + Date.now() + Math.random().toString(36).substr(2, 9);
                
                const alertElement = document.createElement('div');
                alertElement.id = alertId;
                alertElement.className = `custom-alert alert-${type}`;
                
                const icon = this.getIcon(type);
                
                alertElement.innerHTML = `
                    <div class="p-4 flex items-start gap-3">
                        <div class="alert-icon flex-shrink-0">
                            ${icon}
                        </div>
                        <div class="flex-1 text-sm font-medium leading-5">
                            ${message}
                        </div>
                        <button class="alert-close flex-shrink-0" onclick="customAlert.hide('${alertId}')">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="alert-progress">
                        <div class="alert-progress-bar"></div>
                    </div>
                `;
                
                this.container.appendChild(alertElement);
                
                // Show alert with animation
                setTimeout(() => {
                    alertElement.classList.add('show');
                }, 10);
                
                // Start progress bar animation
                const progressBar = alertElement.querySelector('.alert-progress-bar');
                setTimeout(() => {
                    progressBar.style.width = '100%';
                    progressBar.style.transition = `width ${duration}ms linear`;
                }, 100);
                
                // Auto hide
                const timeoutId = setTimeout(() => {
                    this.hide(alertId);
                }, duration);
                
                this.alerts.push({ id: alertId, timeoutId });
                
                // Position alerts
                this.repositionAlerts();
                
                return alertId;
            }
            
            hide(alertId) {
                const alert = document.getElementById(alertId);
                if (alert) {
                    alert.classList.remove('show');
                    alert.classList.add('hide');
                    
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                        this.repositionAlerts();
                    }, 300);
                    
                    // Clear timeout
                    const alertIndex = this.alerts.findIndex(a => a.id === alertId);
                    if (alertIndex !== -1) {
                        clearTimeout(this.alerts[alertIndex].timeoutId);
                        this.alerts.splice(alertIndex, 1);
                    }
                }
            }
            
            repositionAlerts() {
                const alerts = this.container.querySelectorAll('.custom-alert.show');
                let topOffset = 20;
                
                alerts.forEach((alert, index) => {
                    alert.style.top = topOffset + 'px';
                    topOffset += alert.offsetHeight + 10;
                });
            }
            
            getIcon(type) {
                const icons = {
                    success: `<svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>`,
                    error: `<svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>`,
                    warning: `<svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>`,
                    info: `<svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>`
                };
                return icons[type] || icons.info;
            }
            
            // Convenience methods
            success(message, duration = 5000) {
                return this.show(message, 'success', duration);
            }
            
            error(message, duration = 7000) {
                return this.show(message, 'error', duration);
            }
            
            warning(message, duration = 6000) {
                return this.show(message, 'warning', duration);
            }
            
            info(message, duration = 5000) {
                return this.show(message, 'info', duration);
            }
            
            // Custom confirm dialog
            confirm(message, onConfirm, onCancel = null) {
                const confirmId = 'confirm-' + Date.now() + Math.random().toString(36).substr(2, 9);
                
                const confirmElement = document.createElement('div');
                confirmElement.id = confirmId;
                confirmElement.className = 'custom-alert alert-warning';
                confirmElement.style.position = 'fixed';
                confirmElement.style.top = '50%';
                confirmElement.style.left = '50%';
                confirmElement.style.transform = 'translate(-50%, -50%)';
                confirmElement.style.zIndex = '10000';
                confirmElement.style.maxWidth = '400px';
                confirmElement.style.width = '90%';
                
                confirmElement.innerHTML = `
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="alert-icon flex-shrink-0">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold">تأكيد العملية</h3>
                        </div>
                        <p class="text-white mb-6 leading-relaxed">${message}</p>
                        <div class="flex gap-3 justify-end">
                            <button id="${confirmId}-cancel" class="px-4 py-2 bg-white/20 text-white rounded-lg hover:bg-white/30 transition-colors font-medium">
                                إلغاء
                            </button>
                            <button id="${confirmId}-confirm" class="px-4 py-2 bg-white text-orange-600 rounded-lg hover:bg-gray-100 transition-colors font-bold">
                                تأكيد
                            </button>
                        </div>
                    </div>
                `;
                
                // Create overlay
                const overlay = document.createElement('div');
                overlay.id = confirmId + '-overlay';
                overlay.style.position = 'fixed';
                overlay.style.top = '0';
                overlay.style.left = '0';
                overlay.style.right = '0';
                overlay.style.bottom = '0';
                overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                overlay.style.zIndex = '9999';
                overlay.style.backdropFilter = 'blur(3px)';
                
                document.body.appendChild(overlay);
                document.body.appendChild(confirmElement);
                
                // Show with animation
                setTimeout(() => {
                    confirmElement.classList.add('show');
                    overlay.style.opacity = '1';
                }, 10);
                
                // Handle buttons
                const confirmBtn = document.getElementById(confirmId + '-confirm');
                const cancelBtn = document.getElementById(confirmId + '-cancel');
                
                const cleanup = () => {
                    confirmElement.classList.remove('show');
                    confirmElement.classList.add('hide');
                    overlay.style.opacity = '0';
                    
                    setTimeout(() => {
                        if (confirmElement.parentNode) confirmElement.parentNode.removeChild(confirmElement);
                        if (overlay.parentNode) overlay.parentNode.removeChild(overlay);
                    }, 300);
                };
                
                confirmBtn.onclick = () => {
                    cleanup();
                    if (onConfirm) onConfirm();
                };
                
                cancelBtn.onclick = () => {
                    cleanup();
                    if (onCancel) onCancel();
                };
                
                overlay.onclick = () => {
                    cleanup();
                    if (onCancel) onCancel();
                };
            }
        }
        
        // Create global instance
        const customAlert = new CustomAlert();
        
        // Override default alert function
        window.alert = function(message) {
            customAlert.info(message);
        };
        
        // Override default confirm function
        window.confirm = function(message) {
            return new Promise((resolve) => {
                customAlert.confirm(message, () => resolve(true), () => resolve(false));
            });
        };
        
        // Add global methods
        window.showAlert = customAlert.show.bind(customAlert);
        window.showSuccess = customAlert.success.bind(customAlert);
        window.showError = customAlert.error.bind(customAlert);
        window.showWarning = customAlert.warning.bind(customAlert);
        window.showInfo = customAlert.info.bind(customAlert);
        window.showConfirm = customAlert.confirm.bind(customAlert);
    </script>
    
    @stack('scripts')
    
    
</body>
</html>



