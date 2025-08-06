// Cart Cookie Helper Functions
// Note: Laravel encrypts cookies by default, so we can't parse them directly in JavaScript
// Instead, we'll use API calls to get cart data
function getCartFromCookie() {
    // Use server-provided cart data or fallback to empty cart
    if (window.cartData) {
        return window.cartData;
    }
    
    // Since we can't parse encrypted cookies, return empty cart
    // and rely on API calls for actual data
    return {};
}

async function getCartCount() {
    try {
        const response = await fetch('/api/cart/count');
        const data = await response.json();
        return data.count || 0;
    } catch (error) {
        console.error('Error fetching cart count:', error);
        return 0;
    }
}

async function updateCartBadge() {
    const cartBadge = document.getElementById('cart-count');
    
    if (cartBadge) {
        try {
            const count = await getCartCount();
            cartBadge.textContent = count;
            if (count > 0) {
                cartBadge.classList.remove('hidden');
                cartBadge.style.display = 'flex';
            } else {
                cartBadge.classList.add('hidden');
                cartBadge.style.display = 'none';
            }
        } catch (error) {
            console.error('Error updating cart badge:', error);
        }
    }
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

// Initialize cart badge on page load
document.addEventListener('DOMContentLoaded', function() {
    // Since we can't reliably parse Laravel's encrypted cookies,
    // we rely on the server-side rendered cart count in the header
    // The cart badge is already rendered by the server in header.blade.php
    console.log('Cart helper loaded - using server-side cart data');
});

// Global function for updating cart badge (compatible with existing code)
window.updateCartBadge = function(cartCount) {
    const cartBadge = document.getElementById('cart-count');
    
    if (cartBadge) {
        cartBadge.textContent = cartCount;
        if (cartCount > 0) {
            cartBadge.classList.remove('hidden');
            cartBadge.style.display = 'flex';
        } else {
            cartBadge.classList.add('hidden');
            cartBadge.style.display = 'none';
        }
    } else if (cartCount > 0) {
        // Create cart badge if it doesn't exist
        const cartLink = document.querySelector('a[href*="/cart"]');
        if (cartLink) {
            cartLink.style.position = 'relative';
            const badge = document.createElement('span');
            badge.id = 'cart-count';
            badge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold animate-pulse';
            badge.textContent = cartCount;
            cartLink.appendChild(badge);
        }
    }
};

// Header Data function for Alpine.js
function headerData() {
    return {
        isOpen: false,
        searchQuery: '',
        searchResults: [],
        isSearching: false,
        
        toggleMenu() {
            this.isOpen = !this.isOpen;
        },
        
        async searchProducts() {
            if (this.searchQuery.length < 2) {
                this.searchResults = [];
                return;
            }
            
            this.isSearching = true;
            
            try {
                const response = await fetch(`/api/search?q=${encodeURIComponent(this.searchQuery)}`);
                const data = await response.json();
                this.searchResults = data.products || [];
            } catch (error) {
                console.error('Search error:', error);
                this.searchResults = [];
            } finally {
                this.isSearching = false;
            }
        },
        
        clearSearch() {
            this.searchQuery = '';
            this.searchResults = [];
        }
    };
}

// Make headerData globally available
window.headerData = headerData;
