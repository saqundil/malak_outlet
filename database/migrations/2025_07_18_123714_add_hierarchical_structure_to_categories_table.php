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
        Schema::table('categories', function (Blueprint $table) {
            // Add parent_id for hierarchical structure
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            
            // Add image field for category images
            $table->string('image')->nullable()->after('description');
            
            // Add foreign key constraint for parent_id
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            
            // Add index for better performance on parent_id queries
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['parent_id']);
            
            // Drop columns
            $table->dropColumn(['parent_id', 'image']);
        });
    }
};
