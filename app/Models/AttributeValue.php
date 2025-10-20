<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_attribute_id',
        'value',
        'is_deleted',
        'edit_by',
    ];

    /**
     * المنتج المرتبط بهذه القيمة
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * العلاقة مع الخاصية (مثل اللون، المقاس...)
     */
    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }

    /**
     * المستخدم الذي عدّل
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'edit_by');
    }
}
