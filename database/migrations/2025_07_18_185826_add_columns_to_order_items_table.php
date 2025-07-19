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
        Schema::table('order_items', function (Blueprint $table) {
            // $table->foreignId('order_id')->constrained()->onDelete('cascade');
            // $table->foreignId('product_id')->constrained()->onDelete('cascade');
            // $table->string('product_name'); // Store product name at time of order
            // $table->decimal('price', 10, 2); // Store price at time of order
            // $table->integer('quantity');
            // $table->string('size')->nullable(); // Store size if applicable
            // $table->decimal('total', 10, 2); // price * quantity

            // Add indexes for better performance
        //   /  $table->index(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn([
                'order_id',
                'product_id', 
                'product_name',
                'price',
                'quantity',
                'size',
                'total'
            ]);
            $table->dropIndex(['order_id', 'product_id']);
        });
    }
};
