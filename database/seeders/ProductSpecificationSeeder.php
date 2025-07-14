<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSpecificationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('No products found. Please seed products first.');
            return;
        }

        $specifications = [
            [
                'weight' => '500 جرام',
                'materials' => 'بلاستيك ABS عالي الجودة',
                'country_of_origin' => 'الصين',
                'warranty_period' => 'سنة واحدة',
                'dimensions' => '25 × 20 × 15 سم',
                'additional_specs' => [
                    'العمر المناسب' => '3-12 سنة',
                    'عدد القطع' => '150 قطعة',
                    'المعايير' => 'CE, ISO 9001'
                ]
            ],
            [
                'weight' => '1.2 كيلوجرام',
                'materials' => 'خشب طبيعي مع طلاء آمن',
                'country_of_origin' => 'تركيا',
                'warranty_period' => '6 أشهر',
                'dimensions' => '30 × 25 × 20 سم',
                'additional_specs' => [
                    'العمر المناسب' => '2-8 سنوات',
                    'نوع الخشب' => 'زان طبيعي',
                    'المعايير' => 'EN71, ASTM'
                ]
            ],
            [
                'weight' => '800 جرام',
                'materials' => 'معدن مطلي وبلاستيك',
                'country_of_origin' => 'ألمانيا',
                'warranty_period' => 'سنتان',
                'dimensions' => '35 × 15 × 10 سم',
                'additional_specs' => [
                    'العمر المناسب' => '5+ سنوات',
                    'نوع البطارية' => 'AA × 4',
                    'المعايير' => 'CE, FCC'
                ]
            ],
            [
                'weight' => '200 جرام',
                'materials' => 'قماش قطني ونسيج ناعم',
                'country_of_origin' => 'الهند',
                'warranty_period' => '3 أشهر',
                'dimensions' => '40 × 30 سم',
                'additional_specs' => [
                    'العمر المناسب' => '0-3 سنوات',
                    'قابل للغسل' => 'نعم',
                    'المعايير' => 'Oeko-Tex Standard'
                ]
            ],
            [
                'weight' => '1.5 كيلوجرام',
                'materials' => 'بلاستيك مقوى وإلكترونيات',
                'country_of_origin' => 'اليابان',
                'warranty_period' => 'سنة واحدة',
                'dimensions' => '45 × 35 × 25 سم',
                'additional_specs' => [
                    'العمر المناسب' => '6+ سنوات',
                    'نوع البطارية' => 'ليثيوم قابلة للشحن',
                    'المعايير' => 'CE, RoHS'
                ]
            ]
        ];

        foreach ($products as $index => $product) {
            $spec = $specifications[$index % count($specifications)];
            
            $product->update($spec);
        }

        $this->command->info('Product specifications updated successfully!');
    }
}
