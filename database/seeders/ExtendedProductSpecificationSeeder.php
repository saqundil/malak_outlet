<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ExtendedProductSpecificationSeeder extends Seeder
{
    /**
     * Add more additional_specs examples to products
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('No products found. Please seed products first.');
            return;
        }

        // Extended additional specs for different product types
        $extendedSpecs = [
            // Electronics / Smartphones
            [
                'additional_specs' => [
                    'نوع الشاشة' => 'AMOLED',
                    'حجم الشاشة' => '6.2 بوصة',
                    'دقة الشاشة' => '1080 × 2400 بكسل',
                    'المعالج' => 'Snapdragon 8 Gen 2',
                    'الذاكرة العشوائية' => '8 جيجابايت',
                    'التخزين الداخلي' => '256 جيجابايت',
                    'كاميرا خلفية' => '50 ميجابكسل',
                    'كاميرا أمامية' => '12 ميجابكسل',
                    'سعة البطارية' => '4000 مللي أمبير',
                    'نوع الشحن' => 'شحن سريع 25 واط',
                    'نظام التشغيل' => 'Android 14',
                    'مقاومة الماء' => 'IP68',
                    'الألوان المتاحة' => 'أسود، أبيض، ذهبي',
                    'الشبكة' => '5G',
                    'البلوتوث' => 'v5.3',
                    'المعايير' => 'CE, FCC, IC'
                ]
            ],
            // Toys / Children products
            [
                'additional_specs' => [
                    'العمر المناسب' => '3-8 سنوات',
                    'عدد القطع' => '200 قطعة',
                    'الألوان' => 'متعدد الألوان',
                    'نوع اللعب' => 'تعليمي وترفيهي',
                    'مهارات التطوير' => 'التفكير المنطقي، الإبداع',
                    'سهولة التجميع' => '10-15 دقيقة',
                    'قابل للتنظيف' => 'نعم، بالماء والصابون',
                    'مكان الاستخدام' => 'داخلي وخارجي',
                    'التعبئة والتغليف' => 'صندوق كرتوني قابل لإعادة التدوير',
                    'ملحقات إضافية' => 'دليل التعليمات، ملصقات',
                    'المعايير' => 'EN71, ASTM, CE'
                ]
            ],
            // Fashion / Clothing
            [
                'additional_specs' => [
                    'نوع القماش' => '100% قطن',
                    'الألوان المتاحة' => 'أزرق، أسود، رمادي',
                    'المقاسات المتاحة' => 'S, M, L, XL, XXL',
                    'نوع الياقة' => 'ياقة مدورة',
                    'طول الكم' => 'كم قصير',
                    'التصميم' => 'كاجوال',
                    'المناسبة' => 'يومي، رياضي',
                    'طريقة الغسيل' => 'غسيل آلة 30°م',
                    'التجفيف' => 'تجفيف هوائي',
                    'الكي' => 'كي بدرجة حرارة متوسطة',
                    'مقاوم للتجعد' => 'نعم',
                    'قابل للتمدد' => 'طبيعي',
                    'المعايير' => 'Oeko-Tex Standard 100'
                ]
            ],
            // Home & Kitchen
            [
                'additional_specs' => [
                    'المادة' => 'ستانلس ستيل مقاوم للصدأ',
                    'السعة' => '2.5 لتر',
                    'نوع التسخين' => 'كهربائي',
                    'القوة الكهربائية' => '1500 واط',
                    'الجهد الكهربائي' => '220-240 فولت',
                    'التردد' => '50/60 هرتز',
                    'مؤشرات' => 'إضاءة LED، صوت تنبيه',
                    'خصائص السلامة' => 'إيقاف تلقائي، حماية من الجفاف',
                    'سهولة التنظيف' => 'قابل للغسل في غسالة الأطباق',
                    'الملحقات' => 'دليل المستخدم، كتيب الوصفات',
                    'الألوان' => 'فضي، أسود',
                    'المعايير' => 'CE, RoHS, ETL'
                ]
            ],
            // Books / Educational
            [
                'additional_specs' => [
                    'عدد الصفحات' => '320 صفحة',
                    'نوع الورق' => 'ورق عالي الجودة 80 جرام',
                    'نوع الغلاف' => 'غلاف مقوى',
                    'اللغة' => 'العربية',
                    'المؤلف' => 'د. أحمد محمد',
                    'دار النشر' => 'دار المعرفة',
                    'سنة النشر' => '2024',
                    'الطبعة' => 'الطبعة الثانية',
                    'التصنيف' => 'تطوير الذات',
                    'الفئة العمرية' => '16+ سنة',
                    'مستوى الصعوبة' => 'متوسط',
                    'رقم ISBN' => '978-1234567890',
                    'التوفر' => 'نسخة رقمية متاحة'
                ]
            ]
        ];

        foreach ($products->take(5) as $index => $product) {
            $specs = $extendedSpecs[$index % count($extendedSpecs)];
            
            // Merge with existing specs if any
            $currentSpecs = $product->additional_specs ?? [];
            $mergedSpecs = array_merge($currentSpecs, $specs['additional_specs']);
            
            $product->update(['additional_specs' => $mergedSpecs]);
            
            $this->command->info("Updated {$product->name} with extended specifications");
        }

        $this->command->info('Extended product specifications added successfully!');
    }
}
