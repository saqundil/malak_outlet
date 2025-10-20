<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('products');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }
        
        // Sorting
        $sortBy = $request->sort ?? 'name';
        switch ($sortBy) {
            case 'products_count':
                $query->orderBy('products_count', 'desc');
                break;
            case 'created_at':
            case 'created_at_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_at_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'updated_at':
                $query->orderBy('updated_at', 'desc');
                break;
            case 'name_asc':
            default:
                $query->orderBy('name', 'asc');
                break;
        }
        
        // Get statistics
        $stats = [
            'total_categories' => Category::count(),
            'active_categories' => Category::where('is_active', true)->count(),
            'parent_categories' => Category::whereNull('parent_id')->count(),
            'total_products' => Product::count(),
        ];
        
        // Handle export
        if ($request->filled('export') && $request->export === 'excel') {
            return $this->exportCategories($query->get());
        }
        
        $categories = $query->paginate(20);
        
        return view('admin.categories.index', compact(
            'categories',
            'stats'
        ));
    }
    
    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
        ]);
        
        $data = $request->only([
            'name', 'description', 'sort_order', 
            'meta_title', 'meta_description', 'meta_keywords'
        ]);
        
        // Generate slug
        $data['slug'] = Str::slug($request->name);
        
        // Ensure unique slug
        $originalSlug = $data['slug'];
        $count = 1;
        while (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }
        
        $data['is_active'] = $request->boolean('is_active', true);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('categories', 'public');
            $data['image'] = Storage::url($imagePath);
        }
        
        $category = Category::create($data);
        
        return redirect()->route('admin.categories.show', $category)
                        ->with('success', 'تم إنشاء الفئة بنجاح');
    }
    
    public function show(Category $category)
    {
        $category->load(['products' => function($query) {
            $query->latest()->take(10);
        }]);
        
        $recentProducts = $category->products;
        $totalProducts = $category->products()->count();
        $activeProducts = $category->products()->where('is_active', true)->count();
        $totalRevenue = $category->products()
                                ->join('order_items', 'products.id', '=', 'order_items.product_id')
                                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                                ->where('orders.status', 'completed')
                                ->sum('order_items.total');
        
        return view('admin.categories.show', compact(
            'category',
            'recentProducts',
            'totalProducts',
            'activeProducts',
            'totalRevenue'
        ));
    }
    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
        ]);
        
        $data = $request->only([
            'name', 'description', 'sort_order',
            'meta_title', 'meta_description', 'meta_keywords'
        ]);
        
        // Update slug if name changed
        if ($request->name !== $category->name) {
            $data['slug'] = Str::slug($request->name);
            
            // Ensure unique slug
            $originalSlug = $data['slug'];
            $count = 1;
            while (Category::where('slug', $data['slug'])->where('id', '!=', $category->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $count;
                $count++;
            }
        }
        
        $data['is_active'] = $request->boolean('is_active');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                $oldImagePath = str_replace('/storage/', '', $category->image);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $image = $request->file('image');
            $imagePath = $image->store('categories', 'public');
            $data['image'] = Storage::url($imagePath);
        }
        
        $category->update($data);
        
        return redirect()->route('admin.categories.show', $category)
                        ->with('success', 'تم تحديث الفئة بنجاح');
    }
    
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'لا يمكن حذف الفئة لأنها تحتوي على منتجات. يرجى نقل المنتجات أو حذفها أولاً.');
        }
        
        // Delete image if exists
        if ($category->image) {
            $imagePath = str_replace('/storage/', '', $category->image);
            Storage::disk('public')->delete($imagePath);
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')
                        ->with('success', 'تم حذف الفئة بنجاح');
    }
    
    public function toggleStatus(Request $request, Category $category)
    {
        $request->validate([
            'is_active' => ['required', 'boolean']
        ]);
        
        $category->update(['is_active' => $request->is_active]);
        
        return response()->json(['success' => true]);
    }
    
    public function bulkActivate(Request $request)
    {
        $categoryIds = explode(',', $request->category_ids);
        Category::whereIn('id', $categoryIds)->update(['is_active' => true]);
        
        return redirect()->back()->with('success', 'تم تفعيل الفئات المحددة بنجاح');
    }
    
    public function bulkDeactivate(Request $request)
    {
        $categoryIds = explode(',', $request->category_ids);
        Category::whereIn('id', $categoryIds)->update(['is_active' => false]);
        
        return redirect()->back()->with('success', 'تم إلغاء تفعيل الفئات المحددة بنجاح');
    }
    
    public function bulkDelete(Request $request)
    {
        $categoryIds = explode(',', $request->category_ids);
        
        // Check if any categories have products
        $categoriesWithProducts = Category::whereIn('id', $categoryIds)
                                         ->whereHas('products')
                                         ->count();
        
        if ($categoriesWithProducts > 0) {
            return redirect()->back()
                           ->with('error', 'لا يمكن حذف بعض الفئات لأنها تحتوي على منتجات.');
        }
        
        // Delete images and categories
        $categories = Category::whereIn('id', $categoryIds)->get();
        foreach ($categories as $category) {
            if ($category->image) {
                $imagePath = str_replace('/storage/', '', $category->image);
                Storage::disk('public')->delete($imagePath);
            }
        }
        
        Category::whereIn('id', $categoryIds)->delete();
        
        return redirect()->back()->with('success', 'تم حذف الفئات المحددة بنجاح');
    }
    
    private function exportCategories($categories)
    {
        $filename = 'categories_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Slug', 'Description', 'Products Count', 'Status', 'Created At']);
            
            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->id,
                    $category->name,
                    $category->slug,
                    $category->description,
                    $category->products_count ?? 0,
                    $category->is_active ? 'Active' : 'Inactive',
                    $category->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get categories tree for AJAX requests
     */
    public function getTree()
    {
        try {
            $categories = Category::select('id', 'name', 'slug', 'parent_id', 'is_active')
                ->where('is_active', true)
                ->orderBy('parent_id')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في جلب الفئات'
            ], 500);
        }
    }
}
