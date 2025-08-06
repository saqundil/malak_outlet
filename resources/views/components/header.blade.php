<!-- Professional Header Search -->
<header class="bg-gradient-to-l to-orange-600 from-orange-500 text-white px-4 md:px-10 py-4 sticky top-0 z-50" x-data="headerData()">
    <div class="container mx-auto">
        <!-- Main Header Row -->
        <div class="flex items-center justify-between flex-wrap gap-4">
            
            <!-- Logo Section -->
            <div class="flex items-center order-1">
                <a href="{{ route('home') }}" class="text-xl lg:text-3xl font-bold text-white no-underline flex items-center hover:scale-105 transition-transform duration-200">
                <img src="{{ asset('images/malak.png') }}" alt="MalakOutlet Logo" class="w-16 md:w-20 lg:w-20 ml-2 hover:opacity-80 transition-opacity duration-200" />
                    <div class="flex flex-col">
                        <span class="leading-tight">متجر ملاك</span>
                        <span class="text-xs lg:text-sm font-normal opacity-90 leading-tight">Malak Outlet</span>
                    </div>
                </a>
            </div>

            <!-- Enhanced Desktop Search -->
            <div class="hidden md:block order-2 flex-grow max-w-2xl mx-4 lg:mx-8" x-data="searchBox()">
                <div class="relative">
                    <form action="{{ route('search') }}" method="GET" class="flex w-full bg-white rounded-xl overflow-hidden shadow-lg border-2 border-white/20 hover:border-white/40 transition-all duration-200">
                        <div class="flex-grow relative">
                            <input type="text" 
                                   name="q" 
                                   value="{{ request('q') }}" 
                                   placeholder="ابحث عن المنتجات، العلامات التجارية، الفئات..."
                                   x-model="query"
                                   @keyup="searchProducts"
                                   @focus="showSuggestions = true"
                                   @keydown.escape="showSuggestions = false"
                                   @keydown.enter="if(suggestions.length > 0) { selectSuggestion(suggestions[0]) } else { submitSearch() }"
                                   class="w-full px-5 py-3 border-none text-right text-gray-700 outline-none text-base placeholder-gray-400" />
                            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                
                            </div>
                        </div>
                        <button type="button" @click="submitSearch()" class="px-6 bg-orange-500 text-white border-none font-bold hover:bg-orange-600 transition-colors duration-200 flex items-center justify-center">
                            <span class="hidden lg:inline ml-2">بحث</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                    
                    <!-- Enhanced Search Suggestions -->
                    <div x-show="showSuggestions && suggestions.length > 0" 
                         @click.away="showSuggestions = false"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
                         class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 max-h-80 overflow-y-auto"
                         style="display: none;">
                        
                        <div class="p-3 border-b border-gray-100 bg-gray-50 rounded-t-xl">
                            <h3 class="text-sm font-semibold text-gray-600 text-right">نتائج البحث المقترحة</h3>
                        </div>
                        
                        <template x-for="suggestion in suggestions.slice(0, 6)" :key="suggestion.id">
                            <a :href="'/products/' + suggestion.id" 
                               class="flex items-center p-4 hover:bg-orange-50 border-b border-gray-50 last:border-b-0 transition-colors duration-200 group"
                               @click="showSuggestions = false">
                                <div class="w-12 h-12 ml-4 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 shadow-sm">
                                    <template x-if="suggestion.image">
                                        <img :src="suggestion.image" 
                                             :alt="suggestion.name" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
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
                                    <h4 class="text-sm font-semibold text-gray-800 group-hover:text-orange-600 transition-colors duration-200" x-text="suggestion.name"></h4>
                                    <p class="text-sm text-orange-600 font-bold mt-1" x-text="(suggestion.sale_price || suggestion.price) + ' د.أ'"></p>
                                    <p class="text-xs text-gray-500 mt-1" x-text="suggestion.category_name || 'منتج'"></p>
                                </div>
                                <div class="text-gray-400 group-hover:text-orange-500 transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                        </template>
                        
                        <div x-show="query.length > 0 && suggestions.length === 0 && !isLoading" 
                             class="p-4 text-center text-gray-500 text-sm">
                            لا توجد نتائج للبحث عن "<span x-text="query"></span>"
                        </div>
                        
                        <div x-show="isLoading" class="p-4 text-center">
                            <svg class="animate-spin h-5 w-5 text-orange-500 mx-auto" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        
                        <div class="p-3 bg-gray-50 rounded-b-xl border-t border-gray-100">
                            <button @click="redirectToProductsPage()" class="w-full text-center text-orange-600 hover:text-orange-700 font-medium text-sm transition-colors duration-200 py-1">
                                عرض جميع النتائج
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Right Section with Icons and User Menu -->
            <div class="flex items-center order-3 gap-3">
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = true" class="md:hidden text-white text-2xl p-2 hover:bg-gray-200 hover:bg-opacity-10 rounded-lg transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Enhanced Wishlist Icon -->
                <a href="{{ route('wishlist') }}" class="relative group p-2 hover:bg-gray-200 hover:bg-opacity-10 rounded-lg transition-all duration-200 hidden sm:block">
                    <svg class="w-6 h-6 md:w-7 md:h-7 group-hover:scale-110 transition-transform duration-200" viewBox="0 0 24 24" fill="none">
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
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold animate-pulse" id="wishlist-count">
                                {{ $wishlistCount }}
                            </span>
                        @endif
                    @endauth
                </a>
                
                <!-- Enhanced Cart Icon -->
                <a href="{{ route('cart') }}" class="relative group p-2 hover:bg-gray-200 hover:bg-opacity-10 rounded-lg transition-all duration-200">
                    <svg class="w-6 h-6 md:w-7 md:h-7 group-hover:scale-110 transition-transform duration-200" viewBox="0 0 24 24" fill="none">
                        <path d="M7.5 21.75C8.32843 21.75 9 21.0784 9 20.25C9 19.4216 8.32843 18.75 7.5 18.75C6.67157 18.75 6 19.4216 6 20.25C6 21.0784 6.67157 21.75 7.5 21.75Z" fill="currentColor"/>
                        <path d="M17.25 21.75C18.0784 21.75 18.75 21.0784 18.75 20.25C18.75 19.4216 18.0784 18.75 17.25 18.75C16.4216 18.75 15.75 19.4216 15.75 20.25C15.75 21.0784 16.4216 21.75 17.25 21.75Z" fill="currentColor"/>
                        <path d="M3.96469 6.75H21L18.3262 15.4416C18.2318 15.7482 18.0415 16.0165 17.7833 16.207C17.5252 16.3975 17.2127 16.5002 16.8919 16.5H7.88156C7.55556 16.5001 7.23839 16.3941 6.97806 16.1978C6.71772 16.0016 6.5284 15.7259 6.43875 15.4125L3.04781 3.54375C3.00301 3.38711 2.90842 3.24932 2.77835 3.15122C2.64828 3.05311 2.4898 3.00003 2.32687 3H0.75"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    @php
                        $cartJson = request()->cookie('shopping_cart', '[]');
                        $cart = json_decode($cartJson, true) ?: [];
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold animate-pulse" id="cart-count">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                
                <!-- Enhanced User Authentication -->
                @guest
                    <a href="{{ route('login') }}" class="hidden md:flex items-center text-sm lg:text-base text-white no-underline hover:bg-gray-200 hover:bg-opacity-10 px-3 py-2 rounded-lg transition-all duration-200 font-medium">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        تسجيل دخول
                    </a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="hidden md:flex items-center text-sm lg:text-base text-white no-underline hover:bg-white hover:bg-opacity-10 px-3 py-2 rounded-lg transition-all duration-200 font-medium">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center ml-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="truncate max-w-24">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 mr-2 transition-transform duration-200" :class="{ 'transform rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="open" 
                             @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden">
                            <div class="p-4 bg-gradient-to-r from-orange-50 to-orange-100 border-b border-orange-200">
                                <p class="font-semibold text-gray-800 text-right">مرحباً، {{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-600 text-right">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profile') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-200">
                                    <svg class="w-4 h-4 ml-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    الملف الشخصي
                                </a>
                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-200">
                                    <svg class="w-4 h-4 ml-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    طلباتي
                                </a>
                                @if(auth()->user()->is_admin)
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-orange-600 hover:bg-orange-50 font-medium">
                                        <svg class="w-4 h-4 ml-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        لوحة التحكم
                                    </a>
                                @endif
                                <div class="border-t border-gray-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-right px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                        <svg class="w-4 h-4 ml-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        تسجيل خروج
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>

        <!-- Enhanced Mobile Search -->
        <div class="w-full order-4 mt-4 md:hidden" x-data="mobileSearchBox()">
            <div class="relative">
                <form action="{{ route('search') }}" method="GET" class="flex w-full bg-white rounded-xl overflow-hidden shadow-lg">
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}" 
                           placeholder="ابحث عن المنتجات والعلامات التجارية..."
                           x-model="query"
                           @keyup="searchProducts"
                           @focus="showSuggestions = true"
                           @keydown.escape="showSuggestions = false"
                           @keydown.enter="if(suggestions.length > 0) { selectSuggestion(suggestions[0]) } else { submitSearch() }"
                           class="flex-grow px-4 py-3 border-none text-right text-gray-700 outline-none placeholder-gray-400" />
                    <button type="button" @click="submitSearch()" class="px-5 bg-orange-500 text-white border-none font-bold hover:bg-orange-600 transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
                
                <!-- Enhanced Mobile Search Suggestions -->
                <div x-show="showSuggestions && suggestions.length > 0" 
                     @click.away="showSuggestions = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 max-h-72 overflow-y-auto"
                     style="display: none;">
                    
                    <div class="p-3 border-b border-gray-100 bg-gray-50 rounded-t-xl">
                        <h3 class="text-sm font-semibold text-gray-600 text-right">نتائج البحث</h3>
                    </div>
                    
                    <template x-for="suggestion in suggestions.slice(0, 5)" :key="suggestion.id">
                        <a :href="'/products/' + suggestion.id" 
                           class="flex items-center p-3 hover:bg-orange-50 border-b border-gray-50 last:border-b-0 transition-colors duration-200"
                           @click="showSuggestions = false">
                            <div class="w-10 h-10 ml-3 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
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
                                <p class="text-sm text-orange-600 font-semibold" x-text="(suggestion.sale_price || suggestion.price) + ' د.أ'"></p>
                            </div>
                        </a>
                    </template>
                    
                    <div x-show="query.length > 0 && suggestions.length === 0 && !isLoading" 
                         class="p-4 text-center text-gray-500 text-sm">
                        لا توجد نتائج
                    </div>
                    
                    <div class="p-3 bg-gray-50 rounded-b-xl border-t border-gray-100">
                        <button @click="redirectToProductsPage()" class="w-full text-center text-orange-600 hover:text-orange-700 font-medium text-sm py-1">
                            عرض جميع النتائج
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</header>

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

@include('components.navigation')
<script src="{{ asset('js/app-utils.js') }}"></script>
<script src="{{ asset('js/search.js') }}"></script>

<script>
// Set global variables for JavaScript
window.APP_URL = '{{ url('/') }}';
window.API_SEARCH_URL = '{{ route('api.search.suggestions') }}';
window.isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
</script>
