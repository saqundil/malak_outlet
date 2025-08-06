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
        'original_price',
        'sku',
        'quantity',
        'category_id',
        'brand_id',
        'is_active',
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
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
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
