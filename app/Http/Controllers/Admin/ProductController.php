<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Discount;
use App\Models\DiscountProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

        // Filter by main category (parent categories)
        if ($request->filled('main_category')) {
            $mainCategoryId = $request->main_category;
            $query->whereHas('category', function($q) use ($mainCategoryId) {
                $q->where(function($subQ) use ($mainCategoryId) {
                    // Include main category itself
                    $subQ->where('id', $mainCategoryId)
                         // Include subcategories of this main category
                         ->orWhere('parent_id', $mainCategoryId);
                });
            });
        }

        // Filter by specific category (subcategory)
        if ($request->filled('category') || $request->filled('category_id')) {
            $categoryValue = $request->category ?? $request->category_id;
            if (is_numeric($categoryValue)) {
                $query->where('category_id', $categoryValue);
            } else {
                $query->whereHas('category', function($q) use ($categoryValue) {
                    $q->where('slug', $categoryValue);
                });
            }
        }

        // Filter by brand
        if ($request->filled('brand') || $request->filled('brand_id')) {
            $brandValue = $request->brand ?? $request->brand_id;
            $query->where('brand_id', $brandValue);
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true)->where('is_deleted', false);
                    break;
                case 'inactive':
                    $query->where('is_active', false)->where('is_deleted', false);
                    break;
                case 'featured':
                    $query->where('is_featured', true)->where('is_deleted', false);
                    break;
                case 'deleted':
                    $query->where('is_deleted', true);
                    break;
                case 'low_stock':
                    $query->where('quantity', '>', 0)->where('quantity', '<=', 10)->where('is_deleted', false);
                    break;
                case 'out_of_stock':
                    $query->where('quantity', '=', 0)->where('is_deleted', false);
                    break;
                default:
                    $query->where('is_deleted', false);
                    break;
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

        $products = $query->paginate(20)->appends($request->all());

        // Get filter options
        $categories = Category::active()->orderBy('parent_id')->orderBy('name')->get(['id', 'name', 'slug', 'parent_id']);
        $brands = Brand::active()->orderBy('name')->get(['id', 'name']);

        // Get statistics
        $stats = [
            'total_products' => Product::where('is_deleted', false)->count(),
            'active_products' => Product::where('is_active', true)->where('is_deleted', false)->count(),
            'inactive_products' => Product::where('is_active', false)->where('is_deleted', false)->count(),
            'featured_products' => Product::where('is_featured', true)->where('is_deleted', false)->count(),
            'low_stock' => Product::where('quantity', '>', 0)->where('quantity', '<=', 10)->where('is_deleted', false)->count(),
            'out_of_stock' => Product::where('quantity', '=', 0)->where('is_deleted', false)->count(),
            'in_stock' => Product::where('quantity', '>', 10)->where('is_deleted', false)->count(),
        ];

        return view('admin.products.index', compact('products', 'categories', 'brands', 'stats'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('parent_id')->orderBy('name')->get(['id', 'name', 'parent_id']);
        $brands = Brand::active()->orderBy('name')->get(['id', 'name']);
        $discounts = Discount::active()->orderBy('name')->get(['id', 'name', 'discount_type', 'discount_value']);

        return view('admin.products.create', compact('categories', 'brands', 'discounts'));
    }

    public function store(Request $request)
    {
        // Get selected category to check if it's shoes
        $selectedCategory = Category::find($request->category_id);
        $isShoesCategory = $selectedCategory && str_contains($selectedCategory->name, 'أحذية');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'quantity' => 'required|integer|min:0',
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
            'shoe_sizes' => $isShoesCategory ? 'required|array|min:1' : 'nullable|array',
            'shoe_sizes.*.size' => $isShoesCategory ? 'required|string' : 'nullable|string',
            'shoe_sizes.*.quantity' => $isShoesCategory ? 'required|integer|min:0' : 'nullable|integer|min:0',
            'discount_ids' => 'nullable|array',
            'discount_ids.*' => 'exists:discounts,id',
        ], [
            'shoe_sizes.required' => 'يجب إضافة مقاس واحد على الأقل للأحذية',
            'shoe_sizes.min' => 'يجب إضافة مقاس واحد على الأقل للأحذية',
            'shoe_sizes.*.size.required' => 'مقاس الحذاء مطلوب',
            'shoe_sizes.*.quantity.required' => 'كمية المقاس مطلوبة',
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
                    // Sanitize filename - remove spaces and special characters
                    $originalName = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
                    
                    // Clean the filename: remove spaces, special chars, keep only alphanumeric, dots, hyphens, underscores
                    $cleanName = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $nameWithoutExtension);
                    $cleanName = preg_replace('/_+/', '_', $cleanName); // Replace multiple underscores with single
                    $cleanName = trim($cleanName, '_'); // Remove leading/trailing underscores
                    
                    // If clean name is empty or too short, use a default name
                    if (empty($cleanName) || strlen($cleanName) < 2) {
                        $cleanName = 'product_image';
                    }
                    
                    $filename = time() . '_' . $index . '_' . $cleanName . '.' . $extension;
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
                        'stock_quantity' => $validated['quantity'] // Default to same as stock
                    ]);
                }
            }

            // Handle shoe sizes for shoes category
            if ($isShoesCategory && !empty($validated['shoe_sizes'])) {
                $totalShoeQuantity = 0;
                
                foreach ($validated['shoe_sizes'] as $shoeSize) {
                    if (!empty($shoeSize['size']) && isset($shoeSize['quantity'])) {
                        ProductSize::create([
                            'product_id' => $product->id,
                            'size' => $shoeSize['size'],
                            'stock_quantity' => (int)$shoeSize['quantity']
                        ]);
                        $totalShoeQuantity += (int)$shoeSize['quantity'];
                    }
                }
                
                // Update total product quantity to match shoe sizes total
                $product->update(['quantity' => $totalShoeQuantity]);
            }

            // Handle discount associations
            if (!empty($validated['discount_ids'])) {
                foreach ($validated['discount_ids'] as $discountId) {
                    DiscountProduct::create([
                        'product_id' => $product->id,
                        'discount_id' => $discountId,
                        'edit_by' => Auth::id(),
                    ]);
                }
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
        }, 'reviews', 'favoritedByUsers', 'attributeValues.attribute']);

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
        $categories = Category::active()->orderBy('name')->get(['id', 'name', 'parent_id']);
        $brands = Brand::active()->orderBy('name')->get(['id', 'name']);
        $discounts = Discount::active()->orderBy('name')->get(['id', 'name', 'discount_type', 'discount_value']);

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'discounts'));
    }

    public function update(Request $request, Product $product)
    {
        // Get selected category to check if it's shoes
        $selectedCategory = Category::find($request->category_id);
        $isShoesCategory = $selectedCategory && str_contains($selectedCategory->name, 'أحذية');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'quantity' => $isShoesCategory ? 'nullable|integer|min:0' : 'required|integer|min:0',
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
            'shoe_sizes' => $isShoesCategory ? 'required|array|min:1' : 'nullable|array',
            'shoe_sizes.*.size' => $isShoesCategory ? 'required|string' : 'nullable|string',
            'shoe_sizes.*.quantity' => $isShoesCategory ? 'required|integer|min:0' : 'nullable|integer|min:0',
            'discount_ids' => 'nullable|array',
            'discount_ids.*' => 'exists:discounts,id',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'exists:product_images,id',
        ], [
            'shoe_sizes.required' => 'يجب إضافة مقاس واحد على الأقل للأحذية',
            'shoe_sizes.min' => 'يجب إضافة مقاس واحد على الأقل للأحذية',
            'shoe_sizes.*.size.required' => 'مقاس الحذاء مطلوب',
            'shoe_sizes.*.quantity.required' => 'كمية المقاس مطلوبة',
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
                    // Sanitize filename - remove spaces and special characters
                    $originalName = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
                    
                    // Clean the filename: remove spaces, special chars, keep only alphanumeric, dots, hyphens, underscores
                    $cleanName = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $nameWithoutExtension);
                    $cleanName = preg_replace('/_+/', '_', $cleanName); // Replace multiple underscores with single
                    $cleanName = trim($cleanName, '_'); // Remove leading/trailing underscores
                    
                    // If clean name is empty or too short, use a default name
                    if (empty($cleanName) || strlen($cleanName) < 2) {
                        $cleanName = 'product_image';
                    }
                    
                    $filename = time() . '_' . $index . '_' . $cleanName . '.' . $extension;
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
                        'stock_quantity' => $validated['quantity']
                    ]);
                }
            }

            // Handle shoe sizes update for shoes category
            if ($isShoesCategory && isset($validated['shoe_sizes'])) {
                // Remove existing sizes
                $product->sizes()->delete();
                
                $totalShoeQuantity = 0;
                
                // Add new shoe sizes
                foreach ($validated['shoe_sizes'] as $shoeSize) {
                    if (!empty($shoeSize['size']) && isset($shoeSize['quantity'])) {
                        ProductSize::create([
                            'product_id' => $product->id,
                            'size' => $shoeSize['size'],
                            'stock_quantity' => (int)$shoeSize['quantity']
                        ]);
                        $totalShoeQuantity += (int)$shoeSize['quantity'];
                    }
                }
                
                // Update total product quantity to match shoe sizes total
                $validated['quantity'] = $totalShoeQuantity;
            }

            // Handle discount associations
            // Remove existing discount associations
            DiscountProduct::where('product_id', $product->id)->delete();
            
            // Add new discount associations
            if (!empty($validated['discount_ids'])) {
                foreach ($validated['discount_ids'] as $discountId) {
                    DiscountProduct::create([
                        'product_id' => $product->id,
                        'discount_id' => $discountId,
                        'edit_by' => Auth::id(),
                    ]);
                }
            }

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

    public function toggleFeatured(Product $product)
    {
        try {
            $product->update(['is_featured' => !$product->is_featured]);
            
            $status = $product->is_featured ? 'featured' : 'unfeatured';
            return response()->json([
                'success' => true,
                'message' => "Product {$status} successfully!",
                'is_featured' => $product->is_featured
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling product featured status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product featured status.'
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
            'field' => 'required|in:price,sale_price,quantity,is_active,is_featured',
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
            } elseif ($validated['field'] === 'quantity') {
                $value = intval($value);
                if ($value < 0) throw new \Exception('Stock cannot be negative');
            }

            $product->update([$validated['field'] => $value]);

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

            // Duplicate attribute values
            foreach ($product->attributeValues as $attributeValue) {
                $newAttributeValue = $attributeValue->replicate();
                $newAttributeValue->product_id = $newProduct->id;
                $newAttributeValue->save();
            }

            // Duplicate discount associations
            foreach ($product->discountProducts as $discountProduct) {
                DiscountProduct::create([
                    'product_id' => $newProduct->id,
                    'discount_id' => $discountProduct->discount_id,
                    'edit_by' => Auth::id(),
                ]);
            }

            DB::commit();

            return redirect()->route('admin.products.edit', $newProduct)
                           ->with('success', 'Product duplicated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error duplicating product: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to duplicate product.']);
        }
    }

    /**
     * Get real-time product statistics for API
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_products' => Product::where('is_deleted', false)->count(),
                'active_products' => Product::where('is_active', true)->where('is_deleted', false)->count(),
                'inactive_products' => Product::where('is_active', false)->where('is_deleted', false)->count(),
                'featured_products' => Product::where('is_featured', true)->where('is_deleted', false)->count(),
                'low_stock' => Product::where('quantity', '>', 0)->where('quantity', '<=', 10)->where('is_deleted', false)->count(),
                'out_of_stock' => Product::where('quantity', '=', 0)->where('is_deleted', false)->count(),
                'in_stock' => Product::where('quantity', '>', 10)->where('is_deleted', false)->count(),
                'total_value' => Product::where('is_deleted', false)->sum(DB::raw('price * COALESCE(quantity, 0)')),
                'recent_products_count' => Product::where('is_deleted', false)->where('created_at', '>=', now()->subDays(30))->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في جلب الإحصائيات'
            ], 500);
        }
    }

    /**
     * Search products for AJAX autocomplete
     */
    public function search(Request $request)
    {
        try {
            $search = $request->get('q');
            $products = Product::where('is_deleted', false)
                ->where(function($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('sku', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                })
                ->with(['category', 'brand', 'images'])
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $products->map(function($product) {
                    return [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'name' => $product->name,
                        'sku' => $product->sku,
                        'price' => $product->price,
                        'sale_price' => $product->sale_price,
                        'quantity' => $product->quantity,
                        'is_active' => $product->is_active,
                        'is_featured' => $product->is_featured,
                        'category' => $product->category?->name,
                        'brand' => $product->brand?->name,
                        'image' => $product->images->first()?->image_path,
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البحث'
            ], 500);
        }
    }

    /**
     * Delete a product image
     */
    public function deleteImage(ProductImage $image)
    {
        try {
            // Check if this is the only image
            $product = $image->product;
            if ($product->images->count() <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن حذف الصورة الوحيدة للمنتج'
                ], 400);
            }

            // Delete the physical file
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }

            // If this was the primary image, make another image primary
            if ($image->is_primary) {
                $nextImage = $product->images()->where('id', '!=', $image->id)->first();
                if ($nextImage) {
                    $nextImage->update(['is_primary' => true]);
                }
            }

            // Delete the image record
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الصورة بنجاح'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting product image: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الصورة'
            ], 500);
        }
    }

    /**
     * Make an image primary
     */
    public function makePrimaryImage(ProductImage $image)
    {
        try {
            DB::beginTransaction();

            // Remove primary status from all other images of this product
            ProductImage::where('product_id', $image->product_id)
                       ->where('id', '!=', $image->id)
                       ->update(['is_primary' => false]);

            // Make this image primary
            $image->update(['is_primary' => true]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الصورة الرئيسية بنجاح'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error making image primary: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الصورة الرئيسية'
            ], 500);
        }
    }
}
