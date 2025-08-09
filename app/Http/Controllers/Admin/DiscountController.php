<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $query = Discount::with(['products', 'categories']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)->where('is_deleted', false);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false)->where('is_deleted', false);
            } elseif ($request->status === 'deleted') {
                $query->where('is_deleted', true);
            }
        } else {
            $query->where('is_deleted', false);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        // Handle combined sort values from the view
        if ($sortBy === 'created_at_desc') {
            $sortBy = 'created_at';
            $sortDirection = 'desc';
        } elseif ($sortBy === 'created_at_asc') {
            $sortBy = 'created_at';
            $sortDirection = 'asc';
        } elseif ($sortBy === 'name_asc') {
            $sortBy = 'name';
            $sortDirection = 'asc';
        } elseif ($sortBy === 'name_desc') {
            $sortBy = 'name';
            $sortDirection = 'desc';
        }
        
        $query->orderBy($sortBy, $sortDirection);

        $discounts = $query->paginate(15);

        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        $products = Product::active()->orderBy('name')->get(['id', 'name', 'price']);
        $categories = Category::active()->orderBy('name')->get(['id', 'name']);
        $brands = Brand::active()->orderBy('name')->get(['id', 'name']);

        return view('admin.discounts.create', compact('products', 'categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'nullable|string|max:50|unique:discounts,code',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
            'apply_to' => 'required|in:all_products,specific_products,specific_categories',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Validate percentage discounts
        if ($validated['type'] === 'percentage' && $validated['value'] > 100) {
            return back()->withErrors(['value' => 'Percentage discount cannot exceed 100%'])->withInput();
        }

        DB::beginTransaction();
        try {
            $discount = Discount::create($validated);

            // Handle product associations
            if ($validated['apply_to'] === 'specific_products' && !empty($validated['product_ids'])) {
                $discount->products()->attach($validated['product_ids']);
            }

            // Handle category associations
            if ($validated['apply_to'] === 'specific_categories' && !empty($validated['category_ids'])) {
                $discount->categories()->attach($validated['category_ids']);
            }

            DB::commit();

            return redirect()->route('admin.discounts.index')
                           ->with('success', 'Discount created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating discount: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create discount.'])->withInput();
        }
    }

    public function show(Discount $discount)
    {
        $discount->load(['products', 'categories']);
        
        // Get usage statistics
        $stats = [
            'products_count' => $discount->products()->count(),
            'categories_count' => $discount->categories()->count(),
            'total_usage' => $discount->used_count ?? 0,
            'remaining_usage' => $discount->usage_limit ? max(0, $discount->usage_limit - ($discount->used_count ?? 0)) : null,
        ];

        return view('admin.discounts.show', compact('discount', 'stats'));
    }

    public function edit(Discount $discount)
    {
        $discount->load(['products', 'categories']);
        $products = Product::active()->orderBy('name')->get(['id', 'name', 'price']);
        $categories = Category::active()->orderBy('name')->get(['id', 'name']);
        $brands = Brand::active()->orderBy('name')->get(['id', 'name']);

        return view('admin.discounts.edit', compact('discount', 'products', 'categories', 'brands'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'nullable|string|max:50|unique:discounts,code,' . $discount->id,
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
            'apply_to' => 'required|in:all_products,specific_products,specific_categories',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Validate percentage discounts
        if ($validated['type'] === 'percentage' && $validated['value'] > 100) {
            return back()->withErrors(['value' => 'Percentage discount cannot exceed 100%'])->withInput();
        }

        DB::beginTransaction();
        try {
            $discount->update($validated);

            // Update product associations
            if ($validated['apply_to'] === 'specific_products') {
                $discount->products()->sync($validated['product_ids'] ?? []);
            } else {
                $discount->products()->detach();
            }

            // Update category associations
            if ($validated['apply_to'] === 'specific_categories') {
                $discount->categories()->sync($validated['category_ids'] ?? []);
            } else {
                $discount->categories()->detach();
            }

            DB::commit();

            return redirect()->route('admin.discounts.index')
                           ->with('success', 'Discount updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating discount: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update discount.'])->withInput();
        }
    }

    public function destroy(Discount $discount)
    {
        try {
            // Soft delete
            $discount->update(['is_deleted' => true, 'is_active' => false]);
            
            return redirect()->route('admin.discounts.index')
                           ->with('success', 'Discount deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting discount: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete discount.']);
        }
    }

    public function toggleStatus(Discount $discount)
    {
        try {
            $discount->update(['is_active' => !$discount->is_active]);
            
            $status = $discount->is_active ? 'activated' : 'deactivated';
            return response()->json([
                'success' => true,
                'message' => "Discount {$status} successfully!",
                'status' => $discount->is_active
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling discount status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update discount status.'
            ], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:discounts,id'
        ]);

        try {
            $count = 0;
            foreach ($validated['selected_items'] as $discountId) {
                $discount = Discount::find($discountId);
                if ($discount) {
                    switch ($validated['action']) {
                        case 'activate':
                            $discount->update(['is_active' => true]);
                            break;
                        case 'deactivate':
                            $discount->update(['is_active' => false]);
                            break;
                        case 'delete':
                            $discount->update(['is_deleted' => true, 'is_active' => false]);
                            break;
                    }
                    $count++;
                }
            }

            $action = ucfirst($validated['action']);
            if ($validated['action'] === 'activate') $action = 'Activated';
            if ($validated['action'] === 'deactivate') $action = 'Deactivated';
            if ($validated['action'] === 'delete') $action = 'Deleted';

            return response()->json([
                'success' => true,
                'message' => "{$action} {$count} discount(s) successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('Error in bulk action: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to perform bulk action.'
            ], 500);
        }
    }

    public function applyToProducts(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'exists:products,id'
        ]);

        try {
            $discount->products()->syncWithoutDetaching($validated['product_ids']);
            
            return response()->json([
                'success' => true,
                'message' => 'Discount applied to selected products successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error applying discount to products: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to apply discount to products.'
            ], 500);
        }
    }

    public function applyToCategories(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id'
        ]);

        try {
            $discount->categories()->syncWithoutDetaching($validated['category_ids']);
            
            return response()->json([
                'success' => true,
                'message' => 'Discount applied to selected categories successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error applying discount to categories: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to apply discount to categories.'
            ], 500);
        }
    }
}
