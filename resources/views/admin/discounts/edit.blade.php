@extends('admin.layout')

@section('title', 'تعديل الخصم')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="admin-card mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">تعديل الخصم</h1>
                <p class="text-gray-600 mt-1">تحديث بيانات الخصم الحالي</p>
            </div>
            <a href="{{ route('admin.discounts.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                عودة للقائمة
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="admin-card">
        <form action="{{ route('admin.discounts.update', $discount) }}" method="POST" id="discountForm">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Basic Info -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">المعلومات الأساسية</h3>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">اسم الخصم</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $discount->name) }}"
                               class="form-input @error('name') border-red-500 @enderror" 
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">كود الخصم</label>
                        <input type="text" 
                               name="code" 
                               id="code" 
                               value="{{ old('code', $discount->code) }}"
                               class="form-input @error('code') border-red-500 @enderror" 
                               required>
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">نوع الخصم</label>
                        <select name="type" id="type" class="form-select @error('type') border-red-500 @enderror" required>
                            <option value="percentage" {{ old('type', $discount->type) == 'percentage' ? 'selected' : '' }}>نسبة مئوية</option>
                            <option value="fixed" {{ old('type', $discount->type) == 'fixed' ? 'selected' : '' }}>مبلغ ثابت</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="value" class="block text-sm font-medium text-gray-700 mb-2">قيمة الخصم</label>
                        <input type="number" 
                               name="value" 
                               id="value" 
                               step="0.01" 
                               min="0"
                               value="{{ old('value', $discount->value) }}"
                               class="form-input @error('value') border-red-500 @enderror" 
                               required>
                        @error('value')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Advanced Settings -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">الإعدادات المتقدمة</h3>
                    
                    <div>
                        <label for="min_amount" class="block text-sm font-medium text-gray-700 mb-2">الحد الأدنى للمبلغ</label>
                        <input type="number" 
                               name="min_amount" 
                               id="min_amount" 
                               step="0.01" 
                               min="0"
                               value="{{ old('min_amount', $discount->min_amount) }}"
                               class="form-input @error('min_amount') border-red-500 @enderror">
                        @error('min_amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-2">حد الاستخدام</label>
                        <input type="number" 
                               name="usage_limit" 
                               id="usage_limit" 
                               min="1"
                               value="{{ old('usage_limit', $discount->usage_limit) }}"
                               class="form-input @error('usage_limit') border-red-500 @enderror">
                        @error('usage_limit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-gray-700 mb-2">تاريخ البداية</label>
                        <input type="datetime-local" 
                               name="starts_at" 
                               id="starts_at" 
                               value="{{ old('starts_at', $discount->starts_at?->format('Y-m-d\TH:i')) }}"
                               class="form-input @error('starts_at') border-red-500 @enderror">
                        @error('starts_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">تاريخ الانتهاء</label>
                        <input type="datetime-local" 
                               name="expires_at" 
                               id="expires_at" 
                               value="{{ old('expires_at', $discount->expires_at?->format('Y-m-d\TH:i')) }}"
                               class="form-input @error('expires_at') border-red-500 @enderror">
                        @error('expires_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $discount->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="mr-2 text-sm font-medium text-gray-700">الخصم نشط</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="form-textarea @error('description') border-red-500 @enderror"
                          placeholder="وصف اختياري للخصم">{{ old('description', $discount->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-3 space-x-reverse mt-6 pt-6 border-t">
                <a href="{{ route('admin.discounts.index') }}" class="btn-secondary">إلغاء</a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Usage Statistics -->
@if($discount->used_count > 0)
<div class="container mx-auto px-4 mt-6">
    <div class="admin-card">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">إحصائيات الاستخدام</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $discount->used_count }}</div>
                <div class="text-sm text-gray-600">مرات الاستخدام</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">
                    {{ $discount->usage_limit ? $discount->usage_limit - $discount->used_count : '∞' }}
                </div>
                <div class="text-sm text-gray-600">الاستخدامات المتبقية</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">
                    {{ $discount->orders_count ?? 0 }}
                </div>
                <div class="text-sm text-gray-600">إجمالي الطلبات</div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const valueInput = document.getElementById('value');
    
    function updateValueInput() {
        const type = typeSelect.value;
        if (type === 'percentage') {
            valueInput.max = '100';
            valueInput.placeholder = 'مثال: 10 (يعني 10%)';
        } else {
            valueInput.removeAttribute('max');
            valueInput.placeholder = 'مثال: 50 (يعني 50 ريال)';
        }
    }
    
    typeSelect.addEventListener('change', updateValueInput);
    updateValueInput(); // Initialize
});
</script>
@endsection
