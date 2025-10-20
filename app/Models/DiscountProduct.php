<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountProduct extends Model
{
    protected $table = 'discount_product'; // since it's not plural

    protected $fillable = [
        'discount_id',
        'product_id',
        'is_deleted',
        'edit_by',
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
