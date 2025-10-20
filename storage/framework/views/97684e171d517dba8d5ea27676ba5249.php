

<?php $__env->startSection('title', 'تعديل المنتج: ' . $product->name); ?>
<?php $__env->startSection('page-title', 'تعديل المنتج'); ?>
<?php $__env->startSection('page-description', 'تعديل معلومات المنتج: ' . Str::limit($product->name, 50)); ?>

<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('admin.products.update', $product)); ?>" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Product Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">معلومات أساسية</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">اسم المنتج *</label>
                        <input type="text" name="name" value="<?php echo e(old('name', $product->name)); ?>" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">رقم المنتج (SKU) *</label>
                        <input type="text" name="sku" value="<?php echo e(old('sku', $product->sku)); ?>" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">وصف المنتج *</label>
                    <textarea name="description" rows="4" required
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $product->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <!-- Pricing -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">التسعير</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">السعر الأساسي (د.أ) *</label>
                        <input type="number" name="price" value="<?php echo e(old('price', $product->price)); ?>" step="0.01" min="0" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">سعر التخفيض (د.أ)</label>
                        <input type="number" name="sale_price" value="<?php echo e(old('sale_price', $product->sale_price)); ?>" step="0.01" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                        <input type="number" name="weight" value="<?php echo e(old('weight', $product->weight)); ?>" step="0.01" min="0"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الأبعاد</label>
                        <input type="text" name="dimensions" value="<?php echo e(old('dimensions', $product->dimensions)); ?>" placeholder="الطول × العرض × الارتفاع"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">المواد</label>
                        <input type="text" name="materials" value="<?php echo e(old('materials', $product->materials)); ?>" placeholder="البلاستيك، المعدن، القماش..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">بلد المنشأ</label>
                        <input type="text" name="country_of_origin" value="<?php echo e(old('country_of_origin', $product->country_of_origin)); ?>"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">فترة الضمان</label>
                        <input type="text" name="warranty_period" value="<?php echo e(old('warranty_period', $product->warranty_period)); ?>" placeholder="سنة واحدة، 6 أشهر..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">العمر المناسب</label>
                        <input type="text" name="suitable_age" value="<?php echo e(old('suitable_age', $product->suitable_age)); ?>" placeholder="3-6 سنوات، للكبار..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">عدد القطع</label>
                        <input type="number" name="pieces_count" value="<?php echo e(old('pieces_count', $product->pieces_count)); ?>" min="1"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">المعايير</label>
                        <input type="text" name="standards" value="<?php echo e(old('standards', $product->standards)); ?>" placeholder="CE، ISO..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">نوع البطارية</label>
                        <input type="text" name="battery_type" value="<?php echo e(old('battery_type', $product->battery_type)); ?>" placeholder="AA، AAA، مدمجة..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">قابل للغسل</label>
                        <select name="washable" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">غير محدد</option>
                            <option value="1" <?php echo e(old('washable', $product->washable) == '1' ? 'selected' : ''); ?>>نعم</option>
                            <option value="0" <?php echo e(old('washable', $product->washable) == '0' ? 'selected' : ''); ?>>لا</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Current Images -->
            <?php if($product->images->count() > 0): ?>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">
                    <i class="fas fa-images text-orange-500 mr-3"></i>
                    الصور الحالية (<?php echo e($product->images->count()); ?>)
                </h3>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="relative group">
                            <img src="<?php echo e($image->image_url); ?>" alt="<?php echo e($product->name); ?>" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-300 cursor-pointer hover:opacity-75 transition-opacity shadow-sm"
                                 onclick="openImageModal('<?php echo e($image->image_url); ?>')"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            
                            <?php if($image->is_primary): ?>
                                <div class="absolute top-2 right-2 bg-orange-500 text-white text-xs px-2 py-1 rounded shadow-md">
                                    <i class="fas fa-star mr-1"></i>
                                    رئيسية
                                </div>
                            <?php endif; ?>
                            
                            <!-- Delete button -->
                            <button type="button" onclick="deleteImage(<?php echo e($image->id); ?>)"
                                    class="absolute top-2 left-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-7 h-7 flex items-center justify-center text-sm opacity-0 group-hover:opacity-100 transition-all duration-200 shadow-md"
                                    title="حذف الصورة">
                                <i class="fas fa-trash"></i>
                            </button>
                            
                            <!-- Make primary button (if not already primary) -->
                            <?php if(!$image->is_primary): ?>
                                <button type="button" onclick="makePrimaryImage(<?php echo e($image->id); ?>)"
                                        class="absolute bottom-2 left-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full w-7 h-7 flex items-center justify-center text-sm opacity-0 group-hover:opacity-100 transition-all duration-200 shadow-md"
                                        title="جعلها الصورة الرئيسية">
                                    <i class="fas fa-star"></i>
                                </button>
                            <?php endif; ?>
                            
                            <!-- Image index -->
                            <div class="absolute bottom-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                <?php echo e($loop->iteration); ?>

                            </div>
                            
                            <!-- Fallback placeholder -->
                            <div class="hidden absolute inset-0 bg-gray-200 rounded-lg items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-image text-gray-400 text-3xl mb-2"></i>
                                    <p class="text-gray-500 text-xs">لا يمكن تحميل الصورة</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center text-sm text-yellow-700">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span>انقر على الصورة للمعاينة. انقر على زر النجمة لجعلها الصورة الرئيسية.</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Add New Images -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">
                    <i class="fas fa-plus text-green-500 mr-3"></i>
                    إضافة صور جديدة
                </h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        اختر صور إضافية
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
                    <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <!-- Preview area -->
                <div id="image-preview" class="mt-6 hidden">
                    <h4 class="text-md font-medium text-gray-700 mb-3">معاينة الصور الجديدة:</h4>
                    <div id="preview-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <!-- Images will be shown here -->
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
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الفئة الرئيسية *</label>
                        <select id="main_category" name="main_category_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">اختر الفئة الرئيسية</option>
                            <?php $__currentLoopData = $categories->whereNull('parent_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $product->category->parent_id ?? $product->category_id) == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div id="subcategory_section" style="display: <?php echo e($product->category->parent_id ? 'block' : 'none'); ?>">
                        <label class="block text-sm font-medium text-gray-700 mb-2">الفئة الفرعية *</label>
                        <select id="subcategory" name="category_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">اختر الفئة الفرعية</option>
                            <?php if($product->category->parent_id): ?>
                                <?php $__currentLoopData = $categories->where('parent_id', $product->category->parent_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subcategory->id); ?>" <?php echo e(old('category_id', $product->category_id) == $subcategory->id ? 'selected' : ''); ?>>
                                        <?php echo e($subcategory->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">العلامة التجارية</label>
                        <select name="brand_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">بدون علامة تجارية</option>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($brand->id); ?>" <?php echo e(old('brand_id', $product->brand_id) == $brand->id ? 'selected' : ''); ?>>
                                    <?php echo e($brand->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Shoe Sizes Section -->
            <div id="shoe_sizes_section" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200" style="display: none;">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">مقاسات الأحذية *</h3>
                
                <div id="shoe_sizes_container">
                    <?php if($product->sizes && $product->sizes->count() > 0): ?>
                        <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="shoe-size-row grid grid-cols-3 gap-3 mb-3" data-index="<?php echo e($index); ?>">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">المقاس</label>
                                <select name="shoe_sizes[<?php echo e($index); ?>][size]" class="shoe-size-select w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                                    <option value="">اختر المقاس</option>
                                    <option value="35" <?php echo e($size->size == '35' ? 'selected' : ''); ?>>35</option>
                                    <option value="36" <?php echo e($size->size == '36' ? 'selected' : ''); ?>>36</option>
                                    <option value="37" <?php echo e($size->size == '37' ? 'selected' : ''); ?>>37</option>
                                    <option value="38" <?php echo e($size->size == '38' ? 'selected' : ''); ?>>38</option>
                                    <option value="39" <?php echo e($size->size == '39' ? 'selected' : ''); ?>>39</option>
                                    <option value="40" <?php echo e($size->size == '40' ? 'selected' : ''); ?>>40</option>
                                    <option value="41" <?php echo e($size->size == '41' ? 'selected' : ''); ?>>41</option>
                                    <option value="42" <?php echo e($size->size == '42' ? 'selected' : ''); ?>>42</option>
                                    <option value="43" <?php echo e($size->size == '43' ? 'selected' : ''); ?>>43</option>
                                    <option value="44" <?php echo e($size->size == '44' ? 'selected' : ''); ?>>44</option>
                                    <option value="45" <?php echo e($size->size == '45' ? 'selected' : ''); ?>>45</option>
                                    <option value="46" <?php echo e($size->size == '46' ? 'selected' : ''); ?>>46</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">الكمية</label>
                                <input type="number" name="shoe_sizes[<?php echo e($index); ?>][quantity]" value="<?php echo e($size->stock_quantity); ?>" min="0" class="shoe-quantity w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                            </div>
                            <div class="flex items-end">
                                <button type="button" onclick="removeShoeSizeRow(this)" class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <div class="shoe-size-row grid grid-cols-3 gap-3 mb-3" data-index="0">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">المقاس</label>
                            <select name="shoe_sizes[0][size]" class="shoe-size-select w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
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
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">الكمية</label>
                            <input type="number" name="shoe_sizes[0][quantity]" min="0" class="shoe-quantity w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                        </div>
                        <div class="flex items-end">
                            <button type="button" onclick="removeShoeSizeRow(this)" class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="mt-4 space-y-3">
                    <button type="button" id="add_shoe_size" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة مقاس
                    </button>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-sm text-blue-700">
                            <i class="fas fa-info-circle ml-2"></i>
                            المجموع الكلي: <span id="total_shoe_quantity">0</span> قطعة
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Stock -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">المخزون</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">كمية المخزون *</label>
                    <input type="number" name="quantity" value="<?php echo e(old('quantity', $product->quantity)); ?>" min="0" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="space-y-4">
                    <button type="submit" 
                            class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        حفظ التغييرات
                    </button>
                    
                    <a href="<?php echo e(route('admin.products.show', $product)); ?>" 
                       class="w-full bg-blue-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-600 transition-colors block text-center">
                        <i class="fas fa-eye ml-2"></i>
                        عرض المنتج
                    </a>
                    
                    <a href="<?php echo e(route('admin.products.index')); ?>" 
                       class="w-full bg-gray-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors block text-center">
                        <i class="fas fa-times ml-2"></i>
                        إلغاء
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let shoeSizeIndex = <?php echo e($product->sizes ? $product->sizes->count() : 1); ?>;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Check if current product is shoes category and show/hide shoe sizes section
        checkShoesCategory();
        
        // Calculate initial total quantity for shoe sizes
        calculateTotalShoeQuantity();
        
        // Main category change handler
        document.getElementById('main_category').addEventListener('change', function() {
            const mainCategoryId = this.value;
            const subcategorySection = document.getElementById('subcategory_section');
            const subcategorySelect = document.getElementById('subcategory');
            
            if (mainCategoryId) {
                // Load subcategories
                fetch(`/api/categories/${mainCategoryId}/children`)
                    .then(response => response.json())
                    .then(data => {
                        subcategorySelect.innerHTML = '<option value="">اختر الفئة الفرعية</option>';
                        
                        if (data.length > 0) {
                            data.forEach(category => {
                                const option = document.createElement('option');
                                option.value = category.id;
                                option.textContent = category.name;
                                subcategorySelect.appendChild(option);
                            });
                            subcategorySection.style.display = 'block';
                        } else {
                            subcategorySection.style.display = 'none';
                            subcategorySelect.value = '';
                        }
                    });
            } else {
                subcategorySection.style.display = 'none';
                subcategorySelect.innerHTML = '<option value="">اختر الفئة الفرعية</option>';
            }
            
            checkShoesCategory();
        });
        
        // Subcategory change handler
        document.getElementById('subcategory').addEventListener('change', function() {
            checkShoesCategory();
        });
        
        // Add shoe size button
        document.getElementById('add_shoe_size').addEventListener('click', function() {
            addShoeSizeRow();
        });
        
        // Handle shoe quantity changes
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('shoe-quantity')) {
                calculateTotalShoeQuantity();
            }
        });
    });
    
    // Check if current category is shoes and show/hide shoe sizes section
    function checkShoesCategory() {
        const mainCategorySelect = document.getElementById('main_category');
        const subcategorySelect = document.getElementById('subcategory');
        const shoeSizesSection = document.getElementById('shoe_sizes_section');
        const regularQuantitySection = document.querySelector('input[name="quantity"]').closest('.bg-white');
        
        let selectedCategoryName = '';
        
        // Check subcategory first (if exists), then main category
        if (subcategorySelect.value) {
            const selectedOption = subcategorySelect.options[subcategorySelect.selectedIndex];
            selectedCategoryName = selectedOption ? selectedOption.text : '';
        } else if (mainCategorySelect.value) {
            const selectedOption = mainCategorySelect.options[mainCategorySelect.selectedIndex];
            selectedCategoryName = selectedOption ? selectedOption.text : '';
        }
        
        if (selectedCategoryName.includes('أحذية')) {
            shoeSizesSection.style.display = 'block';
            regularQuantitySection.style.display = 'none';
            
            // Make shoe sizes required
            const shoeSizeSelects = document.querySelectorAll('.shoe-size-select');
            const shoeQuantityInputs = document.querySelectorAll('.shoe-quantity');
            
            shoeSizeSelects.forEach(select => select.required = true);
            shoeQuantityInputs.forEach(input => input.required = true);
        } else {
            shoeSizesSection.style.display = 'none';
            regularQuantitySection.style.display = 'block';
            
            // Make shoe sizes not required
            const shoeSizeSelects = document.querySelectorAll('.shoe-size-select');
            const shoeQuantityInputs = document.querySelectorAll('.shoe-quantity');
            
            shoeSizeSelects.forEach(select => select.required = false);
            shoeQuantityInputs.forEach(input => input.required = false);
        }
    }
    
    // Add new shoe size row
    function addShoeSizeRow() {
        const container = document.getElementById('shoe_sizes_container');
        const newRow = document.createElement('div');
        newRow.className = 'shoe-size-row grid grid-cols-3 gap-3 mb-3';
        newRow.setAttribute('data-index', shoeSizeIndex);
        
        newRow.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">المقاس</label>
                <select name="shoe_sizes[${shoeSizeIndex}][size]" class="shoe-size-select w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">الكمية</label>
                <input type="number" name="shoe_sizes[${shoeSizeIndex}][quantity]" min="0" class="shoe-quantity w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
            </div>
            <div class="flex items-end">
                <button type="button" onclick="removeShoeSizeRow(this)" class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        
        container.appendChild(newRow);
        shoeSizeIndex++;
    }
    
    // Remove shoe size row
    function removeShoeSizeRow(button) {
        const row = button.closest('.shoe-size-row');
        const container = document.getElementById('shoe_sizes_container');
        
        // Don't allow removing the last row
        if (container.children.length > 1) {
            row.remove();
            calculateTotalShoeQuantity();
        } else {
            showWarning('يجب الاحتفاظ بمقاس واحد على الأقل');
        }
    }
    
    // Calculate total quantity from shoe sizes
    function calculateTotalShoeQuantity() {
        const quantityInputs = document.querySelectorAll('.shoe-quantity');
        let total = 0;
        
        quantityInputs.forEach(input => {
            const value = parseInt(input.value) || 0;
            total += value;
        });
        
        document.getElementById('total_shoe_quantity').textContent = total;
    }

    // Image upload and preview functionality
    const dropArea = document.getElementById('dropArea');
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('image-preview');
    const previewGrid = document.getElementById('preview-container');
    
    let selectedFiles = [];
    const maxFiles = 5;
    const maxFileSize = 2 * 1024 * 1024; // 2MB

    // Drag and drop handlers
    if (dropArea && imageInput) {
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
    }

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
        if (!imageInput) return;
        const dt = new DataTransfer();
        selectedFiles.forEach(file => {
            dt.items.add(file);
        });
        imageInput.files = dt.files;
    }

    function updatePreview() {
        if (!previewContainer || !previewGrid) return;
        
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
                    <div class="relative overflow-hidden rounded-lg border-2 border-green-500 hover:border-green-400 transition-colors">
                        <img src="${e.target.result}" alt="Preview ${index + 1}" 
                             class="w-full h-32 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200"></div>
                        
                        <!-- Remove button -->
                        <button type="button" onclick="removeNewImage(${index})"
                                class="absolute top-2 left-2 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors opacity-0 group-hover:opacity-100">
                            <i class="fas fa-times"></i>
                        </button>
                        
                        <!-- New badge -->
                        <div class="absolute bottom-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded">
                            جديدة
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

    // Remove new image function
    window.removeNewImage = function(index) {
        selectedFiles.splice(index, 1);
        updateFileInput();
        updatePreview();
    };

    // Image modal functions
    window.openImageModal = function(imageSrc) {
        let modal = document.getElementById('imageModal');
        if (!modal) {
            // Create modal if it doesn't exist
            modal = document.createElement('div');
            modal.id = 'imageModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4';
            modal.innerHTML = `
                <div class="relative max-w-full max-h-full">
                    <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl z-10 bg-black bg-opacity-50 w-10 h-10 rounded-full flex items-center justify-center hover:bg-opacity-75">
                        <i class="fas fa-times"></i>
                    </button>
                    <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('modalImage').alt = 'صورة المنتج';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    };

    window.closeImageModal = function() {
        const modal = document.getElementById('imageModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    };

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
    
    // Delete image function
    function deleteImage(imageId) {
        if (!confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
            return;
        }
        
        const formData = new FormData();
        formData.append('_method', 'DELETE');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        fetch(`/admin/products/images/${imageId}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء حذف الصورة');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حذف الصورة');
        });
    }

    // Make image primary function
    function makePrimaryImage(imageId) {
        if (!confirm('هل تريد جعل هذه الصورة هي الصورة الرئيسية؟')) {
            return;
        }
        
        const formData = new FormData();
        formData.append('_method', 'PATCH');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        fetch(`/admin/products/images/${imageId}/primary`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء تحديث الصورة الرئيسية');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تحديث الصورة الرئيسية');
        });
    }
</script>
<?php $__env->stopPush(); ?>





<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>