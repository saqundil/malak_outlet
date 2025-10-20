<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\ProductReview;
use App\Models\User;

class PopularProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('⭐ إضافة تقييمات ومراجعات للمنتجات...');
        
        $products = Product::all();
        $users = User::where('email', '!=', 'admin@malakoutlet.com')->get();
        
        if ($users->count() == 0) {
            $this->command->info('❌ لا توجد مستخدمين لإضافة التقييمات');
            return;
        }
        
        // Arabic review comments
        $reviewComments = [
            'منتج رائع جداً، أطفالي يحبونه كثيراً',
            'جودة ممتازة وسعر مناسب جداً',
            'وصل في الوقت المحدد والتغليف رائع',
            'ابنتي سعيدة جداً بهذا المنتج',
            'مناسب تماماً للعمر المذكور وآمن',
            'ألوان زاهية وجميلة جداً',
            'قيمة رائعة مقابل السعر',
            'مقاوم ومتين، يتحمل اللعب الكثير',
            'تصميم جميل وعملي في نفس الوقت',
            'أنصح بشرائه بقوة للأطفال',
            'منتج تعليمي ومفيد جداً',
            'مريح جداً في الاستخدام اليومي',
            'حجم مناسب ومثالي للأطفال',
            'ابني يلعب به يومياً ولا يمل',
            'سهل التنظيف والصيانة',
            'خامات عالية الجودة',
            'يستحق كل ريال دفعته فيه',
            'منتج آمن ومطابق للمواصفات',
            'تسليم سريع وخدمة ممتازة',
            'بناتي يحبونه أكثر من ألعابهن القديمة',
        ];
        
        $reviewCount = 0;
        
        // Add reviews to random products
        $reviewedProducts = $products->random(min(35, $products->count()));
        
        foreach ($reviewedProducts as $product) {
            $numReviews = rand(2, 8); // 2-8 reviews per product
            $productUsers = $users->random(min($numReviews, $users->count()));
            
            foreach ($productUsers as $user) {
                ProductReview::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'rating' => rand(3, 5), // Rating between 3-5 stars
                    'comment' => $reviewComments[array_rand($reviewComments)],
                    'is_approved' => true, // All approved for demo
                    'is_deleted' => false,
                ]);
                $reviewCount++;
            }
        }
        
        $this->command->info("✅ تم إضافة {$reviewCount} تقييم على {$reviewedProducts->count()} منتج");
        $this->command->info('🎉 المتجر جاهز بالكامل مع منتجات وتقييمات لجميع التصنيفات!');
    }
}
