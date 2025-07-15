

<?php $__env->startSection('title', 'قائمة الأمنيات - متجر ملاك'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-pink-600 to-red-600 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">قائمة الأمنيات</h1>
            <p class="text-lg opacity-90">منتجاتك المفضلة في مكان واحد</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Wishlist Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">منتجاتي المفضلة</h2>
                <p class="text-gray-600">لديك <span id="wishlist-count"><?php echo e($favorites->count()); ?></span> منتجات في قائمة الأمنيات</p>
            </div>
            <?php if($favorites->count() > 0): ?>
            <div class="flex gap-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    إضافة الكل للسلة
                </button>
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    مسح القائمة
                </button>
            </div>
            <?php endif; ?>
        </div>

        <!-- Wishlist Items -->
        <?php if($favorites->count() > 0): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="wishlist-items">
            <?php $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $favorite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Wishlist Item -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group wishlist-item" data-product-id="<?php echo e($favorite->product->id); ?>">
                <div class="relative">
                    <div class="aspect-square bg-gray-100 overflow-hidden">
                        <?php if($favorite->product->images && $favorite->product->images->first()): ?>
                            <img src="<?php echo e($favorite->product->images->first()->image_path); ?>" 
                                 alt="<?php echo e($favorite->product->name); ?>" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-500 font-bold text-sm"><?php echo e($favorite->product->name); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <button class="absolute top-3 left-3 p-2 bg-white rounded-full shadow-lg hover:bg-red-50 transition-colors remove-from-wishlist" data-product-id="<?php echo e($favorite->product->id); ?>">
                        <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2"><?php echo e($favorite->product->name); ?></h3>
                    
                    <p class="text-sm text-gray-500 mb-2"><?php echo e($favorite->product->category->name ?? 'فئة غير محددة'); ?></p>
                    
                    <div class="flex items-center gap-2 mb-3">
                        <?php if($favorite->product->sale_price): ?>
                            <span class="text-xl font-bold text-red-600"><?php echo e(number_format($favorite->product->sale_price, 2)); ?> ر.س</span>
                            <span class="text-sm text-gray-500 line-through"><?php echo e(number_format($favorite->product->price, 2)); ?> ر.س</span>
                        <?php else: ?>
                            <span class="text-xl font-bold text-gray-800"><?php echo e(number_format($favorite->product->price, 2)); ?> ر.س</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex items-center">
                            <?php $__currentLoopData = range(1, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $star): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <svg class="w-4 h-4 <?php echo e($star <= ($favorite->product->average_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <span class="text-sm text-gray-500">(<?php echo e($favorite->product->reviews_count ?? 0); ?> تقييم)</span>
                    </div>
                    
                    <div class="flex gap-2">
                        <button class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-semibold add-to-cart" data-product-id="<?php echo e($favorite->product->id); ?>">
                            إضافة للسلة
                        </button>
                        <a href="<?php echo e(route('products.show', $favorite->product->id)); ?>" 
                           class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <!-- Empty Wishlist State -->
        <div class="text-center py-16" id="empty-wishlist">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-600 mb-2">قائمة الأمنيات فارغة</h3>
            <p class="text-gray-500 mb-6">لم تقم بإضافة أي منتجات لقائمة الأمنيات بعد</p>
            <a href="<?php echo e(route('home')); ?>" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                تصفح المنتجات
            </a>
        </div>
        <?php endif; ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Remove from wishlist
        document.querySelectorAll('.remove-from-wishlist').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const wishlistItem = document.querySelector(`.wishlist-item[data-product-id="${productId}"]`);
                
                // Make API call to remove from wishlist
                removeFromWishlist(productId, wishlistItem);
            });
        });

        // Add to cart
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                addToCart(productId, this);
            });
        });

        // Bulk actions
        document.querySelector('.bg-blue-600.text-white.px-4.py-2')?.addEventListener('click', function() {
            addAllToCart();
        });

        document.querySelector('.bg-red-600.text-white.px-4.py-2')?.addEventListener('click', function() {
            clearWishlist();
        });

        function removeFromWishlist(productId, wishlistItem) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                showNotification('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
                return;
            }

            fetch(`/wishlist/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add fade out animation
                    wishlistItem.style.transform = 'scale(0.8)';
                    wishlistItem.style.opacity = '0';
                    
                    setTimeout(() => {
                        wishlistItem.remove();
                        updateWishlistCount();
                        
                        // Check if wishlist is empty
                        const remainingItems = document.querySelectorAll('.wishlist-item');
                        if (remainingItems.length === 0) {
                            document.getElementById('wishlist-items')?.classList.add('hidden');
                            document.getElementById('empty-wishlist')?.classList.remove('hidden');
                        }
                    }, 300);
                    
                    showNotification(data.message || 'تم حذف المنتج من قائمة الأمنيات', 'success');
                } else {
                    showNotification(data.message || 'حدث خطأ في حذف المنتج', 'error');
                }
            })
            .catch(error => {
                console.error('Remove from wishlist error:', error);
                showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
            });
        }

        function addToCart(productId, button) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                showNotification('خطأ في النظام: لم يتم العثور على رمز الأمان', 'error');
                return;
            }

            // Show loading state
            const originalText = button.innerHTML;
            button.innerHTML = '<svg class="w-5 h-5 mx-auto animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
            button.disabled = true;

            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart badge if exists
                    updateCartBadge(data.cart_count);
                    
                    // Show success state
                    button.innerHTML = '<svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                    button.classList.add('bg-green-600');
                    button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    
                    showNotification('تم إضافة المنتج إلى السلة بنجاح!', 'success');
                    
                    // Reset after 2 seconds
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.classList.remove('bg-green-600');
                        button.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        button.disabled = false;
                    }, 2000);
                } else {
                    showNotification(data.message || 'حدث خطأ في إضافة المنتج', 'error');
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }

        function addAllToCart() {
            const wishlistItems = document.querySelectorAll('.wishlist-item');
            const productIds = Array.from(wishlistItems).map(item => item.dataset.productId);
            
            if (productIds.length === 0) {
                showNotification('لا توجد منتجات في قائمة الأمنيات', 'error');
                return;
            }

            showNotification('جاري إضافة جميع المنتجات إلى السلة...', 'info');

            // Add each product to cart
            productIds.forEach((productId, index) => {
                setTimeout(() => {
                    const addButton = document.querySelector(`.wishlist-item[data-product-id="${productId}"] .add-to-cart`);
                    if (addButton) {
                        addToCart(productId, addButton);
                    }
                }, index * 500); // Stagger the requests
            });
        }

        function clearWishlist() {
            if (!confirm('هل أنت متأكد من حذف جميع المنتجات من قائمة الأمنيات؟')) {
                return;
            }

            const wishlistItems = document.querySelectorAll('.wishlist-item');
            const productIds = Array.from(wishlistItems).map(item => item.dataset.productId);
            
            productIds.forEach((productId, index) => {
                setTimeout(() => {
                    const removeButton = document.querySelector(`.wishlist-item[data-product-id="${productId}"] .remove-from-wishlist`);
                    if (removeButton) {
                        removeButton.click();
                    }
                }, index * 200); // Stagger the removals for better UX
            });
        }

        function updateWishlistCount() {
            const count = document.querySelectorAll('.wishlist-item').length;
            const countElement = document.getElementById('wishlist-count');
            if (countElement) {
                countElement.textContent = count;
            }
        }

        function updateCartBadge(cartCount) {
            let cartBadge = document.getElementById('cart-count');
            
            if (cartBadge) {
                cartBadge.textContent = cartCount;
                if (cartCount > 0) {
                    cartBadge.classList.remove('hidden');
                } else {
                    cartBadge.classList.add('hidden');
                }
            } else if (cartCount > 0) {
                // Create cart badge if it doesn't exist
                const cartLink = document.querySelector('a[href*="cart"]');
                if (cartLink) {
                    cartLink.style.position = 'relative';
                    const badge = document.createElement('span');
                    badge.id = 'cart-count';
                    badge.className = 'absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold';
                    badge.textContent = cartCount;
                    cartLink.appendChild(badge);
                }
            }
        }

        function showNotification(message, type = 'success') {
            // Remove existing notifications
            document.querySelectorAll('.notification').forEach(notif => notif.remove());
            
            const notification = document.createElement('div');
            notification.className = `notification fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white shadow-lg transition-opacity duration-300 ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/wishlist.blade.php ENDPATH**/ ?>