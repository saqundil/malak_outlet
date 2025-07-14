@extends('layouts.main')

@section('title', 'الملف الشخصي - متجر ملاك')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">الملف الشخصي</h1>
            <p class="text-xl opacity-90">إدارة معلوماتك الشخصية وإعدادات الحساب</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            <!-- Profile Navigation -->
            <div class="bg-white rounded-lg shadow-md mb-8">
                <div class="flex flex-wrap border-b">
                    <a href="#profile-info" onclick="showTab('profile-info')" 
                       class="tab-link active px-6 py-4 font-medium text-blue-600 border-b-2 border-blue-600">
                        المعلومات الشخصية
                    </a>
                    <a href="#password" onclick="showTab('password')" 
                       class="tab-link px-6 py-4 font-medium text-gray-600 hover:text-blue-600">
                        تغيير كلمة المرور
                    </a>
                    <a href="#orders" onclick="showTab('orders')" 
                       class="tab-link px-6 py-4 font-medium text-gray-600 hover:text-blue-600">
                        طلباتي
                    </a>
                    <a href="#addresses" onclick="showTab('addresses')" 
                       class="tab-link px-6 py-4 font-medium text-gray-600 hover:text-blue-600">
                        العناوين
                    </a>
                </div>
            </div>

            <!-- Profile Information Tab -->
            <div id="profile-info" class="tab-content">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">المعلومات الشخصية</h3>
                    
                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">تاريخ الميلاد</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-6">
                            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                                حفظ التغييرات
                            </button>
                            
                            @if (session('status') === 'profile-updated')
                                <p class="text-green-600 font-medium">تم حفظ التغييرات بنجاح!</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Change Tab -->
            <div id="password" class="tab-content hidden">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">تغيير كلمة المرور</h3>
                    
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور الحالية</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور الجديدة</label>
                            <input type="password" id="password" name="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">تأكيد كلمة المرور</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-between items-center pt-6">
                            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
                                تحديث كلمة المرور
                            </button>
                            
                            @if (session('status') === 'password-updated')
                                <p class="text-green-600 font-medium">تم تحديث كلمة المرور بنجاح!</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Orders Tab -->
            <div id="orders" class="tab-content hidden">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">طلباتي</h3>
                    
                    <div class="space-y-4">
                        <!-- Sample order -->
                        <div class="border border-gray-200 rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-semibold text-lg">طلب #12345</h4>
                                    <p class="text-gray-600">تاريخ الطلب: 2025-01-15</p>
                                </div>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">تم التوصيل</span>
                            </div>
                            <div class="border-t pt-4">
                                <p class="text-gray-700">المجموع: 450.00 ر.س</p>
                                <div class="mt-4 flex space-x-3 space-x-reverse">
                                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض التفاصيل</button>
                                    <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50">إعادة الطلب</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center py-8">
                            <p class="text-gray-500">لا توجد طلبات أخرى</p>
                            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">تصفح المنتجات</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Addresses Tab -->
            <div id="addresses" class="tab-content hidden">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">عناوين الشحن</h3>
                    
                    <div class="space-y-4">
                        <button class="w-full border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 hover:bg-blue-50 transition duration-200">
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <p class="text-gray-600">إضافة عنوان جديد</p>
                        </button>
                        
                        <div class="text-center py-8">
                            <p class="text-gray-500">لم تقم بإضافة أي عناوين بعد</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.classList.add('hidden'));
    
    // Remove active class from all tab links
    const links = document.querySelectorAll('.tab-link');
    links.forEach(link => {
        link.classList.remove('active', 'text-blue-600', 'border-b-2', 'border-blue-600');
        link.classList.add('text-gray-600');
    });
    
    // Show selected tab content
    document.getElementById(tabName).classList.remove('hidden');
    
    // Add active class to selected tab link
    const activeLink = document.querySelector(`a[href="#${tabName}"]`);
    activeLink.classList.add('active', 'text-blue-600', 'border-b-2', 'border-blue-600');
    activeLink.classList.remove('text-gray-600');
}
</script>
@endsection
