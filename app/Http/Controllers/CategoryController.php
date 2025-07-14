<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->get();
            
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::where('is_active', true)->findOrFail($id);
        
        $products = Product::where('category_id', $id)
            ->where('is_active', true)
            ->with(['brand', 'images'])
            ->paginate(12);
            
        return view('categories.show', compact('category', 'products'));
    }
}
