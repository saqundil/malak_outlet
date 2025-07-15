<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;

class BrandCategoryController extends Controller
{
    /**
     * Display brands grouped by categories
     */
    public function index()
    {
        $categories = Category::with('brands')->orderBy('name')->get();
        
        return view('admin.brands.index', compact('categories'));
    }

    /**
     * Get brands for a specific category (useful for AJAX)
     */
    public function getBrandsByCategory($categoryId)
    {
        $brands = Brand::where('category_id', $categoryId)
                      ->orderBy('name')
                      ->get(['id', 'name', 'slug']);
        
        return response()->json($brands);
    }

    /**
     * Show category with its brands
     */
    public function showCategory($slug)
    {
        $category = Category::with(['brands', 'products'])
                          ->where('slug', $slug)
                          ->firstOrFail();
        
        return view('categories.show', compact('category'));
    }

    /**
     * Show brand with its category and products
     */
    public function showBrand($slug)
    {
        $brand = Brand::with(['category', 'products'])
                     ->where('slug', $slug)
                     ->firstOrFail();
        
        return view('brands.show', compact('brand'));
    }

    /**
     * Get category statistics
     */
    public function getCategoryStats()
    {
        $stats = Category::withCount(['brands', 'products'])
                        ->orderBy('name')
                        ->get();
        
        return response()->json($stats);
    }
}
