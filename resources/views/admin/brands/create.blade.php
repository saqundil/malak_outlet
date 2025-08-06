@extends('admin.layout')

@section('title', 'إضافة علامة تجارية جديدة')
@section('page-title', 'إضافة علامة تجارية')
@section('page-description', 'إضافة علامة تجارية جديدة للمتجر')

@section('content')
<form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">المعلومات الأساسية</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">اسم العلامة التجارية *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">وصف العلامة التجارية</label>
                        <textarea name="description" rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ترتيب العرض</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <p class="text-sm text-gray-500 mt-1">أقل رقم يظهر أولاً في القوائم</p>
                        @error('sort_order')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- SEO Settings -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">إعدادات SEO</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">عنوان الصفحة (Meta Title)</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}" maxlength="255"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <p class="text-sm text-gray-500 mt-1">يُنصح بـ 50-60 حرف</p>
                        @error('meta_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">وصف الصفحة (Meta Description)</label>
                        <textarea name="meta_description" rows="3" maxlength="500"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('meta_description') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">يُنصح بـ 150-160 حرف</p>
                        @error('meta_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الكلمات المفتاحية (Meta Keywords)</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}"
                               placeholder="فصل الكلمات بفواصل"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('meta_keywords')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Brand Logo -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">شعار العلامة التجارية</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اختر الشعار</label>
                    <input type="file" name="logo" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <p class="text-sm text-gray-500 mt-1">الحد الأقصى: 2MB. الصيغ المدعومة: JPG, PNG</p>
                    @error('logo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Preview area -->
                <div id="logo-preview" class="mt-4 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">معاينة الشعار</label>
                    <img id="preview-img" src="" alt="Preview" class="w-32 h-32 object-contain rounded-lg border border-gray-300 bg-gray-50">
                </div>
            </div>
            
            <!-- Status Settings -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">إعدادات الحالة</h3>
                
                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-700">علامة تجارية نشطة</label>
                        <p class="text-xs text-gray-500">تظهر العلامة التجارية في الموقع للزوار</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                    </label>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="space-y-3">
                    <button type="submit" 
                            class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        حفظ العلامة التجارية
                    </button>
                    
                    <a href="{{ route('admin.brands.index') }}" 
                       class="w-full bg-gray-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors block text-center">
                        <i class="fas fa-times ml-2"></i>
                        إلغاء
                    </a>
                </div>
            </div>
            
            <!-- Tips -->
            <div class="bg-blue-50 p-6 rounded-xl border border-blue-200">
                <h4 class="text-sm font-medium text-blue-900 mb-3">
                    <i class="fas fa-lightbulb ml-2"></i>
                    نصائح مهمة
                </h4>
                <ul class="text-sm text-blue-800 space-y-2">
                    <li>• استخدم شعار عالي الجودة للحصول على أفضل عرض</li>
                    <li>• اختر اسم واضح ومميز للعلامة التجارية</li>
                    <li>• اكتب وصف شامل يوضح ما تقدمه العلامة</li>
                    <li>• املأ معلومات SEO لتحسين الظهور في محركات البحث</li>
                    <li>• يمكنك إضافة المنتجات للعلامة التجارية بعد حفظها</li>
                </ul>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // Logo preview functionality
    document.querySelector('input[name="logo"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('logo-preview');
        const previewImg = document.getElementById('preview-img');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
        }
    });
    
    // Auto-generate slug preview when name changes
    document.querySelector('input[name="name"]').addEventListener('input', function(e) {
        const name = e.target.value;
        const slug = name.toLowerCase()
                        .replace(/[^a-z0-9\u0600-\u06FF\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .trim('-');
        
        // You could display the slug preview here if needed
        console.log('Generated slug preview:', slug);
    });
    
    // Auto-fill meta title if empty when name is entered
    const nameInput = document.querySelector('input[name="name"]');
    const metaTitleInput = document.querySelector('input[name="meta_title"]');
    
    nameInput.addEventListener('input', function() {
        if (!metaTitleInput.value) {
            metaTitleInput.value = this.value;
        }
    });
</script>
@endpush




