@extends('admin.layout')

@section('title', 'تعديل المستخدم: ' . $user->name)
@section('page-title', 'تعديل المستخدم')
@section('page-description', 'تعديل معلومات المستخدم: ' . $user->name)

@section('content')
<form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">المعلومات الأساسية</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الاسم الكامل *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الميلاد</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('date_of_birth')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الجنس</label>
                        <select name="gender" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">غير محدد</option>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Address Information -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">معلومات العنوان</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">العنوان</label>
                        <textarea name="address" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">المدينة</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">الرمز البريدي</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('postal_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Password Change -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">تغيير كلمة المرور</h3>
                <p class="text-sm text-gray-600 mb-4">اتركه فارغاً إذا كنت لا تريد تغيير كلمة المرور</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور الجديدة</label>
                        <input type="password" name="password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>
            </div>
            
            <!-- Additional Settings (for admins) -->
            @if(auth()->user()->is_admin)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">إعدادات إضافية</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-700">مدير النظام</label>
                            <p class="text-xs text-gray-500">منح المستخدم صلاحيات الإدارة</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                                   class="sr-only peer" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-700">حساب نشط</label>
                            <p class="text-xs text-gray-500">تفعيل أو إلغاء تفعيل الحساب</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   class="sr-only peer" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-medium text-gray-700">البريد الإلكتروني مؤكد</label>
                            <p class="text-xs text-gray-500">تحديد حالة تأكيد البريد الإلكتروني</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="email_verified" value="1" {{ old('email_verified', $user->email_verified_at ? 1 : 0) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-500"></div>
                        </label>
                    </div>
                </div>
                
                @if($user->id === auth()->id())
                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-yellow-400 mt-0.5 ml-2"></i>
                            <div class="text-sm text-yellow-700">
                                لا يمكنك تعديل صلاحياتك الخاصة أو إلغاء تفعيل حسابك.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- User Info Summary -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات المستخدم</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">تاريخ التسجيل:</span>
                        <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">آخر تحديث:</span>
                        <span class="font-medium">{{ $user->updated_at->format('d/m/Y') }}</span>
                    </div>
                    
                    @if($user->last_login_at)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">آخر دخول:</span>
                            <span class="font-medium">{{ $user->last_login_at->diffForHumans() }}</span>
                        </div>
                    @endif
                    
                    @if(!$user->is_admin)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">عدد الطلبات:</span>
                            <span class="font-medium">{{ $user->orders->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">إجمالي المشتريات:</span>
                            <span class="font-medium">{{ number_format($user->orders->sum('total_amount'), 2) }} د.أ</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="space-y-3">
                    <button type="submit" 
                            class="w-full bg-orange-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-orange-600 transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        حفظ التغييرات
                    </button>
                    
                    <a href="{{ route('admin.users.show', $user) }}" 
                       class="w-full bg-blue-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-600 transition-colors block text-center">
                        <i class="fas fa-eye ml-2"></i>
                        عرض المستخدم
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="w-full bg-gray-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-gray-600 transition-colors block text-center">
                        <i class="fas fa-times ml-2"></i>
                        إلغاء
                    </a>
                </div>
                
                @if($user->id !== auth()->id())
                    <hr class="my-4">
                    
                    <div class="space-y-2">
                        <button type="button" onclick="sendPasswordReset()" 
                                class="w-full bg-purple-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-purple-600 transition-colors text-sm">
                            <i class="fas fa-key ml-2"></i>
                            إرسال رابط إعادة تعيين كلمة المرور
                        </button>
                        
                        <button type="button" onclick="sendEmailVerification()" 
                                class="w-full bg-green-500 text-white py-2 px-4 rounded-lg font-medium hover:bg-green-600 transition-colors text-sm">
                            <i class="fas fa-envelope-check ml-2"></i>
                            إرسال رابط تأكيد البريد الإلكتروني
                        </button>
                    </div>
                @endif
            </div>
            
            <!-- Security Info -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">معلومات الأمان</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">البريد الإلكتروني:</span>
                        <span class="text-sm font-medium {{ $user->email_verified_at ? 'text-green-600' : 'text-red-600' }}">
                            {{ $user->email_verified_at ? 'مؤكد' : 'غير مؤكد' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">حالة الحساب:</span>
                        <span class="text-sm font-medium {{ $user->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $user->is_active ? 'نشط' : 'معطل' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">نوع المستخدم:</span>
                        <span class="text-sm font-medium {{ $user->is_admin ? 'text-purple-600' : 'text-blue-600' }}">
                            {{ $user->is_admin ? 'مدير' : 'عميل' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    function sendPasswordReset() {
        if (confirm('هل أنت متأكد من إرسال رابط إعادة تعيين كلمة المرور؟')) {
            fetch(`/admin/users/{{ $user->id }}/send-password-reset`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('تم إرسال رابط إعادة تعيين كلمة المرور بنجاح');
                } else {
                    alert('حدث خطأ أثناء إرسال الرابط');
                }
            })
            .catch(error => {
                alert('حدث خطأ أثناء إرسال الرابط');
            });
        }
    }
    
    function sendEmailVerification() {
        if (confirm('هل أنت متأكد من إرسال رابط تأكيد البريد الإلكتروني؟')) {
            fetch(`/admin/users/{{ $user->id }}/send-email-verification`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('تم إرسال رابط تأكيد البريد الإلكتروني بنجاح');
                } else {
                    alert('حدث خطأ أثناء إرسال الرابط');
                }
            })
            .catch(error => {
                alert('حدث خطأ أثناء إرسال الرابط');
            });
        }
    }
</script>
@endpush




