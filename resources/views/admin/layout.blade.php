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
    
    <style>
        /* Ensure basic styling works even if Tailwind fails to load */
        * {
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Figtree', sans-serif;
            background-color: #f9fafb;
            direction: rtl;
        }
        
        .flex {
            display: flex;
        }
        
        .h-screen {
            height: 100vh;
        }
        
        .w-64 {
            width: 16rem;
        }
        
        .bg-white {
            background-color: white;
        }
        
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #374151;
            border-radius: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
        }
        
        .sidebar-link.active {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
        }
        
        .sidebar-link:hover {
            background: rgba(249, 115, 22, 0.1);
        }
        
        .stat-card {
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            padding: 1.5rem;
            border-radius: 0.75rem;
        }
        
        .chart-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        
        .btn-success {
            background-color: #10b981;
            color: white;
        }
        
        .btn-danger {
            background-color: #ef4444;
            color: white;
        }
        
        .grid {
            display: grid;
        }
        
        .grid-cols-4 {
            grid-template-columns: repeat(4, 1fr);
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
        <div class="bg-white shadow-lg w-64 flex-shrink-0">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-orange-500">
                <h1 class="text-white text-xl font-bold">Malak Outlet</h1>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-4 space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar ml-3"></i>
                        <span>لوحة التحكم</span>
                    </a>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Products Management -->
                    <div class="space-y-1">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">إدارة المنتجات</p>
                        
                        <a href="{{ route('admin.products.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="fas fa-box ml-3"></i>
                            <span>جميع المنتجات</span>
                            @if(isset($stats['total_products']) && $stats['total_products'] > 0)
                                <span class="mr-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $stats['total_products'] }}</span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.products.create') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle ml-3"></i>
                            <span>إضافة منتج</span>
                        </a>
                        
                        <a href="{{ route('admin.categories.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="fas fa-folder ml-3"></i>
                            <span>الفئات</span>
                            @if(isset($stats['total_categories']) && $stats['total_categories'] > 0)
                                <span class="mr-auto bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">{{ $stats['total_categories'] }}</span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.brands.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                            <i class="fas fa-tags ml-3"></i>
                            <span>العلامات التجارية</span>
                            @if(isset($stats['total_brands']) && $stats['total_brands'] > 0)
                                <span class="mr-auto bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">{{ $stats['total_brands'] }}</span>
                            @endif
                        </a>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Orders Management -->
                    <div class="space-y-1">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">إدارة الطلبات</p>
                        
                        <a href="{{ route('admin.orders.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart ml-3"></i>
                            <span>جميع الطلبات</span>
                            @if(isset($stats['total_orders']) && $stats['total_orders'] > 0)
                                <span class="mr-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">{{ $stats['total_orders'] }}</span>
                            @endif
                        </a>
                        
                        @if(isset($stats['pending_orders']) && $stats['pending_orders'] > 0)
                        <a href="{{ route('admin.orders.index') }}?status=pending" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-clock ml-3"></i>
                            <span>طلبات في الانتظار</span>
                            <span class="mr-auto bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full">{{ $stats['pending_orders'] }}</span>
                        </a>
                        @endif
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- User Management -->
                    <div class="space-y-1">
                        <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">إدارة المستخدمين</p>
                        
                        <a href="{{ route('admin.users.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users ml-3"></i>
                            <span>العملاء</span>
                        </a>
                        
                        <a href="{{ route('admin.reviews.index') }}" 
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                            <i class="fas fa-star ml-3"></i>
                            <span>المراجعات</span>
                        </a>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4"></div>
                    
                    <!-- Quick Actions -->
                    <div class="space-y-1">
                        <a href="{{ route('home') }}" target="_blank"
                           class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-external-link-alt ml-3"></i>
                            <span>زيارة الموقع</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="sidebar-link flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors w-full text-right hover:bg-red-50 hover:text-red-700">
                                <i class="fas fa-sign-out-alt ml-3"></i>
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
                                <i class="fas fa-check-circle ml-2"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-times-circle ml-2"></i>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-triangle ml-2"></i>
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
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // CSRF Token setup for AJAX
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Global admin functionality
        function confirmDelete(message = 'هل أنت متأكد من الحذف؟') {
            return confirm(message);
        }
        
        function showNotification(type, message) {
            // Simple notification system
            const notification = document.createElement('div');
            notification.className = `fixed top-4 left-4 z-50 px-6 py-3 rounded-lg text-white font-medium ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
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
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Update bulk action buttons on page load
            updateBulkActionButtons();
            
            // Add event listeners to checkboxes
            document.querySelectorAll('input[name="selected_items[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActionButtons);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>




