<!-- Toy Subcategories Section -->
<section class="my-8 md:my-10">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-xl md:text-2xl text-gray-800 m-0 font-bold">تصفح الألعاب</h2>
        <a href="{{ route('products.category', 'toys') }}" class="flex items-center text-orange-500 no-underline font-bold text-sm md:text-base">
            عرض جميع الألعاب ←
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
        @php
            $subcategoryIcons = [
                'educational-toys' => ['icon' => '🎓', 'color' => 'bg-gradient-to-br from-indigo-50 to-indigo-100', 'age' => 'عمر 2+', 'border' => 'border-indigo-200'],
                'electronic-toys' => ['icon' => '�', 'color' => 'bg-gradient-to-br from-blue-50 to-blue-100', 'age' => 'عمر 5+', 'border' => 'border-blue-200'],
                'building-toys' => ['icon' => '�', 'color' => 'bg-gradient-to-br from-red-50 to-red-100', 'age' => 'عمر 4+', 'border' => 'border-red-200'],
                'dolls' => ['icon' => '🪆', 'color' => 'bg-gradient-to-br from-pink-50 to-pink-100', 'age' => 'عمر 3+', 'border' => 'border-pink-200'],
                'outdoor-toys' => ['icon' => '�', 'color' => 'bg-gradient-to-br from-green-50 to-green-100', 'age' => 'عمر 6+', 'border' => 'border-green-200'],
                'board-games' => ['icon' => '🎲', 'color' => 'bg-gradient-to-br from-yellow-50 to-yellow-100', 'age' => 'عمر 8+', 'border' => 'border-yellow-200'],
            ];
        @endphp
        
        @if(isset($categories) && $categories->count() > 0)
            @php
                $toysCategory = $categories->where('slug', 'toys')->first();
                $toySubcategories = $toysCategory ? $toysCategory->children : collect();
            @endphp
            
            @if($toySubcategories->count() > 0)
                @foreach($toySubcategories as $subcategory)
                    @php
                        $iconData = $subcategoryIcons[$subcategory->slug] ?? ['icon' => '🧸', 'color' => 'bg-gradient-to-br from-orange-50 to-orange-100', 'age' => 'جميع الأعمار', 'border' => 'border-orange-200'];
                    @endphp
                    <a href="{{ route('products.category', $subcategory->slug) }}" 
                       class="group flex flex-col items-center p-4 md:p-6 rounded-xl bg-white shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-2 no-underline text-gray-700 border {{ $iconData['border'] }} hover:border-opacity-100">
                        <div class="w-16 h-16 md:w-20 md:h-20 {{ $iconData['color'] }} rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <span class="text-2xl md:text-3xl">{{ $iconData['icon'] }}</span>
                        </div>
                        <div class="font-bold text-center text-sm md:text-base group-hover:text-orange-600 transition-colors mb-2">{{ $subcategory->name }}</div>
                        <span class="inline-block py-1.5 px-3 bg-gradient-to-r from-orange-100 to-orange-200 text-orange-700 rounded-full text-xs font-medium shadow-sm">{{ $iconData['age'] }}</span>
                    </a>
                @endforeach
            @else
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">لا توجد فئات فرعية متاحة حالياً</p>
                </div>
            @endif
        @else
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">لا توجد فئات ألعاب متاحة حالياً</p>
            </div>
        @endif
    </div>
</section>
