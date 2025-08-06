<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        // Get main categories with their children and product counts
        $mainCategories = Category::main()
            ->active()
            ->with(['children' => function($query) {
                $query->active()->withCount('activeProducts');
            }])
            ->withCount('activeProducts')
            ->get();
            
        return view('categories.index', compact('mainCategories'));
    }

    public function show($slug)
    {
        $category = Category::active()->where('slug', $slug)->firstOrFail();
        
        // Get products for this category and all its subcategories
        $categoryIds = [$category->id];
        if ($category->hasChildren()) {
            $categoryIds = array_merge($categoryIds, $category->getDescendants()->pluck('id')->toArray());
        }
        
        $products = Product::whereIn('category_id', $categoryIds)
            ->active()
            ->with(['brand', 'images', 'sizes', 'category'])
            ->paginate(12);
            
        // Get breadcrumb for navigation
        $breadcrumb = $category->getBreadcrumb();
        
        // Get subcategories if this is a main category
        $subcategories = $category->children()->active()->withCount('activeProducts')->get();
            
        return view('categories.show', compact('category', 'products', 'breadcrumb', 'subcategories'));
    }

    /**
     * Get categories tree for navigation/menu
     */
    public function getTree()
    {
        $categories = Category::main()
            ->active()
            ->with(['children' => function($query) {
                $query->active()->orderBy('name');
            }])
            ->orderBy('name')
            ->get();
            
        return response()->json($categories);
    }
}
