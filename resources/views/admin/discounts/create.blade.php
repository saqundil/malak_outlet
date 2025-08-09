@extends('admin.layout')

@section('title', 'إضافة خصم جديد')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus mr-2"></i>
            إضافة خصم جديد
        </h1>
        <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-right fa-sm text-white-50"></i>
            العودة للقائمة
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات الخصم</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.discounts.store') }}" id="discountForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">اسم الخصم <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code" class="form-label">كود الخصم</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                               id="code" name="code" value="{{ old('code') }}" placeholder="اتركه فارغًا للتوليد التلقائي">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="generateCode">
                                                <i class="fas fa-random"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" class="form-label">نوع الخصم <span class="text-danger">*</span></label>
                                    <select class="form-control @error('type') is-invalid @enderror" 
                                            id="type" name="type" required>
                                        <option value="">اختر نوع الخصم</option>
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>
                                            نسبة مئوية (%)
                                        </option>
                                        <option value="fixed_amount" {{ old('type') == 'fixed_amount' ? 'selected' : '' }}>
                                            مبلغ ثابت (د.أ)
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="value" class="form-label">قيمة الخصم <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" 
                                               class="form-control @error('value') is-invalid @enderror" 
                                               id="value" name="value" value="{{ old('value') }}" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="valueUnit">%</span>
                                        </div>
                                    </div>
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="min_purchase_amount" class="form-label">الحد الأدنى للشراء</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" 
                                               class="form-control @error('min_purchase_amount') is-invalid @enderror" 
                                               id="min_purchase_amount" name="min_purchase_amount" 
                                               value="{{ old('min_purchase_amount') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">د.أ</span>
                                        </div>
                                    </div>
                                    @error('min_purchase_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_discount_amount" class="form-label">الحد الأقصى للخصم</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" min="0" 
                                               class="form-control @error('max_discount_amount') is-invalid @enderror" 
                                               id="max_discount_amount" name="max_discount_amount" 
                                               value="{{ old('max_discount_amount') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">د.أ</span>
                                        </div>
                                    </div>
                                    @error('max_discount_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="usage_limit" class="form-label">حد الاستخدام</label>
                                    <input type="number" min="1" 
                                           class="form-control @error('usage_limit') is-invalid @enderror" 
                                           id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}"
                                           placeholder="غير محدود">
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="starts_at" class="form-label">تاريخ البداية</label>
                                    <input type="datetime-local" 
                                           class="form-control @error('starts_at') is-invalid @enderror" 
                                           id="starts_at" name="starts_at" value="{{ old('starts_at') }}">
                                    @error('starts_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ends_at" class="form-label">تاريخ النهاية</label>
                                    <input type="datetime-local" 
                                           class="form-control @error('ends_at') is-invalid @enderror" 
                                           id="ends_at" name="ends_at" value="{{ old('ends_at') }}">
                                    @error('ends_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label class="form-label">تطبيق الخصم على <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="applyToAll" 
                                               name="apply_to" value="all_products" 
                                               {{ old('apply_to') == 'all_products' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="applyToAll">
                                            جميع المنتجات
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="applyToProducts" 
                                               name="apply_to" value="specific_products"
                                               {{ old('apply_to') == 'specific_products' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="applyToProducts">
                                            منتجات محددة
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="applyToCategories" 
                                               name="apply_to" value="specific_categories"
                                               {{ old('apply_to') == 'specific_categories' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="applyToCategories">
                                            فئات محددة
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('apply_to')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Products Selection -->
                        <div id="productsSelection" class="form-group" style="display: none;">
                            <label class="form-label">اختر المنتجات</label>
                            <select class="form-control select2-multiple" name="product_ids[]" multiple>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            {{ in_array($product->id, old('product_ids', [])) ? 'selected' : '' }}>
                                        {{ $product->name }} - {{ number_format($product->price, 2) }} د.أ
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Categories Selection -->
                        <div id="categoriesSelection" class="form-group" style="display: none;">
                            <label class="form-label">اختر الفئات</label>
                            <select class="form-control select2-multiple" name="category_ids[]" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ in_array($category->id, old('category_ids', [])) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>
                                حفظ الخصم
                            </button>
                            <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i>
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Settings -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">الإعدادات</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" 
                                   name="is_active" value="1" 
                                   {{ old('is_active', '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">
                                تفعيل الخصم
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            يمكن للعملاء استخدام الخصم فقط إذا كان مفعلاً
                        </small>
                    </div>
                </div>
            </div>

            <!-- Preview -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معاينة الخصم</h6>
                </div>
                <div class="card-body" id="discountPreview">
                    <div class="text-center text-muted">
                        <i class="fas fa-eye fa-2x mb-2"></i>
                        <p>املأ النموذج لرؤية معاينة الخصم</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2-multiple').select2({
        placeholder: 'اختر...',
        allowClear: true
    });

    // Discount type change
    $('#type').change(function() {
        const type = $(this).val();
        const valueUnit = type === 'percentage' ? '%' : 'د.أ';
        $('#valueUnit').text(valueUnit);
        
        if (type === 'percentage') {
            $('#value').attr('max', '100');
        } else {
            $('#value').removeAttr('max');
        }
        
        updatePreview();
    });

    // Apply to radio buttons
    $('input[name="apply_to"]').change(function() {
        const value = $(this).val();
        
        $('#productsSelection, #categoriesSelection').hide();
        
        if (value === 'specific_products') {
            $('#productsSelection').show();
        } else if (value === 'specific_categories') {
            $('#categoriesSelection').show();
        }
        
        updatePreview();
    });

    // Generate random code
    $('#generateCode').click(function() {
        const code = 'DISC' + Math.random().toString(36).substr(2, 8).toUpperCase();
        $('#code').val(code);
    });

    // Update preview on input changes
    $('#name, #value, #type, #description').on('input', updatePreview);

    function updatePreview() {
        const name = $('#name').val();
        const value = $('#value').val();
        const type = $('#type').val();
        const description = $('#description').val();
        const applyTo = $('input[name="apply_to"]:checked').val();

        if (!name || !value || !type || !applyTo) {
            $('#discountPreview').html(`
                <div class="text-center text-muted">
                    <i class="fas fa-eye fa-2x mb-2"></i>
                    <p>املأ النموذج لرؤية معاينة الخصم</p>
                </div>
            `);
            return;
        }

        const valueDisplay = type === 'percentage' ? value + '%' : value + ' د.أ';
        let applyToText = '';
        
        if (applyTo === 'all_products') {
            applyToText = 'جميع المنتجات';
        } else if (applyTo === 'specific_products') {
            const selectedCount = $('select[name="product_ids[]"]').val()?.length || 0;
            applyToText = selectedCount + ' منتج محدد';
        } else {
            const selectedCount = $('select[name="category_ids[]"]').val()?.length || 0;
            applyToText = selectedCount + ' فئة محددة';
        }

        $('#discountPreview').html(`
            <div class="text-center">
                <div class="badge badge-primary badge-lg mb-2">${valueDisplay}</div>
                <h6 class="font-weight-bold">${name}</h6>
                ${description ? `<p class="text-muted small">${description}</p>` : ''}
                <small class="text-success">يطبق على: ${applyToText}</small>
            </div>
        `);
    }

    // Form validation
    $('#discountForm').on('submit', function(e) {
        const type = $('#type').val();
        const value = parseFloat($('#value').val());

        if (type === 'percentage' && value > 100) {
            e.preventDefault();
            toastr.error('النسبة المئوية لا يمكن أن تزيد عن 100%');
            return false;
        }

        const startsAt = $('#starts_at').val();
        const endsAt = $('#ends_at').val();

        if (startsAt && endsAt && new Date(startsAt) >= new Date(endsAt)) {
            e.preventDefault();
            toastr.error('تاريخ النهاية يجب أن يكون بعد تاريخ البداية');
            return false;
        }
    });
});
</script>
@endsection
