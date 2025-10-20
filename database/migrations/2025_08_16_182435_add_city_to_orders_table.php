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
            $table->foreignId('jordan_city_id')->nullable()->after('shipping_address')->constrained()->onDelete('set null');
            $table->string('city_name')->nullable()->after('jordan_city_id'); // Store city name as backup
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['jordan_city_id']);
            $table->dropColumn(['jordan_city_id', 'city_name']);
        });
    }
};
