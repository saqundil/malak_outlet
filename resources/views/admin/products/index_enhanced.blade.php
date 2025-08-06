@extends('admin.layout')

@section('title', 'إدارة المنتجات')
@section('page-title', 'إدارة المنتجات')
@section('page-description', 'عرض وإدارة جميع منتجات المتجر')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">المنتجات ({{ $products->total() }})</h2>
            <p class="text-gray-600 mt-1">إدارة جميع منتجات المتجر الإلكتروني</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('admin.products.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium flex items-center">
                <i class="fas fa-plus ml-2"></i>
                إضافة منتج جديد
            </a>
            <button onclick="exportProducts()" 
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium flex items-center">
                <i class="fas fa-download ml-2"></i>
                تصدير
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">إجمالي المنتجات</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_products'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">منتجات نشطة</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['active_products'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">مخزون منخفض</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['low_stock'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">نفذ المخزون</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['out_of_stock'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">البحث</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="البحث في المنتجات..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">الفئة</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">جميع الفئات</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Brand Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">العلامة التجارية</label>
                <select name="brand" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">جميع العلامات</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">جميع الحالات</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    <option value="featured" {{ request('featured') == '1' ? 'selected' : '' }}>مميز</option>
                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>مخزون منخفض</option>
                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>نفذ المخزون</option>
                </select>
            </div>

            <!-- Sort Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ترتيب حسب</label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>الأحدث</option>
                    <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>الأقدم</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>الاسم (أ-ي)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>الاسم (ي-أ)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>السعر (منخفض لعالي)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>السعر (عالي لمنخفض)</option>
                </select>
            </div>

            <div class="md:col-span-5 flex gap-3">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-search ml-2"></i>
                    بحث
                </button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-refresh ml-2"></i>
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    <!-- Products Grid/Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if($products->count() > 0)
            <!-- Bulk Actions Bar -->
            <div id="bulkActionsBar" class="hidden bg-blue-50 border-b border-blue-200 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-blue-700 font-medium">
                            <span id="selectedCount">0</span> منتج محدد
                        </span>
                        <div class="flex gap-2">
                            <button onclick="bulkActivate()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                                تفعيل
                            </button>
                            <button onclick="bulkDeactivate()" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">
                                إلغاء تفعيل
                            </button>
                            <button onclick="bulkFeature()" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg text-sm">
                                تمييز
                            </button>
                            <button onclick="bulkDelete()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                                حذف
                            </button>
                        </div>
                    </div>
                    <button onclick="clearSelection()" class="text-blue-600 hover:text-blue-800">
                        إلغاء التحديد
                    </button>
                </div>
            </div>

            <!-- Products Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-right">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المنتج</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الفئة</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العلامة</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السعر</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المخزون</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المبيعات</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <input type="checkbox" name="selected_products[]" value="{{ $product->slug }}" 
                                       class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($product->images->count() > 0)
                                        <img src="{{ $product->images->first()->image_path }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-12 h-12 rounded-lg object-cover ml-4">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center ml-4">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($product->description ?? '', 50) }}</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            @if($product->is_featured)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-star ml-1"></i>
                                                    مميز
                                                </span>
                                            @endif
                                            <span class="text-xs text-gray-500">{{ $product->sku ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if($product->category)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                                        {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">غير محدد</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if($product->brand)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-indigo-100 text-indigo-800">
                                        {{ $product->brand->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">غير محدد</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="font-medium">{{ number_format($product->price, 2) }} د.أ</div>
                                @if($product->sale_price)
                                    <div class="text-xs text-green-600">عرض: {{ number_format($product->sale_price, 2) }} د.أ</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($product->track_quantity)
                                    <span class="font-medium {{ $product->stock_quantity < 10 ? 'text-red-600' : ($product->stock_quantity < 50 ? 'text-yellow-600' : 'text-gray-900') }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                    @if($product->stock_quantity < 10)
                                        <div class="text-xs text-red-600">مخزون منخفض</div>
                                    @elseif($product->stock_quantity == 0)
                                        <div class="text-xs text-red-600">نفذ المخزون</div>
                                    @endif
                                @else
                                    <span class="text-gray-500">غير محدود</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs 
                                        {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                    <button onclick="toggleStatus({{ $product->slug }})" 
                                            class="text-xs text-blue-600 hover:text-blue-800">
                                        تغيير
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="font-medium">{{ $product->sales_count ?? 0 }}</div>
                                <div class="text-xs text-gray-500">مبيعة</div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="text-blue-600 hover:text-blue-800" title="عرض">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="text-indigo-600 hover:text-indigo-800" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="duplicateProduct({{ $product->slug }})" 
                                            class="text-green-600 hover:text-green-800" title="نسخ">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <button onclick="toggleFeatured({{ $product->slug }})" 
                                            class="text-yellow-600 hover:text-yellow-800" title="تمييز">
                                        <i class="fas fa-star"></i>
                                    </button>
                                    <button onclick="deleteProduct({{ $product->slug }})" 
                                            class="text-red-600 hover:text-red-800" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    عرض {{ $products->firstItem() }} إلى {{ $products->lastItem() }} من {{ $products->total() }} منتج
                </div>
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد منتجات</h3>
                <p class="text-gray-500 mb-6">ابدأ بإضافة منتجات جديدة لمتجرك</p>
                <a href="{{ route('admin.products.create') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                    <i class="fas fa-plus ml-2"></i>
                    إضافة أول منتج
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Product Quick View Modal -->
<div id="quickViewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" onclick="closeQuickView()"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div id="quickViewContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const selectedCountSpan = document.getElementById('selectedCount');

    selectAllCheckbox.addEventListener('change', function() {
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionsBar();
    });

    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionsBar);
    });

    function updateBulkActionsBar() {
        const selectedProducts = document.querySelectorAll('.product-checkbox:checked');
        const count = selectedProducts.length;
        
        if (count > 0) {
            bulkActionsBar.classList.remove('hidden');
            selectedCountSpan.textContent = count;
        } else {
            bulkActionsBar.classList.add('hidden');
        }
        
        selectAllCheckbox.checked = count === productCheckboxes.length;
        selectAllCheckbox.indeterminate = count > 0 && count < productCheckboxes.length;
    }
});

function clearSelection() {
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    document.getElementById('bulkActionsBar').classList.add('hidden');
}

function toggleStatus(productId) {
    if (confirm('هل أنت متأكد من تغيير حالة المنتج؟')) {
        fetch(`/admin/products/${productId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء تغيير الحالة');
            }
        });
    }
}

function toggleFeatured(productId) {
    fetch(`/admin/products/${productId}/toggle-featured`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('حدث خطأ أثناء تغيير التمييز');
        }
    });
}

function duplicateProduct(productId) {
    if (confirm('هل تريد إنشاء نسخة من هذا المنتج؟')) {
        fetch(`/admin/products/${productId}/duplicate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('تم إنشاء نسخة من المنتج بنجاح');
                location.reload();
            } else {
                alert('حدث خطأ أثناء نسخ المنتج');
            }
        });
    }
}

function deleteProduct(productId) {
    if (confirm('هل أنت متأكد من حذف المنتج؟ لا يمكن التراجع عن هذا الإجراء.')) {
        fetch(`/admin/products/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء حذف المنتج');
            }
        });
    }
}

function bulkActivate() {
    bulkAction('activate', 'تفعيل');
}

function bulkDeactivate() {
    bulkAction('deactivate', 'إلغاء تفعيل');
}

function bulkFeature() {
    bulkAction('feature', 'تمييز');
}

function bulkDelete() {
    bulkAction('delete', 'حذف');
}

function bulkAction(action, actionName) {
    const selectedProducts = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);
    
    if (selectedProducts.length === 0) {
        alert('يجب تحديد منتج واحد على الأقل');
        return;
    }
    
    if (confirm(`هل أنت متأكد من ${actionName} ${selectedProducts.length} منتج؟`)) {
        fetch('/admin/products/bulk-action', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: action,
                product_ids: selectedProducts
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء تنفيذ الإجراء');
            }
        });
    }
}

function exportProducts() {
    window.location.href = '/admin/products/export';
}

function showQuickView(productId) {
    fetch(`/admin/products/${productId}/quick-view`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('quickViewContent').innerHTML = html;
            document.getElementById('quickViewModal').classList.remove('hidden');
        });
}

function closeQuickView() {
    document.getElementById('quickViewModal').classList.add('hidden');
}
</script>
@endsection




