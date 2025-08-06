@extends('admin.layout')

@section('title', 'عرض المستخدم: ' . $user->name)
@section('page-title', 'عرض المستخدم')
@section('page-description', 'معلومات المستخدم: ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- User Header -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex justify-between items-start">
            <div class="flex items-center gap-6">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center">
                    <span class="text-orange-600 font-bold text-2xl">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </span>
                </div>
                
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                    @if($user->phone)
                        <p class="text-gray-600">{{ $user->phone }}</p>
                    @endif
                    
                    <div class="flex items-center gap-4 mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            @if($user->is_admin)
                                <i class="fas fa-crown ml-1"></i>
                                مدير
                            @else
                                <i class="fas fa-user ml-1"></i>
                                عميل
                            @endif
                        </span>
                        
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'نشط' : 'معطل' }}
                        </span>
                        
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle ml-1"></i>
                                بريد مؤكد
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-exclamation-circle ml-1"></i>
                                بريد غير مؤكد
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-edit ml-2"></i>
                    تعديل
                </a>
                
                @if($user->id !== auth()->id())
                    <button onclick="toggleUserStatus()" 
                            class="{{ $user->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }} ml-2"></i>
                        {{ $user->is_active ? 'إلغاء تفعيل' : 'تفعيل' }}
                    </button>
                    
                    <button onclick="deleteUser()" 
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                        <i class="fas fa-trash ml-2"></i>
                        حذف
                    </button>
                @endif
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">المعلومات الشخصية</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <span class="text-gray-600">الاسم الكامل:</span>
                        <span class="font-medium">{{ $user->name }}</span>
                    </div>
                    
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <span class="text-gray-600">البريد الإلكتروني:</span>
                        <span class="font-medium">{{ $user->email }}</span>
                    </div>
                    
                    @if($user->phone)
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">رقم الهاتف:</span>
                            <span class="font-medium">{{ $user->phone }}</span>
                        </div>
                    @endif
                    
                    @if($user->date_of_birth)
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">تاريخ الميلاد:</span>
                            <span class="font-medium">{{ $user->date_of_birth->format('d/m/Y') }}</span>
                        </div>
                    @endif
                    
                    @if($user->gender)
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">الجنس:</span>
                            <span class="font-medium">{{ $user->gender == 'male' ? 'ذكر' : 'أنثى' }}</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <span class="text-gray-600">تاريخ التسجيل:</span>
                        <span class="font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <span class="text-gray-600">آخر تحديث:</span>
                        <span class="font-medium">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    @if($user->last_login_at)
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">آخر تسجيل دخول:</span>
                            <span class="font-medium">{{ $user->last_login_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Address Information -->
            @if($user->address || $user->city || $user->postal_code)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">معلومات العنوان</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($user->address)
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">العنوان:</span>
                            <span class="font-medium">{{ $user->address }}</span>
                        </div>
                    @endif
                    
                    @if($user->city)
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">المدينة:</span>
                            <span class="font-medium">{{ $user->city }}</span>
                        </div>
                    @endif
                    
                    @if($user->postal_code)
                        <div class="flex justify-between py-3 border-b border-gray-100">
                            <span class="text-gray-600">الرمز البريدي:</span>
                            <span class="font-medium">{{ $user->postal_code }}</span>
                        </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Recent Orders -->
            @if(!$user->is_admin && $user->orders->count() > 0)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">الطلبات الأخيرة</h3>
                    <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" 
                       class="text-orange-500 hover:text-orange-700 text-sm font-medium">
                        عرض جميع الطلبات
                    </a>
                </div>
                
                <div class="space-y-4">
                    @foreach($user->orders->take(5) as $order)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">طلب رقم: #{{ $order->id }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="text-sm text-gray-600">عدد المنتجات: {{ $order->items->count() }}</p>
                                </div>
                                
                                <div class="text-left">
                                    <p class="text-lg font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} د.أ</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @switch($order->status)
                                            @case('pending') bg-yellow-100 text-yellow-800 @break
                                            @case('processing') bg-blue-100 text-blue-800 @break
                                            @case('shipped') bg-purple-100 text-purple-800 @break
                                            @case('delivered') bg-green-100 text-green-800 @break
                                            @case('cancelled') bg-red-100 text-red-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch">
                                        @switch($order->status)
                                            @case('pending') قيد الانتظار @break
                                            @case('processing') قيد المعالجة @break
                                            @case('shipped') تم الشحن @break
                                            @case('delivered') تم التوصيل @break
                                            @case('cancelled') ملغي @break
                                            @default {{ $order->status }}
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Recent Reviews -->
            @if(!$user->is_admin && $user->reviews->count() > 0)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">المراجعات الأخيرة</h3>
                
                <div class="space-y-4">
                    @foreach($user->reviews->take(5) as $review)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="font-medium text-gray-900">{{ $review->product->name }}</h4>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-gray-700 text-sm">{{ Str::limit($review->comment, 150) }}</p>
                                    @endif
                                </div>
                                
                                <div class="text-sm text-gray-500">
                                    {{ $review->created_at->format('d/m/Y') }}
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
            <!-- User Statistics -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">إحصائيات المستخدم</h3>
                
                <div class="space-y-4">
                    @if(!$user->is_admin)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">إجمالي الطلبات:</span>
                            <span class="font-bold text-2xl text-blue-600">{{ $user->orders->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">إجمالي المشتريات:</span>
                            <span class="font-bold text-2xl text-green-600">{{ number_format($user->orders->sum('total_amount'), 2) }} د.أ</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">المراجعات:</span>
                            <span class="font-bold text-2xl text-orange-600">{{ $user->reviews->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">قائمة الرغبات:</span>
                            <span class="font-bold text-2xl text-purple-600">{{ $user->favorites->count() }}</span>
                        </div>
                        
                        @if($user->orders->count() > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">متوسط قيمة الطلب:</span>
                                <span class="font-medium text-gray-900">{{ number_format($user->orders->avg('total_amount'), 2) }} د.أ</span>
                            </div>
                        @endif
                    @endif
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">عضو منذ:</span>
                        <span class="font-medium text-gray-900">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">إجراءات سريعة</h3>
                
                <div class="space-y-3">
                    @if(!$user->is_admin)
                        <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" 
                           class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-600 transition-colors block text-center">
                            <i class="fas fa-shopping-cart ml-2"></i>
                            عرض طلبات المستخدم
                        </a>
                    @endif
                    
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="w-full bg-orange-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors block text-center">
                        <i class="fas fa-edit ml-2"></i>
                        تعديل المستخدم
                    </a>
                    
                    @if($user->id !== auth()->id())
                        <button onclick="sendNotification()" 
                                class="w-full bg-green-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-green-600 transition-colors">
                            <i class="fas fa-bell ml-2"></i>
                            إرسال إشعار
                        </button>
                        
                        <button onclick="sendEmail()" 
                                class="w-full bg-purple-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-purple-600 transition-colors">
                            <i class="fas fa-envelope ml-2"></i>
                            إرسال بريد إلكتروني
                        </button>
                    @endif
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="w-full bg-gray-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors block text-center">
                        <i class="fas fa-arrow-left ml-2"></i>
                        العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div id="emailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 max-w-md w-full">
        <h3 class="text-lg font-medium text-gray-900 mb-4">إرسال بريد إلكتروني</h3>
        
        <form id="emailForm">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الموضوع</label>
                    <input type="text" name="subject" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الرسالة</label>
                    <textarea name="message" rows="4" required
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                </div>
            </div>
            
            <div class="flex gap-3 justify-end mt-6">
                <button type="button" onclick="closeEmailModal()" 
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                    إلغاء
                </button>
                <button type="submit" 
                        class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors">
                    إرسال
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleUserStatus() {
        const isActive = {{ $user->is_active ? 'true' : 'false' }};
        const action = isActive ? 'إلغاء تفعيل' : 'تفعيل';
        
        if (confirm(`هل أنت متأكد من ${action} هذا المستخدم؟`)) {
            fetch(`/admin/users/{{ $user->id }}/toggle-status`, {
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
                    alert('حدث خطأ أثناء تحديث حالة المستخدم');
                }
            })
            .catch(error => {
                alert('حدث خطأ أثناء تحديث حالة المستخدم');
            });
        }
    }
    
    function deleteUser() {
        if (confirm('هل أنت متأكد من حذف هذا المستخدم؟ لا يمكن التراجع عن هذا الإجراء.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/{{ $user->id }}`;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.innerHTML = `
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="_method" value="DELETE">
            `;
            
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function sendNotification() {
        // Placeholder for notification functionality
        alert('ستتم إضافة وظيفة الإشعارات قريباً');
    }
    
    function sendEmail() {
        document.getElementById('emailModal').classList.remove('hidden');
    }
    
    function closeEmailModal() {
        document.getElementById('emailModal').classList.add('hidden');
        document.getElementById('emailForm').reset();
    }
    
    document.getElementById('emailForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        fetch(`/admin/users/{{ $user->id }}/send-email`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('تم إرسال البريد الإلكتروني بنجاح');
                closeEmailModal();
            } else {
                alert('حدث خطأ أثناء إرسال البريد الإلكتروني');
            }
        })
        .catch(error => {
            alert('حدث خطأ أثناء إرسال البريد الإلكتروني');
        });
    });
    
    // Close modal when clicking outside
    document.getElementById('emailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEmailModal();
        }
    });
</script>
@endpush




