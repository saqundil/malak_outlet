<!-- Desktop Navigation -->
<nav class="bg-gradient-to-l to-orange-600 from-orange-500 text-white px-4 md:px-10 py-4 hidden md:block">
    <div class="flex justify-between items-center container mx-auto flex-wrap">
        <div class="relative">
            <button id="brands-dropdown-toggle" class="bg-white text-orange-500 border-none py-2 px-4 rounded flex items-center font-bold text-sm lg:text-base hover:bg-gray-100 transition-colors">
                <span class="ml-2">⭐</span> العلامات التجارية المشهورة
            </button>
            
            <!-- Famous Brands Dropdown - Fixed Position and Better Z-index -->
            <div id="brands-dropdown" class="hidden absolute top-full right-0 mt-2 bg-white rounded-lg shadow-xl border border-gray-200 z-[9999] w-80 max-w-sm sm:max-w-md lg:max-w-lg xl:w-96">
                <div class="p-3 sm:p-4">
                    <h3 class="text-orange-600 font-bold text-sm sm:text-base mb-3 border-b border-orange-100 pb-2">العلامات التجارية الرائدة</h3>
                    
                    <div class="grid grid-cols-1 gap-3">
                        <!-- Games Category - Top 2 Brands -->
                        <div class="bg-orange-50 rounded-lg p-2 sm:p-3">
                            <h4 class="text-orange-700 font-semibold text-xs sm:text-sm mb-2 flex items-center">
                                <span class="ml-1 sm:ml-2">🧸</span> ألعاب
                            </h4>
                            <div class="flex gap-1 sm:gap-2">
                                <a href="<?php echo e(route('products.index', ['category' => [1], 'brand' => 'LEGO'])); ?>" 
                                   class="bg-white text-orange-600 px-2 sm:px-3 py-1.5 sm:py-2 rounded-md text-xs sm:text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                                    LEGO
                                </a>
                                <a href="<?php echo e(route('products.index', ['category' => [1], 'brand' => 'Fisher-Price'])); ?>" 
                                   class="bg-white text-orange-600 px-2 sm:px-3 py-1.5 sm:py-2 rounded-md text-xs sm:text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                                    Fisher-Price
                                </a>
                            </div>
                        </div>
                        
                        <!-- Shoes Category - Top 2 Brands -->
                        <div class="bg-orange-50 rounded-lg p-2 sm:p-3">
                            <h4 class="text-orange-700 font-semibold text-xs sm:text-sm mb-2 flex items-center">
                                <span class="ml-1 sm:ml-2">👟</span> أحذية
                            </h4>
                            <div class="flex gap-1 sm:gap-2">
                                <a href="<?php echo e(route('products.index', ['category' => [7], 'brand' => 'Nike'])); ?>" 
                                   class="bg-white text-orange-600 px-2 sm:px-3 py-1.5 sm:py-2 rounded-md text-xs sm:text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                                    Nike
                                </a>
                                <a href="<?php echo e(route('products.index', ['category' => [7], 'brand' => 'Adidas'])); ?>" 
                                   class="bg-white text-orange-600 px-2 sm:px-3 py-1.5 sm:py-2 rounded-md text-xs sm:text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                                    Adidas
                                </a>
                            </div>
                        </div>
                        
                        <!-- Kids Supplies Category - Top 2 Brands -->
                        <div class="bg-orange-50 rounded-lg p-2 sm:p-3">
                            <h4 class="text-orange-700 font-semibold text-xs sm:text-sm mb-2 flex items-center">
                                <span class="ml-1 sm:ml-2">🎒</span> مستلزمات أطفال
                            </h4>
                            <div class="flex gap-1 sm:gap-2">
                                <a href="<?php echo e(route('products.index', ['category' => [13], 'brand' => 'Pampers'])); ?>" 
                                   class="bg-white text-orange-600 px-2 sm:px-3 py-1.5 sm:py-2 rounded-md text-xs sm:text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                                    Pampers
                                </a>
                                <a href="<?php echo e(route('products.index', ['category' => [13], 'brand' => 'Johnson'])); ?>" 
                                   class="bg-white text-orange-600 px-2 sm:px-3 py-1.5 sm:py-2 rounded-md text-xs sm:text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                                    Johnson's
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3 sm:mt-4 pt-2 sm:pt-3 border-t border-orange-100">
                        <a href="<?php echo e(route('products.index')); ?>" class="text-orange-600 text-xs sm:text-sm font-medium hover:text-orange-700 transition-colors flex items-center justify-center">
                            <span class="ml-1">👁️</span> عرض جميع المنتجات
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <ul class="flex list-none m-0 p-0 flex-wrap">
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="<?php echo e(route('about')); ?>" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300 transition-colors">
                    عن الشركة
                </a>
            </li>
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="<?php echo e(route('offers')); ?>" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300 transition-colors">
                    العروض
                </a>
            </li>
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="<?php echo e(route('products.index', ['category' => [1]])); ?>" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300 transition-colors">
                    ألعاب
                </a>
            </li>
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="<?php echo e(route('products.index', ['category' => [7]])); ?>" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300 transition-colors">
                    أحذية
                </a>
            </li>
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="<?php echo e(route('products.index', ['category' => [13]])); ?>" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300 transition-colors">
                    مستلزمات أطفال
                </a>
            </li>
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="<?php echo e(route('products.index')); ?>" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300 transition-colors">
                    جميع المنتجات
                </a>
            </li>
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="<?php echo e(route('contact')); ?>" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300 transition-colors">
                    اتصل بنا
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Mobile Navigation -->
<nav class="bg-orange-500 text-white md:hidden">
    <div class="px-4 py-3">
        <!-- Mobile Top Bar -->
        <div class="flex justify-between items-center">
            <button id="mobile-nav-toggle" class="bg-white text-orange-500 border-none py-2 px-3 rounded flex items-center font-bold text-sm hover:bg-gray-100 transition-colors">
                <span class="ml-1">≡</span> القائمة
            </button>
            <!-- Mobile Brands Button -->
            <button id="mobile-brands-toggle" class="bg-white text-orange-500 border-none py-2 px-3 rounded flex items-center font-bold text-sm hover:bg-gray-100 transition-colors">
                <span class="ml-1">⭐</span> العلامات
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-nav-menu" class="hidden mt-3 bg-orange-600 rounded-lg p-4">
            <ul class="space-y-3">
                <li>
                    <a href="<?php echo e(route('products.index')); ?>" class="block text-white font-medium py-2 px-3 rounded hover:bg-orange-700 transition-colors">
                        🏠 جميع المنتجات
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('products.index', ['category' => [1]])); ?>" class="block text-white font-medium py-2 px-3 rounded hover:bg-orange-700 transition-colors">
                        🧸 ألعاب
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('products.index', ['category' => [7]])); ?>" class="block text-white font-medium py-2 px-3 rounded hover:bg-orange-700 transition-colors">
                        👟 أحذية
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('products.index', ['category' => [13]])); ?>" class="block text-white font-medium py-2 px-3 rounded hover:bg-orange-700 transition-colors">
                        🎒 مستلزمات أطفال
                    </a>
                </li>
                <li class="border-t border-orange-500 pt-3 mt-3">
                    <a href="<?php echo e(route('offers')); ?>" class="block text-white font-medium py-2 px-3 rounded hover:bg-orange-700 transition-colors">
                        🎁 العروض
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('about')); ?>" class="block text-white font-medium py-2 px-3 rounded hover:bg-orange-700 transition-colors">
                        ℹ️ عن الشركة
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('contact')); ?>" class="block text-white font-medium py-2 px-3 rounded hover:bg-orange-700 transition-colors">
                        📞 اتصل بنا
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Mobile Brands Dropdown -->
        <div id="mobile-brands-menu" class="hidden mt-3 bg-white rounded-lg shadow-lg border border-orange-200 p-4">
            <h3 class="text-orange-600 font-bold text-base mb-3 border-b border-orange-100 pb-2">العلامات التجارية المشهورة</h3>
            
            <div class="space-y-3">
                <!-- Games Category - Mobile -->
                <div class="bg-orange-50 rounded-lg p-3">
                    <h4 class="text-orange-700 font-semibold text-sm mb-2 flex items-center">
                        🧸 ألعاب
                    </h4>
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('products.index', ['category' => [1], 'brand' => 'LEGO'])); ?>" 
                           class="bg-white text-orange-600 px-3 py-2 rounded-md text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                            LEGO
                        </a>
                        <a href="<?php echo e(route('products.index', ['category' => [1], 'brand' => 'Fisher-Price'])); ?>" 
                           class="bg-white text-orange-600 px-3 py-2 rounded-md text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                            Fisher-Price
                        </a>
                    </div>
                </div>
                
                <!-- Shoes Category - Mobile -->
                <div class="bg-orange-50 rounded-lg p-3">
                    <h4 class="text-orange-700 font-semibold text-sm mb-2 flex items-center">
                        👟 أحذية
                    </h4>
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('products.index', ['category' => [7], 'brand' => 'Nike'])); ?>" 
                           class="bg-white text-orange-600 px-3 py-2 rounded-md text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                            Nike
                        </a>
                        <a href="<?php echo e(route('products.index', ['category' => [7], 'brand' => 'Adidas'])); ?>" 
                           class="bg-white text-orange-600 px-3 py-2 rounded-md text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                            Adidas
                        </a>
                    </div>
                </div>
                
                <!-- Kids Supplies Category - Mobile -->
                <div class="bg-orange-50 rounded-lg p-3">
                    <h4 class="text-orange-700 font-semibold text-sm mb-2 flex items-center">
                        🎒 مستلزمات أطفال
                    </h4>
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('products.index', ['category' => [13], 'brand' => 'Pampers'])); ?>" 
                           class="bg-white text-orange-600 px-3 py-2 rounded-md text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                            Pampers
                        </a>
                        <a href="<?php echo e(route('products.index', ['category' => [13], 'brand' => 'Johnson'])); ?>" 
                           class="bg-white text-orange-600 px-3 py-2 rounded-md text-sm font-medium hover:bg-orange-100 transition-colors flex-1 text-center border border-orange-200">
                            Johnson's
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 pt-3 border-t border-orange-100">
                <a href="<?php echo e(route('products.index')); ?>" class="text-orange-600 text-sm font-medium hover:text-orange-700 transition-colors flex items-center justify-center">
                    <span class="ml-1">👁️</span> عرض جميع المنتجات
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation Toggle
    const toggleButton = document.getElementById('mobile-nav-toggle');
    const mobileMenu = document.getElementById('mobile-nav-menu');
    
    // Mobile Brands Toggle
    const mobileBrandsToggle = document.getElementById('mobile-brands-toggle');
    const mobileBrandsMenu = document.getElementById('mobile-brands-menu');
    
    // Desktop Brands Dropdown Toggle
    const brandsToggle = document.getElementById('brands-dropdown-toggle');
    const brandsDropdown = document.getElementById('brands-dropdown');
    
    // Auto-close dropdowns on page load (especially for products page)
    function closeAllDropdowns() {
        if (mobileMenu) mobileMenu.classList.add('hidden');
        if (mobileBrandsMenu) mobileBrandsMenu.classList.add('hidden');
        if (brandsDropdown) brandsDropdown.classList.add('hidden');
    }
    
    // Close dropdowns immediately on page load
    closeAllDropdowns();
    
    // Mobile navigation menu functionality
    if (toggleButton && mobileMenu) {
        toggleButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            // Close brands menu when opening nav menu
            if (mobileBrandsMenu) {
                mobileBrandsMenu.classList.add('hidden');
            }
        });
    }
    
    // Mobile brands menu functionality
    if (mobileBrandsToggle && mobileBrandsMenu) {
        mobileBrandsToggle.addEventListener('click', function() {
            mobileBrandsMenu.classList.toggle('hidden');
            // Close nav menu when opening brands menu
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
            }
        });
        
        // Close mobile brands menu when clicking on a brand link
        const mobileBrandLinks = mobileBrandsMenu.querySelectorAll('a');
        mobileBrandLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileBrandsMenu.classList.add('hidden');
            });
        });
    }
    
    // Desktop brands dropdown functionality
    if (brandsToggle && brandsDropdown) {
        brandsToggle.addEventListener('click', function(event) {
            event.stopPropagation();
            brandsDropdown.classList.toggle('hidden');
        });
        
        // Close desktop brands dropdown when clicking on a brand link
        const brandLinks = brandsDropdown.querySelectorAll('a');
        brandLinks.forEach(link => {
            link.addEventListener('click', function() {
                brandsDropdown.classList.add('hidden');
            });
        });
    }
    
    // Close all dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        // Close mobile menus
        if (mobileMenu && toggleButton && 
            !toggleButton.contains(event.target) && 
            !mobileMenu.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
        
        if (mobileBrandsMenu && mobileBrandsToggle && 
            !mobileBrandsToggle.contains(event.target) && 
            !mobileBrandsMenu.contains(event.target)) {
            mobileBrandsMenu.classList.add('hidden');
        }
        
        // Close desktop brands dropdown
        if (brandsDropdown && brandsToggle && 
            !brandsToggle.contains(event.target) && 
            !brandsDropdown.contains(event.target)) {
            brandsDropdown.classList.add('hidden');
        }
    });
    
    // Handle window resize to close mobile menus on desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) { // md breakpoint
            closeAllDropdowns();
        }
    });
    
    // Close dropdowns when navigating (before page unload)
    window.addEventListener('beforeunload', function() {
        closeAllDropdowns();
    });
    
    // Also close dropdowns on hash/history changes
    window.addEventListener('popstate', function() {
        closeAllDropdowns();
    });
});
</script>



<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/components/navigation.blade.php ENDPATH**/ ?>