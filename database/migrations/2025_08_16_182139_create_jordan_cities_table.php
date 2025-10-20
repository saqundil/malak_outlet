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
        Schema::create('jordan_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar'); // Arabic name
            $table->string('name_en'); // English name
            $table->decimal('delivery_cost', 8, 2)->default(0.00); // Delivery cost in JD
            $table->boolean('is_active')->default(true);
            $table->integer('delivery_days')->default(1); // Estimated delivery days
            $table->text('notes')->nullable(); // Additional notes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jordan_cities');
    }
};
