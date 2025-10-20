<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('product_attribute_id')->constrained('product_attributes')->onDelete('cascade');
            $table->string('value'); // مثال: أحمر، XL، قطن، إلخ
            $table->boolean('is_deleted')->default(false);
            $table->unsignedBigInteger('edit_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};

