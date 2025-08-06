@extends('admin.layout')

@section('title', 'عرض العلامة التجارية: ' . $brand->name)
@section('page-title', 'عرض العلامة التجارية')
@section('page-description', 'تفاصيل العلامة التجارية: ' . $brand->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Brand Information -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center">
                    @if($brand->logo)
                        <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" 
                             class="w-16 h-16 object-contain rounded-lg border border-gray-200 ml-4">
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $brand->name }}</h2>
                        @if($brand->slug)
                            <p class="text-sm text-gray-500">{{ $brand->slug }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    @if($brand->is_active)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle ml-1"></i>
                            نشط
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times-circle ml-1"></i>
                            غير نشط
                        </span>
                    @endif
                </div>
            </div>
            
            @if($brand->description)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">وصف العلامة التجارية</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $brand->description }}</p>
                </div>
            @endif
            
            <!-- SEO Information -->
            @if($brand->meta_title || $brand->meta_description || $brand->meta_keywords)
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات SEO</h3>
                    <div class="space-y-4">
                        @if($brand->meta_title)
                            <div>
                                <label class="text-sm font-medium text-gray-700">عنوان الصفحة:</label>
                                <p class="text-gray-900 mt-1">{{ $brand->meta_title }}</p>
                            </div>
                        @endif
                        
                        @if($brand->meta_description)
                            <div>
                                <label class="text-sm font-medium text-gray-700">وصف الصفحة:</label>
                                <p class="text-gray-900 mt-1">{{ $brand->meta_description }}</p>
                            </div>
                        @endif
                        
                        @if($brand->meta_keywords)
                            <div>
                                <label class="text-sm font-medium text-gray-700">الكلمات المفتاحية:</label>
                                <p class="text-gray-900 mt-1">{{ $brand->meta_keywords }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Products -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">منتجات العلامة التجارية</h3>
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    {{ $brand->products->count() }} منتج
                </span>
            </div>
            
            @if($brand->products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($brand->products->take(6) as $product)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            @if($product->images->first())
                                <img src="{{ $product->images->first()->image_url }}" alt="{{ $product->name }}" 
                                     class="w-full h-32 object-cover rounded-lg mb-3">
                            @else
                                <div class="w-full h-32 bg-gray-100 rounded-lg mb-3 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                            
                            <h4 class="font-medium text-gray-900 mb-2">{{ Str::limit($product->name, 30) }}</h4>
                            <p class="text-orange-600 font-bold mb-2">{{ number_format($product->price) }} ريال</p>
                            
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">المخزون: {{ $product->stock_quantity }}</span>
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="text-orange-600 hover:text-orange-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($brand->products->count() > 6)
                    <div class="mt-6 text-center">
                        <a href="{{ route('admin.products.index', ['brand' => $brand->id]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-eye ml-2"></i>
                            عرض جميع المنتجات ({{ $brand->products->count() }})
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-cube text-4xl mb-4"></i>
                    <p>لا توجد منتجات لهذه العلامة التجارية</p>
                    <a href="{{ route('admin.products.create', ['brand' => $brand->id]) }}" 
                       class="text-orange-500 hover:text-orange-700 mt-2 inline-block">
                        إضافة منتج جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">الإجراءات السريعة</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.brands.edit', $brand) }}" 
                   class="w-full bg-orange-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors block text-center">
                    <i class="fas fa-edit ml-2"></i>
                    تعديل العلامة التجارية
                </a>
                
                <form method="POST" action="{{ route('admin.brands.toggle-status', $brand) }}" class="w-full">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="w-full {{ $brand->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white py-2 px-4 rounded-lg font-medium transition-colors">
                        @if($brand->is_active)
                            <i class="fas fa-pause ml-2"></i>
                            إلغاء التفعيل
                        @else
                            <i class="fas fa-play ml-2"></i>
                            تفعيل
                        @endif
                    </button>
                </form>
                
                <a href="{{ route('admin.brands.index') }}" 
                   class="w-full bg-gray-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors block text-center">
                    <i class="fas fa-arrow-right ml-2"></i>
                    العودة للقائمة
                </a>
                
                <button type="button" onclick="deleteBrand()" 
                        class="w-full bg-red-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-600 transition-colors">
                    <i class="fas fa-trash ml-2"></i>
                    حذف العلامة التجارية
                </button>
            </div>
        </div>
        
        <!-- Brand Statistics -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">إحصائيات العلامة</h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">عدد المنتجات:</span>
                    <span class="font-bold text-blue-600">{{ $brand->products->count() }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">المنتجات النشطة:</span>
                    <span class="font-bold text-green-600">{{ $brand->products->where('is_active', true)->count() }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">المنتجات غير النشطة:</span>
                    <span class="font-bold text-red-600">{{ $brand->products->where('is_active', false)->count() }}</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">متوسط السعر:</span>
                    <span class="font-bold text-orange-600">
                        {{ $brand->products->count() > 0 ? number_format($brand->products->avg('price')) : '0' }} ريال
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">إجمالي المخزون:</span>
                    <span class="font-bold text-purple-600">{{ $brand->products->sum('stock_quantity') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Brand Details -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">تفاصيل العلامة</h3>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">معرف العلامة:</span>
                    <span class="font-medium">#{{ $brand->id }}</span>
                </div>
                
                @if($brand->sort_order !== null)
                    <div class="flex justify-between">
                        <span class="text-gray-600">ترتيب العرض:</span>
                        <span class="font-medium">{{ $brand->sort_order }}</span>
                    </div>
                @endif
                
                <div class="flex justify-between">
                    <span class="text-gray-600">تاريخ الإنشاء:</span>
                    <span class="font-medium">{{ $brand->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">آخر تحديث:</span>
                    <span class="font-medium">{{ $brand->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteBrand() {
        if (confirm('هل أنت متأكد من حذف هذه العلامة التجارية؟\n\nتحذير: سيتم حذف جميع المنتجات المرتبطة بهذه العلامة أيضاً.\nهذا الإجراء لا يمكن التراجع عنه.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.brands.destroy", $brand) }}';
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush




