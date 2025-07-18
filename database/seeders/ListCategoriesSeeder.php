<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use Illuminate\Support\Facades\DB;

class ListCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        $this->command->info('Found ' . $categories->count() . ' categories:');
        
        foreach ($categories as $category) {
            $productCount = Product::where('category_id', $category->id)->count();
            $this->command->info($category->id . ': ' . $category->name . ' (' . $productCount . ' products)');
        }
    }
}
