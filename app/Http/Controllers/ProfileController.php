<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        
        // Get user statistics
        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
            'wishlist_count' => $user->wishlistItems()->count(),
            'total_spent' => $user->orders()->where('status', 'completed')->sum('total_amount'),
        ];
        
        // Get cart count from cookie
        $cart = json_decode($request->cookie('cart', '[]'), true);
        $stats['cart_count'] = array_sum($cart);
        
        // Get recent orders (last 5)
        $recentOrders = $user->orders()
            ->with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get recent wishlist items (last 5)
        $recentWishlist = $user->favoriteProducts()
            ->with(['category', 'brand', 'images'])
            ->orderBy('favorites.created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Calculate membership level based on orders and spending
        $membershipLevel = $this->calculateMembershipLevel($stats['total_orders'], $stats['total_spent']);
        
        // Get last login activity
        $lastActivity = [
            'login' => $user->created_at,
            'profile_updated' => $user->updated_at,
        ];
        
        return view('profile.index', compact('user', 'stats', 'recentOrders', 'recentWishlist', 'membershipLevel', 'lastActivity'));
    }
    
    /**
     * Calculate membership level based on user activity
     */
    private function calculateMembershipLevel($totalOrders, $totalSpent)
    {
        if ($totalOrders >= 20 && $totalSpent >= 5000) {
            return ['level' => 'بلاتيني', 'color' => 'bg-gray-400', 'icon' => '💎'];
        } elseif ($totalOrders >= 10 && $totalSpent >= 2000) {
            return ['level' => 'ذهبي', 'color' => 'bg-yellow-500', 'icon' => '🏆'];
        } elseif ($totalOrders >= 3 && $totalSpent >= 500) {
            return ['level' => 'فضي', 'color' => 'bg-gray-300', 'icon' => '🥈'];
        } else {
            return ['level' => 'برونزي', 'color' => 'bg-orange-400', 'icon' => '🥉'];
        }
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        
        // Check if email is being changed
        $emailChanged = $user->email !== $validated['email'];
        
        $user->fill($validated);
        
        if ($emailChanged) {
            $user->setAttribute('email_verified_at', null);
        }
        
        $user->save();

        return Redirect::route('profile')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's profile page.
     */
    public function show()
    {
        return view('profile.show');
    }
}
