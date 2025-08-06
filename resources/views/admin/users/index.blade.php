@extends('admin.layout')

@section('title', 'إدارة المستخدمين')
@section('page-title', 'إدارة المستخدمين')
@section('page-description', 'عرض وإدارة جميع المستخدمين المسجلين في النظام')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">إجمالي المستخدمين</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $users->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-check text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">المستخدمين النشطين</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeUsers }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-crown text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">المدراء</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $adminUsers }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus text-orange-600 text-xl"></i>
                    </div>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">مستخدمين جدد هذا الشهر</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $newUsersThisMonth }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters and Search -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">البحث</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="البحث بالاسم أو البريد الإلكتروني..."
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نوع المستخدم</label>
                    <select name="user_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">الكل</option>
                        <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>مدراء</option>
                        <option value="customer" {{ request('user_type') == 'customer' ? 'selected' : '' }}>عملاء</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ التسجيل</label>
                    <select name="date_filter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="">الكل</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>اليوم</option>
                        <option value="week" {{ request('date_filter') == 'week' ? 'selected' : '' }}>هذا الأسبوع</option>
                        <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>هذا الشهر</option>
                        <option value="year" {{ request('date_filter') == 'year' ? 'selected' : '' }}>هذا العام</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ترتيب حسب</label>
                    <select name="sort" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>الأقدم</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>الاسم</option>
                        <option value="email" {{ request('sort') == 'email' ? 'selected' : '' }}>البريد الإلكتروني</option>
                    </select>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors">
                    <i class="fas fa-search ml-2"></i>
                    البحث
                </button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-undo ml-2"></i>
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>
    
    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">قائمة المستخدمين</h3>
                
                @if($users->count() > 0)
                    <div class="flex gap-3">
                        <button onclick="exportUsers()" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                            <i class="fas fa-download ml-2"></i>
                            تصدير Excel
                        </button>
                        <button onclick="toggleBulkActions()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-tasks ml-2"></i>
                            إجراءات متعددة
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
        @if($users->count() > 0)
            <!-- Bulk Actions (hidden by default) -->
            <div id="bulk-actions" class="p-4 bg-gray-50 border-b border-gray-200 hidden">
                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="select-all" class="rounded border-gray-300">
                        <span class="mr-2 text-sm text-gray-700">تحديد الكل</span>
                    </label>
                    
                    <div class="flex gap-2">
                        <button onclick="bulkAction('activate')" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                            تفعيل المحدد
                        </button>
                        <button onclick="bulkAction('deactivate')" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                            إلغاء تفعيل المحدد
                        </button>
                        <button onclick="bulkAction('delete')" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                            حذف المحدد
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" class="bulk-select-toggle rounded border-gray-300 hidden">
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                المستخدم
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                البريد الإلكتروني
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                النوع
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                تاريخ التسجيل
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                آخر نشاط
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الحالة
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" class="bulk-select-item rounded border-gray-300 hidden" value="{{ $user->id }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                                <span class="text-orange-600 font-medium text-sm">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            @if($user->phone)
                                                <div class="text-sm text-gray-500">{{ $user->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                    @if($user->email_verified_at)
                                        <div class="text-xs text-green-600">مؤكد</div>
                                    @else
                                        <div class="text-xs text-red-600">غير مؤكد</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        @if($user->is_admin)
                                            <i class="fas fa-crown ml-1"></i>
                                            مدير
                                        @else
                                            <i class="fas fa-user ml-1"></i>
                                            عميل
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y') }}
                                    <div class="text-xs text-gray-400">{{ $user->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($user->last_login_at)
                                        {{ $user->last_login_at->diffForHumans() }}
                                    @else
                                        لم يسجل دخول
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->is_active ? 'نشط' : 'معطل' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="text-blue-600 hover:text-blue-900" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="text-orange-600 hover:text-orange-900" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <button onclick="toggleUserStatus({{ $user->id }}, {{ $user->is_active ? 'false' : 'true' }})" 
                                                    class="{{ $user->is_active ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }}" 
                                                    title="{{ $user->is_active ? 'إلغاء تفعيل' : 'تفعيل' }}">
                                                <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                            </button>
                                            <button onclick="deleteUser({{ $user->id }})" 
                                                    class="text-red-600 hover:text-red-900" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-users text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد مستخدمين</h3>
                <p class="text-gray-500">لم يتم العثور على أي مستخدمين يطابقون معايير البحث.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleBulkActions() {
        const bulkActions = document.getElementById('bulk-actions');
        const checkboxes = document.querySelectorAll('.bulk-select-item, .bulk-select-toggle');
        
        if (bulkActions.classList.contains('hidden')) {
            bulkActions.classList.remove('hidden');
            checkboxes.forEach(cb => cb.classList.remove('hidden'));
        } else {
            bulkActions.classList.add('hidden');
            checkboxes.forEach(cb => cb.classList.add('hidden'));
            // Uncheck all
            checkboxes.forEach(cb => cb.checked = false);
        }
    }
    
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.bulk-select-item');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
    
    function bulkAction(action) {
        const selected = Array.from(document.querySelectorAll('.bulk-select-item:checked')).map(cb => cb.value);
        
        if (selected.length === 0) {
            alert('يرجى تحديد المستخدمين أولاً');
            return;
        }
        
        let message = '';
        switch(action) {
            case 'activate':
                message = `تفعيل ${selected.length} مستخدم؟`;
                break;
            case 'deactivate':
                message = `إلغاء تفعيل ${selected.length} مستخدم؟`;
                break;
            case 'delete':
                message = `حذف ${selected.length} مستخدم؟ لا يمكن التراجع عن هذا الإجراء.`;
                break;
        }
        
        if (confirm(message)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/bulk-${action}`;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.innerHTML = `
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="user_ids" value="${selected.join(',')}">
            `;
            
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function toggleUserStatus(userId, newStatus) {
        const action = newStatus === 'true' ? 'تفعيل' : 'إلغاء تفعيل';
        
        if (confirm(`هل أنت متأكد من ${action} هذا المستخدم؟`)) {
            fetch(`/admin/users/${userId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ is_active: newStatus === 'true' })
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
    
    function deleteUser(userId) {
        if (confirm('هل أنت متأكد من حذف هذا المستخدم؟ لا يمكن التراجع عن هذا الإجراء.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${userId}`;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.innerHTML = `
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="_method" value="DELETE">
            `;
            
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function exportUsers() {
        const params = new URLSearchParams(window.location.search);
        params.set('export', 'excel');
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }
</script>
@endpush




