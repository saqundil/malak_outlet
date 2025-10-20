<!-- Promotional Cards -->
<div class="flex flex-col md:flex-row my-5 gap-5">
    <!-- Card 1 -->
    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm flex flex-col md:flex-row w-full">
        <div class="flex-1 flex items-center justify-center p-4">
            <img src="{{ asset('images/pngegg.png') }}" alt="أحذية عالمية" class="max-w-full max-h-48 object-contain">
        </div>
        <div class="p-5 md:p-8 flex-1">
            <span class="inline-block py-1 px-3 bg-orange-50 text-orange-500 rounded-full font-bold mb-2 md:mb-4 text-xs md:text-sm">وصل حديثًا</span>
            <h2 class="text-xl md:text-2xl my-1 mb-2 md:mb-4">تشكيلتنا الجديدة من الأحذية العالمية وصلت!</h2>
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-orange-500 font-bold no-underline text-sm md:text-base">تصفح المجموعة ←</a>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm flex flex-col md:flex-row w-full mt-5 md:mt-0">
        <div class="flex-1 flex items-center justify-center p-4">
            <img src="{{ asset('images/baby.png') }}" alt="ألعاب تعليمية" class="max-w-full max-h-48 object-contain">
        </div>
        <div class="p-5 md:p-8 flex-1">
            <span class="inline-block py-1 px-3 bg-orange-50 text-orange-500 rounded-full font-bold mb-2 md:mb-4 text-xs md:text-sm">الأكثر رواجاً</span>
            <h2 class="text-xl md:text-2xl my-1 mb-2 md:mb-4">منتجات العناية بطفلك <br>بجودة تريحك وتريح طفلك.</h2>
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-orange-500 font-bold no-underline text-sm md:text-base">تصفح المجموعة ←</a>
        </div>
    </div>
</div>
