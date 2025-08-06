<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // مثل: اللون، المقاس، المادة
            $table->string('input_type')->default('text'); // مثل: select, radio, text, color
            $table->boolean('is_deleted')->default(false);
            $table->unsignedBigInteger('edit_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
