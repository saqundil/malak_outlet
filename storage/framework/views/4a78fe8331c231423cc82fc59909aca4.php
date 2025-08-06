<!-- Desktop Navigation -->
<nav class="bg-gradient-to-l to-orange-600 from-orange-500 text-white px-4 md:px-10 py-4 hidden md:block">
    <div class="flex justify-between items-center container mx-auto flex-wrap">
        <button class="bg-white text-orange-500 border-none py-2 px-4 rounded flex items-center font-bold text-sm lg:text-base hover:bg-gray-100 transition-colors">
            <span class="ml-2">≡</span> تصفح جميع الفئات
        </button>

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
            <button class="bg-white text-orange-500 border-none py-2 px-3 rounded flex items-center font-bold text-sm hover:bg-gray-100 transition-colors">
                <span class="ml-1">🔍</span> بحث
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
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('mobile-nav-toggle');
    const mobileMenu = document.getElementById('mobile-nav-menu');
    
    if (toggleButton && mobileMenu) {
        toggleButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!toggleButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    }
});
</script>



<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/components/navigation.blade.php ENDPATH**/ ?>