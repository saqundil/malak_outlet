@extends('admin.layout')

@section('title', 'إضافة خصم جديد')

@section('content')
<div class="p-6" dir="rtl">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-plus text-red-500 ml-3"></i>
                إضافة خصم جديد
            </h1>
            <p class="text-gray-600 mt-2">إنشاء خصم جديد في النظام</p>
        </div>
        <a href="{{ route('admin.discounts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة للقائمة
        </a>
    </div>

    <!-- Main Form -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-red-50 to-orange-50 p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-edit text-red-500 ml-2"></i>
                معلومات الخصم
            </h3>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('admin.discounts.store') }}" id="discountForm">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">اسم الخصم <span class="text-red-600">*</span></label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('name') border-red-500 @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required placeholder="أدخل اسم الخصم">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-2">نوع الخصم <span class="text-red-600">*</span></label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('discount_type') border-red-500 @enderror" 
                                id="discount_type" name="discount_type" required>
                            <option value="">اختر نوع الخصم</option>
                            <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>مبلغ ثابت (د.أ)</option>
                        </select>
                        @error('discount_type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
                    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('description') border-red-500 @enderror" 
                              id="description" name="description" rows="3" placeholder="وصف اختياري للخصم">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-2">قيمة الخصم <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <input type="number" step="0.01" min="0" 
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('discount_value') border-red-500 @enderror" 
                                   id="discount_value" name="discount_value" value="{{ old('discount_value') }}" required placeholder="0.00">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm" id="valueUnit">%</span>
                            </div>
                        </div>
                        @error('discount_value')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                        <div class="flex items-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                <span class="mr-3 text-sm font-medium text-gray-700">تفعيل الخصم</span>
                            </label>
                        </div>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-gray-700 mb-2">تاريخ البداية</label>
                        <input type="datetime-local" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('starts_at') border-red-500 @enderror" 
                               id="starts_at" name="starts_at" value="{{ old('starts_at') }}">
                        @error('starts_at')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-gray-700 mb-2">تاريخ النهاية</label>
                        <input type="datetime-local" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all @error('ends_at') border-red-500 @enderror" 
                               id="ends_at" name="ends_at" value="{{ old('ends_at') }}">
                        @error('ends_at')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                
                <div class="flex justify-end gap-4 mt-8 pt-6 border-t">
                    <a href="{{ route('admin.discounts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center">
                        <i class="fas fa-times ml-2"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center">
                        <i class="fas fa-save ml-2"></i>
                        حفظ الخصم
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Discount type change
    document.getElementById('discount_type').addEventListener('change', function() {
        const type = this.value;
        const valueUnit = document.getElementById('valueUnit');
        const valueInput = document.getElementById('discount_value');
        
        if (type === 'percentage') {
            valueUnit.textContent = '%';
            valueInput.setAttribute('max', '100');
        } else {
            valueUnit.textContent = 'د.أ';
            valueInput.removeAttribute('max');
        }
    });

    // Form validation
    document.getElementById('discountForm').addEventListener('submit', function(e) {
        const type = document.getElementById('discount_type').value;
        const value = parseFloat(document.getElementById('discount_value').value);

        if (type === 'percentage' && value > 100) {
            e.preventDefault();
            alert('النسبة المئوية لا يمكن أن تزيد عن 100%');
            return false;
        }

        const startsAt = document.getElementById('starts_at').value;
        const endsAt = document.getElementById('ends_at').value;

        if (startsAt && endsAt && new Date(startsAt) >= new Date(endsAt)) {
            e.preventDefault();
            alert('تاريخ النهاية يجب أن يكون بعد تاريخ البداية');
            return false;
        }
    });
});
</script>
@endsection
