@extends('layouts.main')

@section('content')

@include('partials.home.styles')

<main class="container mx-auto px-4" style="max-width: 1400px;">
    
    @include('partials.home.hero-section')

    @include('partials.home.promotional-cards')

    @include('partials.home.toy-categories')

    @include('partials.home.featured-products')

    @include('partials.home.new-arrivals')

    @include('partials.home.advertisement-banner')

    @include('partials.home.best-sellers')

    @include('partials.home.sale-products')

    @include('partials.home.newsletter')

    @include('partials.home.brand-features')

</main>

<script>
// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all add-to-cart buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            addToCart(productId, this);
        });
    });

    // Add event listeners to all add-to-wishlist buttons
    document.querySelectorAll('.add-to-wishlist-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            addToWishlist(productId, this);
        });
    });
});

// Add to cart functionality
function addToCart(productId, button) {
    const btnText = button.querySelector('.btn-text');
    const loadingText = button.querySelector('.loading-text');
    
    // Check for CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        showNotification('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
        return;
    }
    
    // Show loading state
    if (btnText) btnText.classList.add('hidden');
    if (loadingText) loadingText.classList.remove('hidden');
    button.disabled = true;
    
    fetch('{{ route("cart.add", ":productId") }}'.replace(':productId', productId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count in header
            const cartBadge = document.getElementById('cart-count');
            if (cartBadge) {
                cartBadge.textContent = data.cart_count;
                cartBadge.classList.remove('hidden');
            } else if (data.cart_count > 0) {
                // Create cart badge if it doesn't exist
                const cartLink = document.querySelector('a[href*="cart"]');
                if (cartLink && cartLink.querySelector('svg')) {
                    const badge = document.createElement('span');
                    badge.id = 'cart-count';
                    badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
                    badge.textContent = data.cart_count;
                    cartLink.appendChild(badge);
                }
            }
            
            // Show success message
            showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
        } else {
            showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
        }
    })
    .catch(error => {
        console.error('Add to cart error:', error);
        showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
    })
    .finally(() => {
        // Reset button state
        if (btnText) btnText.classList.remove('hidden');
        if (loadingText) loadingText.classList.add('hidden');
        button.disabled = false;
    });
}

function updateWishlistBadge(wishlistCount) {
    let wishlistBadge = document.getElementById('wishlist-count');
    
    if (wishlistBadge) {
        wishlistBadge.textContent = wishlistCount;
        if (wishlistCount > 0) {
            wishlistBadge.classList.remove('hidden');
            wishlistBadge.style.display = 'flex';
        } else {
            wishlistBadge.classList.add('hidden');
            wishlistBadge.style.display = 'none';
        }
    } else if (wishlistCount > 0) {
        // Create wishlist badge if it doesn't exist
        const wishlistLink = document.querySelector('a[href*="/wishlist"]');
        if (wishlistLink && !wishlistLink.querySelector('#wishlist-count')) {
            wishlistLink.style.position = 'relative';
            const badge = document.createElement('span');
            badge.id = 'wishlist-count';
            badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
            badge.textContent = wishlistCount;
            wishlistLink.appendChild(badge);
        }
    }
}

// Add to wishlist functionality
function addToWishlist(productId, button) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        showNotification('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
        return;
    }

    // Check if user is authenticated
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
    if (!isAuthenticated) {
        showNotification('يجب تسجيل الدخول أولاً لإضافة المنتجات إلى قائمة الأمنيات', 'error');
        setTimeout(() => {
            window.location.href = '{{ route("login") }}';
        }, 2000);
        return;
    }

    // Check if already in wishlist
    const isInWishlist = button.classList.contains('is-in-wishlist');
    const action = isInWishlist ? 'remove' : 'add';
    const method = isInWishlist ? 'DELETE' : 'POST';

    // Show loading state
    const originalIcon = button.innerHTML;
    button.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    button.disabled = true;

    fetch(`/wishlist/${action}/${productId}`, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (action === 'add') {
                // Item added to wishlist
                button.innerHTML = '<svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
                button.classList.add('is-in-wishlist', 'text-red-500');
                button.classList.remove('text-gray-600', 'hover:text-orange-600');
                button.title = 'موجود في قائمة الأمنيات';
                showNotification('تم إضافة المنتج إلى قائمة الأمنيات!', 'success');
            } else {
                // Item removed from wishlist
                button.innerHTML = '<svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
                button.classList.remove('is-in-wishlist', 'text-red-500');
                button.classList.add('text-gray-600', 'hover:text-orange-600');
                button.title = 'إضافة إلى قائمة الأمنيات';
                showNotification('تم حذف المنتج من قائمة الأمنيات!', 'success');
            }
            
            // Update wishlist count in header
            if (data.wishlist_count !== undefined) {
                updateWishlistBadge(data.wishlist_count);
            }
        } else {
            showNotification(data.message || 'حدث خطأ في تحديث قائمة الأمنيات', 'error');
            button.innerHTML = originalIcon;
        }
    })
    .catch(error => {
        console.error('Wishlist error:', error);
        showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
        button.innerHTML = originalIcon;
    })
    .finally(() => {
        button.disabled = false;
    });
}

// Notification function
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} shadow-lg transition-opacity duration-300`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
</script>
@endsection
