<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CitiesController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/enhanced', [DashboardController::class, 'enhanced'])->name('dashboard.enhanced');
    Route::get('/dashboard/tables', [DashboardController::class, 'tablesOverview'])->name('dashboard.tables');
    
    // Products Management
    Route::resource('products', ProductController::class);
    Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::patch('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('products/{product}/duplicate', [ProductController::class, 'duplicate'])->name('products.duplicate');
    Route::delete('products/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.delete');
    Route::patch('products/images/{image}/primary', [ProductController::class, 'makePrimaryImage'])->name('products.images.primary');
    Route::post('products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
    
    // Categories Management
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction'])->name('categories.bulk-action');
    
    // Brands Management
    Route::resource('brands', BrandController::class);
    Route::post('brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');
    Route::post('brands/bulk-action', [BrandController::class, 'bulkAction'])->name('brands.bulk-action');
    
    // Discounts Management
    Route::resource('discounts', DiscountController::class);
    Route::post('discounts/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])->name('discounts.toggle-status');
    Route::post('discounts/bulk-action', [DiscountController::class, 'bulkAction'])->name('discounts.bulk-action');
    Route::get('discounts/{discount}/products', [DiscountController::class, 'products'])->name('discounts.products');
    Route::get('discounts/{discount}/categories', [DiscountController::class, 'categories'])->name('discounts.categories');
    Route::put('discounts/{discount}/sync-products', [DiscountController::class, 'syncProducts'])->name('discounts.sync-products');
    Route::put('discounts/{discount}/sync-categories', [DiscountController::class, 'syncCategories'])->name('discounts.sync-categories');
    Route::post('discounts/{discount}/apply-to-products', [DiscountController::class, 'applyToProducts'])->name('discounts.apply-to-products');
    Route::post('discounts/{discount}/apply-to-categories', [DiscountController::class, 'applyToCategories'])->name('discounts.apply-to-categories');
    
    // Orders Management
    Route::resource('orders', OrderController::class)->except(['create', 'store']);
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::post('orders/bulk-action', [OrderController::class, 'bulkAction'])->name('orders.bulk-action');
    
    // Users Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
    
    // Reviews Management
    Route::resource('reviews', ReviewController::class)->except(['create', 'store']);
    Route::post('reviews/{review}/toggle-status', [ReviewController::class, 'toggleStatus'])->name('reviews.toggle-status');
    Route::post('reviews/bulk-action', [ReviewController::class, 'bulkAction'])->name('reviews.bulk-action');
    
    // Cities Management
    Route::resource('cities', CitiesController::class);
    Route::post('cities/{city}/toggle-status', [CitiesController::class, 'toggleStatus'])->name('cities.toggle-status');
    Route::post('cities/bulk-action', [CitiesController::class, 'bulkAction'])->name('cities.bulk-action');
    Route::get('cities/{city}/orders', [CitiesController::class, 'orders'])->name('cities.orders');
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/contact', [SettingsController::class, 'contact'])->name('settings.contact');
    Route::put('/settings/contact', [SettingsController::class, 'updateContact'])->name('settings.contact.update');
    
    // Analytics & Reports
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    Route::get('/reports/sales', [DashboardController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/products', [DashboardController::class, 'productsReport'])->name('reports.products');
    
    // API endpoints for AJAX
    Route::get('/api/stats', [DashboardController::class, 'getStats'])->name('api.stats');
    Route::get('/api/products/stats', [ProductController::class, 'getStats'])->name('api.products.stats');
    Route::get('/api/products/search', [ProductController::class, 'search'])->name('api.products.search');
    Route::get('/api/categories/tree', [CategoryController::class, 'getTree'])->name('api.categories.tree');
});
