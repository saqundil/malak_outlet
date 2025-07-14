<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating' => 'integer'
    ];

    /**
     * Get the product that this review belongs to
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user who wrote this review
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get only approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Get the review author's first name initial
     */
    public function getAuthorInitialAttribute(): string
    {
        return mb_substr($this->user->name, 0, 1);
    }

    /**
     * Get formatted time ago
     */
    public function getTimeAgoAttribute(): string
    {
        $diffInDays = $this->created_at->diffInDays();
        
        if ($diffInDays == 0) {
            return 'اليوم';
        } elseif ($diffInDays == 1) {
            return 'أمس';
        } elseif ($diffInDays < 7) {
            return "منذ {$diffInDays} أيام";
        } elseif ($diffInDays < 30) {
            $weeks = floor($diffInDays / 7);
            return $weeks == 1 ? 'منذ أسبوع' : "منذ {$weeks} أسابيع";
        } else {
            $months = floor($diffInDays / 30);
            return $months == 1 ? 'منذ شهر' : "منذ {$months} أشهر";
        }
    }

    /**
     * Get star rating as HTML
     */
    public function getStarRatingAttribute(): string
    {
        $fullStars = $this->rating;
        $emptyStars = 5 - $fullStars;
        
        $stars = str_repeat('<i class="fas fa-star"></i>', $fullStars);
        $stars .= str_repeat('<i class="far fa-star"></i>', $emptyStars);
        
        return $stars;
    }
}
