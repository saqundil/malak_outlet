<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'لوحة التحكم') - Malak Outlet Admin</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        /* Enhanced Sidebar Styles */
        body {
            direction: rtl;
        }
        
        .sidebar-link {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-link:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            transform: translateX(4px);
            color: #3b82f6;
        }
        
        .sidebar-link.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .sidebar-link.active:before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: #fbbf24;
        }
        
        .sidebar-section {
            position: relative;
            margin-bottom: 8px;
        }
        
        .sidebar-section:before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, transparent, #e2e8f0, transparent);
        }
        
        .sidebar-badge {
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .sidebar-collapsible {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .sidebar-collapsible.expanded {
            max-height: 500px;
        }
        
        /* Enhanced icon spacing for RTL layout */
        .sidebar-link i {
            width: 20px;
            text-align: center;
        }
        
        .sidebar-section p i {
            width: 18px;
            text-align: center;
        }
        
        /* Global icon spacing fixes for RTL */
        .fas, .far, .fab, .fal {
            margin-left: 0 !important;
        }
        
        /* Proper icon spacing in flex containers */
        .flex .fas + span,
        .flex .far + span,
        .flex .fab + span,
        .flex .fal + span {
            margin-right: 12px;
        }
        
        /* Button icon spacing */
        button .fas,
        a .fas,
        .btn .fas {
            margin-left: 0 !important;
        }
        
        /* Dashboard card icon spacing */
        .card .fas + *,
        .bg-white .fas + * {
            margin-right: 8px;
        }
        
        /* Alert/notification icon spacing */
        .alert .fas + *,
        .notification .fas + * {
            margin-right: 8px;
        }
        
        /* Dashboard statistics and content icons */
        .fas.ml-2, .fas.ml-3, .fas.ml-4, .fas.ml-5 {
            margin-left: 0 !important;
            margin-right: 12px !important;
        }
        
        /* Dashboard text with leading icons */
        i.fas + span,
        i.far + span,
        i.fab + span,
        i.fal + span {
            margin-right: 0.75rem;
        }
        
        /* Orders list icon spacing */
        .order-icon, 
        .w-12.h-12 .fas {
            margin: 0 !important;
        }
        
        /* Button text spacing */
        button i.fas + *,
        a i.fas + *,
        .btn i.fas + * {
            margin-right: 8px;
        }
        
        /* Force proper spacing for all dashboard content */
        .bg-gray-50 i.fas,
        .p-4 i.fas,
        .rounded-lg i.fas {
            margin-left: 0 !important;
        }
        
        .gap-6 {
            gap: 1.5rem;
        }
        
        .p-6 {
            padding: 1.5rem;
        }
        
        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .text-gray-900 {
            color: #111827;
        }
        
        .text-gray-600 {
            color: #4b5563;
        }
        
        .mt-4 {
            margin-top: 1rem;
        }
        
        .flex-1 {
            flex: 1;
        }
        
        .overflow-auto {
            overflow: auto;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-white shadow-xl w-64 flex-shrink-0" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
                <div class="flex items-center space-x-3 space-x-reverse">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-store text-orange-500"></i>
                    </div>
                    <h1 class="text-white text-xl font-bold">Malak Outlet</h1>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8 h-full overflow-y-auto pb-8">
                <div class="px-4 space-y-2">
                    <!-- Dashboard Section -->
                    <div class="sidebar-section">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                            <i class="fas fa-chart-bar mr-3"></i>
                            لوحات التحكم
                        </p>
                        
                        <a href="{{ route('admin.dashboard') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') && !request()->routeIs('admin.dashboard.enhanced') && !request()->routeIs('admin.dashboard.tables') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt mr-4"></i>
                            <span>لوحة التحكم الرئيسية</span>
                        </a>
                        
                       
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Products Management -->
                    <div class="sidebar-section">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                            <i class="fas fa-box-open mr-3"></i>
                            إدارة المنتجات
                        </p>
                        
                        <a href="{{ route('admin.products.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="fas fa-box mr-4"></i>
                            <span>جميع المنتجات</span>
                            @if(isset($stats['total_products']) && $stats['total_products'] > 0)
                                <span class="mr-auto sidebar-badge bg-blue-100 text-blue-800">{{ $stats['total_products'] }}</span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.products.create') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle mr-4"></i>
                            <span>إضافة منتج جديد</span>
                        </a>
                        
                        <a href="{{ route('admin.categories.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="fas fa-folder mr-4"></i>
                            <span>فئات المنتجات</span>
                            @if(isset($stats['total_categories']) && $stats['total_categories'] > 0)
                                <span class="mr-auto sidebar-badge bg-purple-100 text-purple-800">{{ $stats['total_categories'] }}</span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.brands.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                            <i class="fas fa-tags mr-4"></i>
                            <span>العلامات التجارية</span>
                            @if(isset($stats['total_brands']) && $stats['total_brands'] > 0)
                                <span class="mr-auto sidebar-badge bg-indigo-100 text-indigo-800">{{ $stats['total_brands'] }}</span>
                            @endif
                        </a>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Orders and Sales Management -->
                    <div class="sidebar-section">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                            <i class="fas fa-shopping-cart mr-3"></i>
                            إدارة الطلبات والمبيعات
                        </p>
                        
                        <a href="{{ route('admin.orders.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="fas fa-receipt mr-4"></i>
                            <span>جميع الطلبات</span>
                            @if(isset($stats['total_orders']) && $stats['total_orders'] > 0)
                                <span class="mr-auto sidebar-badge bg-green-100 text-green-800">{{ $stats['total_orders'] }}</span>
                            @endif
                        </a>
                        
                        @if(isset($stats['pending_orders']) && $stats['pending_orders'] > 0)
                        <a href="{{ route('admin.orders.index') }}?status=pending" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-clock mr-4"></i>
                            <span>طلبات في الانتظار</span>
                            <span class="mr-auto sidebar-badge bg-orange-100 text-orange-800">{{ $stats['pending_orders'] }}</span>
                        </a>
                        @endif
                        
                        <a href="{{ route('admin.discounts.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.discounts.*') ? 'active' : '' }}">
                            <i class="fas fa-percentage mr-4"></i>
                            <span>الخصومات والعروض</span>
                            @if(isset($stats['total_discounts']) && $stats['total_discounts'] > 0)
                                <span class="mr-auto sidebar-badge bg-red-100 text-red-800">{{ $stats['total_discounts'] }}</span>
                            @endif
                        </a>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Customer and Location Management -->
                    <div class="sidebar-section">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                            <i class="fas fa-users mr-3"></i>
                            إدارة العملاء والمواقع
                        </p>
                        
                        <a href="{{ route('admin.users.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-user-friends mr-4"></i>
                            <span>العملاء</span>
                            @if(isset($stats['total_customers']) && $stats['total_customers'] > 0)
                                <span class="mr-auto sidebar-badge bg-blue-100 text-blue-800">{{ $stats['total_customers'] }}</span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.cities.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">
                            <i class="fas fa-map-marker-alt mr-4"></i>
                            <span>المدن الأردنية</span>
                            @if(isset($stats['total_jordan_cities']) && $stats['total_jordan_cities'] > 0)
                                <span class="mr-auto sidebar-badge bg-green-100 text-green-800">{{ $stats['total_jordan_cities'] }}</span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.reviews.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                            <i class="fas fa-star mr-4"></i>
                            <span>مراجعات العملاء</span>
                            @if(isset($stats['total_reviews']) && $stats['total_reviews'] > 0)
                                <span class="mr-auto sidebar-badge bg-yellow-100 text-yellow-800">{{ $stats['total_reviews'] }}</span>
                            @endif
                        </a>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- System Tools -->
                    <div class="sidebar-section">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center">
                            <i class="fas fa-tools mr-3"></i>
                            أدوات النظام
                        </p>
                        
                        <a href="{{ route('admin.settings.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <i class="fas fa-cog mr-4"></i>
                            <span>إعدادات النظام</span>
                        </a>
                        
                        <a href="{{ route('home') }}" target="_blank"
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-external-link-alt mr-4"></i>
                            <span>زيارة الموقع</span>
                            <i class="fas fa-arrow-up-right-from-square mr-auto text-xs"></i>
                        </a>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Logout -->
                    <div class="px-4">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors w-full text-right hover:bg-red-50 hover:text-red-700">
                                <i class="fas fa-sign-out-alt mr-4"></i>
                                <span>تسجيل الخروج</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'لوحة التحكم')</h1>
                            <p class="text-gray-600">@yield('page-description', 'مرحباً بك في لوحة التحكم')</p>
                        </div>
                        
                        <div class="flex items-center space-x-4 space-x-reverse">
                            <div class="text-sm text-gray-600">
                                مرحباً، {{ auth()->user()->name }}
                            </div>
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <!-- Alerts -->
                    @if (session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-times-circle mr-3"></i>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-triangle mr-3"></i>
                                يرجى تصحيح الأخطاء التالية:
                            </div>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Global Notification System -->
    <div id="notificationContainer" class="fixed top-4 left-4 z-50 space-y-2"></div>

    <!-- Global Loading Overlay -->
    <div id="globalLoader" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white rounded-lg p-6 flex items-center space-x-4 space-x-reverse">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div>
                <span class="text-gray-700 font-medium">جاري التحميل...</span>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // CSRF Token setup for AJAX
        if (typeof window.axios !== 'undefined') {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }
        
        // Global admin functionality
        function confirmDelete(message = 'هل أنت متأكد من الحذف؟') {
            return confirm(message);
        }
        
        // Enhanced Notification System
        let notificationCounter = 0;
        
        function showNotification(type, message, duration = 4000) {
            const notificationContainer = document.getElementById('notificationContainer');
            const notificationId = `notification-${++notificationCounter}`;
            
            const notification = document.createElement('div');
            notification.id = notificationId;
            notification.className = `transform transition-all duration-300 translate-x-full opacity-0 px-6 py-4 rounded-lg shadow-lg font-medium flex items-center space-x-3 space-x-reverse max-w-sm`;
            
            // Set notification colors and icons
            const styles = {
                success: {
                    bg: 'bg-green-500',
                    text: 'text-white',
                    icon: 'fas fa-check-circle'
                },
                error: {
                    bg: 'bg-red-500',
                    text: 'text-white',
                    icon: 'fas fa-times-circle'
                },
                warning: {
                    bg: 'bg-yellow-500',
                    text: 'text-white',
                    icon: 'fas fa-exclamation-triangle'
                },
                info: {
                    bg: 'bg-blue-500',
                    text: 'text-white',
                    icon: 'fas fa-info-circle'
                }
            };
            
            const style = styles[type] || styles.info;
            notification.className += ` ${style.bg} ${style.text}`;
            
            notification.innerHTML = `
                <i class="${style.icon} text-lg"></i>
                <span class="flex-1">${message}</span>
                <button onclick="closeNotification('${notificationId}')" class="text-white hover:text-gray-200 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            notificationContainer.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full', 'opacity-0');
            }, 100);
            
            // Auto dismiss
            setTimeout(() => {
                closeNotification(notificationId);
            }, duration);
            
            return notificationId;
        }
        
        function closeNotification(notificationId) {
            const notification = document.getElementById(notificationId);
            if (notification) {
                notification.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }
        
        // Global Loading System
        function showLoader(message = 'جاري التحميل...') {
            const loader = document.getElementById('globalLoader');
            const loaderText = loader.querySelector('span');
            loaderText.textContent = message;
            loader.classList.remove('hidden');
        }
        
        function hideLoader() {
            const loader = document.getElementById('globalLoader');
            loader.classList.add('hidden');
        }
        
        // Enhanced AJAX Helper
        function makeRequest(url, options = {}) {
            showLoader(options.loadingMessage || 'جاري التحميل...');
            
            const defaultOptions = {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            };
            
            const mergedOptions = { ...defaultOptions, ...options };
            
            return fetch(url, mergedOptions)
                .then(response => {
                    hideLoader();
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .catch(error => {
                    hideLoader();
                    showNotification('error', 'حدث خطأ في الاتصال بالخادم');
                    throw error;
                });
        }
        
        // Bulk actions
        function toggleAllCheckboxes(masterCheckbox) {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = masterCheckbox.checked;
            });
            updateBulkActionButtons();
        }
        
        function updateBulkActionButtons() {
            const selectedItems = document.querySelectorAll('input[name="selected_items[]"]:checked');
            const bulkActionButtons = document.querySelector('.bulk-actions');
            
            if (bulkActionButtons) {
                bulkActionButtons.style.display = selectedItems.length > 0 ? 'block' : 'none';
            }
        }
        
        // Real-time updates for sidebar stats
        function updateSidebarStats() {
            makeRequest('/admin/api/stats')
                .then(data => {
                    if (data.success) {
                        // Update sidebar badges
                        updateSidebarBadge('products', data.data.total_products);
                        updateSidebarBadge('categories', data.data.total_categories);
                        updateSidebarBadge('brands', data.data.total_brands);
                        updateSidebarBadge('orders', data.data.total_orders);
                        updateSidebarBadge('discounts', data.data.total_discounts);
                    }
                })
                .catch(error => {
                    console.error('Error updating sidebar stats:', error);
                });
        }
        
        function updateSidebarBadge(type, count) {
            const badge = document.querySelector(`a[href*="${type}"] .bg-blue-100, a[href*="${type}"] .bg-purple-100, a[href*="${type}"] .bg-indigo-100, a[href*="${type}"] .bg-green-100, a[href*="${type}"] .bg-red-100`);
            if (badge) {
                badge.textContent = count;
            }
        }
        
        // Auto-save functionality
        function enableAutoSave(formSelector, saveUrl, interval = 30000) {
            const form = document.querySelector(formSelector);
            if (!form) return;
            
            let autoSaveTimer;
            const inputs = form.querySelectorAll('input, textarea, select');
            
            function saveForm() {
                const formData = new FormData(form);
                
                fetch(saveUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('info', 'تم حفظ التغييرات تلقائياً', 2000);
                    }
                })
                .catch(error => {
                    console.error('Auto-save failed:', error);
                });
            }
            
            function resetAutoSaveTimer() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(saveForm, interval);
            }
            
            inputs.forEach(input => {
                input.addEventListener('input', resetAutoSaveTimer);
                input.addEventListener('change', resetAutoSaveTimer);
            });
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Update bulk action buttons on page load
            updateBulkActionButtons();
            
            // Add event listeners to checkboxes
            document.querySelectorAll('input[name="selected_items[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActionButtons);
            });
            
            // Update sidebar stats every 2 minutes
            updateSidebarStats();
            setInterval(updateSidebarStats, 120000);
            
            // Handle page visibility change for real-time updates
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    updateSidebarStats();
                }
            });
            
            // Global error handling
            window.addEventListener('unhandledrejection', function(event) {
                console.error('Unhandled promise rejection:', event.reason);
                showNotification('error', 'حدث خطأ غير متوقع');
            });
        });
        
        // Utility functions
        function formatNumber(number) {
            return new Intl.NumberFormat('ar-SA').format(number);
        }
        
        function formatCurrency(amount) {
            return new Intl.NumberFormat('ar-SA', {
                style: 'currency',
                currency: 'JOD'
            }).format(amount);
        }
        
        function formatDate(date) {
            return new Intl.DateTimeFormat('ar-SA').format(new Date(date));
        }
    </script>
    
    @stack('scripts')
</body>
</html>




