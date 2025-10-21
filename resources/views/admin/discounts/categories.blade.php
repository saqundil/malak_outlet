@extends('admin.layout')

@section('title', 'ربط الفئات بالخصم')

@section('content')
<div class="p-6" dir="rtl">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-tags text-red-500 ml-3"></i>
                ربط الفئات بالخصم
            </h1>
            <p class="text-gray-600 mt-2">إدارة الفئات المرتبطة بالخصم: {{ $discount->name }}</p>
        </div>
        <a href="{{ route('admin.discounts.show', $discount) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center">
            <i class="fas fa-arrow-right ml-2"></i>
            عودة للخصم
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Available Categories -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-list text-blue-500 ml-2"></i>
                    الفئات المتاحة
                </h3>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <input type="text" 
                           id="searchAvailable" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                           placeholder="البحث في الفئات المتاحة...">
                </div>
                
                <div class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg">
                    @forelse($availableCategories as $category)
                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 available-category transition-colors" 
                         data-name="{{ strtolower($category->name) }}" 
                         data-id="{{ $category->id }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     class="w-12 h-12 object-cover rounded-lg ml-3">
                                @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg ml-3 flex items-center justify-center">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                @endif
                                
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $category->name }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $category->products_count ?? 0 }} منتج
                                    </p>
                                </div>
                            </div>
                            
                            <button onclick="addCategory({{ $category->id }}, '{{ $category->name }}')" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-plus ml-1"></i>
                                إضافة
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-tags text-4xl mb-4"></i>
                        <p>لا توجد فئات متاحة للإضافة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Assigned Categories -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-check-circle text-green-500 ml-2"></i>
                    الفئات المرتبطة
                </h3>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <input type="text" 
                           id="searchAssigned" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" 
                           placeholder="البحث في الفئات المرتبطة...">
                </div>
                
                <form id="assignedCategoriesForm" method="POST" action="{{ route('admin.discounts.sync-categories', $discount) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg mb-4" id="assignedCategoriesList">
                        @forelse($discount->categories as $category)
                        <div class="p-4 border-b border-gray-100 hover:bg-gray-50 assigned-category transition-colors" 
                             data-name="{{ strtolower($category->name) }}" 
                             data-id="{{ $category->id }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         alt="{{ $category->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg ml-3">
                                    @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg ml-3 flex items-center justify-center">
                                        <i class="fas fa-tag text-gray-400"></i>
                                    </div>
                                    @endif
                                    
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $category->name }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $category->products_count ?? 0 }} منتج
                                        </p>
                                    </div>
                                </div>
                                
                                <button type="button" 
                                        onclick="removeCategory({{ $category->id }})" 
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm py-2 px-4 rounded-lg transition-colors">
                                    <i class="fas fa-trash ml-1"></i>
                                    إزالة
                                </button>
                            </div>
                            <input type="hidden" name="category_ids[]" value="{{ $category->id }}">
                        </div>
                        @empty
                        <div class="p-8 text-center text-gray-500" id="emptyAssigned">
                            <i class="fas fa-link text-4xl mb-4"></i>
                            <p>لم يتم ربط أي فئات بهذا الخصم</p>
                        </div>
                        @endforelse
                    </div>
                    
                    <div class="flex justify-between items-center pt-4 border-t">
                        <div class="text-sm text-gray-600">
                            إجمالي الفئات المرتبطة: <span id="assignedCount">{{ $discount->categories->count() }}</span>
                        </div>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center">
                            <i class="fas fa-save ml-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mt-6">
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 border-b">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-tasks text-purple-500 ml-2"></i>
                إجراءات مجمعة
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="addAllVisible()" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-plus-circle ml-2"></i>
                    إضافة جميع الفئات المرئية
                </button>
                
                <button onclick="removeAllVisible()" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-minus-circle ml-2"></i>
                    إزالة جميع الفئات المرئية
                </button>
                
                <button onclick="clearAll()" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-trash-alt ml-2"></i>
                    إزالة جميع الفئات
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let assignedCategories = new Set(@json($discount->categories->pluck('id')->toArray()));

// Search functionality
document.getElementById('searchAvailable').addEventListener('input', function() {
    filterCategories('available-category', this.value);
});

document.getElementById('searchAssigned').addEventListener('input', function() {
    filterCategories('assigned-category', this.value);
});

function filterCategories(className, searchTerm) {
    const categories = document.getElementsByClassName(className);
    const term = searchTerm.toLowerCase();
    
    for (let category of categories) {
        const name = category.dataset.name;
        if (name.includes(term)) {
            category.style.display = 'block';
        } else {
            category.style.display = 'none';
        }
    }
}

function addCategory(id, name) {
    if (assignedCategories.has(id)) {
        showNotification('هذه الفئة مربوطة بالفعل', 'warning');
        return;
    }
    
    assignedCategories.add(id);
    
    // Remove from available (hide it)
    const availableCategory = document.querySelector(`[data-id="${id}"].available-category`);
    if (availableCategory) {
        availableCategory.style.display = 'none';
    }
    
    // Add to assigned list
    const assignedList = document.getElementById('assignedCategoriesList');
    const emptyMessage = document.getElementById('emptyAssigned');
    
    if (emptyMessage) {
        emptyMessage.remove();
    }
    
    const categoryHtml = `
        <div class="p-4 border-b border-gray-100 hover:bg-gray-50 assigned-category transition-colors" 
             data-name="${name.toLowerCase()}" 
             data-id="${id}">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-200 rounded-lg ml-3 flex items-center justify-center">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">${name}</h4>
                        <p class="text-sm text-gray-600">0 منتج</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="removeCategory(${id})" 
                        class="bg-red-500 hover:bg-red-600 text-white text-sm py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-trash ml-1"></i>
                    إزالة
                </button>
            </div>
            <input type="hidden" name="category_ids[]" value="${id}">
        </div>
    `;
    
    assignedList.insertAdjacentHTML('beforeend', categoryHtml);
    updateAssignedCount();
    showNotification('تم إضافة الفئة بنجاح', 'success');
}

function removeCategory(id) {
    assignedCategories.delete(id);
    
    // Show in available list again
    const availableCategory = document.querySelector(`[data-id="${id}"].available-category`);
    if (availableCategory) {
        availableCategory.style.display = 'block';
    }
    
    // Remove from assigned list
    const assignedCategory = document.querySelector(`[data-id="${id}"].assigned-category`);
    if (assignedCategory) {
        assignedCategory.remove();
    }
    
    updateAssignedCount();
    
    // Show empty message if no categories
    if (assignedCategories.size === 0) {
        const assignedList = document.getElementById('assignedCategoriesList');
        assignedList.innerHTML = `
            <div class="p-8 text-center text-gray-500" id="emptyAssigned">
                <i class="fas fa-link text-4xl mb-4"></i>
                <p>لم يتم ربط أي فئات بهذا الخصم</p>
            </div>
        `;
    }
    
    showNotification('تم إزالة الفئة بنجاح', 'success');
}

function addAllVisible() {
    const visibleCategories = document.querySelectorAll('.available-category[style="display: block"], .available-category:not([style])');
    let count = 0;
    
    visibleCategories.forEach(category => {
        const id = parseInt(category.dataset.id);
        if (!assignedCategories.has(id)) {
            const name = category.querySelector('h4').textContent;
            addCategory(id, name);
            count++;
        }
    });
    
    if (count > 0) {
        showNotification(`تم إضافة ${count} فئة`, 'success');
    } else {
        showNotification('لا توجد فئات جديدة للإضافة', 'info');
    }
}

function removeAllVisible() {
    const visibleCategories = document.querySelectorAll('.assigned-category[style="display: block"], .assigned-category:not([style])');
    let count = 0;
    
    visibleCategories.forEach(category => {
        const id = parseInt(category.dataset.id);
        if (assignedCategories.has(id)) {
            removeCategory(id);
            count++;
        }
    });
    
    if (count > 0) {
        showNotification(`تم إزالة ${count} فئة`, 'success');
    } else {
        showNotification('لا توجد فئات للإزالة', 'info');
    }
}

function clearAll() {
    if (assignedCategories.size === 0) {
        showNotification('لا توجد فئات لإزالتها', 'info');
        return;
    }
    
    if (confirm('هل أنت متأكد من إزالة جميع الفئات؟')) {
        const assignedCategoryElements = document.querySelectorAll('.assigned-category');
        assignedCategoryElements.forEach(category => {
            const id = parseInt(category.dataset.id);
            removeCategory(id);
        });
        
        showNotification('تم إزالة جميع الفئات', 'success');
    }
}

function updateAssignedCount() {
    document.getElementById('assignedCount').textContent = assignedCategories.size;
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 left-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'warning' ? 'bg-yellow-500 text-white' : 
        type === 'info' ? 'bg-blue-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : type === 'info' ? 'fa-info-circle' : 'fa-exclamation-circle'} ml-2"></i>
            ${message}
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(-100%)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Form submission handler
document.getElementById('assignedCategoriesForm').addEventListener('submit', function() {
    showNotification('جاري حفظ التغييرات...', 'info');
});
</script>
@endsection