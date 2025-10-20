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
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6" id="productsStatsGrid">
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">إجمالي المنتجات</p>
                    <p class="text-3xl font-bold text-gray-900 animate-pulse" id="totalProducts">{{ $stats['total_products'] ?? 0 }}</p>
                    <div class="mt-2">
                        <span class="text-xs text-green-600 font-medium" id="totalProductsChange">+0</span>
                        <span class="text-xs text-gray-500">هذا الشهر</span>
                    </div>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">منتجات نشطة</p>
                    <p class="text-3xl font-bold text-gray-900 animate-pulse" id="activeProducts">{{ $stats['active_products'] ?? 0 }}</p>
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" id="activeProductsProgress" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">مخزون منخفض</p>
                    <p class="text-3xl font-bold text-gray-900 animate-pulse" id="lowStock">{{ $stats['low_stock'] ?? 0 }}</p>
                    <div class="mt-2">
                        <span class="text-xs text-yellow-600 font-medium">يحتاج انتباه</span>
                    </div>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500 transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">نفذ المخزون</p>
                    <p class="text-3xl font-bold text-gray-900 animate-pulse" id="outOfStock">{{ $stats['out_of_stock'] ?? 0 }}</p>
                    <div class="mt-2">
                        <span class="text-xs text-red-600 font-medium">إجراء عاجل</span>
                    </div>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">تصفية المنتجات</h3>
            <div class="text-sm text-gray-500">
                {{ $products->total() }} منتج
            </div>
        </div>
        <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4" id="filterForm">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">البحث</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="البحث في المنتجات..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Main Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">الفئة الرئيسية</label>
                <select name="main_category" id="mainCategorySelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">جميع الفئات الرئيسية</option>
                    @foreach($categories->whereNull('parent_id') as $mainCategory)
                        <option value="{{ $mainCategory->id }}" {{ request('main_category') == $mainCategory->id ? 'selected' : '' }}>
                            {{ $mainCategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sub Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    الفئة الفرعية
                    <span id="subcategoryLoader" class="hidden ml-2">
                        <i class="fas fa-spinner fa-spin text-blue-500 text-xs"></i>
                    </span>
                </label>
                <select name="category" id="subCategorySelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">جميع الفئات الفرعية</option>
                    @if(request('main_category'))
                        @foreach($categories->where('parent_id', request('main_category')) as $subCategory)
                            <option value="{{ $subCategory->id }}" {{ request('category') == $subCategory->id ? 'selected' : '' }}>
                                {{ $subCategory->name }}
                            </option>
                        @endforeach
                    @endif
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
                    <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>مميز</option>
                    <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>مخزون منخفض</option>
                    <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>نفذ المخزون</option>
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

            <div class="md:col-span-6 flex gap-3">
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
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <input type="checkbox" name="selected_products[]" value="{{ $product->slug }}" 
                                       class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                    @if($product->images->count() > 0)
                                        <img src="{{ $product->images->first()->image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-16 h-16 rounded-lg object-cover shadow-sm">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center shadow-sm">
                                            <i class="fas fa-image text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</div>
                                        @if($product->description)
                                            <div class="text-sm text-gray-500 truncate">{{ Str::limit($product->description, 60) }}</div>
                                        @endif
                                        <div class="flex items-center gap-2 mt-2">
                                            @if($product->is_featured)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-star mr-1"></i>
                                                    مميز
                                                </span>
                                            @endif
                                            @if($product->sku)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600">
                                                    {{ $product->sku }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($product->category)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-purple-100 text-purple-800 font-medium">
                                        {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">غير محدد</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($product->brand)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-indigo-100 text-indigo-800 font-medium">
                                        {{ $product->brand->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">غير محدد</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="space-y-1">
                                    <div class="font-semibold text-gray-900">{{ number_format($product->price, 2) }} د.أ</div>
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <div class="text-sm text-green-600 font-medium">{{ number_format($product->sale_price, 2) }} د.أ</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="space-y-1">
                                    <span class="font-medium {{ $product->quantity <= 0 ? 'text-red-600' : ($product->quantity <= 10 ? 'text-yellow-600' : 'text-gray-900') }}">
                                        {{ $product->quantity }}
                                    </span>
                                    @if($product->quantity <= 0)
                                        <div class="text-xs text-red-600 font-medium">نفذ المخزون</div>
                                    @elseif($product->quantity <= 10)
                                        <div class="text-xs text-yellow-600 font-medium">مخزون منخفض</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="text-center">
                                    <div class="font-medium text-gray-900">{{ $product->sales_count ?? 0 }}</div>
                                    <div class="text-xs text-gray-500">مبيعة</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="action-button text-blue-600 hover:text-blue-800 transition-colors" title="عرض">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="action-button text-indigo-600 hover:text-indigo-800 transition-colors" title="تعديل">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <button onclick="duplicateProduct('{{ $product->slug }}')" 
                                            class="action-button text-green-600 hover:text-green-800 transition-colors" title="نسخ">
                                        <i class="fas fa-copy text-sm"></i>
                                    </button>
                                    <button onclick="toggleStatus('{{ $product->slug }}')" 
                                            class="action-button text-yellow-600 hover:text-yellow-800 transition-colors" title="تغيير الحالة">
                                        <i class="fas fa-toggle-{{ $product->is_active ? 'on' : 'off' }} text-sm"></i>
                                    </button>
                                    <button onclick="deleteProduct('{{ $product->slug }}')" 
                                            class="action-button text-red-600 hover:text-red-800 transition-colors" title="حذف">
                                        <i class="fas fa-trash text-sm"></i>
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
                <div class="pagination-wrapper">
                    {{ $products->appends(request()->query())->links() }}
                </div>
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

<style>
/* Custom pagination styles */
.pagination-wrapper nav {
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination-wrapper .pagination {
    display: flex;
    gap: 0.25rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.pagination-wrapper .page-item {
    margin: 0;
}

.pagination-wrapper .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 0.75rem;
    color: #6b7280;
    text-decoration: none;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.pagination-wrapper .page-link:hover {
    background-color: #f3f4f6;
    color: #374151;
}

.pagination-wrapper .page-item.active .page-link {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.pagination-wrapper .page-item.disabled .page-link {
    color: #9ca3af;
    background-color: #f9fafb;
    cursor: not-allowed;
}

/* Filter form enhancements */
.filter-section label {
    font-weight: 600;
}

.filter-section select,
.filter-section input {
    transition: border-color 0.2s, box-shadow 0.2s;
}

.filter-section select:focus,
.filter-section input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Table row hover effects */
tbody tr:hover {
    background-color: #f8fafc;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transition: all 0.2s;
}

/* Action buttons styling */
.action-button {
    padding: 0.375rem;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.action-button:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Status badges enhancement */
.status-badge {
    font-weight: 600;
    letter-spacing: 0.025em;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

/* Disabled select styling */
select:disabled {
    background-color: #f9fafb !important;
    color: #9ca3af !important;
    cursor: not-allowed !important;
}

/* Enhanced filter section */
#filterForm select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: left 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-left: 2.5rem;
}

#filterForm select:disabled {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%9ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
}
</style>

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

    // Handle main category change to load subcategories
    const mainCategorySelect = document.getElementById('mainCategorySelect');
    const subCategorySelect = document.getElementById('subCategorySelect');
    const filterForm = document.getElementById('filterForm');
    
    mainCategorySelect.addEventListener('change', function() {
        const mainCategoryId = this.value;
        const loader = document.getElementById('subcategoryLoader');
        
        // Clear subcategory options and show loading
        subCategorySelect.innerHTML = '<option value="">جاري التحميل...</option>';
        subCategorySelect.disabled = true;
        loader.classList.remove('hidden');
        
        if (mainCategoryId) {
            // Load subcategories via AJAX
            fetch('/admin/api/categories/tree')
                .then(response => response.json())
                .then(data => {
                    // Hide loader and clear loading option
                    loader.classList.add('hidden');
                    subCategorySelect.innerHTML = '<option value="">جميع الفئات الفرعية</option>';
                    
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
            subCategorySelect.innerHTML = '<option value="">جميع الفئات الفرعية</option>';
            subCategorySelect.disabled = true;
            subCategorySelect.classList.add('bg-gray-100', 'cursor-not-allowed');
        }
    });
    
    // Initialize subcategory state on page load
    if (!mainCategorySelect.value) {
        subCategorySelect.disabled = true;
        subCategorySelect.classList.add('bg-gray-100', 'cursor-not-allowed');
    }

    // Auto-submit filters on change (excluding main category to allow subcategory selection)
    const filterSelects = filterForm.querySelectorAll('select:not(#mainCategorySelect)');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Small delay to allow for subcategory loading
            setTimeout(() => {
                filterForm.submit();
            }, 100);
        });
    });

    // Search input debouncing
    const searchInput = filterForm.querySelector('input[name="search"]');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterForm.submit();
        }, 500); // Wait 500ms after user stops typing
    });
});

function clearSelection() {
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    document.getElementById('bulkActionsBar').classList.add('hidden');
}

function toggleStatus(productSlug) {
    if (confirm('هل أنت متأكد من تغيير حالة المنتج؟')) {
        fetch(`/admin/products/${productSlug}/toggle-status`, {
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
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تغيير الحالة');
        });
    }
}

function toggleFeatured(productSlug) {
    fetch(`/admin/products/${productSlug}/toggle-featured`, {
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
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تغيير التمييز');
    });
}

function duplicateProduct(productSlug) {
    if (confirm('هل تريد إنشاء نسخة من هذا المنتج؟')) {
        fetch(`/admin/products/${productSlug}/duplicate`, {
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
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء نسخ المنتج');
        });
    }
}

function deleteProduct(productSlug) {
    if (confirm('هل أنت متأكد من حذف المنتج؟ لا يمكن التراجع عن هذا الإجراء.')) {
        fetch(`/admin/products/${productSlug}`, {
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
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حذف المنتج');
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
                selected_items: selectedProducts
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء تنفيذ الإجراء');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تنفيذ الإجراء');
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

// Real-time statistics update
function updateProductsStats() {
    fetch('/admin/api/products/stats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const stats = data.data;
                
                // Update numbers with animation
                updateNumberWithAnimation('totalProducts', stats.total_products);
                updateNumberWithAnimation('activeProducts', stats.active_products);
                updateNumberWithAnimation('lowStock', stats.low_stock);
                updateNumberWithAnimation('outOfStock', stats.out_of_stock);
                
                // Update progress bar for active products
                const activePercentage = stats.total_products > 0 ? 
                    (stats.active_products / stats.total_products) * 100 : 0;
                document.getElementById('activeProductsProgress').style.width = activePercentage + '%';
                
                // Update recent products change
                document.getElementById('totalProductsChange').textContent = 
                    '+' + stats.recent_products_count;
                
                // Update status indicators
                updateStatusIndicators(stats);
            }
        })
        .catch(error => {
            console.error('Error fetching products stats:', error);
        });
}

function updateNumberWithAnimation(elementId, newValue) {
    const element = document.getElementById(elementId);
    const currentValue = parseInt(element.textContent) || 0;
    
    if (currentValue !== newValue) {
        element.classList.add('animate-bounce');
        
        // Animate the number change
        const duration = 1000;
        const startTime = Date.now();
        const startValue = currentValue;
        
        const updateNumber = () => {
            const elapsed = Date.now() - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const currentNumber = Math.floor(startValue + (newValue - startValue) * progress);
            
            element.textContent = currentNumber.toLocaleString('ar-SA');
            
            if (progress < 1) {
                requestAnimationFrame(updateNumber);
            } else {
                element.classList.remove('animate-bounce');
            }
        };
        
        requestAnimationFrame(updateNumber);
    }
}

function updateStatusIndicators(stats) {
    // Update cards colors based on thresholds
    const lowStockCard = document.querySelector('#lowStock').closest('.bg-white');
    const outOfStockCard = document.querySelector('#outOfStock').closest('.bg-white');
    
    // Low stock warnings
    if (stats.low_stock > 5) {
        lowStockCard.classList.add('ring-2', 'ring-yellow-400');
    } else {
        lowStockCard.classList.remove('ring-2', 'ring-yellow-400');
    }
    
    // Out of stock warnings
    if (stats.out_of_stock > 0) {
        outOfStockCard.classList.add('ring-2', 'ring-red-400');
    } else {
        outOfStockCard.classList.remove('ring-2', 'ring-red-400');
    }
}

// Initialize real-time updates
document.addEventListener('DOMContentLoaded', function() {
    // Update stats immediately
    updateProductsStats();
    
    // Update every 30 seconds
    setInterval(updateProductsStats, 30000);
    
    // Update when page becomes visible again
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            updateProductsStats();
        }
    });
});
</script>
@endsection




