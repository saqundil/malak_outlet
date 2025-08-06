<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'size_type',
        'description',
        'stock_quantity',
        'additional_price',
        'is_available',
        'is_popular',
        'is_deleted',
        'edit_by',
    ];

    /**
     * العلاقة مع المنتج
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * المستخدم الذي عدّل الحجم
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'edit_by');
    }
}
