<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Filter by user type
        if ($request->filled('user_type')) {
            if ($request->user_type === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->user_type === 'customer') {
                $query->where('is_admin', false);
            }
        }
        
        // Filter by date
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', Carbon::now()->startOfWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', Carbon::now()->startOfMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', Carbon::now()->startOfYear());
                    break;
            }
        }
        
        // Sorting
        $sortBy = $request->sort ?? 'newest';
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'email':
                $query->orderBy('email', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // Get statistics
        $activeUsers = User::where('is_active', true)->count();
        $adminUsers = User::where('is_admin', true)->count();
        $newUsersThisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        
        // Handle export
        if ($request->filled('export') && $request->export === 'excel') {
            return $this->exportUsers($query->get());
        }
        
        $users = $query->paginate(20);
        
        return view('admin.users.index', compact(
            'users', 
            'activeUsers', 
            'adminUsers', 
            'newUsersThisMonth'
        ));
    }
    
    public function show(User $user)
    {
        $user->load(['orders', 'reviews', 'favorites']);
        
        return view('admin.users.show', compact('user'));
    }
    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'email_verified' => ['nullable', 'boolean'],
        ]);
        
        $data = $request->only([
            'name', 'email', 'phone', 'date_of_birth', 'gender',
            'address', 'city', 'postal_code'
        ]);
        
        // Handle password change
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        // Handle admin-only fields
        if (auth()->user()->is_admin) {
            // Prevent self-demotion/deactivation
            if ($user->id !== auth()->id()) {
                $data['is_admin'] = $request->boolean('is_admin');
                $data['is_active'] = $request->boolean('is_active');
            }
            
            // Handle email verification
            if ($request->boolean('email_verified') && !$user->email_verified_at) {
                $data['email_verified_at'] = now();
            } elseif (!$request->boolean('email_verified') && $user->email_verified_at) {
                $data['email_verified_at'] = null;
            }
        }
        
        $user->update($data);
        
        return redirect()->route('admin.users.show', $user)
                        ->with('success', 'تم تحديث معلومات المستخدم بنجاح');
    }
    
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'لا يمكنك حذف حسابك الخاص');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
                        ->with('success', 'تم حذف المستخدم بنجاح');
    }
    
    public function toggleStatus(Request $request, User $user)
    {
        $request->validate([
            'is_active' => ['required', 'boolean']
        ]);
        
        // Prevent self-deactivation
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'لا يمكنك إلغاء تفعيل حسابك الخاص']);
        }
        
        $user->update(['is_active' => $request->is_active]);
        
        return response()->json(['success' => true]);
    }
    
    public function sendEmail(Request $request, User $user)
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string']
        ]);
        
        try {
            // Here you would implement your email sending logic
            // For now, we'll just return success
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'فشل في إرسال البريد الإلكتروني']);
        }
    }
    
    public function sendPasswordReset(User $user)
    {
        try {
            // Here you would implement password reset logic
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'فشل في إرسال رابط إعادة التعيين']);
        }
    }
    
    public function sendEmailVerification(User $user)
    {
        try {
            // Here you would implement email verification logic
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'فشل في إرسال رابط التأكيد']);
        }
    }
    
    public function bulkActivate(Request $request)
    {
        $userIds = explode(',', $request->user_ids);
        
        // Remove current user from the list to prevent self-deactivation issues
        $userIds = array_filter($userIds, function($id) {
            return $id != auth()->id();
        });
        
        User::whereIn('id', $userIds)->update(['is_active' => true]);
        
        return redirect()->back()->with('success', 'تم تفعيل المستخدمين المحددين بنجاح');
    }
    
    public function bulkDeactivate(Request $request)
    {
        $userIds = explode(',', $request->user_ids);
        
        // Remove current user from the list to prevent self-deactivation
        $userIds = array_filter($userIds, function($id) {
            return $id != auth()->id();
        });
        
        User::whereIn('id', $userIds)->update(['is_active' => false]);
        
        return redirect()->back()->with('success', 'تم إلغاء تفعيل المستخدمين المحددين بنجاح');
    }
    
    public function bulkDelete(Request $request)
    {
        $userIds = explode(',', $request->user_ids);
        
        // Remove current user from the list to prevent self-deletion
        $userIds = array_filter($userIds, function($id) {
            return $id != auth()->id();
        });
        
        User::whereIn('id', $userIds)->delete();
        
        return redirect()->back()->with('success', 'تم حذف المستخدمين المحددين بنجاح');
    }
    
    private function exportUsers($users)
    {
        $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Type', 'Status', 'Created At']);
            
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->is_admin ? 'Admin' : 'Customer',
                    $user->is_active ? 'Active' : 'Inactive',
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
