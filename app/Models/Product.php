<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'sale_price', 'sku', 'stock', 'stock_quantity', 
        'category_id', 'brand_id', 'is_active', 'is_featured', 'weight', 'materials', 
        'country_of_origin', 'warranty_period', 'dimensions',
        'suitable_age', 'pieces_count', 'standards', 'battery_type', 'washable'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(ProductSize::class);
    }

    public function availableSizes(): HasMany
    {
        return $this->hasMany(ProductSize::class)->available();
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class)->approved()->with('user')->latest();
    }

    /**
     * Get average rating for the product
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->approved()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews count
     */
    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->approved()->count();
    }

    /**
     * Get rating breakdown (1-5 stars count)
     */
    public function getRatingBreakdownAttribute(): array
    {
        $breakdown = [];
        for ($i = 1; $i <= 5; $i++) {
            $breakdown[$i] = $this->reviews()->approved()->where('rating', $i)->count();
        }
        return $breakdown;
    }

    /**
     * Get formatted weight
     */
    public function getFormattedWeightAttribute(): string
    {
        return $this->weight ?? 'غير محدد';
    }

    /**
     * Get formatted materials
     */
    public function getFormattedMaterialsAttribute(): string
    {
        return $this->materials ?? 'عالية الجودة';
    }

    /**
     * Get formatted country of origin
     */
    public function getFormattedCountryAttribute(): string
    {
        return $this->country_of_origin ?? 'غير محدد';
    }

    /**
     * Get formatted warranty period
     */
    public function getFormattedWarrantyAttribute(): string
    {
        return $this->warranty_period ?? 'سنة واحدة';
    }

    /**
     * Get formatted dimensions
     */
    public function getFormattedDimensionsAttribute(): string
    {
        return $this->dimensions ?? 'غير محدد';
    }

    /**
     * Get formatted suitable age
     */
    public function getFormattedSuitableAgeAttribute(): string
    {
        return $this->suitable_age ?? 'غير محدد';
    }

    /**
     * Get formatted pieces count
     */
    public function getFormattedPiecesCountAttribute(): string
    {
        return $this->pieces_count ?? 'غير محدد';
    }

    /**
     * Get formatted standards
     */
    public function getFormattedStandardsAttribute(): string
    {
        return $this->standards ?? 'غير محدد';
    }

    /**
     * Get formatted battery type
     */
    public function getFormattedBatteryTypeAttribute(): string
    {
        return $this->battery_type ?? 'غير محدد';
    }

    /**
     * Get formatted washable status
     */
    public function getFormattedWashableAttribute(): string
    {
        if (is_null($this->washable)) {
            return 'غير محدد';
        }
        return $this->washable ? 'نعم' : 'لا';
    }
}
