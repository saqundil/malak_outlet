<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'original_price',
        'sku',
        'quantity',
        'category_id',
        'brand_id',
        'is_active',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
        'is_sized',
        'is_deleted',
        'edit_by',
    ];

    /**
     * العلاقة مع الفئة (التصنيف)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * العلاقة مع الماركة
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * المستخدم الذي عدّل المنتج
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'edit_by');
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    
    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_approved', true);
    }
    
    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }
    
    public function availableSizes()
    {
        return $this->hasMany(ProductSize::class)->where('is_available', true);
    }

    /**
     * العلاقة مع الصور
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * الصورة الرئيسية
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * العلاقة مع قيم خصائص المنتج
     */
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'product_id')->where('is_deleted', false);
    }

    /**
     * العلاقة مع عناصر الطلبات
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * العلاقة مع الطلبات (من خلال عناصر الطلبات)
     */
    public function orders()
    {
        return $this->hasManyThrough(Order::class, OrderItem::class, 'product_id', 'id', 'id', 'order_id');
    }

    public function discountProducts()
    {
        return $this->hasMany(DiscountProduct::class);
    }

    /**
     * Direct discounts relationship (for compatibility with code using ->discounts())
     * Uses the discount_product pivot table to access Discount models directly.
     */
    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_product', 'product_id', 'discount_id')
                    ->wherePivot('is_deleted', false);
    }

    public function getDiscountValueAttribute()
    {
        $discount = $this->activeDiscount();
        return $discount ? $discount->discount_value : null;
    }

    public function getDiscountTypeAttribute()
    {
        $discount = $this->activeDiscount();
        return $discount ? $discount->discount_type : null;
    }

    public function getFinalPriceAttribute()
    {
        if ($this->discount_value && $this->discount_type) {
            if ($this->discount_type === 'percentage') {
                return round($this->price - ($this->price * ($this->discount_value / 100)), 2);
            }
            return round(max($this->price - $this->discount_value, 0), 2);
        }
        return $this->price;
    }

    protected function activeDiscount()
    {
        $now = now();
        $discountProduct = $this->discountProducts()
            ->whereHas('discount', function ($q) use ($now) {
                $q->where('is_active', true)
                  ->where('is_deleted', false)
                  ->where(function ($q) use ($now) {
                      $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
                  })
                  ->where(function ($q) use ($now) {
                      $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
                  });
            })
            ->with('discount')
            ->first();

        return $discountProduct ? $discountProduct->discount : null;
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_deleted', false);
    }

    public function scopeInStock($query)
    {
        return $query->where('status', 'in_stock')->where('quantity', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price')->where('sale_price', '>', 0);
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('quantity', '<=', $threshold)->where('quantity', '>', 0);
    }

    // Accessor for backward compatibility with views using stock_quantity
    public function getStockQuantityAttribute()
    {
        return $this->quantity;
    }

    // Accessor for backward compatibility with code using track_quantity
    public function getTrackQuantityAttribute()
    {
        return true; // Always track quantity for now
    }

    /**
     * Calculate the discount percentage based on active discounts
     */
    public function getDiscountPercentageAttribute()
    {
        $discount = $this->activeDiscount();
        if (!$discount) {
            return 0;
        }

        if ($discount->discount_type === 'percentage') {
            return (float) $discount->discount_value;
        }
        
        if ($discount->discount_type === 'fixed') {
            return $this->price > 0 ? round(($discount->discount_value / $this->price) * 100, 2) : 0;
        }

        return 0;
    }

    /**
     * Calculate the effective price after applying discounts
     */
    public function getEffectivePriceAttribute()
    {
        return $this->final_price;
    }

    /**
     * Check if product has any discount
     */
    public function getHasDiscountAttribute()
    {
        return $this->activeDiscount() !== null;
    }

    /**
     * Get savings amount
     */
    public function getSavingsAmountAttribute()
    {
        $discount = $this->activeDiscount();
        if (!$discount) {
            return 0;
        }

        if ($discount->discount_type === 'percentage') {
            return round($this->price * ($discount->discount_value / 100), 2);
        }
        
        return min($discount->discount_value, $this->price);
    }

    /**
     * Get formatted price with currency
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' د.أ';
    }

    /**
     * Get formatted final price with currency
     */
    public function getFormattedFinalPriceAttribute()
    {
        return number_format($this->final_price, 2) . ' د.أ';
    }

    /**
     * Get average rating from reviews
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    /**
     * Get reviews count
     */
    public function getReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }
   
}
