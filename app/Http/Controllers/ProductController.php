<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductSize;
use App\Models\Favorite;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images', 'sizes', 'discountProducts.discount'])
            ->active();
        // Search by name or description
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by category (multiple selection with subcategory support)
        if ($request->filled('category')) {
            $categories = is_array($request->category) ? $request->category : [$request->category];
            
            // Get all selected categories and their subcategories
            $allCategoryIds = collect($categories);
            
            // For each selected category, add its subcategories if it's a main category
            foreach ($categories as $categoryId) {
                $subcategories = Category::where('parent_id', $categoryId)->pluck('id');
                $allCategoryIds = $allCategoryIds->merge($subcategories);
            }
            
            $query->whereIn('category_id', $allCategoryIds->unique()->toArray());
        }

        // Filter by brand (multiple selection)
        if ($request->filled('brand')) {
            $brands = is_array($request->brand) ? $request->brand : [$request->brand];
            $query->whereIn('brand_id', $brands);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by size
        if ($request->filled('size')) {
            $query->whereHas('sizes', function($q) use ($request) {
                $q->where('size', $request->size)
                  ->where('is_available', true);
            });
        }

        // Filter by sizes (multiple selection)
        if ($request->filled('sizes')) {
            $sizes = is_array($request->sizes) ? $request->sizes : [$request->sizes];
            $query->whereHas('sizes', function($q) use ($sizes) {
                $q->whereIn('size', $sizes)
                  ->where('is_available', true);
            });
        }

        // Filter by featured products
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        // Filter by stock availability
        if ($request->filled('in_stock')) {
            $query->where('quantity', '>', 0)
                  ->where('status', 'in_stock');
        }

        // Filter by sale products
        if ($request->filled('on_sale')) {
            $query->whereHas('discountProducts.discount', function ($q) {
                $q->where('discounts.is_active', true)
                  ->where('discounts.is_deleted', false)
                  ->where(function ($q) {
                      $q->whereNull('discounts.starts_at')
                        ->orWhere('discounts.starts_at', '<=', now());
                  })
                  ->where(function ($q) {
                      $q->whereNull('discounts.ends_at')
                        ->orWhere('discounts.ends_at', '>=', now());
                  });
            });
        }

        // General filter parameter for common filter types
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'sale':
                    // Only show products that actually have active discounts
                    $query->whereHas('discountProducts.discount', function ($q) {
                        $q->where('discounts.is_active', true)
                          ->where('discounts.is_deleted', false)
                          ->where(function ($q) {
                              $q->whereNull('discounts.starts_at')
                                ->orWhere('discounts.starts_at', '<=', now());
                          })
                          ->where(function ($q) {
                              $q->whereNull('discounts.ends_at')
                                ->orWhere('discounts.ends_at', '>=', now());
                          });
                    });
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'new':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'popular':
                    $query->withCount('favoritedByUsers')
                          ->orderBy('favorited_by_users_count', 'desc');
                    break;
            }
        }

        // Sort products
        $sortBy = $request->get('sort', 'newest');
        
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popularity':
                $query->withCount('favoritedByUsers')
                      ->orderBy('favorited_by_users_count', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        // Get filter options
        $categories = Category::whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->active()->withCount('products')->orderBy('name');
            }])
            ->active()
            ->withCount('products')
            ->orderBy('name')
            ->get();
        
        // Get brands based on selected categories
        $brandsQuery = Brand::active()->withCount('products')->orderBy('name');
        
        if ($request->filled('category')) {
            $categories_selected = is_array($request->category) ? $request->category : [$request->category];
            
            // Get all selected categories and their subcategories
            $allCategoryIds = collect($categories_selected);
            
            // For each selected category, add its subcategories if it's a main category
            foreach ($categories_selected as $categoryId) {
                $subcategories = Category::where('parent_id', $categoryId)->pluck('id');
                $allCategoryIds = $allCategoryIds->merge($subcategories);
            }
            
            // Filter brands to only show those that have products in the selected categories
            $brandsQuery->whereHas('products', function($q) use ($allCategoryIds) {
                $q->whereIn('category_id', $allCategoryIds->unique()->toArray())
                  ->where('is_active', true)
                  ->where('is_deleted', false);
            });
        }
        
        $brands = $brandsQuery->get();
        
        $sizes = ProductSize::select('size')->distinct()->orderBy('size')->pluck('size');
        
        // Get available sizes with counts
        $availableSizes = ProductSize::select('size')
            ->selectRaw('COUNT(*) as count')
            ->where('is_available', true)
            ->groupBy('size')
            ->orderBy('size')
            ->pluck('count', 'size');

        // Get user's wishlist product slugs for authenticated users
        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Favorite::where('user_id', Auth::id())
                ->with('product:id,slug')
                ->get()
                ->pluck('product.slug')
                ->filter()
                ->toArray();
        }

        if ($request->ajax()) {
            return response()->json([
                'products' => $products,
                'html' => view('products.partials.grid', compact('products', 'wishlistProductIds'))->render()
            ]);
        }

        return view('products.index', compact('products', 'categories', 'brands', 'sizes', 'availableSizes', 'wishlistProductIds'));
    }

    public function category($slug)
    {
        // Find the category by slug
        $category = Category::where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Get products for this category and its subcategories
        $categoryIds = [$category->id];
        
        // If this is a main category, include subcategories
        if (!$category->parent_id) {
            $subcategoryIds = Category::where('parent_id', $category->id)
                ->active()
                ->pluck('id')
                ->toArray();
            $categoryIds = array_merge($categoryIds, $subcategoryIds);
        }

        $query = Product::with(['category', 'brand', 'images', 'sizes', 'discountProducts.discount'])
            ->active()
            ->whereIn('category_id', $categoryIds);

        // Sort products
        $sortBy = request()->get('sort', 'newest');
        
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popularity':
                $query->withCount('favoritedByUsers')
                      ->orderBy('favorited_by_users_count', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);

        // Get filter options
        $categories = Category::whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->active()->withCount('products')->orderBy('name');
            }])
            ->active()
            ->withCount('products')
            ->orderBy('name')
            ->get();
        
        // Get brands that have products in this category
        $brands = Brand::active()
            ->whereHas('products', function($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds)
                  ->where('is_active', true)
                  ->where('is_deleted', false);
            })
            ->withCount('products')
            ->orderBy('name')
            ->get();
        
        $sizes = ProductSize::select('size')->distinct()->orderBy('size')->pluck('size');
        
        // Get available sizes with counts for this category
        $availableSizes = ProductSize::select('size')
            ->selectRaw('COUNT(*) as count')
            ->whereHas('product', function($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds)
                      ->where('is_active', true)
                      ->where('is_deleted', false);
            })
            ->where('is_available', true)
            ->groupBy('size')
            ->orderBy('size')
            ->pluck('count', 'size');

        // Get user's wishlist product slugs for authenticated users
        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Favorite::where('user_id', Auth::id())
                ->with('product:id,slug')
                ->get()
                ->pluck('product.slug')
                ->filter()
                ->toArray();
        }

        // Pass the current category to the view
        return view('products.category', compact('products', 'categories', 'brands', 'sizes', 'availableSizes', 'wishlistProductIds', 'category'));
    }

    public function show($slug)
    {
        $product = Product::with([
            'category', 
            'brand', 
            'images', 
            'sizes' => function($query) {
                $query->where('is_available', true)->orderBy('size');
            },
            'reviews.user',
            'attributeValues.attribute',
            'discountProducts.discount'
        ])
        ->where('slug', $slug)
        ->active()
        ->firstOrFail();

        // Get related products
        $relatedProducts = Product::with(['images', 'brand', 'discountProducts.discount'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->limit(4)
            ->get();

        // Check if product is in user's favorites/wishlist
        $isFavorite = false;
        $isInWishlist = false;
        if (Auth::check()) {
            $isFavorite = Favorite::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
            $isInWishlist = $isFavorite; // Same as favorite
        }

        return view('products.show', compact('product', 'relatedProducts', 'isFavorite', 'isInWishlist'));
    }

    public function showById($id)
    {
        $product = Product::where('id', $id)->active()->firstOrFail();
        
        // Redirect to the proper slug URL
        return redirect()->route('products.show', $product->slug, 301);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json(['products' => []]);
        }

        $products = Product::with(['images', 'brand', 'discountProducts.discount'])
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->active()
            ->limit(10)
            ->get();

        return response()->json([
            'products' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->formatted_price,
                    'image' => $product->main_image,
                    'brand' => $product->brand->name ?? null,
                ];
            })
        ]);
    }

    public function toggleFavorite(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً'
            ], 401);
        }

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'تم إزالة المنتج من المفضلة';
            $isFavorite = false;
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ]);
            $message = 'تم إضافة المنتج للمفضلة';
            $isFavorite = true;
        }

        $favoritesCount = Favorite::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_favorite' => $isFavorite,
            'favorites_count' => $favoritesCount
        ]);
    }

    /**
     * Get brands based on selected categories (AJAX endpoint)
     */
    public function getBrandsByCategories(Request $request)
    {
        $brandsQuery = Brand::active()->withCount('products')->orderBy('name');
        
        if ($request->filled('categories')) {
            $categoriesParam = $request->get('categories');
            
            // Handle both comma-separated string and array
            if (is_string($categoriesParam)) {
                $categories_selected = explode(',', $categoriesParam);
            } else {
                $categories_selected = is_array($categoriesParam) ? $categoriesParam : [$categoriesParam];
            }
            
            // Filter out empty values and convert to integers
            $categories_selected = array_filter(array_map('intval', $categories_selected));
            
            if (!empty($categories_selected)) {
                // Get all selected categories and their subcategories
                $allCategoryIds = collect($categories_selected);
                
                // For each selected category, add its subcategories if it's a main category
                foreach ($categories_selected as $categoryId) {
                    $subcategories = Category::where('parent_id', $categoryId)->pluck('id');
                    $allCategoryIds = $allCategoryIds->merge($subcategories);
                }
                
                // Filter brands to only show those that have products in the selected categories
                $brandsQuery->whereHas('products', function($q) use ($allCategoryIds) {
                    $q->whereIn('category_id', $allCategoryIds->unique()->toArray())
                      ->where('is_active', true)
                      ->where('is_deleted', false);
                });
            }
        }
        
        $brands = $brandsQuery->get();
        
        return response()->json([
            'success' => true,
            'brands' => $brands->map(function($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'products_count' => $brand->products_count
                ];
            })
        ]);
    }

    /**
     * Get search suggestions for AJAX autocomplete
     */
    public function searchSuggestions(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'suggestions' => []
            ]);
        }
        
        $products = Product::active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhereHas('category', function ($categoryQuery) use ($query) {
                      $categoryQuery->where('name', 'LIKE', "%{$query}%");
                  });
            })
            ->with(['category', 'images', 'discountProducts.discount'])
            ->limit(8)
            ->get();
        
        $suggestions = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'category' => $product->category,
                'category_name' => $product->category ? $product->category->name : null,
                'images' => $product->images,
                'image' => $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : null,
            ];
        });
        
        return response()->json([
            'success' => true,
            'suggestions' => $suggestions
        ]);
    }

    /**
     * Get full search results for AJAX
     */
    public function searchResults(Request $request)
    {
        $query = $request->get('q', '');
        $sort = $request->get('sort', 'newest');
        $category = $request->get('category', '');
        $page = (int) $request->get('page', 1);
        $perPage = 12;
        
        $productsQuery = Product::with(['category', 'brand', 'images', 'sizes', 'discountProducts.discount'])
            ->active();
        // Search by query
        if (!empty($query)) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhereHas('category', function ($categoryQuery) use ($query) {
                      $categoryQuery->where('name', 'LIKE', "%{$query}%");
                  })
                  ->orWhereHas('brand', function ($brandQuery) use ($query) {
                      $brandQuery->where('name', 'LIKE', "%{$query}%");
                  });
            });
        }

        // Filter by category
        if (!empty($category)) {
            $productsQuery->whereHas('category', function($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // Sorting
        switch ($sort) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'popular':
                $productsQuery->orderBy('views_count', 'desc');
                break;
            case 'newest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        // Get total count
        $total = $productsQuery->count();
        
        // Apply pagination
        $products = $productsQuery->skip(($page - 1) * $perPage)->take($perPage)->get();

        // Format products for JSON response
        $formattedProducts = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'final_price' => $product->final_price,
                'discount_percentage' => $product->discount_percentage,
                'has_discount' => $product->has_discount,
                'description' => $product->description,
                'category' => $product->category ? [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                    'slug' => $product->category->slug
                ] : null,
                'brand' => $product->brand ? [
                    'id' => $product->brand->id,
                    'name' => $product->brand->name
                ] : null,
                'images' => $product->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image_path' => asset('storage/' . $image->image_path),
                        'alt_text' => $image->alt_text
                    ];
                }),
                'main_image' => $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : null,
                'sizes' => $product->sizes->where('is_available', true)->map(function ($size) {
                    return [
                        'id' => $size->id,
                        'size' => $size->size,
                        'stock_quantity' => $size->stock_quantity
                    ];
                }),
                'url' => route('products.show', $product->slug),
                'cart_url' => route('cart.add', $product->id)
            ];
        });

        return response()->json([
            'success' => true,
            'products' => $formattedProducts,
            'pagination' => [
                'current_page' => $page,
                'total' => $total,
                'per_page' => $perPage,
                'last_page' => ceil($total / $perPage),
                'has_more' => ($page * $perPage) < $total
            ],
            'query' => $query,
            'sort' => $sort,
            'category' => $category
        ]);
    }

    /**
     * Get sizes based on selected categories (AJAX endpoint)
     */
    public function getSizesByCategories(Request $request)
    {
        if (!$request->filled('categories')) {
            return response()->json([
                'success' => true,
                'sizes' => []
            ]);
        }

        $categoriesParam = $request->get('categories');
        
        // Handle both comma-separated string and array
        if (is_string($categoriesParam)) {
            $categories_selected = explode(',', $categoriesParam);
        } else {
            $categories_selected = is_array($categoriesParam) ? $categoriesParam : [$categoriesParam];
        }
        
        // Filter out empty values and convert to integers
        $categories_selected = array_filter(array_map('intval', $categories_selected));
        
        if (empty($categories_selected)) {
            return response()->json([
                'success' => true,
                'sizes' => []
            ]);
        }

        // Get all selected categories and their subcategories
        $allCategoryIds = collect($categories_selected);
        
        // For each selected category, add its subcategories if it's a main category
        foreach ($categories_selected as $categoryId) {
            $subcategories = Category::where('parent_id', $categoryId)->pluck('id');
            $allCategoryIds = $allCategoryIds->merge($subcategories);
        }

        // Get available sizes for products in the selected categories
        $sizes = ProductSize::select('size')
            ->selectRaw('COUNT(*) as count')
            ->whereHas('product', function($query) use ($allCategoryIds) {
                $query->whereIn('category_id', $allCategoryIds->unique()->toArray())
                      ->where('is_active', true)
                      ->where('is_deleted', false);
            })
            ->where('is_available', true)
            ->where('is_deleted', false)
            ->groupBy('size')
            ->orderBy('size')
            ->get()
            ->pluck('count', 'size');

        return response()->json([
            'success' => true,
            'sizes' => $sizes->toArray()
        ]);
    }
}
