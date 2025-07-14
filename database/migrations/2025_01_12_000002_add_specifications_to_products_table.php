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
            $table->string('weight')->nullable()->after('description');
            $table->string('materials')->nullable()->after('weight');
            $table->string('country_of_origin')->nullable()->after('materials');
            $table->string('warranty_period')->nullable()->after('country_of_origin');
            $table->string('dimensions')->nullable()->after('warranty_period');
            $table->json('additional_specs')->nullable()->after('dimensions')->comment('JSON field for extra specifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'weight',
                'materials', 
                'country_of_origin',
                'warranty_period',
                'dimensions',
                'additional_specs'
            ]);
        });
    }
};
