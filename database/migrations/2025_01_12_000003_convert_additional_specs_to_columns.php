<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add new columns for additional specifications
            $table->string('suitable_age')->nullable()->after('additional_specs')->comment('العمر المناسب');
            $table->string('pieces_count')->nullable()->after('suitable_age')->comment('عدد القطع');
            $table->string('standards')->nullable()->after('pieces_count')->comment('المعايير');
            $table->string('battery_type')->nullable()->after('standards')->comment('نوع البطارية');
            $table->string('washable')->nullable()->after('battery_type')->comment('قابل للغسل');
            $table->string('color')->nullable()->after('washable')->comment('اللون');
            $table->string('size')->nullable()->after('color')->comment('الحجم');
            $table->string('model_number')->nullable()->after('size')->comment('رقم الموديل');
            $table->string('power_consumption')->nullable()->after('model_number')->comment('استهلاك الطاقة');
            $table->string('connectivity')->nullable()->after('power_consumption')->comment('الاتصال');
        });

        // Migrate existing additional_specs data to new columns
        $this->migrateAdditionalSpecsData();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'suitable_age',
                'pieces_count', 
                'standards',
                'battery_type',
                'washable',
                'color',
                'size',
                'model_number',
                'power_consumption',
                'connectivity'
            ]);
        });
    }

    /**
     * Migrate data from additional_specs JSON to individual columns
     */
    private function migrateAdditionalSpecsData(): void
    {
        $products = \App\Models\Product::whereNotNull('additional_specs')->get();
        
        foreach ($products as $product) {
            $specs = $product->additional_specs;
            
            if (!is_array($specs)) {
                continue;
            }

            $updates = [];
            
            // Map Arabic keys to column names
            $mappings = [
                'العمر المناسب' => 'suitable_age',
                'عدد القطع' => 'pieces_count',
                'المعايير' => 'standards',
                'نوع البطارية' => 'battery_type',
                'قابل للغسل' => 'washable',
                'اللون' => 'color',
                'الحجم' => 'size',
                'رقم الموديل' => 'model_number',
                'استهلاك الطاقة' => 'power_consumption',
                'الاتصال' => 'connectivity',
                // English mappings as well
                'suitable_age' => 'suitable_age',
                'pieces_count' => 'pieces_count',
                'standards' => 'standards',
                'battery_type' => 'battery_type',
                'washable' => 'washable',
                'color' => 'color',
                'size' => 'size',
                'model_number' => 'model_number',
                'power_consumption' => 'power_consumption',
                'connectivity' => 'connectivity',
            ];

            foreach ($specs as $key => $value) {
                if (isset($mappings[$key])) {
                    $updates[$mappings[$key]] = $value;
                }
            }

            if (!empty($updates)) {
                $product->update($updates);
            }
        }
    }
};
