<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ShoesImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample shoe images - you would replace these with actual image URLs or paths
        $shoeImages = [
            'nike-air-force-1-07' => [
                'images/shoes/nike-air-force-1-white.jpg',
                'images/shoes/nike-air-force-1-black.jpg',
                'images/shoes/nike-air-force-1-side.jpg'
            ],
            'nike-react-infinity-run-flyknit-3' => [
                'images/shoes/nike-react-infinity-main.jpg',
                'images/shoes/nike-react-infinity-side.jpg'
            ],
            'nike-dunk-low-retro' => [
                'images/shoes/nike-dunk-low-main.jpg',
                'images/shoes/nike-dunk-low-colorway.jpg'
            ],
            'nike-blazer-mid-77-vintage' => [
                'images/shoes/nike-blazer-mid-white.jpg',
                'images/shoes/nike-blazer-mid-vintage.jpg'
            ],
            'adidas-stan-smith' => [
                'images/shoes/adidas-stan-smith-main.jpg',
                'images/shoes/adidas-stan-smith-green.jpg'
            ],
            'adidas-ultraboost-23' => [
                'images/shoes/adidas-ultraboost-main.jpg',
                'images/shoes/adidas-ultraboost-side.jpg'
            ],
            'adidas-gazelle' => [
                'images/shoes/adidas-gazelle-blue.jpg',
                'images/shoes/adidas-gazelle-grey.jpg'
            ],
            'adidas-nmd-r1' => [
                'images/shoes/adidas-nmd-main.jpg',
                'images/shoes/adidas-nmd-black.jpg'
            ],
            'converse-chuck-taylor-all-star-classic' => [
                'images/shoes/converse-chuck-classic-black.jpg',
                'images/shoes/converse-chuck-classic-white.jpg',
                'images/shoes/converse-chuck-classic-red.jpg'
            ],
            'converse-chuck-70-high-top' => [
                'images/shoes/converse-chuck-70-main.jpg',
                'images/shoes/converse-chuck-70-vintage.jpg'
            ],
            'classic-white-leather-sneakers' => [
                'images/shoes/white-leather-sneakers-main.jpg',
                'images/shoes/white-leather-sneakers-side.jpg'
            ],
            'running-shoes-performance-series' => [
                'images/shoes/running-shoes-performance.jpg',
                'images/shoes/running-shoes-mesh.jpg'
            ],
            'canvas-high-top-sneakers' => [
                'images/shoes/canvas-high-top-main.jpg',
                'images/shoes/canvas-high-top-colors.jpg'
            ],
            'formal-black-dress-shoes' => [
                'images/shoes/formal-dress-shoes-main.jpg',
                'images/shoes/formal-dress-shoes-side.jpg'
            ],
            'womens-ballet-flats' => [
                'images/shoes/ballet-flats-black.jpg',
                'images/shoes/ballet-flats-colors.jpg'
            ],
            'hiking-boots-adventure-series' => [
                'images/shoes/hiking-boots-main.jpg',
                'images/shoes/hiking-boots-side.jpg'
            ]
        ];

        foreach ($shoeImages as $productSlug => $images) {
            $product = Product::where('slug', $productSlug)->first();
            
            if ($product) {
                foreach ($images as $index => $imagePath) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'is_primary' => $index === 0 // First image is primary
                    ]);
                }
            }
        }
    }
}
