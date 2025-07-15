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
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('size'); // مثل: "42", "43", "44", "L", "XL", "M"
            $table->string('size_type')->default('number'); // number, letter, custom
            $table->integer('stock_quantity')->default(0); // كمية المخزون لكل حجم
            $table->decimal('additional_price', 8, 2)->default(0); // سعر إضافي للحجم إن وجد
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unique(['product_id', 'size']); // منع تكرار نفس الحجم لنفس المنتج
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
