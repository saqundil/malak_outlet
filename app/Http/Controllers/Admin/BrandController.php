<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::withCount('products');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
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
                $query->orderBy('created_at', 'desc');
                break;
            case 'updated_at':
                $query->orderBy('updated_at', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
                break;
        }
        
        $brands = $query->paginate(20);
        
        // Get statistics
        $activeBrands = Brand::where('is_active', true)->count();
        $totalProducts = Product::whereNotNull('brand_id')->count();
        
        return view('admin.brands.index', compact('brands', 'activeBrands', 'totalProducts'));
    }
    
    public function create()
    {
        return view('admin.brands.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands,name'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'website' => ['nullable', 'url'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        
        $data = $request->only(['name', 'description', 'website']);
        $data['is_active'] = $request->boolean('is_active', true);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('brands', 'public');
            $data['logo'] = Storage::url($logoPath);
        }
        
        $brand = Brand::create($data);
        
        return redirect()->route('admin.brands.show', $brand)
                        ->with('success', 'تم إنشاء العلامة التجارية بنجاح');
    }
    
    public function show(Brand $brand)
    {
        $brand->load(['products' => function($query) {
            $query->latest()->take(10);
        }]);
        
        $recentProducts = $brand->products;
        $totalProducts = $brand->products()->count();
        $activeProducts = $brand->products()->where('is_active', true)->count();
        
        return view('admin.brands.show', compact(
            'brand',
            'recentProducts',
            'totalProducts',
            'activeProducts'
        ));
    }
    
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }
    
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands,name,' . $brand->id],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'website' => ['nullable', 'url'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        
        $data = $request->only(['name', 'description', 'website']);
        $data['is_active'] = $request->boolean('is_active');
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($brand->logo) {
                $oldLogoPath = str_replace('/storage/', '', $brand->logo);
                Storage::disk('public')->delete($oldLogoPath);
            }
            
            $logo = $request->file('logo');
            $logoPath = $logo->store('brands', 'public');
            $data['logo'] = Storage::url($logoPath);
        }
        
        $brand->update($data);
        
        return redirect()->route('admin.brands.show', $brand)
                        ->with('success', 'تم تحديث العلامة التجارية بنجاح');
    }
    
    public function destroy(Brand $brand)
    {
        // Check if brand has products
        if ($brand->products()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'لا يمكن حذف العلامة التجارية لأنها مرتبطة بمنتجات. يرجى إزالة الربط أولاً.');
        }
        
        // Delete logo if exists
        if ($brand->logo) {
            $logoPath = str_replace('/storage/', '', $brand->logo);
            Storage::disk('public')->delete($logoPath);
        }
        
        $brand->delete();
        
        return redirect()->route('admin.brands.index')
                        ->with('success', 'تم حذف العلامة التجارية بنجاح');
    }
    
    public function toggleStatus(Request $request, Brand $brand)
    {
        $request->validate([
            'is_active' => ['required', 'boolean']
        ]);
        
        $brand->update(['is_active' => $request->is_active]);
        
        return response()->json(['success' => true]);
    }
    
    public function bulkAction(Request $request)
    {
        $brandIds = explode(',', $request->brand_ids);
        $action = $request->action;
        
        switch ($action) {
            case 'activate':
                Brand::whereIn('id', $brandIds)->update(['is_active' => true]);
                $message = 'تم تفعيل العلامات التجارية المحددة بنجاح';
                break;
                
            case 'deactivate':
                Brand::whereIn('id', $brandIds)->update(['is_active' => false]);
                $message = 'تم إلغاء تفعيل العلامات التجارية المحددة بنجاح';
                break;
                
            case 'delete':
                // Check if any brands have products
                $brandsWithProducts = Brand::whereIn('id', $brandIds)
                                          ->whereHas('products')
                                          ->count();
                
                if ($brandsWithProducts > 0) {
                    return redirect()->back()
                                   ->with('error', 'لا يمكن حذف بعض العلامات التجارية لأنها مرتبطة بمنتجات.');
                }
                
                // Delete logos and brands
                $brands = Brand::whereIn('id', $brandIds)->get();
                foreach ($brands as $brand) {
                    if ($brand->logo) {
                        $logoPath = str_replace('/storage/', '', $brand->logo);
                        Storage::disk('public')->delete($logoPath);
                    }
                }
                
                Brand::whereIn('id', $brandIds)->delete();
                $message = 'تم حذف العلامات التجارية المحددة بنجاح';
                break;
                
            default:
                return redirect()->back()->with('error', 'إجراء غير صحيح');
        }
        
        return redirect()->back()->with('success', $message);
    }
}
