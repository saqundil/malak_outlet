<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create some test users if they don't exist
        $users = [
            ['name' => 'أحمد محمد', 'email' => 'ahmed@example.com'],
            ['name' => 'سارة أحمد', 'email' => 'sara@example.com'],
            ['name' => 'محمد علي', 'email' => 'mohamed@example.com'],
            ['name' => 'فاطمة حسن', 'email' => 'fatima@example.com'],
            ['name' => 'خالد عبدالله', 'email' => 'khalid@example.com'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ]
            );
        }

        // Get all products and users
        $products = Product::all();
        $users = User::all();

        if ($products->isEmpty() || $users->isEmpty()) {
            $this->command->info('No products or users found. Please seed products and users first.');
            return;
        }

        // Sample reviews data
        $reviewsData = [
            [
                'rating' => 5,
                'comment' => 'منتج ممتاز وجودة عالية. التسليم كان سريع والتغليف محترف. أنصح بشدة!'
            ],
            [
                'rating' => 4,
                'comment' => 'جودة جيدة ولكن السعر مرتفع قليلاً. الخدمة ممتازة والتعامل راقي.'
            ],
            [
                'rating' => 3,
                'comment' => 'المنتج جيد ولكن توقعت أفضل. الشحن استغرق وقت أطول من المتوقع.'
            ],
            [
                'rating' => 5,
                'comment' => 'رائع جداً! يستحق كل ريال دفعته فيه. سأطلب المزيد بالتأكيد.'
            ],
            [
                'rating' => 4,
                'comment' => 'منتج جيد وعملي. التصميم جميل والمواد عالية الجودة.'
            ],
            [
                'rating' => 5,
                'comment' => 'أفضل متجر تعاملت معه. سرعة في التوصيل وجودة ممتازة.'
            ],
            [
                'rating' => 2,
                'comment' => 'المنتج مقبول لكن ليس كما كنت أتوقع. الجودة أقل من الوصف.'
            ],
            [
                'rating' => 4,
                'comment' => 'سعيدة بالشراء. المنتج كما هو موضح في الصور تماماً.'
            ]
        ];

        // Add reviews to products
        foreach ($products->take(5) as $product) {
            // Add 3-5 reviews per product
            $reviewCount = rand(3, 5);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $reviewData = $reviewsData[array_rand($reviewsData)];
                $user = $users->random();
                
                ProductReview::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'],
                    'is_approved' => true,
                    'created_at' => now()->subDays(rand(1, 60))
                ]);
            }
        }

        $this->command->info('Product reviews seeded successfully!');
    }
}
