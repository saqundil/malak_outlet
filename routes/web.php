<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{orderNumber}/items', [OrderController::class, 'itemsDetails'])->name('orders.items');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{orderNumber}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::put('/orders/{orderNumber}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/{orderNumber}/track', [OrderController::class, 'track'])->name('orders.track');
    Route::get('/orders/{orderNumber}/download', [OrderController::class, 'downloadInvoice'])->name('orders.download');
    Route::post('/orders/{orderNumber}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');
    
    Route::get('/wishlist', [FavoriteController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add/{productId}', [FavoriteController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{productId}', [FavoriteController::class, 'destroy'])->name('wishlist.remove');
    
    // Checkout routes - Require authentication
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{slug}', [ProductController::class, 'category'])->name('products.category');
Route::get('/products/{id}', [ProductController::class, 'showById'])->where('id', '[0-9]+')->name('products.show.id');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'search'])->name('search');

// API Routes for search suggestions
Route::get('/api/search-suggestions', [ProductController::class, 'searchSuggestions'])->name('api.search.suggestions');
Route::get('/api/search-results', [ProductController::class, 'searchResults'])->name('api.search.results');
Route::get('/api/brands-by-categories', [ProductController::class, 'getBrandsByCategories'])->name('api.brands.by-categories');
Route::get('/api/sizes-by-categories', [ProductController::class, 'getSizesByCategories'])->name('api.sizes.by-categories');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{productIdentifier}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/remove/{cartKey}', [CartController::class, 'remove'])->name('cart.remove.post');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');

// Test alerts (remove in production)
Route::get('/test-alerts', function() {
    return view('test-alerts');
})->name('test.alerts');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/offers', [PageController::class, 'offers'])->name('offers');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/returns', [PageController::class, 'returns'])->name('returns');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Include admin routes
require __DIR__.'/admin.php';

// OTP Email Verification Routes
use App\Http\Controllers\Auth\EmailVerificationController;

Route::post('/register-otp', [EmailVerificationController::class, 'register'])->name('register.otp');
Route::post('/verify-otp', [EmailVerificationController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/resend-otp', [EmailVerificationController::class, 'resendOtp'])->name('resend.otp');
Route::get('/email-verification', [EmailVerificationController::class, 'showVerifyForm'])->name('verify.otp.form');

// Legal pages
Route::get('/legal/terms', function () {
    return view('legal.terms');
})->name('legal.terms');

Route::get('/legal/privacy', function () {
    return view('legal.privacy');
})->name('legal.privacy');

require __DIR__.'/auth.php';
