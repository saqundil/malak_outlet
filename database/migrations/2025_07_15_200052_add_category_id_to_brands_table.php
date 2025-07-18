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
        // Skip this migration - category_id not needed in simplified brands structure
        // Schema::table('brands', function (Blueprint $table) {
        //     $table->unsignedBigInteger('category_id')->nullable()->after('image');
        //     $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Skip this migration - category_id not needed in simplified brands structure
        // Schema::table('brands', function (Blueprint $table) {
        //     $table->dropForeign(['category_id']);
        //     $table->dropColumn('category_id');
        // });
    }
};
