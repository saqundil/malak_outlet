<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert existing additional_specs JSON data to individual columns
        $products = Product::whereNotNull('additional_specs')->get();
        
        foreach ($products as $product) {
            $specs = $product->additional_specs;
            if (is_array($specs)) {
                $updates = [];
                
                // Map Arabic keys to column names
                foreach ($specs as $key => $value) {
                    switch ($key) {
                        case 'العمر المناسب':
                            $updates['suitable_age'] = $value;
                            break;
                        case 'عدد القطع':
                            $updates['pieces_count'] = $value;
                            break;
                        case 'المعايير':
                            $updates['standards'] = $value;
                            break;
                        case 'نوع البطارية':
                            $updates['battery_type'] = $value;
                            break;
                        case 'قابل للغسل':
                            $updates['washable'] = in_array(strtolower($value), ['نعم', 'yes', '1', 'true']);
                            break;
                    }
                }
                
                if (!empty($updates)) {
                    $product->update($updates);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset the individual columns to null
        Product::query()->update([
            'suitable_age' => null,
            'pieces_count' => null,
            'standards' => null,
            'battery_type' => null,
            'washable' => null,
        ]);
    }
};
