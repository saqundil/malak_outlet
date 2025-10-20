/**
 * Global Application Functions
 * Handles cart, wishlist, and common functionality across all pages
 */

// Global state management
window.AppState = {
    isAuthenticated: false,
    cartCount: 0,
    wishlistCount: 0,
    csrfToken: null,
    
    init() {
        // Get CSRF token
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (csrfMeta) {
            this.csrfToken = csrfMeta.getAttribute('content');
        }
        
        // Check if user is authenticated (can be set by server-side code)
        this.isAuthenticated = window.isAuthenticated || false;
        
        // Initialize event listeners
        this.initEventListeners();
    },
    
    initEventListeners() {
        // Cart buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.add-to-cart-btn')) {
                e.preventDefault();
                const btn = e.target.closest('.add-to-cart-btn');
                const productId = btn.getAttribute('data-product-id');
                if (productId) {
                    this.addToCart(productId, btn);
                }
            }
            
            // Wishlist buttons
            if (e.target.closest('.wishlist-btn, .add-to-wishlist-btn')) {
                e.preventDefault();
                const btn = e.target.closest('.wishlist-btn, .add-to-wishlist-btn');
                const productSlug = btn.getAttribute('data-product-slug') || btn.getAttribute('data-product-id');
                if (productSlug) {
                    this.toggleWishlist(productSlug, btn);
                }
            }
        });
    }
};

// Cart Management
window.addToCart = function(productId, button = null, quantity = 1, sizeId = null) {
    if (!window.AppState.csrfToken) {
        showNotification('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
        return;
    }
    
    // Show loading state if button provided
    if (button) {
        const btnText = button.querySelector('.btn-text');
        const loadingText = button.querySelector('.loading-text');
        
        if (btnText && loadingText) {
            btnText.classList.add('hidden');
            loadingText.classList.remove('hidden');
        }
        
        button.disabled = true;
        button.style.opacity = '0.7';
        button.style.transform = 'scale(0.98)';
    }
    
    const requestBody = {
        quantity: quantity,
        _token: window.AppState.csrfToken
    };
    
    if (sizeId) {
        requestBody.size_id = sizeId;
    }
    
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.AppState.csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify(requestBody)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart badge
            updateCartBadge(data.cart_count || data.cartCount);
            showNotification(data.message || 'تم إضافة المنتج إلى السلة بنجاح!', 'success');
            
            // Reset button state
            if (button) {
                const btnText = button.querySelector('.btn-text');
                const loadingText = button.querySelector('.loading-text');
                
                if (btnText && loadingText) {
                    loadingText.classList.add('hidden');
                    btnText.classList.remove('hidden');
                }
                
                button.disabled = false;
                button.style.opacity = '1';
                button.style.transform = 'scale(1)';
                
                // Success animation
                button.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                setTimeout(() => {
                    button.style.background = '';
                }, 1000);
            }
        } else {
            showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
            
            // Reset button state
            if (button) {
                const btnText = button.querySelector('.btn-text');
                const loadingText = button.querySelector('.loading-text');
                
                if (btnText && loadingText) {
                    loadingText.classList.add('hidden');
                    btnText.classList.remove('hidden');
                }
                
                button.disabled = false;
                button.style.opacity = '1';
                button.style.transform = 'scale(1)';
            }
        }
    })
    .catch(error => {
        console.error('Add to cart error:', error);
        showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
        
        // Reset button state
        if (button) {
            const btnText = button.querySelector('.btn-text');
            const loadingText = button.querySelector('.loading-text');
            
            if (btnText && loadingText) {
                loadingText.classList.add('hidden');
                btnText.classList.remove('hidden');
            }
            
            button.disabled = false;
            button.style.opacity = '1';
            button.style.transform = 'scale(1)';
        }
    });
};

// Wishlist Management
window.toggleWishlist = function(productSlug, button = null) {
    if (!window.AppState.isAuthenticated) {
        showNotification('يرجى تسجيل الدخول لإضافة المنتجات إلى قائمة الأمنيات', 'error');
        // Redirect to login page
        setTimeout(() => {
            window.location.href = '/login';
        }, 2000);
        return;
    }
    
    if (!window.AppState.csrfToken) {
        showNotification('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
        return;
    }
    
    // Show loading state
    if (button) {
        button.disabled = true;
        button.style.opacity = '0.7';
        const icon = button.querySelector('svg');
        if (icon) {
            icon.style.transform = 'scale(1.1)';
        }
    }
    
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.AppState.csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            product_slug: productSlug,
            _token: window.AppState.csrfToken
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update wishlist count if available
            if (data.wishlist_count !== undefined) {
                updateWishlistBadge(data.wishlist_count);
            }
            
            // Update button state
            if (button) {
                const icon = button.querySelector('svg');
                if (data.added) {
                    // Added to wishlist
                    button.classList.add('text-red-500');
                    button.classList.remove('text-gray-600');
                    if (icon) {
                        icon.setAttribute('fill', 'currentColor');
                    }
                    showNotification('تم إضافة المنتج إلى قائمة الأمنيات', 'success');
                } else {
                    // Removed from wishlist
                    button.classList.remove('text-red-500');
                    button.classList.add('text-gray-600');
                    if (icon) {
                        icon.setAttribute('fill', 'none');
                    }
                    showNotification('تم إزالة المنتج من قائمة الأمنيات', 'info');
                }
            } else {
                showNotification(data.message || (data.added ? 'تم إضافة المنتج إلى قائمة الأمنيات' : 'تم إزالة المنتج من قائمة الأمنيات'), data.added ? 'success' : 'info');
            }
            
            // Reset button state
            if (button) {
                button.disabled = false;
                button.style.opacity = '1';
                const icon = button.querySelector('svg');
                if (icon) {
                    icon.style.transform = 'scale(1)';
                }
            }
        } else {
            showNotification(data.message || 'حدث خطأ في تحديث قائمة الأمنيات', 'error');
            
            // Reset button state
            if (button) {
                button.disabled = false;
                button.style.opacity = '1';
                const icon = button.querySelector('svg');
                if (icon) {
                    icon.style.transform = 'scale(1)';
                }
            }
        }
    })
    .catch(error => {
        console.error('Wishlist error:', error);
        showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
        
        // Reset button state
        if (button) {
            button.disabled = false;
            button.style.opacity = '1';
            const icon = button.querySelector('svg');
            if (icon) {
                icon.style.transform = 'scale(1)';
            }
        }
    });
};

// Badge Updates
window.updateCartBadge = function(count) {
    const cartBadge = document.getElementById('cart-count');
    
    if (count > 0) {
        if (cartBadge) {
            cartBadge.textContent = count;
            cartBadge.classList.remove('hidden');
            
            // Animation
            cartBadge.style.transform = 'scale(1.2)';
            setTimeout(() => {
                cartBadge.style.transform = 'scale(1)';
            }, 200);
        } else {
            // Create badge if it doesn't exist
            const cartLink = document.querySelector('a[href*="/cart"]');
            if (cartLink) {
                cartLink.style.position = 'relative';
                const badge = document.createElement('span');
                badge.id = 'cart-count';
                badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold animate-pulse';
                badge.textContent = count;
                cartLink.appendChild(badge);
            }
        }
    } else if (cartBadge) {
        cartBadge.classList.add('hidden');
    }
    
    // Update global state
    window.AppState.cartCount = count;
};

window.updateWishlistBadge = function(count) {
    const wishlistBadge = document.getElementById('wishlist-count');
    
    if (count > 0) {
        if (wishlistBadge) {
            wishlistBadge.textContent = count;
            wishlistBadge.classList.remove('hidden');
        } else {
            // Create badge if it doesn't exist
            const wishlistLink = document.querySelector('a[href*="/wishlist"]');
            if (wishlistLink) {
                wishlistLink.style.position = 'relative';
                const badge = document.createElement('span');
                badge.id = 'wishlist-count';
                badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold';
                badge.textContent = count;
                wishlistLink.appendChild(badge);
            }
        }
    } else if (wishlistBadge) {
        wishlistBadge.classList.add('hidden');
    }
    
    // Update global state
    window.AppState.wishlistCount = count;
};

// Notification System
window.showNotification = function(message, type = 'success') {
    // Remove existing notifications
    document.querySelectorAll('.notification').forEach(notif => notif.remove());
    
    const notification = document.createElement('div');
    let bgColor, icon;
    
    switch (type) {
        case 'success':
            bgColor = 'bg-green-500';
            icon = '✓';
            break;
        case 'error':
            bgColor = 'bg-red-500';
            icon = '✗';
            break;
        case 'info':
            bgColor = 'bg-blue-500';
            icon = 'ⓘ';
            break;
        default:
            bgColor = 'bg-gray-500';
            icon = '•';
    }
    
    notification.className = `notification fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300 flex items-center gap-3`;
    notification.innerHTML = `
        <span class="text-lg font-bold">${icon}</span>
        <span class="font-medium">${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        notification.style.transform = 'translate(100%, -50%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 4000);
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize app state
    window.AppState.init();
    
    // Set authentication status from server-side data
    const authMeta = document.querySelector('meta[name="user-authenticated"]');
    if (authMeta) {
        window.AppState.isAuthenticated = authMeta.getAttribute('content') === 'true';
    }
    
    console.log('Malak Outlet App initialized successfully');
});

// Export for compatibility
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { addToCart, toggleWishlist, updateCartBadge, updateWishlistBadge, showNotification };
}
