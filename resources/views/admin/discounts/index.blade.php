@extends('admin.layout')

@section('title', 'إدارة الخصومات')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-percentage mr-2"></i>
            إدارة الخصومات
        </h1>
        <div class="d-sm-flex gap-2">
            <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i>
                إضافة خصم جديد
            </a>
            <button type="button" class="btn btn-secondary shadow-sm" id="bulkActionBtn" disabled>
                <i class="fas fa-tasks fa-sm text-white-50"></i>
                إجراءات متعددة
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.discounts.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">البحث</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="البحث في الأسماء والأكواد">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">الحالة</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">جميع الحالات</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>مفعل</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير مفعل</option>
                        <option value="deleted" {{ request('status') == 'deleted' ? 'selected' : '' }}>محذوف</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="type" class="form-label">النوع</label>
                    <select class="form-control" id="type" name="type">
                        <option value="">جميع الأنواع</option>
                        <option value="percentage" {{ request('type') == 'percentage' ? 'selected' : '' }}>نسبة مئوية</option>
                        <option value="fixed_amount" {{ request('type') == 'fixed_amount' ? 'selected' : '' }}>مبلغ ثابت</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="sort" class="form-label">الترتيب</label>
                    <select class="form-control" id="sort" name="sort">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>الاسم</option>
                        <option value="value" {{ request('sort') == 'value' ? 'selected' : '' }}>القيمة</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="direction" class="form-label">الاتجاه</label>
                    <select class="form-control" id="direction" name="direction">
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Discounts Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                قائمة الخصومات ({{ $discounts->total() }} خصم)
            </h6>
        </div>
        <div class="card-body">
            @if($discounts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="discountsTable">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>الاسم</th>
                                <th>الكود</th>
                                <th>النوع</th>
                                <th>القيمة</th>
                                <th>يطبق على</th>
                                <th>الحالة</th>
                                <th>انتهاء الصلاحية</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($discounts as $discount)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="discount-checkbox" value="{{ $discount->id }}">
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-primary">{{ $discount->name }}</div>
                                        @if($discount->description)
                                            <small class="text-muted">{{ Str::limit($discount->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($discount->code)
                                            <code class="badge badge-secondary">{{ $discount->code }}</code>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($discount->type == 'percentage')
                                            <span class="badge badge-success">نسبة مئوية</span>
                                        @else
                                            <span class="badge badge-info">مبلغ ثابت</span>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold">
                                        @if($discount->type == 'percentage')
                                            {{ $discount->value }}%
                                        @else
                                            {{ number_format($discount->value, 2) }} د.أ
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            @if($discount->apply_to == 'all_products')
                                                جميع المنتجات
                                            @elseif($discount->apply_to == 'specific_products')
                                                {{ $discount->products->count() }} منتج
                                            @else
                                                {{ $discount->categories->count() }} فئة
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input status-toggle" 
                                                   id="status{{ $discount->id }}" 
                                                   data-id="{{ $discount->id }}"
                                                   {{ $discount->is_active ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status{{ $discount->id }}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        @if($discount->ends_at)
                                            @if($discount->ends_at->isPast())
                                                <span class="badge badge-danger">منتهي</span>
                                            @else
                                                <small class="text-success">{{ $discount->ends_at->format('Y-m-d') }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">غير محدد</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.discounts.show', $discount) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.discounts.edit', $discount) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.discounts.destroy', $discount) }}" 
                                                  class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $discounts->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-percentage fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-500">لا توجد خصومات</h5>
                    <p class="text-gray-400">لم يتم العثور على أي خصومات بناءً على الفلاتر المحددة</p>
                    <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        إضافة خصم جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إجراءات متعددة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bulkActionForm">
                    <div class="form-group">
                        <label for="bulkAction">اختر الإجراء</label>
                        <select class="form-control" id="bulkAction" name="action" required>
                            <option value="">اختر إجراءً</option>
                            <option value="activate">تفعيل</option>
                            <option value="deactivate">إلغاء تفعيل</option>
                            <option value="delete">حذف</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <strong id="selectedCount">0</strong> خصم محدد
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="executeBulkAction">تنفيذ</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Select all checkbox
    $('#selectAll').change(function() {
        $('.discount-checkbox').prop('checked', $(this).is(':checked'));
        updateBulkActionButton();
    });

    // Individual checkbox change
    $('.discount-checkbox').change(function() {
        updateBulkActionButton();
    });

    // Status toggle
    $('.status-toggle').change(function() {
        const discountId = $(this).data('id');
        const isActive = $(this).is(':checked');
        
        $.post(`/admin/discounts/${discountId}/toggle-status`, {
            _token: '{{ csrf_token() }}',
            is_active: isActive
        }).done(function(response) {
            if (response.success) {
                toastr.success(response.message);
            }
        }).fail(function() {
            toastr.error('حدث خطأ أثناء تحديث الحالة');
        });
    });

    // Bulk action button
    $('#bulkActionBtn').click(function() {
        const selectedIds = $('.discount-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        $('#selectedCount').text(selectedIds.length);
        $('#bulkActionModal').modal('show');
    });

    // Execute bulk action
    $('#executeBulkAction').click(function() {
        const action = $('#bulkAction').val();
        const selectedIds = $('.discount-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (!action) {
            toastr.error('يرجى اختيار إجراء');
            return;
        }

        $.post('{{ route("admin.discounts.bulk-action") }}', {
            _token: '{{ csrf_token() }}',
            action: action,
            selected_items: selectedIds
        }).done(function(response) {
            if (response.success) {
                toastr.success(response.message);
                location.reload();
            }
        }).fail(function() {
            toastr.error('حدث خطأ أثناء تنفيذ الإجراء');
        });

        $('#bulkActionModal').modal('hide');
    });

    function updateBulkActionButton() {
        const checkedCount = $('.discount-checkbox:checked').length;
        $('#bulkActionBtn').prop('disabled', checkedCount === 0);
    }
});
</script>
@endsection
