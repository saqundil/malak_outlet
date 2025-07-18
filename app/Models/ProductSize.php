<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'is_popular'
    ];

    protected $casts = [
        'additional_price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * العلاقة مع Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope للأحجام المتاحة
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('stock_quantity', '>', 0);
    }

    /**
     * احصل على السعر الإجمالي للحجم
     */
    public function getTotalPriceAttribute()
    {
        $basePrice = $this->product->sale_price ?? $this->product->price;
        return $basePrice + $this->additional_price;
    }
}
