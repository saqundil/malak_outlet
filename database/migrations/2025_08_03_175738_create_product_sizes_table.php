<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('size'); // مثال: S, M, L, XL أو 36, 38, 40
            $table->string('size_type')->nullable(); // مثل: "ملابس", "أحذية"
            $table->string('description')->nullable(); // وصف إضافي للحجم إن وجد
            $table->integer('stock_quantity')->default(0);
            $table->decimal('additional_price', 10, 2)->default(0.00); // فرق السعر إن وجد
            $table->boolean('is_available')->default(true);
            $table->boolean('is_popular')->default(false); // للتمييز في الواجهة مثلاً
            $table->boolean('is_deleted')->default(false);
            $table->unsignedBigInteger('edit_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
