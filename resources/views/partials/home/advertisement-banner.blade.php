<!-- Large Advertisement Banner -->
<section class="my-8 md:my-12">
    <div class="relative bg-gradient-to-r from-purple-600 via-pink-600 to-orange-600 rounded-2xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-8 p-8 md:p-12">
            <div class="flex flex-col justify-center text-white">
                <div class="inline-flex items-center bg-white bg-opacity-20 rounded-full px-4 py-2 mb-4 w-fit">
                    <span class="text-yellow-300 ml-2">⚡</span>
                    <span class="text-sm font-bold">عرض لفترة محدودة</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-bold mb-4 leading-tight">
                    خصومات تصل إلى 
                    <span class="text-yellow-300">70%</span>
                </h2>
                <p class="text-lg md:text-xl mb-6 opacity-90">على مجموعة مختارة من أفضل المنتجات</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.index', ['filter' => 'sale']) }}" 
                       class="inline-flex items-center justify-center bg-white text-purple-600 font-bold py-3 px-8 rounded-xl hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg no-underline">
                        <span>تسوق الآن</span>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center justify-center border-2 border-white text-white font-bold py-3 px-8 rounded-xl hover:bg-white hover:text-purple-600 transition-all duration-300 no-underline">
                        استكشف المزيد
                    </a>
                </div>
            </div>
            
            <div class="flex items-center justify-center">
                <div class="relative">
                    <div class="w-64 h-64 md:w-80 md:h-80 bg-white bg-opacity-10 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <div class="w-48 h-48 md:w-64 md:h-64 bg-white bg-opacity-20 rounded-full flex items-center justify-center animate-pulse">
                            <svg class="w-24 h-24 md:w-32 md:h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Floating discount badges -->
                    <div class="absolute -top-4 -right-4 bg-yellow-400 text-purple-600 rounded-full w-16 h-16 flex items-center justify-center font-bold text-lg animate-bounce">
                        50%
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-orange-400 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold animate-bounce" style="animation-delay: 0.5s">
                        70%
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
