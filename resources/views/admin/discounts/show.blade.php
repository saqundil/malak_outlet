@extends('admin.layout')

@section('title', 'تفاصيل الخصم')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="admin-card mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">تفاصيل الخصم</h1>
                <p class="text-gray-600 mt-1">عرض تفاصيل الخصم: {{ $discount->name }}</p>
            </div>
            <div class="flex space-x-3 space-x-reverse">
                <a href="{{ route('admin.discounts.edit', $discount) }}" class="btn-primary">
                    <i class="fas fa-edit mr-2"></i>
                    تعديل
                </a>
                <a href="{{ route('admin.discounts.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    عودة للقائمة
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="admin-card">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">المعلومات الأساسية</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">اسم الخصم</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $discount->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">كود الخصم</label>
                        <div class="flex items-center">
                            <code class="bg-gray-100 px-3 py-1 rounded text-lg font-mono">{{ $discount->code }}</code>
                            <button onclick="copyToClipboard('{{ $discount->code }}')" 
                                    class="mr-2 text-gray-500 hover:text-gray-700" 
                                    title="نسخ الكود">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">نوع الخصم</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                               {{ $discount->type === 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            <i class="fas {{ $discount->type === 'percentage' ? 'fa-percent' : 'fa-dollar-sign' }} mr-1"></i>
                            {{ $discount->type === 'percentage' ? 'نسبة مئوية' : 'مبلغ ثابت' }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">قيمة الخصم</label>
                        <p class="text-lg font-semibold text-gray-800">
                            {{ $discount->value }}{{ $discount->type === 'percentage' ? '%' : ' ريال' }}
                        </p>
                    </div>
                    
                    @if($discount->min_amount)
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">الحد الأدنى للمبلغ</label>
                        <p class="text-lg font-semibold text-gray-800">{{ number_format($discount->min_amount, 2) }} ريال</p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">الحالة</label>
                        <span class="badge {{ $discount->is_active ? 'badge-success' : 'badge-danger' }}">
                            <i class="fas {{ $discount->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                            {{ $discount->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </div>
                </div>
                
                @if($discount->description)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-600 mb-2">الوصف</label>
                    <p class="text-gray-800 bg-gray-50 p-3 rounded-lg">{{ $discount->description }}</p>
                </div>
                @endif
            </div>

            <!-- Date & Usage Info -->
            <div class="admin-card">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">معلومات التاريخ والاستخدام</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($discount->starts_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">تاريخ البداية</label>
                        <p class="text-gray-800">
                            <i class="fas fa-calendar-alt text-green-500 mr-2"></i>
                            {{ $discount->starts_at->format('Y-m-d H:i') }}
                        </p>
                    </div>
                    @endif
                    
                    @if($discount->expires_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">تاريخ الانتهاء</label>
                        <p class="text-gray-800">
                            <i class="fas fa-calendar-alt text-red-500 mr-2"></i>
                            {{ $discount->expires_at->format('Y-m-d H:i') }}
                        </p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">تم إنشاؤه</label>
                        <p class="text-gray-800">
                            <i class="fas fa-clock text-blue-500 mr-2"></i>
                            {{ $discount->created_at->format('Y-m-d H:i') }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">آخر تحديث</label>
                        <p class="text-gray-800">
                            <i class="fas fa-edit text-yellow-500 mr-2"></i>
                            {{ $discount->updated_at->format('Y-m-d H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Using This Discount -->
            @if($discount->orders && $discount->orders->count() > 0)
            <div class="admin-card">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">آخر الطلبات المستخدمة للخصم</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">رقم الطلب</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العميل</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجمالي الطلب</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">مبلغ الخصم</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($discount->orders->take(10) as $order)
                            <tr class="table-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        #{{ $order->id }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-800">{{ $order->customer_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->customer_email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    {{ number_format($order->total_amount, 2) }} ريال
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                                    -{{ number_format($order->discount_amount, 2) }} ريال
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('Y-m-d') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($discount->orders->count() > 10)
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.orders.index', ['discount_id' => $discount->id]) }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm">
                        عرض جميع الطلبات ({{ $discount->orders->count() }})
                    </a>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Usage Statistics -->
            <div class="admin-card">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">إحصائيات الاستخدام</h3>
                
                <div class="space-y-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600">{{ $discount->used_count }}</div>
                        <div class="text-sm text-gray-600">مرات الاستخدام</div>
                    </div>
                    
                    @if($discount->usage_limit)
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-3xl font-bold text-green-600">{{ $discount->usage_limit - $discount->used_count }}</div>
                        <div class="text-sm text-gray-600">الاستخدامات المتبقية</div>
                    </div>
                    
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" 
                             style="width: {{ ($discount->used_count / $discount->usage_limit) * 100 }}%"></div>
                    </div>
                    @endif
                    
                    @if($discount->orders)
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-3xl font-bold text-purple-600">{{ $discount->orders->count() }}</div>
                        <div class="text-sm text-gray-600">إجمالي الطلبات</div>
                    </div>
                    
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-3xl font-bold text-yellow-600">
                            {{ number_format($discount->orders->sum('discount_amount'), 2) }}
                        </div>
                        <div class="text-sm text-gray-600">إجمالي المبلغ المخصوم (ريال)</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-card">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">إجراءات سريعة</h3>
                
                <div class="space-y-3">
                    <form action="{{ route('admin.discounts.toggle', $discount) }}" method="POST" class="inline-block w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full {{ $discount->is_active ? 'btn-warning' : 'btn-success' }}">
                            <i class="fas {{ $discount->is_active ? 'fa-pause' : 'fa-play' }} mr-2"></i>
                            {{ $discount->is_active ? 'إيقاف الخصم' : 'تفعيل الخصم' }}
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.discounts.edit', $discount) }}" class="w-full btn-primary block text-center">
                        <i class="fas fa-edit mr-2"></i>
                        تعديل الخصم
                    </a>
                    
                    <form action="{{ route('admin.discounts.destroy', $discount) }}" 
                          method="POST" 
                          class="inline-block w-full"
                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الخصم؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full btn-danger">
                            <i class="fas fa-trash mr-2"></i>
                            حذف الخصم
                        </button>
                    </form>
                </div>
            </div>

            <!-- Status Info -->
            <div class="admin-card">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">حالة الخصم</h3>
                
                <div class="space-y-3">
                    @if($discount->is_active)
                        @if($discount->starts_at && $discount->starts_at->isFuture())
                            <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-clock text-yellow-600 mr-2"></i>
                                    <span class="text-yellow-800 text-sm">سيبدأ في {{ $discount->starts_at->format('Y-m-d H:i') }}</span>
                                </div>
                            </div>
                        @elseif($discount->expires_at && $discount->expires_at->isPast())
                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                                    <span class="text-red-800 text-sm">انتهت صلاحية الخصم</span>
                                </div>
                            </div>
                        @elseif($discount->usage_limit && $discount->used_count >= $discount->usage_limit)
                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-ban text-red-600 mr-2"></i>
                                    <span class="text-red-800 text-sm">وصل لحد الاستخدام الأقصى</span>
                                </div>
                            </div>
                        @else
                            <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                    <span class="text-green-800 text-sm">الخصم نشط ومتاح للاستخدام</span>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-pause text-gray-600 mr-2"></i>
                                <span class="text-gray-800 text-sm">الخصم غير نشط</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        toastr.success('تم نسخ الكود بنجاح!');
    }).catch(function(err) {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        toastr.success('تم نسخ الكود بنجاح!');
    });
}
</script>
@endsection
