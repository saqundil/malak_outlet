<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductReview::with(['user', 'product']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('product', function($productQuery) use ($search) {
                      $productQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'approved':
                    $query->where('is_approved', true);
                    break;
                case 'pending':
                    $query->where('is_approved', false);
                    break;
            }
        }
        
        // Sorting
        $sortBy = $request->sort ?? 'newest';
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating_high':
                $query->orderBy('rating', 'desc');
                break;
            case 'rating_low':
                $query->orderBy('rating', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $reviews = $query->paginate(20);
        
        // Get statistics
        $totalReviews = ProductReview::count();
        $pendingReviews = ProductReview::where('is_approved', false)->count();
        $averageRating = ProductReview::where('is_approved', true)->avg('rating');
        
        return view('admin.reviews.index', compact(
            'reviews',
            'totalReviews',
            'pendingReviews',
            'averageRating'
        ));
    }
    
    public function show(ProductReview $review)
    {
        $review->load(['user', 'product']);
        
        return view('admin.reviews.show', compact('review'));
    }
    
    public function approve(ProductReview $review)
    {
        $review->update(['is_approved' => true]);
        
        return response()->json(['success' => true]);
    }
    
    public function reject(ProductReview $review)
    {
        $review->update(['is_approved' => false]);
        
        return response()->json(['success' => true]);
    }
    
    public function destroy(ProductReview $review)
    {
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
                        ->with('success', 'تم حذف المراجعة بنجاح');
    }
    
    public function bulkAction(Request $request)
    {
        $reviewIds = explode(',', $request->review_ids);
        $action = $request->action;
        
        switch ($action) {
            case 'approve':
                ProductReview::whereIn('id', $reviewIds)->update(['is_approved' => true]);
                $message = 'تم الموافقة على المراجعات المحددة بنجاح';
                break;
                
            case 'reject':
                ProductReview::whereIn('id', $reviewIds)->update(['is_approved' => false]);
                $message = 'تم رفض المراجعات المحددة بنجاح';
                break;
                
            case 'delete':
                ProductReview::whereIn('id', $reviewIds)->delete();
                $message = 'تم حذف المراجعات المحددة بنجاح';
                break;
                
            default:
                return redirect()->back()->with('error', 'إجراء غير صحيح');
        }
        
        return redirect()->back()->with('success', $message);
    }
}
