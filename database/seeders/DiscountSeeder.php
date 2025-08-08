<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing discounts
        DB::table('discount_product')->delete();
        DB::table('discount_category')->delete();
        DB::table('discounts')->delete();

        // Create percentage discounts
        $discounts = [
            [
                'name' => 'خصم نهاية الصيف',
                'description' => 'خصم كبير على مجموعة مختارة من الألعاب لنهاية الصيف',
                'discount_type' => 'percentage',
                'discount_value' => 25.00,
                'starts_at' => Carbon::now()->subDays(5),
                'ends_at' => Carbon::now()->addDays(15),
                'is_active' => true,
            ],
            [
                'name' => 'عروض العودة للمدارس',
                'description' => 'خصومات مميزة على الألعاب التعليمية والكتب',
                'discount_type' => 'percentage',
                'discount_value' => 20.00,
                'starts_at' => Carbon::now()->subDays(2),
                'ends_at' => Carbon::now()->addDays(20),
                'is_active' => true,
            ],
            [
                'name' => 'خصم الجمعة البيضاء',
                'description' => 'أكبر خصومات السنة على جميع المنتجات (محدود بـ 80%)',
                'discount_type' => 'percentage',
                'discount_value' => 80.00,
                'starts_at' => Carbon::now()->addDays(30),
                'ends_at' => Carbon::now()->addDays(35),
                'is_active' => true,
            ],
            [
                'name' => 'خصم أول الشهر',
                'description' => 'خصم ثابت 10 دنانير على المشتريات الكبيرة',
                'discount_type' => 'fixed',
                'discount_value' => 10.00,
                'starts_at' => Carbon::now()->subDays(3),
                'ends_at' => Carbon::now()->addDays(7),
                'is_active' => true,
            ],
            [
                'name' => 'خصم الألعاب الإلكترونية',
                'description' => 'خصم خاص على جميع الألعاب الإلكترونية',
                'discount_type' => 'percentage',
                'discount_value' => 15.00,
                'starts_at' => Carbon::now()->subDays(1),
                'ends_at' => Carbon::now()->addDays(10),
                'is_active' => true,
            ],
            [
                'name' => 'خصم منتهي الصلاحية',
                'description' => 'خصم انتهت فترته (للاختبار)',
                'discount_type' => 'percentage',
                'discount_value' => 30.00,
                'starts_at' => Carbon::now()->subDays(20),
                'ends_at' => Carbon::now()->subDays(5),
                'is_active' => true,
            ],
            [
                'name' => 'خصم غير مفعل',
                'description' => 'خصم معطل (للاختبار)',
                'discount_type' => 'percentage',
                'discount_value' => 50.00,
                'starts_at' => Carbon::now()->subDays(1),
                'ends_at' => Carbon::now()->addDays(30),
                'is_active' => false,
            ],
        ];

        // Create discounts
        foreach ($discounts as $discountData) {
            $discount = Discount::create($discountData);
            
            $this->command->info("Created discount: {$discount->name}");
        }

        // Get active discounts
        $activeDiscounts = Discount::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->get();

        // Get some products to assign discounts to
        $products = Product::active()->inStock()->limit(20)->get();
        $toysCategory = Category::where('name', 'LIKE', '%ألعاب%')
            ->orWhere('slug', 'toys-games')
            ->first();

        if ($activeDiscounts->count() > 0 && $products->count() > 0) {
            
            // Assign "خصم نهاية الصيف" to random products
            $summerDiscount = $activeDiscounts->where('name', 'خصم نهاية الصيف')->first();
            if ($summerDiscount) {
                $selectedProducts = $products->random(min(6, $products->count()));
                foreach ($selectedProducts as $product) {
                    $summerDiscount->products()->attach($product->id);
                }
                $this->command->info("Attached {$selectedProducts->count()} products to summer discount");
            }

            // Assign "عروض العودة للمدارس" to educational products
            $schoolDiscount = $activeDiscounts->where('name', 'عروض العودة للمدارس')->first();
            if ($schoolDiscount) {
                $educationalProducts = $products->filter(function ($product) {
                    return stripos($product->name, 'تعليم') !== false || 
                           stripos($product->name, 'تعلم') !== false ||
                           stripos($product->description, 'تعليمي') !== false;
                })->take(4);
                
                if ($educationalProducts->count() == 0) {
                    // If no educational products found, take random products
                    $educationalProducts = $products->random(min(4, $products->count()));
                }
                
                foreach ($educationalProducts as $product) {
                    $schoolDiscount->products()->attach($product->id);
                }
                $this->command->info("Attached {$educationalProducts->count()} products to school discount");
            }

            // Assign "خصم أول الشهر" to expensive products
            $monthlyDiscount = $activeDiscounts->where('name', 'خصم أول الشهر')->first();
            if ($monthlyDiscount) {
                $expensiveProducts = $products->sortByDesc('price')->take(3);
                foreach ($expensiveProducts as $product) {
                    $monthlyDiscount->products()->attach($product->id);
                }
                $this->command->info("Attached {$expensiveProducts->count()} products to monthly discount");
            }

            // Assign "خصم الألعاب الإلكترونية" to electronic toys
            $electronicDiscount = $activeDiscounts->where('name', 'خصم الألعاب الإلكترونية')->first();
            if ($electronicDiscount) {
                $electronicProducts = $products->filter(function ($product) {
                    return stripos($product->name, 'إلكترون') !== false || 
                           stripos($product->name, 'ريموت') !== false ||
                           stripos($product->name, 'تحكم') !== false ||
                           stripos($product->description, 'بطارية') !== false;
                })->take(5);
                
                if ($electronicProducts->count() == 0) {
                    $electronicProducts = $products->random(min(5, $products->count()));
                }
                
                foreach ($electronicProducts as $product) {
                    $electronicDiscount->products()->attach($product->id);
                }
                $this->command->info("Attached {$electronicProducts->count()} products to electronic toys discount");
            }

            // Assign category discount to toys category if it exists
            if ($toysCategory) {
                $categoryDiscount = $activeDiscounts->where('name', 'خصم نهاية الصيف')->first();
                if ($categoryDiscount) {
                    $categoryDiscount->categories()->attach($toysCategory->id);
                    $this->command->info("Attached toys category to summer discount");
                }
            }
        }

        $this->command->info('✅ Discount seeder completed successfully!');
        $this->command->info("Created {$activeDiscounts->count()} active discounts");
        $this->command->info("Total products with discounts: " . 
            DB::table('discount_product')
                ->join('discounts', 'discount_product.discount_id', '=', 'discounts.id')
                ->where('discounts.is_active', true)
                ->distinct('discount_product.product_id')
                ->count('discount_product.product_id')
        );
    }
}
