/**
 * Application Utilities
 * Common JavaScript functions used across the application
 */

// Global utilities object
window.AppUtils = {
    
    // Cart management
    cart: {
        /**
         * Update cart badge count
         */
        updateBadge: function(count) {
            const cartBadge = document.getElementById('cart-count');
            if (count > 0) {
                if (cartBadge) {
                    cartBadge.textContent = count;
                } else {
                    const cartLink = document.querySelector('a[href*="/cart"]');
                    if (cartLink) {
                        cartLink.style.position = 'relative';
                        const badge = document.createElement('span');
                        badge.id = 'cart-count';
                        badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
                        badge.textContent = count;
                        cartLink.appendChild(badge);
                    }
                }
            } else if (cartBadge) {
                cartBadge.remove();
            }
        },

        /**
         * Add product to cart
         */
        add: function(productId, quantity = 1, sizeId = null) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                AppUtils.notification.show('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
                return Promise.reject('CSRF token not found');
            }

            const data = {
                product_id: productId,
                quantity: quantity
            };

            if (sizeId) {
                data.size_id = sizeId;
            }

            return fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    AppUtils.notification.show('تم إضافة المنتج إلى السلة!', 'success');
                    if (data.cart_count !== undefined) {
                        AppUtils.cart.updateBadge(data.cart_count);
                    }
                } else {
                    AppUtils.notification.show(data.message || 'حدث خطأ في إضافة المنتج', 'error');
                }
                return data;
            })
            .catch(error => {
                console.error('Cart error:', error);
                AppUtils.notification.show('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
                throw error;
            });
        }
    },

    // Wishlist management
    wishlist: {
        /**
         * Update wishlist badge count
         */
        updateBadge: function(count) {
            const wishlistBadge = document.getElementById('wishlist-count');
            if (count > 0) {
                if (wishlistBadge) {
                    wishlistBadge.textContent = count;
                } else {
                    const wishlistLink = document.querySelector('a[href*="/wishlist"]');
                    if (wishlistLink) {
                        wishlistLink.style.position = 'relative';
                        const badge = document.createElement('span');
                        badge.id = 'wishlist-count';
                        badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
                        badge.textContent = count;
                        wishlistLink.appendChild(badge);
                    }
                }
            } else if (wishlistBadge) {
                wishlistBadge.remove();
            }
        },

        /**
         * Toggle wishlist item
         */
        toggle: function(productId, button) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                AppUtils.notification.show('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
                return Promise.reject('CSRF token not found');
            }

            // Check if user is authenticated
            const isAuthenticated = window.isAuthenticated || false;
            if (!isAuthenticated) {
                AppUtils.notification.show('يجب تسجيل الدخول أولاً لإضافة المنتجات إلى قائمة الأمنيات', 'error');
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
                return Promise.reject('User not authenticated');
            }

            const isInWishlist = button.classList.contains('is-in-wishlist');
            const action = isInWishlist ? 'remove' : 'add';
            const method = isInWishlist ? 'DELETE' : 'POST';

            // Show loading state
            const originalIcon = button.innerHTML;
            button.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            button.disabled = true;

            return fetch(`/wishlist/${action}/${productId}`, {
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
                        button.innerHTML = '<svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
                        button.classList.add('is-in-wishlist', 'text-red-500');
                        button.classList.remove('text-gray-600', 'hover:text-orange-600');
                        button.title = 'موجود في قائمة الأمنيات';
                        AppUtils.notification.show('تم إضافة المنتج إلى قائمة الأمنيات!', 'success');
                    } else {
                        button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
                        button.classList.remove('is-in-wishlist', 'text-red-500');
                        button.classList.add('text-gray-600', 'hover:text-orange-600');
                        button.title = 'إضافة إلى قائمة الأمنيات';
                        AppUtils.notification.show('تم حذف المنتج من قائمة الأمنيات!', 'success');
                    }

                    if (data.wishlist_count !== undefined) {
                        AppUtils.wishlist.updateBadge(data.wishlist_count);
                    }
                } else {
                    AppUtils.notification.show(data.message || 'حدث خطأ في تحديث قائمة الأمنيات', 'error');
                    button.innerHTML = originalIcon;
                }
                return data;
            })
            .catch(error => {
                console.error('Wishlist error:', error);
                AppUtils.notification.show('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
                button.innerHTML = originalIcon;
                throw error;
            })
            .finally(() => {
                button.disabled = false;
            });
        }
    },

    // Notification system
    notification: {
        /**
         * Show notification
         */
        show: function(message, type = 'success', duration = 3000) {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.app-notification');
            existingNotifications.forEach(notification => notification.remove());

            const notification = document.createElement('div');
            notification.className = `app-notification fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} shadow-lg transition-all duration-300 transform translate-x-full`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Trigger animation
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 10);

            // Auto remove
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, duration);
        }
    },

    // Form utilities
    form: {
        /**
         * Get CSRF token
         */
        getCsrfToken: function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            return csrfToken ? csrfToken.getAttribute('content') : null;
        },

        /**
         * Submit form with CSRF protection
         */
        submit: function(url, data, method = 'POST') {
            const csrfToken = this.getCsrfToken();
            if (!csrfToken) {
                throw new Error('CSRF token not found');
            }

            return fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(response => response.json());
        }
    },

    // DOM utilities
    dom: {
        /**
         * Wait for DOM to be ready
         */
        ready: function(callback) {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', callback);
            } else {
                callback();
            }
        },

        /**
         * Add event listener with delegation
         */
        on: function(event, selector, handler) {
            document.addEventListener(event, function(e) {
                if (e.target.matches(selector) || e.target.closest(selector)) {
                    handler.call(e.target.closest(selector) || e.target, e);
                }
            });
        }
    }
};

// Initialize global functions for backward compatibility
window.addToCart = function(productId, quantity = 1, sizeId = null) {
    return AppUtils.cart.add(productId, quantity, sizeId);
};

window.addToWishlist = function(productId, button) {
    return AppUtils.wishlist.toggle(productId, button);
};

window.showNotification = function(message, type = 'success') {
    return AppUtils.notification.show(message, type);
};

// Set authentication status
AppUtils.dom.ready(function() {
    // This will be set by the Blade template
    window.isAuthenticated = window.isAuthenticated || false;
});
