@extends('admin.layout')

@section('title', 'إضافة منتج جديد')
@section('page-title', 'إضافة منتج جديد')
@section('page-description', 'إضافة منتج جديد للمتجر')

@section('content')
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Product Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">معلومات أساسية</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">اسم المنتج *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">رقم المنتج (SKU) *</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('sku') border-red-500 @enderror">
                        @error('sku')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">وصف المنتج *</label>
                    <textarea name="description" rows="4" required
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Pricing -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">التسعير</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">السعر الأساسي (د.أ) *</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">سعر التخفيض (د.أ)</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('sale_price') border-red-500 @enderror">
                        @error('sale_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">اتركه فارغاً إذا لم يكن هناك تخفيض</p>
                    </div>
                </div>
            </div>
            
            <!-- Product Specifications -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">مواصفات المنتج</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الوزن (كجم)</label>
                        <input type="number" name="weight" value="{{ old('weight') }}" step="0.01" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الأبعاد</label>
                        <input type="text" name="dimensions" value="{{ old('dimensions') }}" placeholder="الطول × العرض × الارتفاع"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">المواد</label>
                        <input type="text" name="materials" value="{{ old('materials') }}" placeholder="البلاستيك، المعدن، القماش..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">بلد المنشأ</label>
                        <input type="text" name="country_of_origin" value="{{ old('country_of_origin') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">فترة الضمان</label>
                        <input type="text" name="warranty_period" value="{{ old('warranty_period') }}" placeholder="سنة واحدة، 6 أشهر..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">العمر المناسب</label>
                        <input type="text" name="suitable_age" value="{{ old('suitable_age') }}" placeholder="3-6 سنوات، للكبار..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">عدد القطع</label>
                        <input type="number" name="pieces_count" value="{{ old('pieces_count') }}" min="1"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">المعايير</label>
                        <input type="text" name="standards" value="{{ old('standards') }}" placeholder="CE، ISO..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نوع البطارية</label>
                        <input type="text" name="battery_type" value="{{ old('battery_type') }}" placeholder="AA، AAA، مدمجة..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">قابل للغسل</label>
                        <select name="washable" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">غير محدد</option>
                            <option value="1" {{ old('washable') == '1' ? 'selected' : '' }}>نعم</option>
                            <option value="0" {{ old('washable') == '0' ? 'selected' : '' }}>لا</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Product Images -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">
                    <i class="fas fa-images text-orange-500 mr-3"></i>
                    صور المنتج
                </h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        اختر الصور *
                        <span class="text-xs text-gray-500">(الحد الأقصى 5 صور، كل صورة أقل من 2 ميجابايت)</span>
                    </label>
                    
                    <!-- Drag and Drop Area -->
                    <div id="dropArea" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-orange-400 transition-colors cursor-pointer">
                        <input type="file" name="images[]" id="imageInput" multiple accept="image/*" class="hidden" max="5">
                        <div class="space-y-4">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-600 font-medium">اسحب الصور هنا أو انقر للاختيار</p>
                                <p class="text-sm text-gray-500 mt-1">PNG, JPG, WEBP حتى 2MB للصورة الواحدة</p>
                            </div>
                            <button type="button" class="bg-orange-100 text-orange-700 px-4 py-2 rounded-lg hover:bg-orange-200 transition-colors">
                                اختيار الصور
                            </button>
                        </div>
                    </div>
                    @error('images')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Preview area -->
                <div id="image-preview" class="mt-6 hidden">
                    <h4 class="text-md font-medium text-gray-700 mb-3">معاينة الصور:</h4>
                    <div id="preview-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <!-- Images will be shown here -->
                    </div>
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center text-sm text-blue-700">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span>الصورة الأولى ستكون الصورة الرئيسية للمنتج</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Category & Brand -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">التصنيف</h3>
                
                <div class="space-y-4">
                    <!-- Main Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الفئة الرئيسية *</label>
                        <select name="main_category" id="mainCategorySelect" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">اختر الفئة الرئيسية</option>
                            @foreach($categories->whereNull('parent_id') as $mainCategory)
                                <option value="{{ $mainCategory->id }}" {{ old('main_category') == $mainCategory->id ? 'selected' : '' }}>
                                    {{ $mainCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('main_category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sub Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            الفئة الفرعية *
                            <span id="subcategoryLoader" class="hidden ml-2">
                                <i class="fas fa-spinner fa-spin text-orange-500 text-xs"></i>
                            </span>
                        </label>
                        <select name="category_id" id="subCategorySelect" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('category_id') border-red-500 @enderror">
                            <option value="">اختر الفئة الفرعية</option>
                            @if(old('main_category'))
                                @foreach($categories->where('parent_id', old('main_category')) as $subCategory)
                                    <option value="{{ $subCategory->id }}" {{ old('category_id') == $subCategory->id ? 'selected' : '' }}>
                                        {{ $subCategory->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">العلامة التجارية</label>
                        <select name="brand_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">بدون علامة تجارية</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Shoe Sizes (conditional) -->
            <div id="shoeSizesSection" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hidden">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">
                    <i class="fas fa-shoe-prints text-orange-500 ml-2"></i>
                    مقاسات الأحذية *
                </h3>
                
                <div class="space-y-4">
                    <p class="text-sm text-gray-600 bg-orange-50 p-3 rounded-lg border border-orange-200">
                        <i class="fas fa-info-circle text-orange-500 ml-2"></i>
                        يجب إضافة مقاس واحد على الأقل للأحذية
                    </p>
                    
                    <div id="shoeSizesContainer">
                        <!-- Shoe sizes will be added here -->
                    </div>
                    
                    <button type="button" id="addShoeSizeBtn" 
                            class="w-full bg-orange-100 text-orange-700 py-2 px-4 rounded-lg font-medium hover:bg-orange-200 transition-colors border border-orange-300">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة مقاس
                    </button>
                </div>
            </div>
            
            <!-- Stock -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">المخزون</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">كمية المخزون *</label>
                    <input type="number" name="quantity" value="{{ old('quantity', 0) }}" min="0" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('quantity') border-red-500 @enderror">
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="space-y-4">
                    <button type="submit" 
                            class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        حفظ المنتج
                    </button>
                    
                    <a href="{{ route('admin.products.index') }}" 
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
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const mainCategorySelect = document.getElementById('mainCategorySelect');
        const subCategorySelect = document.getElementById('subCategorySelect');
        const loader = document.getElementById('subcategoryLoader');
        const shoeSizesSection = document.getElementById('shoeSizesSection');
        const shoeSizesContainer = document.getElementById('shoeSizesContainer');
        const addShoeSizeBtn = document.getElementById('addShoeSizeBtn');
        
        let sizeCounter = 0;

        // Handle main category change to load subcategories
        mainCategorySelect.addEventListener('change', function() {
            const mainCategoryId = this.value;
            
            // Clear subcategory options and show loading
            subCategorySelect.innerHTML = '<option value="">جاري التحميل...</option>';
            subCategorySelect.disabled = true;
            loader.classList.remove('hidden');
            
            // Hide shoe sizes section
            shoeSizesSection.classList.add('hidden');
            
            if (mainCategoryId) {
                // Load subcategories via AJAX
                fetch('/admin/api/categories/tree')
                    .then(response => response.json())
                    .then(data => {
                        // Hide loader and clear loading option
                        loader.classList.add('hidden');
                        subCategorySelect.innerHTML = '<option value="">اختر الفئة الفرعية</option>';
                        
                        if (data.success && data.data) {
                            // Find subcategories for selected main category
                            const subcategories = data.data.filter(cat => cat.parent_id == mainCategoryId);
                            
                            if (subcategories.length > 0) {
                                subcategories.forEach(function(subCategory) {
                                    const option = document.createElement('option');
                                    option.value = subCategory.id;
                                    option.textContent = subCategory.name;
                                    subCategorySelect.appendChild(option);
                                });
                                
                                // Enable subcategory select
                                subCategorySelect.disabled = false;
                                subCategorySelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
                            } else {
                                subCategorySelect.innerHTML = '<option value="">لا توجد فئات فرعية</option>';
                                subCategorySelect.disabled = true;
                                subCategorySelect.classList.add('bg-gray-100', 'cursor-not-allowed');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error loading subcategories:', error);
                        loader.classList.add('hidden');
                        subCategorySelect.innerHTML = '<option value="">خطأ في التحميل</option>';
                    });
            } else {
                // Reset to default state when no main category selected
                loader.classList.add('hidden');
                subCategorySelect.innerHTML = '<option value="">اختر الفئة الفرعية</option>';
                subCategorySelect.disabled = true;
                subCategorySelect.classList.add('bg-gray-100', 'cursor-not-allowed');
            }
        });

        // Handle subcategory selection to check for shoes category
        subCategorySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const categoryName = selectedOption.textContent;
            
            // Check if selected category is shoes (أحذية)
            if (categoryName && categoryName.includes('أحذية')) {
                shoeSizesSection.classList.remove('hidden');
                // Add at least one size field if none exist
                if (shoeSizesContainer.children.length === 0) {
                    addShoeSizeField();
                }
            } else {
                shoeSizesSection.classList.add('hidden');
                // Clear shoe sizes when not needed
                shoeSizesContainer.innerHTML = '';
                sizeCounter = 0;
            }
        });

        // Initialize subcategory state on page load
        if (!mainCategorySelect.value) {
            subCategorySelect.disabled = true;
            subCategorySelect.classList.add('bg-gray-100', 'cursor-not-allowed');
        }

        // Check if subcategory is already selected (for form validation errors)
        if (subCategorySelect.value) {
            const selectedOption = subCategorySelect.options[subCategorySelect.selectedIndex];
            if (selectedOption && selectedOption.textContent.includes('أحذية')) {
                shoeSizesSection.classList.remove('hidden');
            }
        }

        // Add shoe size field
        function addShoeSizeField() {
            sizeCounter++;
            const sizeDiv = document.createElement('div');
            sizeDiv.className = 'flex items-center gap-3 p-3 bg-gray-50 rounded-lg';
            sizeDiv.innerHTML = `
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">المقاس</label>
                    <select name="shoe_sizes[${sizeCounter}][size]" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">اختر المقاس</option>
                        <option value="35">35</option>
                        <option value="36">36</option>
                        <option value="37">37</option>
                        <option value="38">38</option>
                        <option value="39">39</option>
                        <option value="40">40</option>
                        <option value="41">41</option>
                        <option value="42">42</option>
                        <option value="43">43</option>
                        <option value="44">44</option>
                        <option value="45">45</option>
                        <option value="46">46</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">الكمية</label>
                    <input type="number" name="shoe_sizes[${sizeCounter}][quantity]" min="0" value="0" required 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
                <div class="pt-6">
                    <button type="button" onclick="removeShoeSizeField(this)" 
                            class="text-red-500 hover:text-red-700 transition-colors p-2">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            shoeSizesContainer.appendChild(sizeDiv);
        }

        // Remove shoe size field
        window.removeShoeSizeField = function(button) {
            const sizeDiv = button.closest('.flex');
            sizeDiv.remove();
            
            // Ensure at least one size field remains for shoes
            const selectedOption = subCategorySelect.options[subCategorySelect.selectedIndex];
            if (selectedOption && selectedOption.textContent.includes('أحذية') && shoeSizesContainer.children.length === 0) {
                addShoeSizeField();
            }
        };

        // Add shoe size button
        addShoeSizeBtn.addEventListener('click', addShoeSizeField);

        // Image upload and preview functionality
        const dropArea = document.getElementById('dropArea');
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('image-preview');
        const previewGrid = document.getElementById('preview-container');
        
        let selectedFiles = [];
        const maxFiles = 5;
        const maxFileSize = 2 * 1024 * 1024; // 2MB

        // Drag and drop handlers
        dropArea.addEventListener('click', () => imageInput.click());
        
        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('border-orange-400', 'bg-orange-50');
        });
        
        dropArea.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropArea.classList.remove('border-orange-400', 'bg-orange-50');
        });
        
        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('border-orange-400', 'bg-orange-50');
            
            const files = Array.from(e.dataTransfer.files);
            handleFiles(files);
        });

        // File input change handler
        imageInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            handleFiles(files);
        });

        function handleFiles(files) {
            const imageFiles = files.filter(file => file.type.startsWith('image/'));
            
            // Check file count limit
            if (selectedFiles.length + imageFiles.length > maxFiles) {
                alert(`يمكنك اختيار ${maxFiles} صور كحد أقصى`);
                return;
            }
            
            // Check file size and add valid files
            const validFiles = [];
            imageFiles.forEach(file => {
                if (file.size > maxFileSize) {
                    alert(`الصورة ${file.name} كبيرة جداً. الحد الأقصى 2 ميجابايت`);
                    return;
                }
                validFiles.push(file);
            });
            
            selectedFiles = selectedFiles.concat(validFiles);
            updateFileInput();
            updatePreview();
        }

        function updateFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => {
                dt.items.add(file);
            });
            imageInput.files = dt.files;
        }

        function updatePreview() {
            if (selectedFiles.length === 0) {
                previewContainer.classList.add('hidden');
                return;
            }
            
            previewContainer.classList.remove('hidden');
            previewGrid.innerHTML = '';
            
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <div class="relative overflow-hidden rounded-lg border-2 ${index === 0 ? 'border-orange-500' : 'border-gray-300'} hover:border-orange-400 transition-colors">
                            <img src="${e.target.result}" alt="Preview ${index + 1}" 
                                 class="w-full h-32 object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200"></div>
                            
                            <!-- Remove button -->
                            <button type="button" onclick="removeImage(${index})"
                                    class="absolute top-2 left-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100">
                                <i class="fas fa-times"></i>
                            </button>
                            
                            <!-- Primary badge -->
                            <div class="absolute bottom-2 right-2 ${index === 0 ? 'bg-orange-500' : 'bg-gray-500'} text-white text-xs px-2 py-1 rounded">
                                ${index === 0 ? 'رئيسية' : index + 1}
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-1 truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} كب</p>
                    `;
                    previewGrid.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        // Remove image function
        window.removeImage = function(index) {
            selectedFiles.splice(index, 1);
            updateFileInput();
            updatePreview();
        };

        // Reorder images (make primary)
        window.makePrimary = function(index) {
            if (index === 0) return;
            
            const file = selectedFiles[index];
            selectedFiles.splice(index, 1);
            selectedFiles.unshift(file);
            updateFileInput();
            updatePreview();
        };
        
        // Auto-generate SKU based on product name
        document.querySelector('input[name="name"]').addEventListener('input', function(e) {
            const skuInput = document.querySelector('input[name="sku"]');
            if (!skuInput.value) {
                const name = e.target.value;
                const sku = name.replace(/[^a-zA-Z0-9\u0600-\u06FF]/g, '').substring(0, 10).toUpperCase() + '-' + Date.now().toString().slice(-4);
                skuInput.value = sku;
            }
        });

        // Form validation for shoes category
        document.querySelector('form').addEventListener('submit', function(e) {
            const selectedOption = subCategorySelect.options[subCategorySelect.selectedIndex];
            if (selectedOption && selectedOption.textContent.includes('أحذية')) {
                const shoeSizes = document.querySelectorAll('select[name^="shoe_sizes"]');
                if (shoeSizes.length === 0) {
                    e.preventDefault();
                    alert('يجب إضافة مقاس واحد على الأقل للأحذية');
                    return false;
                }
            }
        });
    });
</script>
@endpush




