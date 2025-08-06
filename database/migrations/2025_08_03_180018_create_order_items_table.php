<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2); // السعر الفردي وقت الطلب
            $table->integer('quantity')->default(1);
            $table->string('size')->nullable(); // إن وُجد، مثل "M", "42", إلخ
            $table->decimal('total', 10, 2); // price * quantity
            $table->boolean('is_deleted')->default(false);
            $table->unsignedBigInteger('edit_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
