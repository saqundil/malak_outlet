<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Favorite;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured/latest products
        $featuredProducts = Product::with(['category', 'brand', 'images'])
            ->active()
            ->inStock()
            ->latest()
            ->limit(8)
            ->get();

        // Get main categories with images
        $categories = Category::main()
            ->active()
            ->withCount('activeProducts')
            ->limit(8)
            ->get();

        // Get latest products
        $latestProducts = Product::with(['category', 'brand', 'images'])
            ->active()
            ->inStock()
            ->latest()
            ->limit(6)
            ->get();

        // Get discounted products (products with active discounts)
        $discountedProducts = Product::with(['category', 'brand', 'images', 'discounts'])
            ->active()
            ->inStock()
            ->whereHas('discounts', function ($query) {
                $query->where('discounts.is_active', true)
                      ->where('discounts.is_deleted', false)
                      ->where(function ($q) {
                          $q->whereNull('discounts.starts_at')
                            ->orWhere('discounts.starts_at', '<=', now());
                      })
                      ->where(function ($q) {
                          $q->whereNull('discounts.ends_at')
                            ->orWhere('discounts.ends_at', '>=', now());
                      });
            })
            ->limit(6)
            ->get();

        // Get popular products (most favorited)
        $popularProducts = Product::with(['category', 'brand', 'images'])
            ->active()
            ->inStock()
            ->withCount('favoritedByUsers')
            ->orderBy('favorited_by_users_count', 'desc')
            ->limit(8)
            ->get();

        // Get sale products (products with active discounts)
        $saleProducts = Product::with(['category', 'brand', 'images', 'discounts'])
            ->active()
            ->inStock()
            ->whereHas('discounts', function ($query) {
                $query->where('discounts.is_active', true)
                      ->where('discounts.is_deleted', false)
                      ->where(function ($q) {
                          $q->whereNull('discounts.starts_at')
                            ->orWhere('discounts.starts_at', '<=', now());
                      })
                      ->where(function ($q) {
                          $q->whereNull('discounts.ends_at')
                            ->orWhere('discounts.ends_at', '>=', now());
                      });
            })
            ->limit(8)
            ->get();

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

        return view('home', compact('featuredProducts', 'categories', 'latestProducts', 'discountedProducts', 'popularProducts', 'saleProducts', 'wishlistProductIds'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Here you can store the contact message or send an email
        // For now, just redirect back with success message
        
        return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح. سنقوم بالرد عليك في أقرب وقت ممكن.');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    public function termsOfService()
    {
        return view('pages.terms-of-service');
    }

    public function faq()
    {
        $faqs = [
            [
                'question' => 'كيف يمكنني تتبع طلبي؟',
                'answer' => 'يمكنك تتبع طلبك من خلال الدخول إلى حسابك وزيارة صفحة "طلباتي". ستجد هناك جميع تفاصيل طلباتك وحالة كل طلب.'
            ],
            [
                'question' => 'ما هي طرق الدفع المتاحة؟',
                'answer' => 'نحن نقبل الدفع عند الاستلام، والدفع بالبطاقات الائتمانية، والتحويل البنكي.'
            ],
            [
                'question' => 'كم تستغرق عملية التوصيل؟',
                'answer' => 'عادة ما تستغرق عملية التوصيل من 2-5 أيام عمل حسب موقعك الجغرافي.'
            ],
            [
                'question' => 'هل يمكنني إرجاع المنتج؟',
                'answer' => 'نعم، يمكنك إرجاع المنتج خلال 14 يوم من تاريخ الاستلام بشرط أن يكون في حالته الأصلية.'
            ],
        ];

        return view('pages.faq', compact('faqs'));
    }
}
