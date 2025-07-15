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
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('size'); // مثل: 42, 43, S, M, L, XL
            $table->string('size_type')->default('number'); // number, letter, custom
            $table->integer('stock_quantity')->default(0); // الكمية المتوفرة
            $table->decimal('additional_price', 8, 2)->default(0); // سعر إضافي
            $table->boolean('is_available')->default(true); // متوفر أم لا
            $table->timestamps();

            // فهرس مركب للبحث السريع
            $table->index(['product_id', 'size']);
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
