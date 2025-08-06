<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductService
{
    /**
     * Build product query with filters
     */
    public function buildFilteredQuery(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images']);

        $this->applySearch($query, $request->search);
        $this->applyFilters($query, $request);
        $this->applySorting($query, $request->sort);

        return $query;
    }

    /**
     * Apply search filters to query
     */
    private function applySearch($query, ?string $search): void
    {
        if (empty($search)) {
            return;
        }

        $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('sku', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Apply various filters to query
     */
    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('status')) {
            $this->applyStatusFilter($query, $request->status);
        }
    }

    /**
     * Apply status filter to query
     */
    private function applyStatusFilter($query, string $status): void
    {
        switch ($status) {
            case 'active':
                $query->where('is_active', true);
                break;
            case 'inactive':
                $query->where('is_active', false);
                break;
            case 'featured':
                $query->where('is_featured', true);
                break;
            case 'low_stock':
                $query->where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0);
                break;
            case 'out_of_stock':
                $query->where('stock_quantity', 0);
                break;
        }
    }

    /**
     * Apply sorting to query
     */
    private function applySorting($query, ?string $sort): void
    {
        $sortMap = [
            'name_asc' => ['name', 'asc'],
            'name_desc' => ['name', 'desc'],
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            'created_at_asc' => ['created_at', 'asc'],
        ];

        if (isset($sortMap[$sort])) {
            $query->orderBy(...$sortMap[$sort]);
        } else {
            $query->orderBy('created_at', 'desc');
        }
    }

    /**
     * Get product statistics
     */
    public function getStatistics(): array
    {
        return [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'low_stock' => Product::where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0)->count(),
            'out_of_stock' => Product::where('stock_quantity', 0)->count(),
        ];
    }

    /**
     * Duplicate a product
     */
    public function duplicateProduct(Product $product): Product
    {
        $newProduct = $product->replicate();
        $newProduct->name = $product->name . ' - نسخة';
        $newProduct->sku = $product->sku . '-copy-' . time();
        $newProduct->is_active = false;
        $newProduct->save();

        // Copy images
        foreach ($product->images as $image) {
            $newProduct->images()->create([
                'image_path' => $image->image_path,
                'is_primary' => $image->is_primary
            ]);
        }

        return $newProduct;
    }

    /**
     * Perform bulk actions on products
     */
    public function performBulkAction(string $action, array $productIds): bool
    {
        $actions = [
            'activate' => fn() => Product::whereIn('id', $productIds)->update(['is_active' => true]),
            'deactivate' => fn() => Product::whereIn('id', $productIds)->update(['is_active' => false]),
            'feature' => fn() => Product::whereIn('id', $productIds)->update(['is_featured' => true]),
            'delete' => fn() => Product::whereIn('id', $productIds)->delete(),
        ];

        if (!isset($actions[$action])) {
            return false;
        }

        $actions[$action]();
        return true;
    }
}
