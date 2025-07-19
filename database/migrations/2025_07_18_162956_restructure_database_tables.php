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
        // 1. Update Categories Table: id, parent_id, name, image, is_active, description
        Schema::table('categories', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('categories', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('id');
                $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            }
            if (!Schema::hasColumn('categories', 'image')) {
                $table->string('image')->nullable()->after('name');
            }
            if (!Schema::hasColumn('categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('image');
            }
            // Description should already exist
        });

        // 2. Update Brands Table: id, name, image (simplified)
        Schema::table('brands', function (Blueprint $table) {
            // Drop unnecessary columns if they exist
            if (Schema::hasColumn('brands', 'image_path')) {
                $table->dropColumn('image_path');
            }
            if (Schema::hasColumn('brands', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('brands', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('brands', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            
            // Add image column if it doesn't exist
            if (!Schema::hasColumn('brands', 'image')) {
                $table->string('image')->nullable()->after('name');
            }
        });

        // 3. Update Products Table: id, name, category_id, brand_id, stock, description, is_active, etc.
        Schema::table('products', function (Blueprint $table) {
            // Ensure we have the basic required columns
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0)->after('brand_id');
            }
            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('description');
            }
            
            // Make sure foreign keys are properly set
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->unsignedBigInteger('category_id')->after('name');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            }
            if (!Schema::hasColumn('products', 'brand_id')) {
                $table->unsignedBigInteger('brand_id')->nullable()->after('category_id');
                $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
            }
        });

        // 4. Update Product Images Table: id, product_id, image, is_premium
        Schema::table('product_images', function (Blueprint $table) {
            // Drop old column name if exists and add new one
            if (Schema::hasColumn('product_images', 'image_path')) {
                $table->dropColumn('image_path');
            }
            if (!Schema::hasColumn('product_images', 'image')) {
                $table->string('image')->after('product_id');
            }
            if (!Schema::hasColumn('product_images', 'is_premium')) {
                $table->boolean('is_premium')->default(false)->after('image');
            }
        });

        // 5. Update Product Sizes Table: id, product_id, size, stock, price
        Schema::table('product_sizes', function (Blueprint $table) {
            // Remove unnecessary columns
            $columnsToRemove = ['size_type', 'additional_price', 'is_available', 'is_popular'];
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('product_sizes', $column)) {
                    $table->dropColumn($column);
                }
            }
            
            // Rename stock_quantity to stock if it exists
            if (Schema::hasColumn('product_sizes', 'stock_quantity')) {
                $table->renameColumn('stock_quantity', 'stock');
            } elseif (!Schema::hasColumn('product_sizes', 'stock')) {
                $table->integer('stock')->default(0)->after('size');
            }
            
            // Add price column if it doesn't exist
            if (!Schema::hasColumn('product_sizes', 'price')) {
                $table->decimal('price', 10, 2)->after('stock');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the changes (this is optional, but good practice)
        Schema::table('product_sizes', function (Blueprint $table) {
            if (Schema::hasColumn('product_sizes', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('product_sizes', 'stock')) {
                $table->renameColumn('stock', 'stock_quantity');
            }
            $table->string('size_type')->default('number');
            $table->decimal('additional_price', 8, 2)->default(0);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_popular')->default(false);
        });

        Schema::table('product_images', function (Blueprint $table) {
            if (Schema::hasColumn('product_images', 'is_premium')) {
                $table->dropColumn('is_premium');
            }
            if (Schema::hasColumn('product_images', 'image')) {
                $table->renameColumn('image', 'image_path');
            }
        });

        Schema::table('brands', function (Blueprint $table) {
            if (Schema::hasColumn('brands', 'image')) {
                $table->renameColumn('image', 'image_path');
            }
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }
};
