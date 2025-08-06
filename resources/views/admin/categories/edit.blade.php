@extends('admin.layout')

@section('title', 'تعديل الفئة: ' . $category->name)
@section('page-title', 'تعديل الفئة')
@section('page-description', 'تعديل معلومات الفئة: ' . $category->name)

@section('content')
<form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">المعلومات الأساسية</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">اسم الفئة *</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">وصف الفئة</label>
                        <textarea name="description" rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ترتيب العرض</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
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
                        <input type="text" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" maxlength="255"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <p class="text-sm text-gray-500 mt-1">يُنصح بـ 50-60 حرف</p>
                        @error('meta_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">وصف الصفحة (Meta Description)</label>
                        <textarea name="meta_description" rows="3" maxlength="500"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('meta_description', $category->meta_description) }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">يُنصح بـ 150-160 حرف</p>
                        @error('meta_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الكلمات المفتاحية (Meta Keywords)</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $category->meta_keywords) }}"
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
            <!-- Category Image -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">صورة الفئة</h3>
                
                <!-- Current Image -->
                @if($category->image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">الصورة الحالية</label>
                        <div class="relative inline-block">
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" 
                                 class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                        </div>
                    </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $category->image ? 'تغيير الصورة' : 'اختر الصورة' }}
                    </label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <p class="text-sm text-gray-500 mt-1">الحد الأقصى: 2MB. الصيغ المدعومة: JPG, PNG</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Preview area -->
                <div id="image-preview" class="mt-4 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">معاينة الصورة الجديدة</label>
                    <img id="preview-img" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                </div>
            </div>
            
            <!-- Status Settings -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">إعدادات الحالة</h3>
                
                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-700">فئة نشطة</label>
                        <p class="text-xs text-gray-500">تظهر الفئة في الموقع للزوار</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                    </label>
                </div>
            </div>
            
            <!-- Category Statistics -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">إحصائيات الفئة</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">عدد المنتجات:</span>
                        <span class="font-medium">{{ $category->products->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">تاريخ الإنشاء:</span>
                        <span class="font-medium">{{ $category->created_at->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">آخر تحديث:</span>
                        <span class="font-medium">{{ $category->updated_at->format('d/m/Y') }}</span>
                    </div>
                    
                    @if($category->slug)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">الرابط المختصر:</span>
                            <span class="font-medium text-blue-600">{{ $category->slug }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="space-y-3">
                    <button type="submit" 
                            class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        حفظ التغييرات
                    </button>
                    
                    <a href="{{ route('admin.categories.show', $category) }}" 
                       class="w-full bg-blue-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-600 transition-colors block text-center">
                        <i class="fas fa-eye ml-2"></i>
                        عرض الفئة
                    </a>
                    
                    <a href="{{ route('admin.categories.index') }}" 
                       class="w-full bg-gray-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors block text-center">
                        <i class="fas fa-times ml-2"></i>
                        إلغاء
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // Image preview functionality
    document.querySelector('input[name="image"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('image-preview');
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
</script>
@endpush




