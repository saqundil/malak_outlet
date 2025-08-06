@extends('admin.layout')

@section('title', 'عرض الفئة: ' . $category->name)
@section('page-title', 'عرض الفئة')
@section('page-description', $category->name)

@section('content')
<div class="space-y-6">
    <!-- Category Header -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex justify-between items-start">
            <div class="flex items-center gap-6">
                @if($category->image)
                    <div class="w-20 h-20 rounded-lg overflow-hidden border border-gray-300">
                        <img src="{{ $category->image }}" alt="{{ $category->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="w-20 h-20 bg-orange-100 rounded-lg flex items-center justify-center border border-gray-300">
                        <i class="fas fa-tag text-orange-600 text-2xl"></i>
                    </div>
                @endif
                
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
                    @if($category->slug)
                        <p class="text-gray-600 mt-1">{{ $category->slug }}</p>
                    @endif
                    
                    <div class="flex items-center gap-4 mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $category->is_active ? 'نشطة' : 'غير نشطة' }}
                        </span>
                        
                        @if($category->sort_order !== null)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-sort ml-1"></i>
                                ترتيب: {{ $category->sort_order }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.categories.edit', $category) }}" 
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-edit ml-2"></i>
                    تعديل
                </a>
                <a href="{{ route('categories.show', $category->slug) }}" target="_blank"
                   class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                    <i class="fas fa-external-link-alt ml-2"></i>
                    عرض في الموقع
                </a>
                <button onclick="deleteCategory()" 
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-trash ml-2"></i>
                    حذف
                </button>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Category Description -->
            @if($category->description)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">وصف الفئة</h3>
                <div class="prose max-w-none text-gray-700">
                    {{ $category->description }}
                </div>
            </div>
            @endif
            
            <!-- SEO Information -->
            @if($category->meta_title || $category->meta_description || $category->meta_keywords)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">معلومات SEO</h3>
                
                <div class="space-y-4">
                    @if($category->meta_title)
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">عنوان الصفحة:</span>
                            <span class="font-medium">{{ $category->meta_title }}</span>
                        </div>
                    @endif
                    
                    @if($category->meta_description)
                        <div class="py-2 border-b border-gray-100">
                            <span class="text-gray-600 block mb-2">وصف الصفحة:</span>
                            <p class="text-gray-900">{{ $category->meta_description }}</p>
                        </div>
                    @endif
                    
                    @if($category->meta_keywords)
                        <div class="py-2">
                            <span class="text-gray-600 block mb-2">الكلمات المفتاحية:</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $category->meta_keywords) as $keyword)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ trim($keyword) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Recent Products -->
            @if($recentProducts->count() > 0)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">المنتجات الحديثة</h3>
                    <a href="{{ route('admin.products.index', ['category_id' => $category->slug]) }}" 
                       class="text-orange-500 hover:text-orange-700 text-sm font-medium">
                        عرض جميع المنتجات
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($recentProducts as $product)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center gap-4">
                                @if($product->images->first())
                                    <img src="{{ $product->images->first()->image_path }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-12 h-12 object-cover rounded-lg border border-gray-300">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-300">
                                        <i class="fas fa-box text-gray-400"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 truncate">{{ $product->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ number_format($product->price, 2) }} د.أ</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $product->stock_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $product->stock_quantity > 0 ? 'متوفر' : 'غير متوفر' }}
                                        </span>
                                        @if($product->sale_price)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                تخفيض
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex flex-col gap-1">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="text-blue-600 hover:text-blue-900 text-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="text-orange-600 hover:text-orange-900 text-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistics -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">إحصائيات الفئة</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">إجمالي المنتجات:</span>
                        <span class="font-bold text-2xl text-blue-600">{{ $totalProducts }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">المنتجات النشطة:</span>
                        <span class="font-bold text-2xl text-green-600">{{ $activeProducts }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">المنتجات غير النشطة:</span>
                        <span class="font-bold text-2xl text-red-600">{{ $totalProducts - $activeProducts }}</span>
                    </div>
                    
                    @if($totalRevenue > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">إجمالي المبيعات:</span>
                            <span class="font-bold text-2xl text-orange-600">{{ number_format($totalRevenue, 2) }} د.أ</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Category Info -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات الفئة</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">تاريخ الإنشاء:</span>
                        <span class="font-medium">{{ $category->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">آخر تحديث:</span>
                        <span class="font-medium">{{ $category->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    @if($category->slug)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">الرابط المختصر:</span>
                            <span class="font-medium text-blue-600">{{ $category->slug }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">إجراءات سريعة</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.products.index', ['category_id' => $category->slug]) }}" 
                       class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-600 transition-colors block text-center">
                        <i class="fas fa-box ml-2"></i>
                        عرض منتجات الفئة
                    </a>
                    
                    <a href="{{ route('admin.products.create', ['category_id' => $category->slug]) }}" 
                       class="w-full bg-green-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-green-600 transition-colors block text-center">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة منتج جديد
                    </a>
                    
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="w-full bg-orange-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors block text-center">
                        <i class="fas fa-edit ml-2"></i>
                        تعديل الفئة
                    </a>
                    
                    <button onclick="toggleStatus()" 
                            class="{{ $category->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} w-full text-white py-2 px-4 rounded-lg font-medium transition-colors">
                        <i class="fas fa-{{ $category->is_active ? 'ban' : 'check' }} ml-2"></i>
                        {{ $category->is_active ? 'إلغاء تفعيل' : 'تفعيل' }}
                    </button>
                    
                    <a href="{{ route('admin.categories.index') }}" 
                       class="w-full bg-gray-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors block text-center">
                        <i class="fas fa-arrow-left ml-2"></i>
                        العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 max-w-md w-full">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-trash text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">حذف الفئة</h3>
            <p class="text-sm text-gray-500 mb-6">
                هل أنت متأكد من حذف هذه الفئة؟ 
                @if($totalProducts > 0)
                    <br><strong class="text-red-600">تحتوي الفئة على {{ $totalProducts }} منتج وسيتم حذفها جميعاً.</strong>
                @endif
                <br>لا يمكن التراجع عن هذا الإجراء.
            </p>
            <div class="flex gap-3 justify-center">
                <button onclick="confirmDelete()" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    نعم، احذف
                </button>
                <button onclick="closeDeleteModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                    إلغاء
                </button>
            </div>
        </div>
    </div>
</div>

<form id="delete-form" action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    function toggleStatus() {
        const isActive = {{ $category->is_active ? 'true' : 'false' }};
        const action = isActive ? 'إلغاء تفعيل' : 'تفعيل';
        
        if (confirm(`هل أنت متأكد من ${action} هذه الفئة؟`)) {
            fetch(`/admin/categories/{{ $category->slug }}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ is_active: !isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('حدث خطأ أثناء تحديث حالة الفئة');
                }
            })
            .catch(error => {
                alert('حدث خطأ أثناء تحديث حالة الفئة');
            });
        }
    }
    
    function deleteCategory() {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }
    
    function confirmDelete() {
        document.getElementById('delete-form').submit();
    }
    
    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
    
    // Close modal with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endpush




