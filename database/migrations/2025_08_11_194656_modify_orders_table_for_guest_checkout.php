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
        Schema::table('orders', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Modify user_id to allow null values
            $table->foreignId('user_id')->nullable()->change();
            
            // Add foreign key constraint that allows null
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            // Add customer name field for guest orders
            $table->string('customer_name')->after('user_id');
            
            // Add customer email field for guest orders
            $table->string('customer_email')->nullable()->after('customer_name');
            
            // Add payment method and status fields if they don't exist
            $table->string('payment_method')->default('cash')->after('total_amount');
            $table->string('payment_status')->default('pending')->after('payment_method');
            
            // Add tax amount field
            $table->decimal('tax_amount', 10, 2)->default(0)->after('shipping_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop added columns
            $table->dropColumn(['customer_name', 'customer_email', 'payment_method', 'payment_status', 'tax_amount']);
            
            // Drop foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Restore user_id to not null
            $table->foreignId('user_id')->change();
            
            // Restore original foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
