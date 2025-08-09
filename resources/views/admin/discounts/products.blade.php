@extends('admin.layout')

@section('title', 'ربط المنتجات بالخصم')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="admin-card mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">ربط المنتجات بالخصم</h1>
                <p class="text-gray-600 mt-1">إدارة المنتجات المرتبطة بالخصم: {{ $discount->name }}</p>
            </div>
            <a href="{{ route('admin.discounts.show', $discount) }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                عودة للخصم
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Available Products -->
        <div class="admin-card">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">المنتجات المتاحة</h3>
            
            <div class="mb-4">
                <input type="text" 
                       id="searchAvailable" 
                       class="form-input" 
                       placeholder="البحث في المنتجات المتاحة...">
            </div>
            
            <div class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg">
                @forelse($availableProducts as $product)
                <div class="p-3 border-b border-gray-100 hover:bg-gray-50 available-product" 
                     data-name="{{ strtolower($product->name) }}" 
                     data-id="{{ $product->id }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-12 h-12 object-cover rounded-lg mr-3">
                            @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                            @endif
                            
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $product->name }}</h4>
                                <p class="text-sm text-gray-600">
                                    {{ number_format($product->price, 2) }} ريال
                                    @if($product->sale_price)
                                        <span class="text-red-600">({{ number_format($product->sale_price, 2) }} ريال)</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <button onclick="addProduct({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" 
                                class="btn-primary text-sm py-1 px-3">
                            <i class="fas fa-plus mr-1"></i>
                            إضافة
                        </button>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-box-open text-4xl mb-4"></i>
                    <p>لا توجد منتجات متاحة للإضافة</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Assigned Products -->
        <div class="admin-card">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">المنتجات المرتبطة</h3>
            
            <div class="mb-4">
                <input type="text" 
                       id="searchAssigned" 
                       class="form-input" 
                       placeholder="البحث في المنتجات المرتبطة...">
            </div>
            
            <form id="assignedProductsForm" method="POST" action="{{ route('admin.discounts.sync-products', $discount) }}">
                @csrf
                @method('PUT')
                
                <div class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg mb-4" id="assignedProductsList">
                    @forelse($discount->products as $product)
                    <div class="p-3 border-b border-gray-100 hover:bg-gray-50 assigned-product" 
                         data-name="{{ strtolower($product->name) }}" 
                         data-id="{{ $product->id }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-12 h-12 object-cover rounded-lg mr-3">
                                @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                                @endif
                                
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $product->name }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ number_format($product->price, 2) }} ريال
                                        @if($product->sale_price)
                                            <span class="text-red-600">({{ number_format($product->sale_price, 2) }} ريال)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <button type="button" 
                                    onclick="removeProduct({{ $product->id }})" 
                                    class="btn-danger text-sm py-1 px-3">
                                <i class="fas fa-trash mr-1"></i>
                                إزالة
                            </button>
                        </div>
                        <input type="hidden" name="product_ids[]" value="{{ $product->id }}">
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500" id="emptyAssigned">
                        <i class="fas fa-link text-4xl mb-4"></i>
                        <p>لم يتم ربط أي منتجات بهذا الخصم</p>
                    </div>
                    @endforelse
                </div>
                
                <div class="flex justify-between items-center pt-4 border-t">
                    <div class="text-sm text-gray-600">
                        إجمالي المنتجات المرتبطة: <span id="assignedCount">{{ $discount->products->count() }}</span>
                    </div>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="admin-card mt-6">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">إجراءات مجمعة</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <button onclick="addAllVisible()" class="w-full btn-success">
                    <i class="fas fa-plus-circle mr-2"></i>
                    إضافة جميع المنتجات المرئية
                </button>
            </div>
            
            <div class="text-center">
                <button onclick="removeAllVisible()" class="w-full btn-warning">
                    <i class="fas fa-minus-circle mr-2"></i>
                    إزالة جميع المنتجات المرئية
                </button>
            </div>
            
            <div class="text-center">
                <button onclick="clearAll()" class="w-full btn-danger">
                    <i class="fas fa-trash-alt mr-2"></i>
                    إزالة جميع المنتجات
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let assignedProducts = new Set(@json($discount->products->pluck('id')->toArray()));

// Search functionality
document.getElementById('searchAvailable').addEventListener('input', function() {
    filterProducts('available-product', this.value);
});

document.getElementById('searchAssigned').addEventListener('input', function() {
    filterProducts('assigned-product', this.value);
});

function filterProducts(className, searchTerm) {
    const products = document.getElementsByClassName(className);
    const term = searchTerm.toLowerCase();
    
    for (let product of products) {
        const name = product.dataset.name;
        if (name.includes(term)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    }
}

function addProduct(id, name, price) {
    if (assignedProducts.has(id)) {
        toastr.warning('هذا المنتج مربوط بالفعل');
        return;
    }
    
    assignedProducts.add(id);
    
    // Remove from available (hide it)
    const availableProduct = document.querySelector(`[data-id="${id}"].available-product`);
    if (availableProduct) {
        availableProduct.style.display = 'none';
    }
    
    // Add to assigned list
    const assignedList = document.getElementById('assignedProductsList');
    const emptyMessage = document.getElementById('emptyAssigned');
    
    if (emptyMessage) {
        emptyMessage.remove();
    }
    
    const productHtml = `
        <div class="p-3 border-b border-gray-100 hover:bg-gray-50 assigned-product" 
             data-name="${name.toLowerCase()}" 
             data-id="${id}">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                        <i class="fas fa-image text-gray-400"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">${name}</h4>
                        <p class="text-sm text-gray-600">${price.toFixed(2)} ريال</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="removeProduct(${id})" 
                        class="btn-danger text-sm py-1 px-3">
                    <i class="fas fa-trash mr-1"></i>
                    إزالة
                </button>
            </div>
            <input type="hidden" name="product_ids[]" value="${id}">
        </div>
    `;
    
    assignedList.insertAdjacentHTML('beforeend', productHtml);
    updateAssignedCount();
    toastr.success('تم إضافة المنتج بنجاح');
}

function removeProduct(id) {
    assignedProducts.delete(id);
    
    // Show in available list again
    const availableProduct = document.querySelector(`[data-id="${id}"].available-product`);
    if (availableProduct) {
        availableProduct.style.display = 'block';
    }
    
    // Remove from assigned list
    const assignedProduct = document.querySelector(`[data-id="${id}"].assigned-product`);
    if (assignedProduct) {
        assignedProduct.remove();
    }
    
    updateAssignedCount();
    
    // Show empty message if no products
    if (assignedProducts.size === 0) {
        const assignedList = document.getElementById('assignedProductsList');
        assignedList.innerHTML = `
            <div class="p-8 text-center text-gray-500" id="emptyAssigned">
                <i class="fas fa-link text-4xl mb-4"></i>
                <p>لم يتم ربط أي منتجات بهذا الخصم</p>
            </div>
        `;
    }
    
    toastr.success('تم إزالة المنتج بنجاح');
}

function addAllVisible() {
    const visibleProducts = document.querySelectorAll('.available-product[style="display: block"], .available-product:not([style])');
    let count = 0;
    
    visibleProducts.forEach(product => {
        const id = parseInt(product.dataset.id);
        if (!assignedProducts.has(id)) {
            const name = product.querySelector('h4').textContent;
            const price = parseFloat(product.querySelector('.text-sm').textContent.match(/[\d.]+/)[0]);
            addProduct(id, name, price);
            count++;
        }
    });
    
    if (count > 0) {
        toastr.success(`تم إضافة ${count} منتج`);
    } else {
        toastr.info('لا توجد منتجات جديدة للإضافة');
    }
}

function removeAllVisible() {
    const visibleProducts = document.querySelectorAll('.assigned-product[style="display: block"], .assigned-product:not([style])');
    let count = 0;
    
    visibleProducts.forEach(product => {
        const id = parseInt(product.dataset.id);
        if (assignedProducts.has(id)) {
            removeProduct(id);
            count++;
        }
    });
    
    if (count > 0) {
        toastr.success(`تم إزالة ${count} منتج`);
    } else {
        toastr.info('لا توجد منتجات للإزالة');
    }
}

function clearAll() {
    if (assignedProducts.size === 0) {
        toastr.info('لا توجد منتجات لإزالتها');
        return;
    }
    
    if (confirm('هل أنت متأكد من إزالة جميع المنتجات؟')) {
        const assignedProductElements = document.querySelectorAll('.assigned-product');
        assignedProductElements.forEach(product => {
            const id = parseInt(product.dataset.id);
            removeProduct(id);
        });
        
        toastr.success('تم إزالة جميع المنتجات');
    }
}

function updateAssignedCount() {
    document.getElementById('assignedCount').textContent = assignedProducts.size;
}

// Form submission handler
document.getElementById('assignedProductsForm').addEventListener('submit', function() {
    toastr.info('جاري حفظ التغييرات...');
});
</script>
@endsection
