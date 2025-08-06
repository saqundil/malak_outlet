<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'discount_type',
        'discount_value',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * المنتجات المرتبطة بهذا الخصم
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'discount_product');
    }

    /**
     * الفئات المرتبطة بهذا الخصم
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'discount_category');
    }

    /**
     * تحقق مما إذا كان الخصم نشطًا حاليًا
     */
    public function isCurrentlyActive(): bool
    {
        $now = now();
        return $this->is_active &&
               ($this->starts_at === null || $this->starts_at <= $now) &&
               ($this->ends_at === null || $this->ends_at >= $now);
    }

    /**
     * وصف النص الكامل للخصم (مثال: خصم 20% أو خصم 5 دنانير)
     */
    public function getLabelAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            return "{$this->discount_value}% خصم";
        }

        if ($this->discount_type === 'fixed') {
            return "{$this->discount_value} دينار خصم";
        }

        return "خصم";
    }
}
