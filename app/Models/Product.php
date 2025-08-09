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

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_product');
    }
    /**
     * المستخدم الذي عدّل المنتج
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'edit_by');
    }

    /**
     * العلاقة مع المفضلة
     */
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    /**
     * العلاقة مع التقييمات
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    
    /**
     * التقييمات المعتمدة فقط
     */
    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_approved', true);
    }
    
    /**
     * العلاقة مع الأحجام
     */
    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }
    
    /**
     * الأحجام المتاحة فقط
     */
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
     * العلاقة مع خصائص المنتج
     */
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
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

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' ريال';
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price ? number_format($this->original_price, 2) . ' ريال' : null;
    }

    public function getDiscountPercentageAttribute()
    {
        // First check if product has active discount from discount table
        $activeDiscount = $this->discounts()
            ->where('discounts.is_active', true)
            ->where('discounts.is_deleted', false)
            ->where(function ($q) {
                $q->whereNull('discounts.starts_at')
                  ->orWhere('discounts.starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('discounts.ends_at')
                  ->orWhere('discounts.ends_at', '>=', now());
            })
            ->first();
        
        if ($activeDiscount) {
            if ($activeDiscount->discount_type === 'percentage') {
                return min(95, max(1, $activeDiscount->discount_value));
            } else if ($activeDiscount->discount_type === 'fixed') {
                $discountPercent = round(($activeDiscount->discount_value / $this->price) * 100);
                return min(95, max(1, $discountPercent));
            }
        }
        
        // Fallback to sale_price calculation
        if ($this->sale_price && $this->sale_price > 0 && $this->price > $this->sale_price) {
            $discountPercent = round((($this->price - $this->sale_price) / $this->price) * 100);
            return min(95, max(1, $discountPercent)); // Cap discount at 95% and minimum 1%
        }
        
        // Fallback to original_price for backward compatibility
        if ($this->original_price && $this->original_price > $this->price) {
            $discountPercent = round((($this->original_price - $this->price) / $this->original_price) * 100);
            return min(95, max(1, $discountPercent)); // Cap discount at 95% and minimum 1%
        }
        
        return 0;
    }

    /**
     * Get the effective discounted price after applying active discounts
     */
    public function getEffectivePriceAttribute()
    {
        // First check if product has active discount from discount table
        $activeDiscount = $this->discounts()
            ->where('discounts.is_active', true)
            ->where('discounts.is_deleted', false)
            ->where(function ($q) {
                $q->whereNull('discounts.starts_at')
                  ->orWhere('discounts.starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('discounts.ends_at')
                  ->orWhere('discounts.ends_at', '>=', now());
            })
            ->first();
        
        if ($activeDiscount) {
            if ($activeDiscount->discount_type === 'percentage') {
                $discountAmount = ($this->price * min(95, $activeDiscount->discount_value)) / 100;
                return max(0.01, $this->price - $discountAmount); // Ensure minimum price of 0.01
            } else if ($activeDiscount->discount_type === 'fixed') {
                return max(0.01, $this->price - $activeDiscount->discount_value); // Ensure minimum price of 0.01
            }
        }
        
        // Fallback to sale_price if available
        if ($this->sale_price && $this->sale_price > 0 && $this->price > $this->sale_price) {
            return $this->sale_price;
        }
        
        // Return original price
        return $this->price;
    }

    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    // Accessor for backward compatibility with views using stock_quantity
    public function getStockQuantityAttribute()
    {
        return $this->quantity;
    }
}
