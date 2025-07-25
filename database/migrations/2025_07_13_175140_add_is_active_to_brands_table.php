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
        // Skip this migration since we're using simplified brands table
        // Brands table now only has: id, name, image, timestamps
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Skip since we're using simplified structure
    }
};
