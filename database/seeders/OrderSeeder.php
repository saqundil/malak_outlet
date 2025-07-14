<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user (assuming one exists)
        $user = User::first();
        if (!$user) {
            // Create a test user if none exists
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'phone' => '0501234567',
            ]);
        }

        // Get some products
        $products = Product::take(5)->get();
        if ($products->count() == 0) {
            // Create some test products if none exist
            $category = \App\Models\Category::first();
            $brand = \App\Models\Brand::first();
            
            $products = collect([
                Product::create([
                    'name' => 'سيارة التحكم عن بعد الرياضية',
                    'description' => 'سيارة رياضية ممتعة للأطفال',
                    'price' => 149.99,
                    'stock_quantity' => 10,
                    'category_id' => $category ? $category->id : 1,
                    'brand_id' => $brand ? $brand->id : 1,
                ]),
                Product::create([
                    'name' => 'دمية الدب الناعمة الكبيرة',
                    'description' => 'دمية ناعمة ومريحة للأطفال',
                    'price' => 79.99,
                    'stock_quantity' => 15,
                    'category_id' => $category ? $category->id : 1,
                    'brand_id' => $brand ? $brand->id : 1,
                ]),
                Product::create([
                    'name' => 'روبوت تعليمي قابل للبرمجة',
                    'description' => 'روبوت تعليمي متقدم',
                    'price' => 249.99,
                    'stock_quantity' => 5,
                    'category_id' => $category ? $category->id : 1,
                    'brand_id' => $brand ? $brand->id : 1,
                ]),
                Product::create([
                    'name' => 'لعبة الألغاز الذكية ثلاثية الأبعاد',
                    'description' => 'لعبة ألغاز تفاعلية',
                    'price' => 99.99,
                    'stock_quantity' => 8,
                    'category_id' => $category ? $category->id : 1,
                    'brand_id' => $brand ? $brand->id : 1,
                ]),
            ]);
        }

        // Create Order 1 - Delivered
        $order1 = Order::create([
            'order_number' => 'ORD-2025-001',
            'user_id' => $user->id,
            'status' => 'delivered',
            'subtotal' => 309.97,
            'shipping_cost' => 30.00,
            'tax_amount' => 46.50,
            'total_amount' => 386.47,
            'payment_method' => 'cod',
            'payment_status' => 'paid',
            'shipping_address' => 'الرياض، حي النخيل، شارع الملك فهد، مبنى 123، شقة 45',
            'phone' => '0501234567',
            'notes' => null,
            'delivered_at' => now()->subDays(2),
            'created_at' => now()->subDays(7),
        ]);

        // Add items to order 1
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $products->first()->id,
            'product_name' => 'سيارة التحكم عن بعد الرياضية',
            'product_price' => 149.99,
            'quantity' => 1,
            'total_price' => 149.99,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $products->get(1)->id,
            'product_name' => 'دمية الدب الناعمة الكبيرة',
            'product_price' => 79.99,
            'quantity' => 2,
            'total_price' => 159.98,
        ]);

        // Create Order 2 - Shipped
        $order2 = Order::create([
            'order_number' => 'ORD-2025-002',
            'user_id' => $user->id,
            'status' => 'shipped',
            'subtotal' => 99.99,
            'shipping_cost' => 30.00,
            'tax_amount' => 15.00,
            'total_amount' => 144.99,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'shipping_address' => 'الرياض، حي النخيل، شارع الملك فهد، مبنى 123، شقة 45',
            'phone' => '0501234567',
            'notes' => null,
            'shipped_at' => now()->subDays(1),
            'created_at' => now()->subDays(3),
        ]);

        // Add items to order 2
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $products->get(3)->id,
            'product_name' => 'لعبة الألغاز الذكية ثلاثية الأبعاد',
            'product_price' => 99.99,
            'quantity' => 1,
            'total_price' => 99.99,
        ]);

        // Create Order 3 - Pending
        $order3 = Order::create([
            'order_number' => 'ORD-2025-003',
            'user_id' => $user->id,
            'status' => 'pending',
            'subtotal' => 249.99,
            'shipping_cost' => 30.00,
            'tax_amount' => 37.50,
            'total_amount' => 317.49,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'shipping_address' => 'الرياض، حي النخيل، شارع الملك فهد، مبنى 123، شقة 45',
            'phone' => '0501234567',
            'notes' => 'يرجى التواصل قبل التسليم',
            'created_at' => now()->subDays(1),
        ]);

        // Add items to order 3
        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $products->get(2)->id,
            'product_name' => 'روبوت تعليمي قابل للبرمجة',
            'product_price' => 249.99,
            'quantity' => 1,
            'total_price' => 249.99,
        ]);
    }
}
