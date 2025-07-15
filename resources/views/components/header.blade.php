<header class="bg-orange-500 text-white px-10 md:px-10 py-4 sticky top-0 z-50">
    <div class="flex justify-between items-center container mx-auto">
        <!-- Left side with logo and search bar -->
        <div class="flex items-center flex-1 space-x-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img src="{{ asset('images/malak.png') }}" alt="MalakOutlet Logo" class="w-16 md:w-20 lg:w-20 ml-6 hover:opacity-80 transition-opacity duration-200" />
            </a>

            <!-- Search Bar - Desktop -->
            <div class="hidden md:flex flex-1 max-w-md mr-6" x-data="searchBox()">
                <div class="relative w-full">
                    <form action="{{ route('search') }}" method="GET" class="flex w-full bg-white rounded-full overflow-hidden">
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}" 
                               placeholder="عما تبحث؟"
                               x-model="query"
                               @keyup="searchProducts"
                               @focus="showSuggestions = true"
                               @keydown.escape="showSuggestions = false"
                               @keydown.enter="if(suggestions.length > 0) { selectSuggestion(suggestions[0]) } else { $el.closest('form').submit() }"
                               class="flex-grow px-4 py-2 border-none text-right text-gray-700 outline-none" />
                        <button type="submit" class="px-4 bg-white text-orange-500 border-none font-bold">🔍</button>
                    </form>
                    
                    <!-- Search Suggestions Dropdown -->
                    <div x-show="showSuggestions && suggestions.length > 0" 
                         @click.away="showSuggestions = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="absolute top-full left-0 right-0 mt-1 bg-white rounded-lg shadow-xl border border-gray-100 z-50 max-h-96 overflow-y-auto">
                        
                        <template x-for="suggestion in suggestions.slice(0, 5)" :key="suggestion.id">
                            <a :href="'/products/' + suggestion.id" 
                               class="flex items-center p-3 hover:bg-gray-50 border-b border-gray-50 last:border-b-0"
                               @click="showSuggestions = false">
                                <div class="w-12 h-12 ml-3 rounded overflow-hidden bg-gray-100 flex-shrink-0">
                                    <template x-if="suggestion.image">
                                        <img :src="suggestion.image" 
                                             :alt="suggestion.name" 
                                             class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!suggestion.image">
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </template>
                                </div>
                                <div class="flex-1 text-right">
                                    <h4 class="text-sm font-medium text-gray-800" x-text="suggestion.name"></h4>
                                    <p class="text-xs text-gray-500" x-text="suggestion.category"></p>
                                    <p class="text-sm text-orange-600 font-semibold">
                                        <span x-text="suggestion.sale_price || suggestion.price"></span> د.أ
                                        <span x-show="suggestion.sale_price" 
                                              class="text-xs text-gray-400 line-through mr-2" 
                                              x-text="suggestion.price"></span>
                                    </p>
                                </div>
                            </a>
                        </template>
                        
                        <div x-show="query.length > 0 && suggestions.length === 0 && !isLoading" 
                             class="p-4 text-center text-gray-500">
                            لا توجد نتائج للبحث
                        </div>
                        
                        <div x-show="isLoading" class="p-4 text-center">
                            <svg class="animate-spin h-5 w-5 text-orange-500 mx-auto" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Icons -->
        <div class="flex items-center">
            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = true" class="md:hidden mr-4 text-white text-2xl">
                ☰
            </button>

            <!-- Icons -->
            <div class="flex items-center">
                <!-- Wishlist -->
                <a href="{{ route('wishlist') }}" class="relative mr-2 lg:mr-4">
                    <svg class="w-6 h-6 md:w-7 md:h-7" viewBox="0 0 24 24" fill="none">
                        <path d="M12 20.25C12 20.25 2.25 15 2.25 8.8125C2.25 7.46984 2.78337 6.18217 3.73277 5.23277C4.68217 4.28337 5.96984 3.75 7.3125 3.75C9.43031 3.75 11.2444 4.90406 12 6.75C12.7556 4.90406 14.5697 3.75 16.6875 3.75C18.0302 3.75 19.3178 4.28337 20.2672 5.23277C21.2166 6.18217 21.75 7.46984 21.75 8.8125C21.75 15 12 20.25 12 20.25Z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    @auth
                        @php
                            $wishlistCount = 0;
                            try {
                                $wishlistCount = auth()->user()->wishlistItems()->count();
                            } catch (Exception $e) {
                                $wishlistCount = 0;
                            }
                        @endphp
                        @if($wishlistCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" id="wishlist-count">
                                {{ $wishlistCount }}
                            </span>
                        @endif
                    @endauth
                </a>
                
                <!-- Cart -->
                <a href="{{ route('cart') }}" class="relative mr-2 lg:mr-4">
                    <svg class="w-6 h-6 md:w-7 md:h-7" viewBox="0 0 24 24" fill="none">
                        <path d="M7.5 21.75C8.32843 21.75 9 21.0784 9 20.25C9 19.4216 8.32843 18.75 7.5 18.75C6.67157 18.75 6 19.4216 6 20.25C6 21.0784 6.67157 21.75 7.5 21.75Z" fill="currentColor"/>
                        <path d="M17.25 21.75C18.0784 21.75 18.75 21.0784 18.75 20.25C18.75 19.4216 18.0784 18.75 17.25 18.75C16.4216 18.75 15.75 19.4216 15.75 20.25C15.75 21.0784 16.4216 21.75 17.25 21.75Z" fill="currentColor"/>
                        <path d="M3.96469 6.75H21L18.3262 15.4416C18.2318 15.7482 18.0415 16.0165 17.7833 16.207C17.5252 16.3975 17.2127 16.5002 16.8919 16.5H7.88156C7.55556 16.5001 7.23839 16.3941 6.97806 16.1978C6.71772 16.0016 6.5284 15.7259 6.43875 15.4125L3.04781 3.54375C3.00301 3.38711 2.90842 3.24932 2.77835 3.15122C2.64828 3.05311 2.4898 3.00003 2.32687 3H0.75"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    @php
                        $cart = json_decode(request()->cookie('cart', '[]'), true);
                        $cartCount = array_sum($cart);
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" id="cart-count">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                
                <!-- Login/Register -->
                @guest
                    <a href="{{ route('login') }}" class="hidden md:block text-sm lg:text-base text-white no-underline mr-2 lg:mr-4">
                        تسجيل دخول / تسجيل
                    </a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="hidden md:flex items-center text-sm lg:text-base text-white no-underline mr-2 lg:mr-4">
                            {{ auth()->user()->name }}
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                            <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">الملف الشخصي</a>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">طلباتي</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">تسجيل خروج</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>

    <!-- Mobile Search -->
    <div class="w-full order-4 mt-3 md:hidden" x-data="mobileSearchBox()">
        <div class="relative">
            <form action="{{ route('search') }}" method="GET" class="flex w-full bg-white rounded-full overflow-hidden">
                <input type="text" 
                       name="q" 
                       value="{{ request('q') }}" 
                       placeholder="عما تبحث؟"
                       x-model="query"
                       @keyup="searchProducts"
                       @focus="showSuggestions = true"
                       @keydown.escape="showSuggestions = false"
                       @keydown.enter="if(suggestions.length > 0) { selectSuggestion(suggestions[0]) } else { $el.closest('form').submit() }"
                       class="flex-grow px-4 py-2 border-none text-right text-gray-700 outline-none" />
                <button type="submit" class="px-4 bg-white text-orange-500 border-none font-bold">🔍</button>
            </form>
            
            <!-- Mobile Search Suggestions -->
            <div x-show="showSuggestions && suggestions.length > 0" 
                 @click.away="showSuggestions = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="absolute top-full left-0 right-0 mt-1 bg-white rounded-lg shadow-xl border border-gray-100 z-50 max-h-64 overflow-y-auto">
                
                <template x-for="suggestion in suggestions.slice(0, 5)" :key="suggestion.id">
                    <a :href="'/products/' + suggestion.id" 
                       class="flex items-center p-3 hover:bg-gray-50 border-b border-gray-50 last:border-b-0"
                       @click="showSuggestions = false">
                        <div class="w-10 h-10 ml-3 rounded overflow-hidden bg-gray-100 flex-shrink-0">
                            <template x-if="suggestion.image">
                                <img :src="suggestion.image" 
                                     :alt="suggestion.name" 
                                     class="w-full h-full object-cover">
                            </template>
                            <template x-if="!suggestion.image">
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </template>
                        </div>
                        <div class="flex-1 text-right">
                            <h4 class="text-sm font-medium text-gray-800" x-text="suggestion.name"></h4>
                            <p class="text-xs text-orange-600 font-semibold" x-text="(suggestion.sale_price || suggestion.price) + ' د.أ'"></p>
                        </div>
                    </a>
                </template>
            </div>
        </div>
    </div>
</header>

<!-- Desktop Navigation -->
<nav class="bg-orange-500 text-white px-4 md:px-10 pb-3 hidden md:block">
    <div class="flex justify-between items-center container mx-auto flex-wrap">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="bg-white text-orange-500 border-none py-2 px-4 rounded flex items-center font-bold text-sm lg:text-base hover:bg-gray-100 transition duration-200">
                <span class="ml-2">≡</span> تصفح جميع الفئات
                <svg class="w-4 h-4 mr-2 transition-transform duration-200" :class="{ 'transform rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
            
            <!-- Categories Dropdown -->
            <div x-show="open" 
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="absolute top-full left-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                
                <div class="p-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 text-right">جميع الفئات</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @php
                            $categoriesForDropdown = \App\Models\Category::with('brands')->get();
                            $categoryIcons = [
                                'electronics' => '📱',
                                'clothing' => '👕', 
                                'home-garden' => '🏠',
                                'sports-fitness' => '⚽',
                                'books' => '📚',
                                'toys-games' => '🎮',
                                'beauty-health' => '💄',
                                'automotive' => '🚗'
                            ];
                        @endphp
                        
                        @foreach($categoriesForDropdown as $category)
                            <a href="{{ route('products.category', $category->slug) }}" 
                               class="flex items-center p-3 rounded-lg hover:bg-orange-50 transition duration-200 group"
                               @click="open = false">
                                <span class="text-2xl ml-3">{{ $categoryIcons[$category->slug] ?? '🛍️' }}</span>
                                <div class="text-right">
                                    <div class="font-medium text-gray-800 group-hover:text-orange-600">{{ $category->name }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $category->products_count ?? 0 }} منتج
                                        @if($category->brands->count() > 0)
                                            • {{ $category->brands->count() }} علامة تجارية
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        
                        <!-- View All Categories Link -->
                        <a href="{{ route('categories.index') }}" 
                           class="col-span-2 flex items-center justify-center p-3 mt-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition duration-200 font-medium"
                           @click="open = false">
                            عرض جميع الفئات
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <ul class="flex list-none m-0 p-0 flex-wrap">
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="{{ route('about') }}" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300">عن الشركة</a>
            </li>
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="{{ route('offers') }}" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300">العروض</a>
            </li>
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="{{ route('products.category', 'toys-games') }}" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300">الألعاب</a>
            </li>
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="{{ route('products.category', 'electronics') }}" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300">إلكترونيات</a>
            </li>
            <li class="mr-3 lg:mr-6 relative font-bold">
                <a href="{{ route('products.index') }}" class="text-white no-underline text-sm lg:text-base flex items-center hover:text-yellow-300">جميع المنتجات</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
    class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"></div>

<!-- Mobile Side Menu -->
<div class="fixed top-0 right-0 w-3/4 h-full bg-white shadow-2xl z-50 transform transition-transform duration-300 mobile-menu md:hidden"
    :class="{'translate-x-0': mobileMenuOpen, 'translate-x-full': !mobileMenuOpen}" x-show="mobileMenuOpen">
    <div class="p-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-bold text-orange-500">القائمة</h2>
            <button @click="mobileMenuOpen = false" class="text-gray-500 hover:text-gray-700">
                ✕
            </button>
        </div>
    </div>
    <div class="py-4">
        <ul class="list-none m-0 p-0">
            <li class="border-b border-gray-100">
                <a href="{{ route('products.category', 'toys-games') }}" class="block py-3 px-4 text-gray-700 hover:bg-orange-50">الألعاب</a>
            </li>
            <li class="border-b border-gray-100">
                <a href="{{ route('products.category', 'electronics') }}" class="block py-3 px-4 text-gray-700 hover:bg-orange-50">إلكترونيات</a>
            </li>
            <li class="border-b border-gray-100">
                <a href="{{ route('offers') }}" class="block py-3 px-4 text-gray-700 hover:bg-orange-50">العروض</a>
            </li>
            <li class="border-b border-gray-100">
                <a href="{{ route('about') }}" class="block py-3 px-4 text-gray-700 hover:bg-orange-50">عن الشركة</a>
            </li>
            <li class="border-b border-gray-100">
                <a href="{{ route('products.index') }}" class="block py-3 px-4 text-gray-700 hover:bg-orange-50">جميع المنتجات</a>
            </li>
            @guest
                <li class="border-b border-gray-100">
                    <a href="{{ route('login') }}" class="block py-3 px-4 text-gray-700 hover:bg-orange-50">تسجيل دخول / تسجيل</a>
                </li>
            @else
                <li class="border-b border-gray-100">
                    <a href="{{ route('profile') }}" class="block py-3 px-4 text-gray-700 hover:bg-orange-50">الملف الشخصي</a>
                </li>
                <li class="border-b border-gray-100">
                    <a href="{{ route('orders.index') }}" class="block py-3 px-4 text-gray-700 hover:bg-orange-50">طلباتي</a>
                </li>
            @endguest
        </ul>
    </div>
</div>

<script src="{{ asset('js/search.js') }}"></script>

<script>
// Set global variables for JavaScript
window.APP_URL = '{{ url('/') }}';
window.API_SEARCH_URL = '{{ route('api.search.suggestions') }}';
</script>