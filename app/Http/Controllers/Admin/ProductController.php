<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images', 'discounts']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
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

        // Filter by stock status
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('quantity', '>', 0);
                    break;
                case 'low_stock':
                    $query->where('quantity', '>', 0)->where('quantity', '<=', 10);
                    break;
                case 'out_of_stock':
                    $query->where('quantity', '=', 0);
                    break;
            }
        }

        // Filter by discounts
        if ($request->filled('has_discount')) {
            if ($request->has_discount === 'yes') {
                $query->whereHas('discounts', function($q) {
                    $q->where('is_active', true);
                });
            } elseif ($request->has_discount === 'no') {
                $query->whereDoesntHave('discounts', function($q) {
                    $q->where('is_active', true);
                });
            }
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
        } elseif ($sortBy === 'price_asc') {
            $sortBy = 'price';
            $sortDirection = 'asc';
        } elseif ($sortBy === 'price_desc') {
            $sortBy = 'price';
            $sortDirection = 'desc';
        }
        
        if ($sortBy === 'category') {
            $query->join('categories', 'products.category_id', '=', 'categories.id')
                  ->select('products.*')
                  ->orderBy('categories.name', $sortDirection);
        } elseif ($sortBy === 'brand') {
            $query->join('brands', 'products.brand_id', '=', 'brands.id')
                  ->select('products.*')
                  ->orderBy('brands.name', $sortDirection);
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $products = $query->paginate(20);

        // Get filter options
        $categories = Category::active()->orderBy('name')->get(['id', 'name']);
        $brands = Brand::active()->orderBy('name')->get(['id', 'name']);

        // Get statistics
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->where('is_deleted', false)->count(),
            'inactive_products' => Product::where('is_active', false)->where('is_deleted', false)->count(),
            'low_stock_products' => Product::where('quantity', '<=', 10)->where('quantity', '>', 0)->count(),
            'out_of_stock_products' => Product::where('quantity', 0)->count(),
            'featured_products' => Product::where('is_featured', true)->where('is_deleted', false)->count(),
            'total_revenue' => Product::join('order_items', 'products.id', '=', 'order_items.product_id')
                                   ->join('orders', 'order_items.order_id', '=', 'orders.id')
                                   ->where('orders.status', 'completed')
                                   ->sum('order_items.total'),
        ];

        return view('admin.products.index', compact('products', 'categories', 'brands', 'stats'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('name')->get(['id', 'name']);
        $brands = Brand::active()->orderBy('name')->get(['id', 'name']);
        $discounts = Discount::active()->orderBy('name')->get(['id', 'name', 'type', 'value']);

        return view('admin.products.create', compact('categories', 'brands', 'discounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'stock_quantity' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*' => 'string|max:10',
            'discount_ids' => 'nullable|array',
            'discount_ids.*' => 'exists:discounts,id',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        
        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Generate SKU if not provided
        if (empty($validated['sku'])) {
            $validated['sku'] = 'PRD-' . strtoupper(Str::random(8));
        }

        DB::beginTransaction();
        try {
            $product = Product::create($validated);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('products', $filename, 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $index === 0
                    ]);
                }
            }

            // Handle sizes
            if (!empty($validated['sizes'])) {
                foreach ($validated['sizes'] as $size) {
                    ProductSize::create([
                        'product_id' => $product->id,
                        'size' => $size,
                        'quantity' => $validated['stock_quantity'] // Default to same as stock
                    ]);
                }
            }

            // Handle discount associations
            if (!empty($validated['discount_ids'])) {
                $product->discounts()->attach($validated['discount_ids']);
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                           ->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating product: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create product.'])->withInput();
        }
    }

    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'images', 'sizes', 'discounts' => function($query) {
            $query->where('is_active', true);
        }, 'reviews']);

        // Get product statistics
        $stats = [
            'total_views' => $product->views ?? 0,
            'total_orders' => $product->orders()->distinct()->count(),
            'average_rating' => $product->reviews()->avg('rating') ?? 0,
            'total_reviews' => $product->reviews()->count(),
            'revenue' => $product->orders()->where('status', 'completed')->sum('total_amount'),
        ];

        return view('admin.products.show', compact('product', 'stats'));
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'sizes', 'discounts']);
        $categories = Category::active()->orderBy('name')->get(['id', 'name']);
        $brands = Brand::active()->orderBy('name')->get(['id', 'name']);
        $discounts = Discount::active()->orderBy('name')->get(['id', 'name', 'type', 'value']);

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'discounts'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'stock_quantity' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*' => 'string|max:10',
            'discount_ids' => 'nullable|array',
            'discount_ids.*' => 'exists:discounts,id',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'exists:product_images,id',
        ]);

        // Update slug if name changed
        if ($product->name !== $validated['name']) {
            $baseSlug = Str::slug($validated['name']);
            $validated['slug'] = $baseSlug;
            
            $counter = 1;
            while (Product::where('slug', $validated['slug'])->where('id', '!=', $product->id)->exists()) {
                $validated['slug'] = $baseSlug . '-' . $counter;
                $counter++;
            }
        }

        DB::beginTransaction();
        try {
            $product->update($validated);

            // Handle image removal
            if (!empty($validated['remove_images'])) {
                $imagesToRemove = ProductImage::whereIn('id', $validated['remove_images'])->get();
                foreach ($imagesToRemove as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            // Handle new image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('products', $filename, 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $product->images()->count() === 0 && $index === 0
                    ]);
                }
            }

            // Handle sizes update
            if (isset($validated['sizes'])) {
                // Remove existing sizes
                $product->sizes()->delete();
                
                // Add new sizes
                foreach ($validated['sizes'] as $size) {
                    ProductSize::create([
                        'product_id' => $product->id,
                        'size' => $size,
                        'quantity' => $validated['stock_quantity']
                    ]);
                }
            }

            // Handle discount associations
            $product->discounts()->sync($validated['discount_ids'] ?? []);

            DB::commit();

            return redirect()->route('admin.products.index')
                           ->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating product: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update product.'])->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            // Soft delete
            $product->update(['is_deleted' => true, 'is_active' => false]);
            
            return redirect()->route('admin.products.index')
                           ->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete product.']);
        }
    }

    public function toggleStatus(Product $product)
    {
        try {
            $product->update(['is_active' => !$product->is_active]);
            
            $status = $product->is_active ? 'activated' : 'deactivated';
            return response()->json([
                'success' => true,
                'message' => "Product {$status} successfully!",
                'status' => $product->is_active
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling product status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status.'
            ], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate,delete,feature,unfeature',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:products,id'
        ]);

        try {
            $count = 0;
            foreach ($validated['selected_items'] as $productId) {
                $product = Product::find($productId);
                if ($product) {
                    switch ($validated['action']) {
                        case 'activate':
                            $product->update(['is_active' => true]);
                            break;
                        case 'deactivate':
                            $product->update(['is_active' => false]);
                            break;
                        case 'delete':
                            $product->update(['is_deleted' => true, 'is_active' => false]);
                            break;
                        case 'feature':
                            $product->update(['is_featured' => true]);
                            break;
                        case 'unfeature':
                            $product->update(['is_featured' => false]);
                            break;
                    }
                    $count++;
                }
            }

            $actionText = [
                'activate' => 'Activated',
                'deactivate' => 'Deactivated',
                'delete' => 'Deleted',
                'feature' => 'Featured',
                'unfeature' => 'Unfeatured'
            ][$validated['action']];

            return response()->json([
                'success' => true,
                'message' => "{$actionText} {$count} product(s) successfully!"
            ]);
        } catch (\Exception $e) {
            Log::error('Error in bulk action: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to perform bulk action.'
            ], 500);
        }
    }

    public function quickEdit(Request $request, Product $product)
    {
        $validated = $request->validate([
            'field' => 'required|in:price,sale_price,stock_quantity,is_active,is_featured',
            'value' => 'required',
        ]);

        try {
            // Validate the value based on field type
            $value = $validated['value'];
            if (in_array($validated['field'], ['is_active', 'is_featured'])) {
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            } elseif (in_array($validated['field'], ['price', 'sale_price'])) {
                $value = floatval($value);
                if ($value < 0) throw new \Exception('Price cannot be negative');
            } elseif ($validated['field'] === 'stock_quantity') {
                $value = intval($value);
                if ($value < 0) throw new \Exception('Stock cannot be negative');
                // Map stock_quantity to quantity column
                $fieldToUpdate = 'quantity';
            } else {
                $fieldToUpdate = $validated['field'];
            }

            $product->update([$fieldToUpdate ?? $validated['field'] => $value]);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'new_value' => $value
            ]);
        } catch (\Exception $e) {
            Log::error('Error in quick edit: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product: ' . $e->getMessage()
            ], 500);
        }
    }

    public function duplicate(Product $product)
    {
        DB::beginTransaction();
        try {
            $newProduct = $product->replicate();
            $newProduct->name = $product->name . ' (Copy)';
            $newProduct->slug = Str::slug($newProduct->name);
            $newProduct->sku = 'PRD-' . strtoupper(Str::random(8));
            $newProduct->is_active = false;
            $newProduct->save();

            // Duplicate images
            foreach ($product->images as $image) {
                $newImage = $image->replicate();
                $newImage->product_id = $newProduct->id;
                $newImage->save();
            }

            // Duplicate sizes
            foreach ($product->sizes as $size) {
                $newSize = $size->replicate();
                $newSize->product_id = $newProduct->id;
                $newSize->save();
            }

            // Duplicate discount associations
            $newProduct->discounts()->attach($product->discounts->pluck('id'));

            DB::commit();

            return redirect()->route('admin.products.edit', $newProduct)
                           ->with('success', 'Product duplicated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error duplicating product: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to duplicate product.']);
        }
    }
}
