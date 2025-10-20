@extends('admin.layout')

@section('title', 'إضافة مدينة جديدة')
@section('page-title', 'إضافة مدينة جديدة')
@section('page-description', 'إضافة مدينة أردنية جديدة مع تكاليف التوصيل')

@push('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #ffffff;
    }
    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .form-input.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }
    .btn {
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
    }
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .info-box {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        border: 1px solid #3b82f6;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .preview-card {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">إضافة مدينة أردنية جديدة</h2>
                <p class="text-gray-600 mt-2">أدخل تفاصيل المدينة وتكاليف التوصيل</p>
            </div>
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-map-marker-alt text-blue-600 text-2xl"></i>
            </div>
        </div>

        <div class="info-box">
            <div class="flex items-center text-blue-800">
                <i class="fas fa-info-circle ml-2"></i>
                <strong>معلومات مهمة:</strong>
            </div>
            <ul class="text-blue-700 text-sm mt-2 mr-6 space-y-1">
                <li>• تأكد من كتابة اسم المدينة بالشكل الصحيح</li>
                <li>• تكلفة التوصيل يجب أن تكون بالدينار الأردني</li>
                <li>• أيام التوصيل تشمل أيام العمل فقط</li>
            </ul>
        </div>

        <form action="{{ route('admin.cities.store') }}" method="POST" id="cityForm">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Form Fields -->
                <div class="space-y-6">
                    <!-- Arabic Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-map-marker-alt ml-2 text-blue-600"></i>
                            اسم المدينة (عربي) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="form-input @error('name') error @enderror"
                               placeholder="مثال: عمان"
                               required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- English Name -->
                    <div class="form-group">
                        <label for="name_en" class="form-label">
                            <i class="fas fa-globe ml-2 text-green-600"></i>
                            اسم المدينة (إنجليزي) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name_en" 
                               name="name_en" 
                               value="{{ old('name_en') }}"
                               class="form-input @error('name_en') error @enderror"
                               placeholder="Example: Amman"
                               required>
                        @error('name_en')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Delivery Cost -->
                    <div class="form-group">
                        <label for="delivery_cost" class="form-label">
                            <i class="fas fa-dollar-sign ml-2 text-green-600"></i>
                            تكلفة التوصيل (د.أ) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="delivery_cost" 
                               name="delivery_cost" 
                               value="{{ old('delivery_cost') }}"
                               step="0.01"
                               min="0"
                               max="999.99"
                               class="form-input @error('delivery_cost') error @enderror"
                               placeholder="5.00"
                               required>
                        @error('delivery_cost')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Delivery Days -->
                    <div class="form-group">
                        <label for="delivery_days" class="form-label">
                            <i class="fas fa-calendar-alt ml-2 text-orange-600"></i>
                            أيام التوصيل <span class="text-red-500">*</span>
                        </label>
                        <select id="delivery_days" 
                                name="delivery_days" 
                                class="form-input @error('delivery_days') error @enderror"
                                required>
                            <option value="">اختر عدد الأيام</option>
                            @for($i = 1; $i <= 7; $i++)
                                <option value="{{ $i }}" {{ old('delivery_days') == $i ? 'selected' : '' }}>
                                    {{ $i }} {{ $i == 1 ? 'يوم' : 'أيام' }}
                                </option>
                            @endfor
                        </select>
                        @error('delivery_days')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label class="flex items-center cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', 1) ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 border-2 border-gray-300 rounded focus:ring-blue-500">
                            <span class="mr-3 text-gray-700 font-medium">
                                <i class="fas fa-toggle-on ml-2 text-green-600"></i>
                                مدينة نشطة (متاحة للتوصيل)
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Preview -->
                <div class="space-y-6">
                    <div class="preview-card">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-map-marker-alt text-blue-600 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">معاينة المدينة</h3>
                        
                        <div id="preview-content" class="text-gray-600">
                            <div class="mb-3">
                                <strong>اسم المدينة:</strong>
                                <div id="preview-name" class="text-blue-600 font-medium">---</div>
                            </div>
                            <div class="mb-3">
                                <strong>الاسم الإنجليزي:</strong>
                                <div id="preview-name-en" class="text-gray-500">---</div>
                            </div>
                            <div class="mb-3">
                                <strong>تكلفة التوصيل:</strong>
                                <div id="preview-cost" class="text-green-600 font-bold">--- د.أ</div>
                            </div>
                            <div class="mb-3">
                                <strong>مدة التوصيل:</strong>
                                <div id="preview-days" class="text-orange-600">--- أيام</div>
                            </div>
                            <div>
                                <strong>الحالة:</strong>
                                <span id="preview-status" class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    نشط
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Common Cities Reference -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-bold text-gray-900 mb-3">
                            <i class="fas fa-list ml-2"></i>
                            مدن أردنية شائعة:
                        </h4>
                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                            <div>• عمان (Amman)</div>
                            <div>• إربد (Irbid)</div>
                            <div>• الزرقاء (Zarqa)</div>
                            <div>• السلط (Salt)</div>
                            <div>• عجلون (Ajloun)</div>
                            <div>• جرش (Jerash)</div>
                            <div>• مادبا (Madaba)</div>
                            <div>• الكرك (Karak)</div>
                            <div>• معان (Ma'an)</div>
                            <div>• العقبة (Aqaba)</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i>
                    إلغاء
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    حفظ المدينة
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Real-time preview updates
    document.addEventListener('DOMContentLoaded', function() {
        const fields = {
            'name': 'preview-name',
            'name_en': 'preview-name-en', 
            'delivery_cost': 'preview-cost',
            'delivery_days': 'preview-days'
        };

        // Update preview for text inputs
        Object.keys(fields).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            const preview = document.getElementById(fields[fieldName]);
            
            if (field && preview) {
                field.addEventListener('input', function() {
                    let value = this.value || '---';
                    
                    if (fieldName === 'delivery_cost' && value !== '---') {
                        value = value + ' د.أ';
                    } else if (fieldName === 'delivery_days' && value !== '---') {
                        value = value + (value == '1' ? ' يوم' : ' أيام');
                    }
                    
                    preview.textContent = value;
                });
            }
        });

        // Update status preview
        const statusCheckbox = document.querySelector('input[name="is_active"]');
        const statusPreview = document.getElementById('preview-status');
        
        if (statusCheckbox && statusPreview) {
            statusCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    statusPreview.textContent = 'نشط';
                    statusPreview.className = 'inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800';
                } else {
                    statusPreview.textContent = 'غير نشط';
                    statusPreview.className = 'inline-block px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800';
                }
            });
        }
    });

    // Form validation
    document.getElementById('cityForm').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const nameEn = document.getElementById('name_en').value.trim();
        const cost = document.getElementById('delivery_cost').value;
        const days = document.getElementById('delivery_days').value;

        if (!name || !nameEn || !cost || !days) {
            e.preventDefault();
            alert('يرجى ملء جميع الحقول المطلوبة');
            return false;
        }

        if (cost < 0 || cost > 999.99) {
            e.preventDefault();
            alert('تكلفة التوصيل يجب أن تكون بين 0 و 999.99');
            return false;
        }
    });
</script>
@endpush

@endsection