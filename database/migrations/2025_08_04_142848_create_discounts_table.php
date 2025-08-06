<?php

// database/migrations/xxxx_xx_xx_create_discounts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // اسم العرض (مثال: خصم رمضان)
            $table->text('description')->nullable();
            $table->enum('discount_type', ['fixed', 'percentage']); // نوع الخصم
            $table->decimal('discount_value', 8, 2); // 20% أو 5 دنانير
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->boolean('is_active')->default(true); // تفعيل/تعطيل الخصم
            $table->boolean('is_deleted')->default(false);
            $table->unsignedBigInteger('edit_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
